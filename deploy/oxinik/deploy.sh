#!/usr/bin/env bash

set -Eeuo pipefail

IMAGE_REPOSITORY="jeft613/oxinik"
CONTAINER_NAME="oxinik-app"
ENV_FILE="/opt/apps/oxinik/oxinik.env"
BACKUP_DIR="/opt/backups/mysql"
DATABASE_NAME="oxinik"
MYSQL_CONTAINER="mysql8"
DB_NETWORK="oxigamex-db"
PROXY_NETWORK="oxigamex-proxy"

usage() {
  echo "Uso: $0 prod-<SHA_DEL_COMMIT>" >&2
  exit 2
}

[[ $# -eq 1 ]] || usage
IMAGE_TAG="$1"

if [[ ! "$IMAGE_TAG" =~ ^prod-[a-f0-9]{40}$ ]]; then
  echo "Etiqueta inválida: $IMAGE_TAG. Se esperaba prod-<SHA de 40 caracteres>." >&2
  exit 2
fi

IMAGE="${IMAGE_REPOSITORY}:${IMAGE_TAG}"
TIMESTAMP="$(date -u +%Y%m%dT%H%M%SZ)"
BACKUP_FILE="${BACKUP_DIR}/${DATABASE_NAME}-${TIMESTAMP}.sql.gz"
OLD_IMAGE=""
OLD_CONTAINER_EXISTS="false"

if [[ ! -f "$ENV_FILE" ]]; then
  echo "No existe el archivo de producción: $ENV_FILE" >&2
  exit 1
fi

for network in "$DB_NETWORK" "$PROXY_NETWORK"; do
  if ! docker network inspect "$network" >/dev/null 2>&1; then
    echo "No existe la red requerida: $network" >&2
    exit 1
  fi
done

if ! docker inspect "$MYSQL_CONTAINER" >/dev/null 2>&1; then
  echo "No existe el contenedor MySQL requerido: $MYSQL_CONTAINER" >&2
  exit 1
fi

mkdir -p "$BACKUP_DIR"

if docker inspect "$CONTAINER_NAME" >/dev/null 2>&1; then
  OLD_CONTAINER_EXISTS="true"
  OLD_IMAGE="$(docker inspect --format '{{.Config.Image}}' "$CONTAINER_NAME")"
fi

echo "Creando respaldo de ${DATABASE_NAME}: ${BACKUP_FILE}"
docker exec "$MYSQL_CONTAINER" sh -c \
  'exec mysqldump -uroot -p"$MYSQL_ROOT_PASSWORD" --single-transaction --routines --triggers "$1"' \
  sh "$DATABASE_NAME" | gzip > "$BACKUP_FILE"
chmod 600 "$BACKUP_FILE"

echo "Descargando imagen: $IMAGE"
docker pull "$IMAGE"

rollback() {
  local exit_code=$?
  if [[ "$OLD_CONTAINER_EXISTS" == "true" && -n "$OLD_IMAGE" ]]; then
    echo "Falló el despliegue. Ejecutando rollback a: $OLD_IMAGE" >&2
    docker rm -f "$CONTAINER_NAME" >/dev/null 2>&1 || true
    docker run -d \
      --name "$CONTAINER_NAME" \
      --restart unless-stopped \
      --network "$DB_NETWORK" \
      --env-file "$ENV_FILE" \
      "$OLD_IMAGE" >/dev/null
    docker network connect "$PROXY_NETWORK" "$CONTAINER_NAME" >/dev/null 2>&1 || true
    echo "Rollback completado. Revisar: docker logs --tail=100 $CONTAINER_NAME" >&2
  else
    echo "Falló el primer despliegue y no existe una imagen anterior para rollback." >&2
  fi
  exit "$exit_code"
}

trap rollback ERR

docker rm -f "$CONTAINER_NAME" >/dev/null 2>&1 || true
docker run -d \
  --name "$CONTAINER_NAME" \
  --restart unless-stopped \
  --network "$DB_NETWORK" \
  --env-file "$ENV_FILE" \
  "$IMAGE" >/dev/null

docker network connect "$PROXY_NETWORK" "$CONTAINER_NAME"

for attempt in {1..12}; do
  if [[ "$(docker inspect --format '{{.State.Running}}' "$CONTAINER_NAME")" == "true" ]]; then
    break
  fi
  sleep 2
done

[[ "$(docker inspect --format '{{.State.Running}}' "$CONTAINER_NAME")" == "true" ]]

echo "Ejecutando migraciones"
docker exec "$CONTAINER_NAME" php artisan migrate --force

echo "Validando endpoint interno"
for attempt in {1..12}; do
  if docker run --rm --network "$PROXY_NETWORK" curlimages/curl:8.10.1 \
      --fail --silent --show-error --max-time 5 \
      "http://${CONTAINER_NAME}:8086/" >/dev/null; then
    echo "Oxinik responde correctamente."
    trap - ERR
    exit 0
  fi
  sleep 2
done

echo "Oxinik no respondió al endpoint interno." >&2
exit 1

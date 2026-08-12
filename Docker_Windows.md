# Guia para exportar la imagen Docker e instalar Oxinik limpio en Windows

Este documento explica como construir la imagen Docker del aplicativo Oxinik, exportarla a un archivo `.tar`, copiarla a una computadora Windows y levantarla junto con un contenedor MySQL limpio, sin datos historicos de otra instalacion.

El proyecto expone la aplicacion en el puerto `8086` y se conectara a MySQL usando estos datos:

```env
DB_HOST=mysql8
DB_PORT=3306
DB_DATABASE=oxinik
DB_USERNAME=root
DB_PASSWORD=pass123
```

## 1. Requisitos

En la computadora donde se construye la imagen:

- Docker instalado.
- El codigo fuente del proyecto Oxinik.

En la computadora Windows destino:

- Docker Desktop instalado y ejecutandose.
- PowerShell o CMD.
- El archivo exportado `oxinik-app.tar`.

Importante: para una instalacion limpia no se debe importar ningun respaldo `.sql`. La base se crea desde migraciones y seeders del proyecto.

## 2. Construir la imagen en la computadora origen

Ubicate en la carpeta raiz del proyecto, donde estan el `Dockerfile` y `docker-compose.yml`.

```sh
docker build -t oxinik:1.0 .
```

Verifica que la imagen exista:

```sh
docker images oxinik
```

## 3. Exportar la imagen

Para imagenes Docker se usa `docker save`. Esto genera un archivo que despues se puede cargar con `docker load` en Windows.

```sh
docker save -o oxinik-app.tar oxinik:1.0
```

Copia el archivo `oxinik-app.tar` a la computadora Windows destino.

## 4. Cargar la imagen en Windows

Abre PowerShell en la carpeta donde copiaste `oxinik-app.tar` y ejecuta:

```powershell
docker load -i .\oxinik-app.tar
```

Verifica que la imagen haya quedado cargada:

```powershell
docker images oxinik
```

## 5. Crear la red Docker

La aplicacion y MySQL deben estar en la misma red para que `DB_HOST=mysql8` resuelva correctamente.

```powershell
docker network create networck-oxigamex
```

Si Docker responde que la red ya existe, puedes continuar.

## 6. Limpiar instalacion anterior, si existe

Si en esa computadora Windows ya se habia levantado Oxinik antes, elimina los contenedores y el volumen de MySQL para asegurar una base totalmente limpia.

Advertencia: estos comandos borran la base de datos anterior.

```powershell
docker rm -f oxinik-app mysql8
docker volume rm oxinik-mysql-data
```

Si Docker responde que algun contenedor o volumen no existe, puedes continuar.

Si elegiste la opcion de carpeta visible en Windows, tambien borra la carpeta de datos para reiniciar desde cero:

```powershell
if (Test-Path C:\oxinik\mysql) { Remove-Item -Recurse -Force C:\oxinik\mysql }
mkdir C:\oxinik\mysql
```

## 7. Levantar MySQL limpio en Windows

Opcion recomendada: usar un volumen nombrado de Docker.

Ejecuta este comando en PowerShell:

```powershell
docker run -d `
  --name mysql8 `
  --network networck-oxigamex `
  -e MYSQL_ROOT_PASSWORD=pass123 `
  -e MYSQL_DATABASE=oxinik `
  -p 3306:3306 `
  -v oxinik-mysql-data:/var/lib/mysql `
  mysql:8.0 `
  --default-authentication-plugin=mysql_native_password
```

La parte importante del volumen es esta:

```powershell
-v oxinik-mysql-data:/var/lib/mysql
```

Esto significa:

- `oxinik-mysql-data` es el volumen persistente administrado por Docker.
- `/var/lib/mysql` es la carpeta interna del contenedor donde MySQL guarda la base de datos.
- Si eliminas el contenedor `mysql8`, los datos siguen existiendo mientras no elimines el volumen.

Espera unos segundos y revisa los logs hasta ver que MySQL esta listo para recibir conexiones:

```powershell
docker logs -f mysql8
```

Para salir de los logs usa `Ctrl + C`. Esto no detiene el contenedor.

## 8. Saber donde esta el volumen de MySQL

Para ver los volumenes existentes:

```powershell
docker volume ls
```

Para inspeccionar el volumen de MySQL:

```powershell
docker volume inspect oxinik-mysql-data
```

Docker mostrara informacion en formato JSON. Busca el campo `Mountpoint`.

En Docker Desktop para Windows, ese `Mountpoint` normalmente apunta a una ruta dentro de la maquina Linux interna que usa Docker, no a una carpeta normal de Windows. El volumen si existe en Windows, pero Docker lo administra dentro de su entorno Linux.

Tambien puedes verlo desde Docker Desktop:

1. Abre Docker Desktop.
2. Entra a `Volumes`.
3. Busca `oxinik-mysql-data`.
4. Desde ahi puedes inspeccionar, exportar, importar o eliminar el volumen.

## 9. Usar una carpeta visible de Windows para MySQL

Si necesitas que los archivos queden en una carpeta visible de Windows, usa un bind mount en lugar de volumen nombrado.

No se deben montar al mismo tiempo `oxinik-mysql-data:/var/lib/mysql` y `C:\oxinik\mysql:/var/lib/mysql`, porque ambos intentarian ocupar la misma carpeta interna de MySQL.

Primero crea la carpeta:

```powershell
mkdir C:\oxinik\mysql
```

Despues levanta MySQL usando esa carpeta:

```powershell
docker run -d `
  --name mysql8 `
  --network networck-oxigamex `
  -e MYSQL_ROOT_PASSWORD=pass123 `
  -e MYSQL_DATABASE=oxinik `
  -p 3306:3306 `
  -v C:\oxinik\mysql:/var/lib/mysql `
  mysql:8.0 `
  --default-authentication-plugin=mysql_native_password
```

Con esta opcion, los archivos de MySQL quedan en:

```text
C:\oxinik\mysql
```

Para este proyecto se recomienda mantener el volumen nombrado `oxinik-mysql-data`, salvo que realmente necesites respaldar o revisar la carpeta desde Windows.

## 10. Crear la base inicial con migraciones y seeders

Para una instalacion limpia y funcional, ejecuta migraciones y seeders. Esto crea la estructura de tablas y carga datos iniciales del sistema, como usuario administrador, permisos y catalogos.

No importes ningun archivo `.sql`, porque eso restauraria datos de otra instalacion.

```powershell
docker run --rm `
  --network networck-oxigamex `
  -e DB_HOST=mysql8 `
  -e DB_PORT=3306 `
  -e DB_DATABASE=oxinik `
  -e DB_USERNAME=root `
  -e DB_PASSWORD=pass123 `
  jeft613/oxinik:latest `
  php artisan migrate --seed --force
```

Verifica que se hayan creado las tablas:

```powershell
docker exec -it mysql8 mysql -uroot -ppass123 -e "SHOW TABLES FROM oxinik;"
```

Segun `database/seeds/AdminSeeder.php`, el seeder crea este usuario inicial:

```text
Usuario: sge.oxinik@gmail.com
Password: oxinik#2020
```

Despues de entrar al sistema, cambia la contrasena del usuario administrador.

## 11. Levantar el contenedor de la aplicacion

Ejecuta:

```powershell
docker run -d `
  --name oxinik-app `
  --network networck-oxigamex `
  -p 8086:8086 `
  -e APP_NAME=Oxinik `
  -e APP_URL=http://localhost:8086 `
  -e SESSION_DRIVER=file `
  -e SESSION_COOKIE=oxinik_session `
  -e SESSION_SECURE_COOKIE=false `
  -e DB_HOST=mysql8 `
  -e DB_PORT=3306 `
  -e DB_DATABASE=oxinik `
  -e DB_USERNAME=root `
  -e DB_PASSWORD=pass123 `
  jeft613/oxinik:latest
```

Revisa que el contenedor este corriendo:

```powershell
docker ps
```

Abre la aplicacion en el navegador:

```text
http://localhost:8086
```

Si al iniciar sesion aparece `419 Page Expired`, borra las cookies de `localhost` o abre una ventana de incognito. El contenedor ya define `SESSION_COOKIE=oxinik_session` para evitar choques con cookies de otros proyectos Laravel en la misma computadora.

## 12. Comandos utiles

Ver logs de la aplicacion:

```powershell
docker logs -f oxinik-app
```

Ver logs de MySQL:

```powershell
docker logs -f mysql8
```

Entrar al contenedor de la aplicacion:

```powershell
docker exec -it oxinik-app sh
```

Entrar a MySQL:

```powershell
docker exec -it mysql8 mysql -uroot -ppass123 oxinik
```

Detener los contenedores:

```powershell
docker stop oxinik-app mysql8
```

Iniciar nuevamente los contenedores:

```powershell
docker start mysql8 oxinik-app
```

Eliminar los contenedores, sin borrar el volumen de MySQL:

```powershell
docker rm -f oxinik-app mysql8
```

Eliminar tambien la informacion guardada de MySQL:

```powershell
docker volume rm oxinik-mysql-data
```

Si usaste carpeta visible de Windows en lugar del volumen nombrado, elimina esa carpeta:

```powershell
if (Test-Path C:\oxinik\mysql) { Remove-Item -Recurse -Force C:\oxinik\mysql }
```

## 13. Problemas comunes

Si la aplicacion no conecta a MySQL:

- Confirma que ambos contenedores esten en la red `networck-oxigamex`.
- Confirma que el contenedor MySQL se llame `mysql8`.
- Confirma que la app tenga `DB_HOST=mysql8`.
- Revisa logs con `docker logs -f oxinik-app`.

Si el puerto `8086` ya esta ocupado en Windows:

```powershell
docker run -d `
  --name oxinik-app `
  --network networck-oxigamex `
  -p 8087:8086 `
  -e APP_NAME=Oxinik `
  -e APP_URL=http://localhost:8087 `
  -e SESSION_DRIVER=file `
  -e SESSION_COOKIE=oxinik_session `
  -e SESSION_SECURE_COOKIE=false `
  -e DB_HOST=mysql8 `
  -e DB_PORT=3306 `
  -e DB_DATABASE=oxinik `
  -e DB_USERNAME=root `
  -e DB_PASSWORD=pass123 `
  oxinik:1.0
```

En ese caso abre:

```text
http://localhost:8087
```

Si el puerto `3306` ya esta ocupado en Windows, puedes publicar MySQL en otro puerto del host:

```powershell
docker run -d `
  --name mysql8 `
  --network networck-oxigamex `
  -e MYSQL_ROOT_PASSWORD=pass123 `
  -e MYSQL_DATABASE=oxinik `
  -p 3307:3306 `
  -v oxinik-mysql-data:/var/lib/mysql `
  mysql:8.0 `
  --default-authentication-plugin=mysql_native_password
```

Dentro de la red Docker la aplicacion debe seguir usando `DB_HOST=mysql8` y `DB_PORT=3306`.




```powershell
docker rm -f oxinik-app

docker run -d `
  --name oxinik-app `
  --network networck-oxigamex `
  -p 8086:8086 `
  -e APP_NAME=Oxinik `
  -e APP_URL=http://localhost:8086 `
  -e SESSION_DRIVER=file `
  -e SESSION_COOKIE=oxinik_session `
  -e SESSION_SECURE_COOKIE=false `
  -e DB_HOST=mysql8 `
  -e DB_PORT=3306 `
  -e DB_DATABASE=oxinik `
  -e DB_USERNAME=root `
  -e DB_PASSWORD=pass123 `
  oxinik:1.1



  docker exec -it oxinik-app sh -lc "rm -f storage/framework/sessions/* && php artisan cache:clear && php artisan config:clear"
```

# Proyecto de Oxinik

laravel : * v7.30.4
php : v7.4.33

# Levantar Proyecto

1. Instalar dependencias (si no lo has hecho ya)
Primero, asegúrate de tener todas las dependencias instaladas. Navega al directorio del proyecto y ejecuta el siguiente comando en la terminal:

```sh
    composer install
```

2. Configurar el archivo .env
Laravel usa un archivo .env para almacenar configuraciones específicas de entorno. Si el proyecto no tiene un archivo .env, puedes crear uno copiando el archivo .env.example:

```sh
cp .env.example .env
```

3. Generar la clave de la aplicación
Si no tienes la clave de la aplicación configurada, puedes generarla con el siguiente comando:

```sh
php artisan key:generate
```

4. Migrar la base de datos (si es necesario)
Si el proyecto usa base de datos y tienes migraciones que debes correr, puedes hacerlas con el siguiente comando:

```sh
php artisan migrate
```

5. Levantar el servidor de desarrollo
Una vez que tengas todo configurado, puedes levantar el servidor de desarrollo con el siguiente comando:


```sh
php artisan serve
```

6. Comprobar que el proyecto funciona
Abre tu navegador y visita http://127.0.0.1:8000 (o la URL que indique el comando php artisan serve). Si todo está correctamente configurado, deberías ver la página de inicio del proyecto.
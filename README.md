## Requerimiento de instalación.

- PHP 7.2.
- Laravel 7.3.
- Composer 2.0.1
- git 2.29.1.

## Pasos de instalacion

- git clone https://github.com/JuanOrmaza123/merqueoExam.git
- configurar en el archivo .env los datos de conexión a la base de datos.
- composer install.
- php artisan migrate.

## Instalar passport

- composer update.
- php artisan passport:install.
- php artisan key:generate.
- php artisan cache:clear.
- php artisan config:clear.

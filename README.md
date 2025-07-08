# README #

Instala las dependencias de Laravel: composer install

Copia el archivo .env: cp .env.example .env

Configura la conexión a la base de datos en .env:

DB_CONNECTION=mysql DB_PASSWORD= DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=prueba DB_USERNAME=root

Genera la clave de la aplicación:

php artisan key:generate

Ejecuta las migraciones:

php artisan migrate

Iniciar servdor

php artisan serve

  FRONTEND
cd frontend

Instala las dependencias:

npm install

Inicia la aplicación Angular:

ng serve



<p align="center"><img src="public/images/logo-color.png" width="300"></p>

## Acerca de ReservasYa

ReservasYa es una aplicación web donde los usuarios pueden reservar recursos limitados. El usuario administrador gestiona los recursos y horarios reservables.

## Características

Este repositorio corresponde al backend de la aplicación, fue desarrollado con las siguientes tecnologías:

- Framework Laravel v8 y lenguaje PHP v7.4.
- Base de datos Postgres v12 o mayor.
- Migrations y modelos relacionados. ORM Eloquent, agnóstico de la BD utilizada.
- Api JSON tipo REST
- Autenticacion básica por token, implementado con laravel sanctum.
- Validacion y control de peticiones [FormRequests](https://laravel.com/docs/8.x/validation#form-request-validation).
- Respuestas de listados paginados.
- Usuarios administradores y normales.
- Recuperación de contraseña olvidada.
- Rutas protegidas por middleware.
- Servicio web de html, css y js del frontend compilado.

El frontend se encuentra en [jlpalaciosb/reserva-vue](https://github.com/jlpalaciosb/reserva-vue).

## Instalación

- `cp .env.example .env`

- `composer install`

- `php artisan key:generate`

- Cree una base de datos postgres y establezca sus credenciales en el archivo .env.

- `php artisan migrate`

- `php artisan db:seed`

- `php artisan serve`

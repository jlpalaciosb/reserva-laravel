<p align="center"><a href="https://laravel.com" target="_blank"><img src="public/images/logo-color.png" width="300"></a></p>

## Acerca de ReservasYa

ReservasYa es una aplicación web donde los usuarios pueden reservar recursos limitados. El usuario administrador gestiona los recursos y horarios reservables.

## Demo

https://reservasya.herokuapp.com

## Características

Este repositorio corresponde la backend de la aplicación, fue desarrollado con las siguientes teconologías:

- Framework Laravel v8 y lenguaje PHP v7.4.
- Base de datos Postgres v12.
- Migrations y modelos relacionados. ORM Eloquent, agnóstico de la BD utilizada.
- Api JSON tipo REST
- Autenticacion básica por token, implementado con laravel sanctum.
- Validacion y control de peticiones [FormRequests](https://laravel.com/docs/8.x/validation#form-request-validation).
- Respuestas de listados paginados.
- Usuarios administradores y normales.
- Recuperación de contraseña olvidada.
- Rutas protegidas por middleware.
- Servicio web de html, css y js del [frontend](https://github.com/jlpalaciosb/reserva-vue) compilado.

## Frontend

https://github.com/jlpalaciosb/reserva-vue

## Instalación

`php composer.phar install`

`php artisan migrate`

`php artisan db:seed`

`php artisan serve`

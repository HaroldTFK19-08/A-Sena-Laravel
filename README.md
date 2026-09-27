<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## AdminSena

Plataforma Laravel para la gestión de formación del SENA. Incluye portales independientes y protegidos por rol para **instructores**, **aprendices** y **aspirantes**, además del panel administrativo.

### Portales

- **Instructor:** aprendices asignados, fichas, detalle de ficha, actividades, agenda, resultados y asignaciones de equipos.
- **Aprendiz:** ficha de formación, asignaciones propias, detalle de equipos, resultados y cronograma.
- **Aspirante:** ofertas, inscripciones, resultados, perfil y calendario de fechas de admisión.

Las consultas de los portales están limitadas al usuario autenticado y a su rol. Las pantallas incluyen filtros, estados vacíos, paginación y navegación responsive para móvil.

### Desarrollo

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
php artisan serve
```

La suite utiliza SQLite en memoria para no depender del servidor MySQL local:

```bash
php artisan test
```

### Datos de prueba

El proyecto incluye factories para todas las tablas de dominio y seeders idempotentes para cargarlas de forma realista:

```bash
php artisan migrate:fresh --seed
```

También se puede ejecutar un grupo o tabla específica:

```bash
php artisan db:seed --class=DatabaseSeeder
php artisan db:seed --class=ApprenticeSeeder
```

Las credenciales de demostración usan la contraseña `12345678`:

- `admin@adminsena.com`
- `instructor1@adminsena.com`
- `aprendiz1@adminsena.com`
- `aspirante1@adminsena.com`

### API REST

La API está versionada bajo `/v1` y utiliza Sanctum. Inicia sesión para obtener un token:

```bash
curl -X POST http://localhost:8000/v1/auth/login \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@adminsena.com","password":"12345678","device_name":"local"}'
```

Después envía el token en las operaciones protegidas:

```bash
curl http://localhost:8000/v1/centros \
  -H "Accept: application/json" \
  -H "Authorization: Bearer TU_TOKEN"
```

Recursos CRUD disponibles:

```text
/v1/centros
/v1/areas
/v1/ambientes
/v1/equipos
/v1/programas
/v1/fichas
/v1/competencias
/v1/resultados
/v1/calificaciones
/v1/asignaciones
/v1/ofertas
/v1/inscripciones
/v1/noticias
/v1/usuarios
```

Cada recurso expone `GET`, `POST`, `GET /{id}`, `PUT/PATCH /{id}` y `DELETE /{id}`. Las operacionesInstitucionales, usuarios, noticias, ofertas, fichas, competencias y resultados exigen rol `Admin`; asignaciones, calificaciones e inscripciones aplican además el ámbito del rol.

### Documentación técnica

- [Informe PDF para presentación](docs/AdminSena-explicacion-tecnica.pdf)
- [Explicación técnica en Markdown](docs/AdminSena-explicacion-tecnica.md)
- [Documentación de la API REST](docs/AdminSena-API.md)

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

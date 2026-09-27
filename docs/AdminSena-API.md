# AdminSena API REST

La API está versionada bajo `/v1`.

> [!IMPORTANT]
> **Las rutas API y web están abiertas** (proyecto de práctica). No se aplica
> middleware de autenticación (`auth`, `auth:sanctum`) ni de rol (`admin`,
> `instructor`, `aprendiz`, `aspirante`) en las definiciones de ruta, y los
> controladores tampoco bloquean cuando no llega un token.
>
> El token Bearer es **opcional**: si lo envías, el alcance del rol se aplica
> dentro de los controladores. Si no lo envías, todos los endpoints responden
> con normalidad.

## Autenticación (opcional)

### Iniciar sesión

```http
POST /v1/auth/login
Content-Type: application/json
Accept: application/json
```

```json
{
  "email": "admin@adminsena.com",
  "password": "12345678",
  "device_name": "mi-aplicacion"
}
```

Respuesta:

```json
{
  "success": true,
  "message": "Sesión iniciada correctamente.",
  "data": {
    "user": {},
    "token": "1|xxxxxxxx",
    "token_type": "Bearer"
  }
}
```

### Usuario autenticado

```http
GET /v1/auth/me
Authorization: Bearer TOKEN
Accept: application/json
```

### Cerrar sesión

```http
POST /v1/auth/logout
Authorization: Bearer TOKEN
Accept: application/json
```

### Registrar usuario

```http
POST /v1/auth/register
Content-Type: application/json
Accept: application/json
```

El registro acepta los roles `aprendiz`, `instructor` y `aspirante`, y los normaliza internamente a `Aprendiz`, `Instructor` y `Aspirante`.

## Formato de respuestas

Las respuestas JSON usan esta forma:

```json
{
  "success": true,
  "message": "Operación realizada correctamente.",
  "data": {}
}
```

Los listados incluyen paginación:

```json
{
  "success": true,
  "message": "Listado obtenido correctamente.",
  "data": [],
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 15,
    "total": 42
  }
}
```

## Recursos CRUD

Todos los recursos tienen:

- `GET /v1/{recurso}`: listar y filtrar.
- `POST /v1/{recurso}`: crear.
- `GET /v1/{recurso}/{id}`: consultar.
- `PUT|PATCH /v1/{recurso}/{id}`: actualizar.
- `DELETE /v1/{recurso}/{id}`: eliminar.

Recursos disponibles:

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

## Roles y permisos

Los roles se aplican **dentro de los controladores**, no como middleware de ruta.
Todos los endpoints responden **sin token**:

- `Admin`: CRUD completo de centros, áreas, ambientes, equipos, programas, fichas, competencias, resultados, ofertas, noticias y usuarios.
- `Instructor`: consulta y opera asignaciones y calificaciones dentro de sus fichas y competencias.
- `Aprendiz`: consulta únicamente sus asignaciones y calificaciones.
- `Aspirante`: consulta ofertas publicadas, gestiona sus inscripciones y solo puede cancelar las que están en estado editable.

Cuando **sí** envías un token, el alcance del rol se aplica: un `Instructor` solo
ve las asignaciones de sus fichas, un `Aprendiz` solo las suyas, un `Aspirante`
solo sus inscripciones, y así sucesivamente. Enviar el token incorrecto o de
otro rol devuelve `403` en las operaciones de escritura.

Para reactivar la protección por rol, pon `API_PRACTICE_MODE=false` en `.env`.

## Ejemplos

### Listar centros con búsqueda

```http
GET /v1/centros?buscar=tecnológico&per_page=10
Authorization: Bearer TOKEN
Accept: application/json
```

### Crear un centro

```http
POST /v1/centros
Authorization: Bearer TOKEN
Content-Type: application/json
Accept: application/json
```

```json
{
  "nombre": "Centro de Formación Tecnológica",
  "direccion": "Carrera 7 # 100-20"
}
```

### Crear una oferta

```http
POST /v1/ofertas
Authorization: Bearer TOKEN
Content-Type: application/json
Accept: application/json
```

```json
{
  "program_id": 1,
  "capacidad": 30,
  "fecha_lanzamiento": "2026-09-27",
  "fecha_convocatoria": "2026-10-01",
  "fecha_fin_convocatoria": "2026-10-30",
  "fecha_primera_prueba": "2026-11-15",
  "fecha_segunda_prueba": "2026-11-30",
  "fecha_seleccionados": "2026-12-10",
  "publicada": true
}
```

### Registrar una calificación

```http
POST /v1/calificaciones
Authorization: Bearer TOKEN
Content-Type: application/json
Accept: application/json
```

```json
{
  "result_id": 1,
  "apprentice_id": 1,
  "teacher_id": 1,
  "estado_resultado": "Aprobado",
  "comentarios": "Cumple el resultado de aprendizaje."
}
```

## Comandos de verificación

```bash
php artisan test --filter=ApiCrudTest
php artisan route:list | grep v1
```

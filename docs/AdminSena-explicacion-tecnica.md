# AdminSena
## Explicación técnica y funcional del proyecto

**Documento de presentación · 24 de septiembre de 2026**

> Documento elaborado a partir de la inspección estática del código fuente actual. Las cifras de inventario describen archivos, rutas y pruebas del repositorio; no representan métricas de una base de datos productiva.

---

## 1. Resumen ejecutivo

AdminSena es una plataforma Laravel para organizar la formación técnica del SENA. El sistema integra:

- Un portal público institucional.
- Autenticación de usuarios y acceso por rol.
- Un panel administrativo para la estructura institucional y la operación académica.
- Un portal para instructores con alcance sobre sus fichas, aprendices, competencias, resultados y equipos.
- Un portal para aprendices con información de su ficha, equipos, calificaciones y cronograma.
- Un portal para aspirantes con ofertas, inscripciones, documentos, estados y fechas del proceso de admisión.
- Factories y seeders para las 20 tablas de dominio.

### Inventario actual

| Elemento | Cantidad | Interpretación |
|---|---:|---|
| Módulos bajo `app/Dominios` | 14 | _auth_, usuarios, estructura, operación, admisión y contenido |
| Tablas de dominio | 20 | Tablas propias de negocio; se excluyen las internas de Laravel |
| Controladores de dominio | 24 | CRUD y flujos específicos por módulo |
| Vistas Blade | 134 | Dashboards, CRUD, formularios, layouts, componentes e inclusions |
| Rutas registradas | 222 | Web y API versionada, incluyendo las rutas generadas por Laravel |
| Factories | 20 | Una por tabla/modelo de dominio, incluidas las dos pivotes |
| Seeders | 22 | 20 seeders de dominio + `DatabaseSeeder` + compatibilidad `AdminUserSeeder` |
| Migraciones | 24 | 21 relacionadas con dominio y 3 internas de Laravel/Sanctum |
| Pruebas | 23 tests / 243 assertions | Suite ejecutada con SQLite en memoria |
| Vite build | Correcto | Vite 6.4.3, Laravel Vite Plugin 1.3 y Tailwind 4 |

### Conclusión ejecutiva

La arquitectura ya tiene una separación por dominios clara, relaciones Eloquent bien expresadas y portales con consultas acotadas por usuario/rol. La siguiente etapa no es añadir más pantallas: es cerrar los contratos de autorización, corregir algunos riesgos de consistencia/publicación y convertir algunos indicadores decorativos en métricas consultadas desde la base de datos.

---

## 2. Arquitectura general

### 2.1 Flujo de una petición

```text
Navegador
   ↓
Middleware web / sesión / CSRF / bindings
   ↓
RouteServiceProvider + rutas del dominio
   ↓
Middleware de autenticación y rol
   ↓
Controller
   ↓
FormRequest (validación y autorización puntual)
   ↓
Modelo Eloquent + relaciones + consultas
   ↓
MySQL en desarrollo / SQLite en pruebas
   ↓
Blade + Tailwind/Vite
```

### 2.2 Composición de una URL

El proyecto organiza las rutas por dominio en archivos independientes:

```text
app/Dominios/Usuarios/Routes/web.php
app/Dominios/Inscripciones/Routes/web.php
app/Dominios/Resultados/Routes/web.php
...
```

`RouteServiceProvider` carga explícitamente los archivos web y API de cada módulo. Esta decisión hace visible la separación de responsabilidades y permite que cada dominio evolucione sin depender de un único `routes/web.php` monolítico.

### 2.3 Middleware

El `Http\Kernel` registra los alias:

- `auth`: exige sesión autenticada.
- `admin`: exige rol `Admin`.
- `instructor`: exige rol `Instructor`.
- `aprendiz`: exige rol `Aprendiz`.
- `aspirante`: exige rol `Aspirante`.

Los grupos de middleware `web` añaden cookies cifradas, sesión, CSRF y sustitución de bindings. El grupo `api` aplica throttling de 60 solicitudes por minuto y bindings.

### 2.4 Autenticación y modelo de usuario

El modelo real de autenticación es:

```text
app/Dominios/Usuarios/Models/User.php
```

No debe confundirse con el modelo esqueleto `app/Models/User.php`, que no es el modelo usado por `config/auth.php`.

`User` contiene los datos de identidad y el campo `rol`. A partir de esa identidad se asocian perfiles opcionales `hasOne`:

```text
User ── Admin
  ├── Teacher
  ├── Apprentice
  └── Aspirant
```

El login regenera la sesión y redirige según el rol:

- `Admin` → `admin.home`
- `Instructor` → `instructor.home`
- `Aprendiz` → `aprendiz.home`
- `Aspirante` → `aspirante.home`

### 2.5 Frontend

- Vite 6.4.3.
- Laravel Vite Plugin 1.3.
- Tailwind CSS 4.3.3.
- Bootstrap Icons como paquete de iconos.
- JavaScript de aplicación compilado mediante `npm run build`.

El layout principal de portals es `Layouts/Usuarios/AppAdmin.blade.php`. Aunque su nombre histórico es `AppAdmin`, decide dinámicamente qué sidebar y header usar según el nombre de la ruta. `AppAprendiz.blade.php` existe como layout legado y no contiene el portal funcional; las vistas activas extenderán el layout dinámico.

### 2.6 API REST

La API está versionada bajo `/v1` y utiliza Laravel Sanctum. El login en `POST /v1/auth/login` devuelve un token Bearer; `GET /v1/auth/me` permite recuperar el usuario autenticado y `POST /v1/auth/logout` revoca el token.

Los controladores API están organizados en `Controllers/Api` dentro de cada dominio y siguen una respuesta común con `success`, `message`, `data` y, en listados, `meta` de paginación.

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

Cada recurso expone `GET`, `POST`, `GET /{id}`, `PUT/PATCH /{id}` y `DELETE /{id}`. Los endpoints institucionales exigen rol `Admin`; asignaciones, calificaciones e inscripciones aplican el alcance del Instructor, Aprendiz o Aspirante.

La referencia completa de la API está en [AdminSena-API.md](AdminSena-API.md).

---

## 3. Mapa de dominios

### 3.1 Identidad y acceso

#### Auth

**Propósito:** portada pública, acceso, registro, noticias y ofertas públicas.

**Rutas principales:**

- `GET /` → `auth.inicio`
- `GET|POST /login`
- `GET|POST /register`
- `GET /noticias-publicas`
- `GET /noticias-publicas/buscar`
- `GET /noticias-publicas/{noticia}` → `auth.noticias.show`
- `GET /ofertas-publicas`
- `GET /ofertas-publicas/buscar`
- `GET /ofertas-publicas/{oferta}` → `auth.ofertas.show`

**Vistas:**

- `Auth/inicio.blade.php`: hero institucional, métricas-presentación, tarjetas de módulos, noticias y ofertas destacadas.
- `Auth/login.blade.php`: formulario de acceso.
- `Auth/register.blade.php`: formulario de registro por pasos.
- `Auth/noticias.blade.php`: listado, búsqueda por título/categoría y tarjetas.
- `Auth/noticia.blade.php`: detalle individual de una noticia publicada.
- `Auth/ofertas.blade.php`: catálogo, buscador por programa/código/área, cupos y fechas.
- `Auth/oferta.blade.php`: detalle individual de una oferta publicada, programa, calendario y CTA de inscripción.
- `Includes/Auth/*`: header, footer, formularios y navegación pública.

El catálogo público aplica dos filtros: las ofertas deben tener `publicada = true` y las noticias deben tener `publicada = true` y `estado = 'Publicado'`. Las tarjetas enlazan a sus rutas `show`; un intento de abrir contenido no publicado responde `404`.

#### Usuarios

**Propósito:** identidad común, perfiles de rol y portales autenticados.

**Modelos:** `User`, `Admin`, `Teacher`, `Apprentice`, `Aspirant`.

**Vistas por rol:**

- Admin: `Usuarios/Admin/*`.
- Instructor: `Usuarios/Instructores/*`.
- Aprendiz: `Usuarios/Aprendices/*`.
- Aspirante: `Usuarios/Aspirantes/*`.
- Formulario compartido: `Usuarios/partials/formularioPerfil.blade.php`.

### 3.2 Estructura institucional

#### Centros

**Modelo:** `Trainingcenter`.

**Campos de negocio:** nombre y dirección.

**Relaciones:** un centro tiene muchas áreas y muchos ambientes.

**Funcionalidad:** CRUD de centros con listados, formularios, edición y detalle.

**Vista principal:** `Centros/index.blade.php`.

#### Áreas

**Modelo:** `Area`.

**Campos:** `trainingcenter_id`, nombre.

**Relación:** un área pertenece a un centro y tiene muchos programas.

**Funcionalidad:** CRUD; el listado carga el centro y cuenta programas.

**Vista principal:** `Areas/index.blade.php`.

#### Programas

**Modelo:** `Program`.

**Campos:** área, nombre, código único y nivel (`Tecnico` o `Tecnologo`).

**Relación:** un programa pertenece a un área y puede tener ofertas.

**Funcionalidad:** CRUD con validación de código único y nivel.

**Vista principal:** `Programas/index.blade.php`.

#### Ambientes

**Modelo:** `Environment`.

**Campos:** centro, nombre, capacidad y tipo (`Software`, `TICS`, `Laboratorio`, `Cocina`).

**Relación:** un ambiente pertenece a un centro y tiene equipos.

**Funcionalidad:** CRUD y selección de centro en alta/edición.

**Vista principal:** `Ambientes/index.blade.php`.

#### Equipos

**Modelo:** `Equipment`.

**Campos:** ambiente, nombre, marca y tipo.

**Relación:** un equipo pertenece a un ambiente y puede tener asignaciones.

**Funcionalidad:** CRUD e inventario de equipos.

**Vista principal:** `Equipos/index.blade.php`.

### 3.3 Formación y operación académica

#### Fichas

**Modelo:** `Course_group`.

**Campos:** programa, instructor principal, código único y capacidad de aprendices.

**Relaciones:**

```text
Program 1 ── N Course_group
Teacher 1 ── N Course_group (teacher_id)
Course_group N ── N Teacher (course_group_teacher)
Course_group 1 ── N Apprentice
```

La aplicación usa el instructor principal y la relación pivote para determinar si una ficha pertenece al alcance de un instructor. El `CourseGroupRequest` exige que el instructor principal sea de tipo `Planta`.

**Funcionalidad:** CRUD administrativo y detalle de ficha con programa, instructores y aprendices.

#### Competencias

**Modelo:** `Competition`.

**Campos:** instructor principal opcional, código, nombre, descripción y fechas.

**Relaciones:**

```text
Teacher 1 ── N Competition (teacher_id)
Competition N ── N Teacher (competition_teacher)
Competition 1 ── N Result
```

**Funcionalidad:** CRUD, asignación de instructores y relación con resultados de aprendizaje.

#### Resultados y calificaciones

**Modelos:** `Result` y `Grade`.

`Result` representa un resultado de aprendizaje de una competencia. Tras la migración de reestructuración, contiene `competition_id`, código, nombre y descripción.

`Grade` representa la calificación de un aprendiz para un resultado concreto. Contiene estado (`Aprobado`, `Reprobado`, `Pendiente`), comentarios, maestro evaluador y una restricción única para `(result_id, apprentice_id)`.

**Funcionalidad:**

- Admin: CRUD de resultados, resumen de aprobados/reprobados/pendientes y bloqueo de eliminación si existen grades.
- Instructor: vista de resultados por ficha, matriz de calificación y `updateOrCreate`.
- Aprendiz: historial de sus propias calificaciones y resumen por estado.

**Vistas:**

- `Resultados/index.blade.php`
- `Resultados/show.blade.php`
- `Resultados/Instructor/index.blade.php`
- `Resultados/Instructor/ficha.blade.php`
- `Resultados/Instructor/calificar.blade.php`
- `Resultados/Aprendiz/index.blade.php`

#### Asignaciones

**Modelo:** `Assignment`.

**Campos:** equipo, aprendiz, fecha de asignación, fecha de devolución y estado (`Activo`/`Inactivo`).

**Relaciones:** equipo–ambiente y aprendiz–ficha.

**Funcionalidad:**

- Admin: listar y consultar.
- Instructor: crear, editar, eliminar y supervisar; el alcance se limita a aprendices de sus fichas.
- Aprendiz: listar y consultar únicamente sus propias asignaciones.
- La búsqueda de instructor usa relaciones `whereHas`; la vista de aprendiz debe revisarse porque actualmente intenta filtrar columnas de `equipment` sin join.

### 3.4 Admisión y comunicación

#### Ofertas

**Modelo:** `Offer`.

**Campos:** administrador responsable, programa, capacidad, imágenes, bandera `publicada` y secuencia de fechas de convocatoria/pruebas/selección.

**Relaciones:** oferta → programa y oferta → inscripciones.

**Funcionalidad:**

- Admin: CRUD, publicar y despublicar.
- Aspirante: ver solamente ofertas publicadas, consultar detalle y comprobar apertura/capacidad.
- Público: catálogo de ofertas, aunque la ruta de búsqueda actual tiene un problema de contrato.

#### Inscripciones

**Modelo:** `Registration`.

**Campos:** aspirante, oferta, estado y fecha de inscripción.

**Estados:** `Registrado`, `En proceso`, `Seleccionado`, `Rechazado`, `Cancelada`.

**Reglas de negocio del modelo:**

- Solo `Registrado` permite edición por el Aspirante.
- `Registrado` y `En proceso` permiten cancelación.
- `Cancelada` no cuenta como inscripción activa.
- El controlador de alta evita una segunda inscripción activa para la misma pareja aspirante/oferta.

**Funcionalidad:** administración de estados, filtros y seguimiento, además del autoservicio del Aspirante con comprobaciones de propiedad.

#### Noticias

**Modelo:** `News`.

**Campos:** centro, administrador autor, título, descripción, imagen, estado, categoría y publicación.

**Estados:** `Creado`, `Pendiente`, `Publicado`.

**Categorías:** `Tecnologia`, `Educacion`, `Deporte`, `Politica`, `Artistica`, `Diseño`.

**Funcionalidad:** CRUD administrativo y consulta/búsqueda pública. La lógica actual de publicación debe unificarse para que el portal público no exponga contenido no publicado.

---

## 4. Diccionario de datos

| Tabla | Modelo | Claves y campos esenciales | Dependencias |
|---|---|---|---|
| `users` | `User` | identidad, email, password, `rol` | Base de todos los perfiles |
| `trainingcenters` | `Trainingcenter` | nombre, dirección |Raíz institucional |
| `admins` | `Admin` | `user_id`, cargo, oficina | users |
| `aspirants` | `Aspirant` | `user_id`, EPS, documentos | users |
| `areas` | `Area` | `trainingcenter_id`, nombre | trainingcenters |
| `environments` | `Environment` | centro, capacidad, tipo | trainingcenters |
| `teachers` | `Teacher` | `user_id`, área, especialidad, tipo | users, areas |
| `equipments` | `Equipment` | ambiente, nombre, marca, tipo | environments |
| `programs` | `Program` | área, código, nivel | areas |
| `news` | `News` | centro, admin, estado, categoría | trainingcenters, admins |
| `course_groups` | `Course_group` | programa, teacher principal, código, capacidad | programs, teachers |
| `apprentices` | `Apprentice` | user, ficha, estado, fechas | users, course_groups |
| `offers` | `Offer` | admin, programa, capacidad, fechas, publicada | admins, programs |
| `competitions` | `Competition` | teacher principal, código, fechas | teachers |
| `results` | `Result` | `competition_id`, código, nombre | competitions |
| `grades` | `Grade` | result, apprentice, teacher, estado | results, apprentices, teachers |
| `registrations` | `Registration` | aspirante, oferta, estado, fecha | aspirants, offers |
| `assignments` | `Assignment` | equipo, aprendiz, fechas, estado | equipments, apprentices |
| `competition_teacher` | `CompetitionTeacher` | `competency_id`, `teacher_id` | competitions, teachers |
| `course_group_teacher` | `CourseGroupTeacher` | `course_group_id`, `teacher_id` | course_groups, teachers |

### Relaciones de negocio

```text
Centro
 ├── Áreas ── Programas ── Ofertas ── Inscripciones ── Aspirantes
 └── Ambientes ── Equipos ── Asignaciones ── Aprendices

Programa ── Fichas ── Aprendices
                 └── Aprendices ── Calificaciones ── Resultados ── Competencias
                                   └── Asignaciones ── Equipos

Usuario ── perfil de rol
Teacher ── Fichas (principal y pivote)
Teacher ── Competencias (principal y pivote)
```

---

## 5. Vistas, navegación y experiencia de usuario

### 5.1 Layout común

`resources/views/Layouts/Usuarios/AppAdmin.blade.php` es el shell activo de los portales:

1. Selecciona el sidebar por prefijo de ruta.
2. Selecciona el header por portal.
3. Carga el contenido desde `@yield('contenido')`.
4. Usa Vite para CSS.
5. Añade una barra de navegación inferior en móvil.

### 5.2 Sidebar

`resources/views/Includes/Usuarios/Sidebar.blade.php` es un componente reutilizable. Recibe:

- `portalTitle`.
- `portalSubtitle`.
- Tema de color.
- Secciones y elementos de navegación.

Cada elemento usa una ruta nombrada, un icono SVG y un patrón `active`. El enlace activo se obtiene con `request()->routeIs()`.

Los cuatro sidebarspezz-specific passthrough son:

- `Admin/Sidebar.blade.php`: estructura institucional, operación, contenido y usuarios.
- `Instructores/Sidebar.blade.php`: aprendices, fichas, resultados, asignaciones, actividades y agenda.
- `Aprendices/Sidebar.blade.php`: ficha, asignaciones, resultados, perfil y cronograma.
- `Aspirantes/Sidebar.blade.php`: ofertas, inscripciones, resultados, perfil y fechas.

Existe un fallback genérico `href="#"` dentro del componente compartido. Los sidebars de rol ya utilizan rutas reales, pero el fallback debe eliminarse para evitar enlaces no funcionales en futuras configuraciones.

### 5.3 Componentes compartidos

- `components/portal/page-header.blade.php`: encabezado consistente de página.
- `components/portal/metric.blade.php`: métrica de dashboard.
- `components/portal/empty-state.blade.php`: estado vacío accionable.
- `components/portal/status-badge.blade.php`: etiquetas visuales de estado.

Estos componentes reducen duplicación y mantienen la misma jerarquía visual en los cuatro portales.

### 5.4 Vistas por portal

#### Administrador

- Dashboard: totales de centros y aprendices, accesos rápidos, cobertura, asignaciones y procesos completados.
- `Centros/*`: listar, crear, editar, ver y eliminar.
- `Areas/*`: áreas por centro y conteo de programas.
- `Programas/*`: programas, área, nivel y ofertas.
- `Ambientes/*`: ambientes, tipo y capacidad.
- `Equipos/*`: inventario y ambiente.
- `Fichas/*`: grupos formativos, instructor y aprendices.
- `Competencias/*`: competencias e instructores relacionados.
- `Resultados/*`: resultados, competencias y grades.
- `Inscripciones/*`: consulta, filtros por búsqueda/oferta/estado y cambio de estado.
- `Noticias/*` y `Ofertas/*`: gestión y publicación.
- `Asignaciones/*`: consulta institucional.
- `Usuarios/Admin/usuarios.blade.php`: búsqueda y filtro por rol.

#### Instructor

- Dashboard: aprendices, fichas, competencias, asignaciones y progreso de calificación.
- Aprendices: filtros por estado, ficha y texto; paginación y resumen.
- Fichas: listado, capacidad, disponibilidad y detalle autorizado.
- Resultados: índice, ficha, matriz de calificación y guardado.
- Asignaciones: CRUD con alcance por ficha.
- Actividades: filtros por estado y búsqueda de equipo/aprendiz.
- Agenda: eventos de inicio/cierre de ficha, competencias, equipos y devoluciones.

#### Aprendiz

- Dashboard: ficha, asignaciones, resultados y progreso.
- Mi ficha: programa, área, instructores, competencias, equipos y resumen.
- Asignaciones: filtro por estado/búsqueda y detalle con comprobación de propietario.
- Resultados: historial y conteo por estado.
- Cronograma: eventos agrupados y próximos.
- Perfil: datos personales y ficha.

#### Aspirante

- Dashboard: inscripciones activas, documentos, estado y avance documental.
- Ofertas: catálogo publicado, búsqueda y detalle.
- Inscripciones: alta, documentos, lista, detalle, edición y cancelación según estado.
- Resultados: resumen de seleccionadas, en proceso y rechazadas.
- Fechas: cronología completa de inscripción y convocatoria.
- Perfil: identidad, EPS y documentos.

### 5.5 Responsive

El layout de escritorio usa sidebar fijo. En móvil se oculta el sidebar y aparece una barra inferior con desplazamiento horizontal. Las vistas aplican `grid`, `flex`, `overflow-x-auto`, `md:`, `lg:` y `xl:` para cambiar la composición según el ancho.

---

## 6. Validación y reglas de negocio

### Identidad

- Tipo de identificación: `CC`, `TI`, `CE`, `PPT`.
- Email e identificación son únicos.
- Password se cifra con `Hash::make`.
- La sesión se regenera después del login.

### Estructura

- Centro: nombre de mínimo 5 caracteres, letras y espacios; dirección mínima de 10.
- Área: mínimo 3 caracteres y centro válido.
- Ambiente: capacidad positiva y tipo enum.
- Programa: código único y nivel `Tecnico`/`Tecnologo`.
- Ficha: código único, capacidad positiva e instructor principal `Planta`.

### Ofertas

Las fechas deben seguir esta secuencia:

```text
fecha_lanzamiento
≤ fecha_convocatoria
< fecha_fin_convocatoria
< fecha_primera_prueba
≤ fecha_seleccionados
```

La segunda prueba es opcional, pero, si se informa, debe ser posterior a la primera.

### Asignaciones

- Equipo y aprendiz deben existir.
- La devolución no puede ser anterior a la asignación.
- Estado limitado a `Activo` o `Inactivo`.

### Calificaciones

Cada fila de la matriz debe apuntar a un resultado y a un aprendiz existentes. El estado es `Aprobado`, `Reprobado` o `Pendiente`. El controlador Instructor también verifica que ambos IDs pertenezcan a la ficha y competencia autorizadas.

### Inscripciones

- El Aspirante solo puede ver y modificar sus propias inscripciones.
- Solo se edita en `Registrado`.
- Solo se cancela en `Registrado` o `En proceso`.
- Una inscripción `Cancelada` no cuenta para capacidad ni proceso activo.
- `AspirantRegistrationRequest` exige documentos EPS, bachiller e ICFES si aún no existen.

---

## 7. Factories y seeders

### 7.1 Factories

Se crearon factories planas en `database/factories` para:

```text
User, Trainingcenter, Area, Environment, Program, Equipment, News,
Admin, Teacher, CourseGroup, Apprentice, Aspirant, Competition,
Result, Grade, Offer, Registration, Assignment,
CompetitionTeacher, CourseGroupTeacher
```

`AppServiceProvider` configura un resolver global que transforma el basename del modelo en el nombre plano de la factory. Esto permite que modelos bajo `App\Dominios` usen `Model::factory()` sin duplicar namespaces.

Estados destacados:

```php
User::factory()->admin();
User::factory()->instructor();
User::factory()->apprentice();
User::factory()->aspirant();

Grade::factory()->aprobado();
Grade::factory()->reprobado();
Grade::factory()->pendiente();

Registration::factory()->registrado();
Registration::factory()->cancelada();
```

Las factories respetan enums, claves foráneas, fechas de oferta, capacidad, uniques y la estructura final de `results`/`grades`.

### 7.2 Seeders

Los seeders de dominio son:

```text
UserSeeder
TrainingCenterSeeder
AreaSeeder
EnvironmentSeeder
ProgramSeeder
EquipmentSeeder
AdminSeeder
TeacherSeeder
CourseGroupSeeder
ApprenticeSeeder
AspirantSeeder
CompetitionSeeder
ResultSeeder
OfferSeeder
RegistrationSeeder
GradeSeeder
AssignmentSeeder
NewsSeeder
CompetitionTeacherSeeder
CourseGroupTeacherSeeder
```

`DatabaseSeeder` los carga en orden. Cada seeder puede resolver sus dependencias directas y utiliza `updateOrCreate`/`sync` para ser idempotente.

`AdminUserSeeder` se conserva como wrapper compatible y delega en `UserSeeder` + `AdminSeeder`; así el administrador tiene fila en `users` y también en `admins`.

### 7.3 Datos demo

Contraseña de todos los usuarios generados por factories y seeders:

```text
12345678
```

Cuentas principales:

```text
admin@adminsena.com
instructor1@adminsena.com
instructor2@adminsena.com
aprendiz1@adminsena.com
aspirante1@adminsena.com
```

La base almacena hashes, no contraseñas en texto plano.

---

## 8. Pruebas y calidad

### 8.1 Suite actual

```bash
php artisan test --compact
```

Resultado validado:

```text
23 tests
243 assertions
```

La configuración de `phpunit.xml` usa SQLite en memoria. Esto permite validar migraciones, factories, seeders, relaciones y autorización sin depender de MySQL local.

### 8.2 Cobertura existente

- Navegación básica de los cuatro portales.
- Separación de roles.
- Aislamiento de aprendices por ficha.
- Aislamiento por propietario en asignaciones.
- Cronograma aislado por Aspirante.
- Smoke test que crea una instancia de cada factory.
- Idempotencia del `DatabaseSeeder`.

### 8.3 Comandos de soporte

```bash
php artisan migrate:fresh --seed
php artisan db:seed --class=DatabaseSeeder
php artisan db:seed --class=ApprenticeSeeder
php artisan test
npm run build
npm audit
vendor/bin/pint --test
```

`migrate:fresh` destruye las tablas. Debe usarse únicamente sobre una base descartable.

---

## 9. Riesgos y deuda técnica identificada

Esta sección distingue funcionalidades implementadas de riesgos que todavía deben cerrarse. Son hallazgos de inspección estática y no sustituyen una prueba HTTP contra cada ruta.

### P0 — seguridad y correcciones funcionales

1. **Redirección de invitados:** `Authenticate::redirectTo()` llama `route('login')`, pero la ruta real se llama `auth.login`. Debe corregirse y agregar pruebas de invitados.
2. **CRUD institucional expuesto:** las rutas web de Centros, Ambientes, Áreas, Programas y Equipos no tienen middleware `auth/admin` en el grupo actual.
3. **Registro inconsistente:** `RegisterRequest` acepta roles en minúsculas, mientras el enum y los middlewares usan mayúsculas. `RegisterController` crea solo `User` y no crea el perfil de dominio.
4. **Binding de resource:** el resource de inscripciones genera `{inscripcion}`, pero `RegistrationController` utiliza `{inscripcione}` en el binding implícito.
5. **Documentos sensibles:** documentos de Aspirantes se guardan en `documents` con disco `public`; deberían usar disco privado y autorización de descarga.
6. **Edición de ficha por Aprendiz:** el formulario permite modificar ficha, estado y fechas; esos campos deberían pertenecer a Admin/Instructor.

### P1 — integridad académica y publicación

1. Unificar las reglas de publicación entre modelos, requests y vistas administrativas.
2. Unificar `teacher_id` y `teachers[]` en formularios/requests de competencias.
3. Corregir la búsqueda de asignaciones del Aprendiz para usar `whereHas('equipment', ...)`.
4. Añadir restricciones únicas de negocio para inscripción activa, asignaciones activas y pivotes.
5. Separar datos de demostración de métricas reales en dashboards.
6. Implementar logout, `remember` y corregir `RouteServiceProvider::HOME`.

### P2 — mantenimiento

1. Eliminar o marcar como obsoleto `AppAprendiz`.
2. Normalizar nombres de clases y columnas heredadas (`TrainingCenter/Trainingcenter`, `competency_id`).
3. Introducir Policies para autorización por objeto y no solo por rol.
4. Añadir CI con SQLite aislado.
5. Completar pruebas de resource bindings, archivos, onboarding y autorización.
6. Versionar y documentar la API: la API CRUD está bajo `/v1`, pero conviene añadir versionado de cambios y contratos OpenAPI.

---

## 10. Roadmap senior recomendado

### Fase 1 — seguridad y contratos

- Corregir redirección de invitados.
- Proteger los CRUD institucionales.
- Normalizar roles y crear perfiles transaccionalmente.
- Corregir bindings y la ruta de búsqueda pública.
- Mover documentos a disco privado.

### Fase 2 — calidad de dominio

- Unificar publicación de noticias/ofertas.
- Introducir Policies.
- Corregir filtros y contratos de formularios.
- Añadir uniques de negocio.
- Separar métricas reales de valores de demostración.

### Fase 3 — operación

- Implementar logout/remember.
- Añadir auditoría de cambios de estado y calificaciones.
- Crear jobs para procesamiento de archivos y reportes.
- Añadir una especificación OpenAPI y versionado de la API después de cerrar los contratos actuales.

### Fase 4 — entrega

- Pipeline de CI.
- Migraciones de base de datos en entorno aislado.
- Pruebas de navegador para los tres portales.
- Documentación de despliegue, backups y observabilidad.

---

## 11. Glosario

| Término | Significado en AdminSena |
|---|---|
| Ficha | `Course_group`, agrupación de aprendices vinculada a un programa e instructor |
| Competencia | `Competition`, unidad de desempeño con fecha y responsables |
| Resultado | `Result`, resultado de aprendizaje dentro de una competencia |
| Calificación | `Grade`, evaluación de un aprendiz para un resultado |
| Oferta | `Offer`, convocatoria formativa con programa, fechas y capacidad |
| Inscripción | `Registration`, vínculo entre Aspirante y Oferta |
| Asignación | `Assignment`, entrega de un equipo a un aprendiz |
| Ámbito | Conjunto de datos visibles según rol, ficha o propietario |

---

## 12. Conclusión

AdminSena ya posee una base de aplicación modular y una experiencia visual consistente para los portales. La arquitectura de dominios facilita la extensión y las factories/seeders hacen que los datos de prueba sean verificables y coherentes.

El siguiente salto de calidad no consiste únicamente en terminar CRUD: consiste en convertir el sistema en una plataforma segura y operable. Las prioridades son autorización por objeto, privacidad de documentos, publicación consistente, contratos de datos estables y métricas basadas en consultas reales.

**Archivos de referencia principales:**

```text
app/Providers/RouteServiceProvider.php
app/Http/Kernel.php
app/Dominios/
resources/views/Layouts/Usuarios/AppAdmin.blade.php
resources/views/Includes/Usuarios/Sidebar.blade.php
database/factories/
database/seeders/
database/migrations/
tests/Feature/
README.md
```

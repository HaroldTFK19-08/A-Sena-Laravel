<?php

namespace Tests\Feature;

use App\Dominios\Usuarios\Models\Admin;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Dominios\Usuarios\Models\Aspirant;
use App\Dominios\Usuarios\Models\Teacher;
use App\Dominios\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiCrudTest extends TestCase
{
    use RefreshDatabase;

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();

        $admin = User::factory()->create([
            'rol' => 'Admin',
            'email' => 'api-admin@adminsena.com',
            'password' => Hash::make('12345678'),
        ]);

        Admin::create([
            'user_id' => $admin->id,
            'cargo' => 'Administrador API',
            'ubicacion_oficina' => 'Principal',
        ]);

        $login = $this->postJson('/v1/auth/login', [
            'email' => 'api-admin@adminsena.com',
            'password' => '12345678',
            'device_name' => 'test-suite',
        ]);

        $login->assertOk()->assertJsonStructure([
            'success',
            'message',
            'data' => ['user', 'token', 'token_type'],
        ]);

        $this->token = $login->json('data.token');
    }

    public function test_domain_routes_do_not_use_authentication_middleware(): void
    {
        $apiRoute = app('router')->getRoutes()->getByName('api.centros.index');
        $webRoute = app('router')->getRoutes()->getByName('instructor.home');

        $this->assertSame(['api'], $apiRoute?->gatherMiddleware());
        $this->assertSame(['web'], $webRoute?->gatherMiddleware());
    }

    public function test_every_api_index_answers_without_a_token(): void
    {
        $routes = [
            'api.centros.index',
            'api.areas.index',
            'api.ambientes.index',
            'api.equipos.index',
            'api.programas.index',
            'api.fichas.index',
            'api.competencias.index',
            'api.resultados.index',
            'api.calificaciones.index',
            'api.asignaciones.index',
            'api.ofertas.index',
            'api.inscripciones.index',
            'api.noticias.index',
            'api.usuarios.index',
        ];

        foreach ($routes as $route) {
            $this->getJson(route($route))
                ->assertOk()
                ->assertJsonStructure(['success', 'message', 'data', 'meta']);
        }

        $this->getJson(route('api.auth.me'))
            ->assertOk()
            ->assertJsonPath('data', null);
    }

    public function test_api_writes_succeed_without_a_token_in_practice_mode(): void
    {
        $centro = $this->postResource('api.centros.store', [
            'nombre' => 'Centro sin token',
            'direccion' => 'Carrera 12 # 34-56',
        ], withToken: false);

        $this->assertDatabaseHas('trainingcenters', ['id' => $centro]);

        $this->postJson(route('api.noticias.store'), [
            'trainingcenter_id' => $centro,
            'titulo' => 'Noticia sin token',
            'descripcion' => 'Se crea sin autenticación en modo práctica.',
            'estado' => 'Publicado',
            'categoria' => 'Tecnologia',
        ])->assertCreated();
    }

    public function test_admin_can_authenticate_and_access_domain_indexes(): void
    {
        $routes = [
            'api.centros.index',
            'api.areas.index',
            'api.ambientes.index',
            'api.equipos.index',
            'api.programas.index',
            'api.fichas.index',
            'api.competencias.index',
            'api.resultados.index',
            'api.calificaciones.index',
            'api.asignaciones.index',
            'api.ofertas.index',
            'api.inscripciones.index',
            'api.noticias.index',
            'api.usuarios.index',
        ];

        foreach ($routes as $route) {
            $this->withToken($this->token)
                ->getJson(route($route))
                ->assertOk()
                ->assertJsonStructure(['success', 'message', 'data', 'meta']);
        }
    }

    public function test_admin_can_perform_crud_on_a_domain_resource(): void
    {
        $create = $this->withToken($this->token)->postJson(route('api.centros.store'), [
            'nombre' => 'Centro API',
            'direccion' => 'Carrera 10 # 20-30',
        ]);
        $create->assertCreated()->assertJsonPath('data.nombre', 'Centro API');
        $centroId = $create->json('data.id');

        $this->withToken($this->token)
            ->getJson(route('api.centros.show', $centroId))
            ->assertOk()
            ->assertJsonPath('data.nombre', 'Centro API');

        $this->withToken($this->token)
            ->putJson(route('api.centros.update', $centroId), [
                'nombre' => 'Centro API actualizado',
                'direccion' => 'Carrera 10 # 20-30',
            ])
            ->assertOk()
            ->assertJsonPath('data.nombre', 'Centro API actualizado');

        $this->withToken($this->token)
            ->deleteJson(route('api.centros.destroy', $centroId))
            ->assertOk()
            ->assertJsonPath('data', null);

        $this->assertDatabaseMissing('trainingcenters', ['id' => $centroId]);
    }

    public function test_admin_can_create_resources_across_all_api_domains(): void
    {
        $centro = $this->postResource('api.centros.store', [
            'nombre' => 'Centro Integración API',
            'direccion' => 'Carrera 11 # 22-33',
        ]);

        $area = $this->postResource('api.areas.store', [
            'trainingcenter_id' => $centro,
            'nombre' => 'Tecnología API',
        ]);

        $ambiente = $this->postResource('api.ambientes.store', [
            'trainingcenter_id' => $centro,
            'nombre' => 'Laboratorio API',
            'capacidad' => 20,
            'tipo_ambiente' => 'Laboratorio',
        ]);

        $equipo = $this->postResource('api.equipos.store', [
            'environment_id' => $ambiente,
            'name' => 'Equipo API',
            'brand' => 'SENA',
            'equipment_type' => 'Equipo de cómputo',
        ]);

        $programa = $this->postResource('api.programas.store', [
            'area_id' => $area,
            'nombre' => 'Programa API',
            'codigo_programa' => 'API-001',
            'nivel_programa' => 'Tecnico',
        ]);

        $teacher = Teacher::factory()->create(['area_id' => $area])->id;
        $ficha = $this->postResource('api.fichas.store', [
            'program_id' => $programa,
            'teacher_id' => $teacher,
            'codigo' => 'FIC-API-001',
            'capacidad_aprendices' => 20,
        ]);

        $competencia = $this->postResource('api.competencias.store', [
            'teacher_id' => $teacher,
            'codigo' => 'COMP-API-001',
            'nombre' => 'Competencia API',
            'descripcion' => 'Competencia creada desde la API.',
            'fecha_inicio' => now()->toDateString(),
            'fecha_fin' => now()->addMonths(6)->toDateString(),
        ]);

        $resultado = $this->postResource('api.resultados.store', [
            'competition_id' => $competencia,
            'codigo' => 'RA-API-001',
            'nombre' => 'Resultado API',
            'descripcion' => 'Resultado creado desde la API.',
            'cantidad' => 1,
        ]);

        $oferta = $this->postResource('api.ofertas.store', [
            'program_id' => $programa,
            'fecha_lanzamiento' => now()->toDateString(),
            'capacidad' => 20,
            'fecha_convocatoria' => now()->addDays(3)->toDateString(),
            'fecha_fin_convocatoria' => now()->addDays(30)->toDateString(),
            'fecha_primera_prueba' => now()->addDays(45)->toDateString(),
            'fecha_segunda_prueba' => now()->addDays(60)->toDateString(),
            'fecha_seleccionados' => now()->addDays(75)->toDateString(),
            'publicada' => true,
        ]);

        $aspirante = Aspirant::factory()->create();
        $inscripcion = $this->postResource('api.inscripciones.store', [
            'aspirant_id' => $aspirante->id,
            'offer_id' => $oferta,
            'estado' => 'Registrado',
        ]);

        $aprendiz = Apprentice::factory()->create([
            'course_group_id' => $ficha,
        ]);
        $this->postResource('api.asignaciones.store', [
            'equipment_id' => $equipo,
            'apprentice_id' => $aprendiz->id,
            'fecha_asignacion' => now()->toDateString(),
            'Estado' => 'Activo',
        ]);
        $this->postResource('api.calificaciones.store', [
            'result_id' => $resultado,
            'apprentice_id' => $aprendiz->id,
            'teacher_id' => $teacher,
            'estado_resultado' => 'Aprobado',
        ]);
        $this->postResource('api.noticias.store', [
            'trainingcenter_id' => $centro,
            'titulo' => 'Noticia creada desde la API',
            'descripcion' => 'Contenido de prueba para la API.',
            'estado' => 'Publicado',
            'categoria' => 'Tecnologia',
            'publicada' => true,
        ]);
        $this->postResource('api.usuarios.store', [
            'nombre_1' => 'Api',
            'apellido_1' => 'Usuario',
            'tipo_identificacion' => 'CC',
            'identificacion' => '900000001',
            'email' => 'api-user@adminsena.com',
            'rol' => 'Aprendiz',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $this->assertDatabaseHas('registrations', ['id' => $inscripcion]);
    }

    public function test_authenticated_user_can_read_own_profile_and_logout(): void
    {
        $this->withToken($this->token)
            ->getJson(route('api.auth.me'))
            ->assertOk()
            ->assertJsonPath('data.email', 'api-admin@adminsena.com');

        $this->withToken($this->token)
            ->postJson(route('api.auth.logout'))
            ->assertOk();

        $this->assertDatabaseCount('personal_access_tokens', 0);

        $this->withToken($this->token)
            ->getJson(route('api.auth.me'))
            ->assertOk()
            ->assertJsonPath('data', null);
    }

    private function postResource(string $route, array $payload, bool $withToken = true): int
    {
        $response = $withToken
            ? $this->withToken($this->token)->postJson(route($route), $payload)
            : $this->postJson(route($route), $payload);

        $response->assertCreated();

        return (int) $response->json('data.id');
    }
}

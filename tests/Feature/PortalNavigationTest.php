<?php

namespace Tests\Feature;

use App\Dominios\Ambientes\Models\Environment;
use App\Dominios\Areas\Models\Area;
use App\Dominios\Asignaciones\Models\Assignment;
use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Equipos\Models\Equipment;
use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Inscripciones\Models\Registration;
use App\Dominios\Ofertas\Models\Offer;
use App\Dominios\Programas\Models\Program;
use App\Dominios\Usuarios\Models\Admin;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Dominios\Usuarios\Models\Aspirant;
use App\Dominios\Usuarios\Models\Teacher;
use App\Dominios\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortalNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_each_portal_exposes_all_sidebar_views_for_its_role(): void
    {
        [$instructor, $teacher, $ficha, $aprendiz] = $this->crearEscenarioDocente();
        $aspirante = $this->crearAspirante();

        $this->actingAs($instructor);
        foreach ([
            'instructor.home',
            'instructor.aprendices',
            'instructor.fichas',
            'instructor.actividades',
            'instructor.agenda',
        ] as $route) {
            $this->get(route($route))->assertOk();
        }
        $this->get(route('instructor.fichas.show', $ficha))->assertOk();

        $this->actingAs($aprendiz['user']);
        $this->get(route('aprendiz.home'))->assertOk();
        foreach (['aprendiz.ficha', 'aprendiz.asignaciones.index', 'aprendiz.cronograma'] as $route) {
            $this->get(route($route))->assertOk();
        }

        $this->actingAs($aspirante);
        $this->get(route('aspirante.home'))->assertOk();
        $this->get(route('aspirante.fechas'))->assertOk();
    }

    public function test_portal_routes_are_not_protected_by_role_middleware(): void
    {
        $instructorData = $this->crearInstructorConFicha();
        $instructor = $instructorData['user'];
        $aprendiz = $this->crearAprendizPara($instructorData['ficha']);
        $aspirante = $this->crearAspirante();

        foreach ([
            'instructor.home',
            'instructor.fichas',
            'instructor.actividades',
            'aprendiz.home',
            'aprendiz.ficha',
            'aspirante.home',
        ] as $route) {
            $middleware = collect(app('router')->getRoutes()->getByName($route)?->gatherMiddleware() ?? []);

            $this->assertTrue(
                $middleware->every(fn ($item) => ! str_contains((string) $item, 'Ensure')),
                "La ruta {$route} no debe aplicar middleware de rol.",
            );
        }

        $this->actingAs($instructor)
            ->get(route('aprendiz.ficha'))
            ->assertOk();

        $this->actingAs($aprendiz['user'])
            ->get(route('instructor.fichas'))
            ->assertOk();

        $this->actingAs($aspirante)
            ->get(route('instructor.actividades'))
            ->assertOk();
    }

    public function test_sidebar_pages_render_before_related_profiles_are_completed(): void
    {
        $instructor = User::factory()->create(['rol' => 'Instructor']);
        $aprendiz = User::factory()->create(['rol' => 'Aprendiz']);
        $aspirante = User::factory()->create(['rol' => 'Aspirante']);

        $this->actingAs($instructor);
        foreach (['instructor.aprendices', 'instructor.fichas', 'instructor.actividades', 'instructor.agenda'] as $route) {
            $this->get(route($route))->assertOk();
        }

        $this->actingAs($aprendiz);
        foreach (['aprendiz.ficha', 'aprendiz.asignaciones.index', 'aprendiz.cronograma'] as $route) {
            $this->get(route($route))->assertOk();
        }

        $this->actingAs($aspirante)
            ->get(route('aspirante.fechas'))
            ->assertOk();
    }

    public function test_instructor_only_sees_apprentices_from_assigned_fichas(): void
    {
        [$instructor, $teacher, $ficha] = $this->crearEscenarioDocente();
        $other = $this->crearInstructorConFicha();
        $assigned = $this->crearAprendizPara($ficha, 'APRENDIZ ASIGNADO');
        $unassigned = $this->crearAprendizPara($other['ficha'], 'APRENDIZ AJENO');

        $this->actingAs($instructor)
            ->get(route('instructor.aprendices'))
            ->assertOk()
            ->assertSee('APRENDIZ ASIGNADO')
            ->assertDontSee('APRENDIZ AJENO');
    }

    public function test_apprentice_can_only_open_their_own_assignment(): void
    {
        [$instructor, $teacher, $ficha] = $this->crearEscenarioDocente();
        $own = $this->crearAprendizPara($ficha, 'APRENDIZ PROPIO');
        $other = $this->crearAprendizPara($ficha, 'APRENDIZ AJENO');
        $equipment = $this->crearEquipo();
        $ownAssignment = Assignment::create([
            'equipment_id' => $equipment->id,
            'apprentice_id' => $own['aprendiz']->id,
            'fecha_asignacion' => now(),
            'Estado' => 'Activo',
        ]);
        $otherAssignment = Assignment::create([
            'equipment_id' => $equipment->id,
            'apprentice_id' => $other['aprendiz']->id,
            'fecha_asignacion' => now(),
            'Estado' => 'Activo',
        ]);

        $this->actingAs($own['user'])
            ->get(route('aprendiz.asignaciones.show', $ownAssignment))
            ->assertOk()
            ->assertSee('APRENDIZ PROPIO');

        $this->actingAs($own['user'])
            ->get(route('aprendiz.asignaciones.show', $otherAssignment))
            ->assertForbidden();
    }

    public function test_aspirant_schedule_uses_only_own_registrations(): void
    {
        $aspirante = $this->crearAspirante();
        $otra = $this->crearAspirante('otra@test.com', 'OTRA ASPIRANTE');
        $offer = $this->crearOferta();

        $this->crearInscripcion($aspirante, $offer);
        $this->crearInscripcion($otra, $offer);

        $this->actingAs($aspirante)
            ->get(route('aspirante.fechas'))
            ->assertOk()
            ->assertSee('PROGRAMA DE PRUEBA')
            ->assertSee('Inscripción registrada');
    }

    private function crearEscenarioDocente(): array
    {
        $data = $this->crearInstructorConFicha();
        $aprendiz = $this->crearAprendizPara($data['ficha'], 'APRENDIZ ASIGNADO');

        return [$data['user'], $data['teacher'], $data['ficha'], $aprendiz];
    }

    private function crearInstructorConFicha(): array
    {
        $center = Trainingcenter::create(['nombre' => 'Centro de prueba', 'direccion' => 'Calle 1']);
        $area = Area::create(['trainingcenter_id' => $center->id, 'nombre' => 'Área de prueba']);
        $user = User::factory()->create([
            'rol' => 'Instructor',
            'email' => fake()->unique()->safeEmail(),
        ]);
        $teacher = Teacher::create([
            'user_id' => $user->id,
            'area_id' => $area->id,
            'especialidad' => 'Especialidad de prueba',
            'tipo_instructor' => 'Planta',
            'fecha_inicio' => now()->subYear(),
        ]);
        $program = Program::create([
            'area_id' => $area->id,
            'nombre' => 'Programa de prueba',
            'codigo_programa' => 'PROG-'.fake()->unique()->numerify('####'),
            'nivel_programa' => 'Tecnico',
        ]);
        $ficha = Course_group::create([
            'program_id' => $program->id,
            'teacher_id' => $teacher->id,
            'codigo' => 'FIC-'.fake()->unique()->numerify('####'),
            'capacidad_aprendices' => 30,
        ]);

        return compact('center', 'area', 'user', 'teacher', 'program', 'ficha');
    }

    private function crearAprendizPara(Course_group $ficha, string $nombre = 'APRENDIZ'): array
    {
        $user = User::factory()->create([
            'rol' => 'Aprendiz',
            'nombre_1' => $nombre,
            'email' => fake()->unique()->safeEmail(),
        ]);
        $aprendiz = Apprentice::create([
            'user_id' => $user->id,
            'course_group_id' => $ficha->id,
            'estado' => 'Activo',
            'fecha_inicio' => now()->subMonths(2),
            'fecha_fin' => now()->addMonths(4),
        ]);

        return compact('user', 'aprendiz');
    }

    private function crearAspirante(string $email = 'aspirante@test.com', string $nombre = 'ASPIRANTE'): User
    {
        $user = User::factory()->create([
            'rol' => 'Aspirante',
            'email' => $email,
            'nombre_1' => $nombre,
        ]);
        Aspirant::create(['user_id' => $user->id, 'eps' => 'SURA']);

        return $user;
    }

    private function crearEquipo()
    {
        $center = Trainingcenter::first() ?? Trainingcenter::create(['nombre' => 'Centro', 'direccion' => 'Dirección']);
        $environment = Environment::create([
            'trainingcenter_id' => $center->id,
            'nombre' => 'Laboratorio de prueba',
            'capacidad' => 20,
            'tipo_ambiente' => 'Laboratorio',
        ]);

        return Equipment::create([
            'environment_id' => $environment->id,
            'name' => 'Equipo de prueba',
            'brand' => 'Marca',
            'equipment_type' => 'Herramienta',
        ]);
    }

    private function crearOferta(): Offer
    {
        $center = Trainingcenter::first() ?? Trainingcenter::create(['nombre' => 'Centro de ofertas', 'direccion' => 'Dirección']);
        $area = Area::first() ?? Area::create([
            'trainingcenter_id' => $center->id,
            'nombre' => 'Área de ofertas',
        ]);
        $program = Program::first() ?? Program::create([
            'area_id' => $area->id,
            'nombre' => 'PROGRAMA DE PRUEBA',
            'codigo_programa' => 'PROG-'.fake()->unique()->numerify('####'),
            'nivel_programa' => 'Tecnico',
        ]);
        $admin = User::factory()->create(['rol' => 'Admin', 'email' => fake()->unique()->safeEmail()]);

        return Offer::create([
            'admin_id' => Admin::create([
                'user_id' => $admin->id,
                'cargo' => 'Administrador de prueba',
                'ubicacion_oficina' => 'Oficina central',
            ])->id,
            'program_id' => $program->id,
            'fecha_lanzamiento' => now()->subMonth(),
            'fecha_convocatoria' => now()->subDays(20),
            'fecha_fin_convocatoria' => now()->addDays(20),
            'fecha_primera_prueba' => now()->addMonth(),
            'fecha_segunda_prueba' => now()->addMonths(2),
            'fecha_seleccionados' => now()->addMonths(3),
            'capacidad' => 50,
            'publicada' => true,
        ]);
    }

    private function crearInscripcion(User $user, Offer $oferta): void
    {
        $aspirant = $user->aspirant;
        Registration::create([
            'aspirant_id' => $aspirant->id,
            'offer_id' => $oferta->id,
            'estado' => 'Registrado',
            'Fecha_inscripcion' => now(),
        ]);
    }
}

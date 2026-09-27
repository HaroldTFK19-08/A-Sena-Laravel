<?php

namespace Tests\Feature;

use App\Dominios\Areas\Models\Area;
use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Programas\Models\Program;
use App\Dominios\Usuarios\Models\Admin;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Dominios\Usuarios\Models\Aspirant;
use App\Dominios\Usuarios\Models\Teacher;
use App\Dominios\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileLogoutButtonTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_profile_page_offers_the_logout_option(): void
    {
        $centro = Trainingcenter::create(['nombre' => 'Centro prueba', 'direccion' => 'Calle 1']);
        $area = Area::create(['trainingcenter_id' => $centro->id, 'nombre' => 'Área prueba']);
        $program = Program::create([
            'area_id' => $area->id,
            'nombre' => 'Programa prueba',
            'codigo_programa' => 'PROG-LOGOUT',
            'nivel_programa' => 'Tecnico',
        ]);

        $instructor = User::factory()->create(['rol' => 'Instructor']);
        $teacher = Teacher::create([
            'user_id' => $instructor->id,
            'area_id' => $area->id,
            'especialidad' => 'Especialidad',
            'tipo_instructor' => 'Planta',
            'fecha_inicio' => now()->subYear(),
        ]);
        $ficha = Course_group::create([
            'program_id' => $program->id,
            'teacher_id' => $teacher->id,
            'codigo' => 'FIC-LOGOUT',
            'capacidad_aprendices' => 20,
        ]);
        $teacher->coursegroups()->syncWithoutDetaching([$ficha->id]);

        $aprendiz = User::factory()->create(['rol' => 'Aprendiz']);
        Apprentice::create([
            'user_id' => $aprendiz->id,
            'course_group_id' => $ficha->id,
            'eps' => 'Emssanar',
            'fecha_inicio' => now()->subMonths(3),
        ]);

        $aspirante = User::factory()->create(['rol' => 'Aspirante']);
        Aspirant::create(['user_id' => $aspirante->id, 'eps' => 'Emssanar']);

        $admin = User::factory()->create(['rol' => 'Admin']);
        Admin::create([
            'user_id' => $admin->id,
            'cargo' => 'Coordinador',
            'ubicacion_oficina' => 'Sede principal',
            'direccion' => 'Calle 1',
        ]);

        $profiles = [
            [$admin, 'admin.perfil'],
            [$instructor, 'instructor.perfil'],
            [$aprendiz, 'aprendiz.perfil'],
            [$aspirante, 'aspirante.perfil'],
        ];

        foreach ($profiles as [$user, $route]) {
            $this->actingAs($user)
                ->get(route($route))
                ->assertOk()
                ->assertSee('Cerrar sesión')
                ->assertSee(route('auth.logout'), escape: false);
        }
    }

    public function test_logout_button_ends_the_session(): void
    {
        $user = User::factory()->create(['rol' => 'Admin']);

        $this->actingAs($user)
            ->from(route('admin.perfil'))
            ->post(route('auth.logout'))
            ->assertRedirect(route('auth.inicio'));

        $this->assertGuest();
    }
}

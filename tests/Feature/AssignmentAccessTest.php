<?php

namespace Tests\Feature;

use App\Dominios\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignmentAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_can_access_assignment_dashboard(): void
    {
        $user = User::factory()->create([
            'rol' => 'Instructor',
            'email' => 'instructor@test.com',
        ]);

        $this->actingAs($user)
            ->get(route('instructor.asignaciones.index'))
            ->assertOk();
    }

    public function test_assignment_routes_are_open_to_any_authenticated_role(): void
    {
        $admin = User::factory()->create([
            'rol' => 'Admin',
            'email' => 'admin@test.com',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.asignaciones.index'))
            ->assertOk();

        // Las rutas ya no aplican middleware de rol, así que el portal de
        // instructor responde igual para un usuario Admin.
        $this->actingAs($admin)
            ->get(route('instructor.asignaciones.index'))
            ->assertOk();
    }
}

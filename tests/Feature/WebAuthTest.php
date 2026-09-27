<?php

namespace Tests\Feature;

use App\Dominios\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_reach_login_and_register_forms(): void
    {
        $this->get(route('auth.login'))->assertOk();
        $this->get(route('auth.register'))->assertOk();
    }

    public function test_authenticated_user_is_redirected_away_from_login_and_register(): void
    {
        $admin = User::factory()->create(['rol' => 'Admin']);

        $this->actingAs($admin)->get(route('auth.login'))->assertRedirect(route('admin.home'));
        $this->actingAs($admin)->get(route('auth.register'))->assertRedirect(route('admin.home'));
    }

    public function test_profile_routes_require_a_session(): void
    {
        foreach ([
            'admin.perfil',
            'admin.edit',
            'instructor.perfil',
            'instructor.edit',
            'aprendiz.perfil',
            'aprendiz.edit',
            'aspirante.perfil',
            'aspirante.edit',
        ] as $route) {
            $this->get(route($route))->assertRedirect(route('auth.login'));
        }
    }

    public function test_authenticated_user_can_open_own_profile(): void
    {
        $admin = User::factory()->create(['rol' => 'Admin']);

        $this->actingAs($admin)
            ->get(route('admin.perfil'))
            ->assertOk()
            ->assertSee($admin->nombre_1);

        $this->actingAs($admin)
            ->get(route('admin.edit'))
            ->assertOk();
    }

    public function test_update_profile_requires_a_session(): void
    {
        $this->put(route('admin.update'))->assertRedirect(route('auth.login'));
        $this->put(route('instructor.update'))->assertRedirect(route('auth.login'));
        $this->put(route('aprendiz.update'))->assertRedirect(route('auth.login'));
        $this->put(route('aspirante.update'))->assertRedirect(route('auth.login'));
    }

    public function test_other_portal_pages_stay_open_for_guests(): void
    {
        foreach ([
            'auth.inicio',
            'centros.index',
            'ofertas.index',
            'noticias.index',
            'instructor.fichas',
            'aspirante.ofertas.index',
        ] as $route) {
            $response = $this->get(route($route));

            $this->assertNotSame(302, $response->getStatusCode(), "La ruta {$route} no debería exigir sesión.");
        }
    }

    public function test_login_redirects_to_the_portal_of_the_user_role(): void
    {
        $user = User::factory()->create([
            'rol' => 'Instructor',
            'email' => 'instructor-web@test.com',
            'password' => bcrypt('12345678'),
        ]);

        $this->post(route('auth.login.submit'), [
            'email' => 'instructor-web@test.com',
            'password' => '12345678',
        ])->assertRedirect(route('instructor.home'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_ends_the_session(): void
    {
        $admin = User::factory()->create(['rol' => 'Admin']);

        $this->actingAs($admin)
            ->post(route('auth.logout'))
            ->assertRedirect(route('auth.inicio'));

        $this->assertGuest();
    }
}

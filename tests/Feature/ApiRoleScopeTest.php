<?php

namespace Tests\Feature;

use App\Dominios\Asignaciones\Models\Assignment;
use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Ofertas\Models\Offer;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Dominios\Usuarios\Models\Aspirant;
use App\Dominios\Usuarios\Models\Teacher;
use App\Dominios\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiRoleScopeTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_api_only_exposes_assignments_from_assigned_fichas(): void
    {
        $instructor = $this->crearInstructorConFicha();
        $other = $this->crearInstructorConFicha();
        $assignment = Assignment::factory()->create([
            'apprentice_id' => $instructor['aprendiz']->id,
        ]);
        $foreignAssignment = Assignment::factory()->create([
            'apprentice_id' => $other['aprendiz']->id,
        ]);

        $response = $this->withToken($instructor['user']->createToken('test')->plainTextToken)
            ->getJson(route('api.asignaciones.index'))
            ->assertOk();

        $ids = collect($response->json('data'))->pluck('id');
        $this->assertTrue($ids->contains($assignment->id));
        $this->assertFalse($ids->contains($foreignAssignment->id));

        $this->withToken($instructor['user']->createToken('test-2')->plainTextToken)
            ->getJson(route('api.asignaciones.show', $foreignAssignment))
            ->assertForbidden();
    }

    public function test_apprentice_api_only_reads_own_assignments(): void
    {
        $instructor = $this->crearInstructorConFicha();
        $other = $this->crearInstructorConFicha();
        $own = Assignment::factory()->create(['apprentice_id' => $instructor['aprendiz']->id]);
        $foreign = Assignment::factory()->create(['apprentice_id' => $other['aprendiz']->id]);
        $token = $instructor['aprendiz']->user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson(route('api.asignaciones.index'))
            ->assertOk();

        $ids = collect($response->json('data'))->pluck('id');
        $this->assertTrue($ids->contains($own->id));
        $this->assertFalse($ids->contains($foreign->id));

        $this->withToken($token)
            ->getJson(route('api.asignaciones.show', $foreign))
            ->assertForbidden();
    }

    public function test_aspirant_api_reads_published_offers_and_manages_own_registration(): void
    {
        $published = Offer::factory()->publicada()->create();
        $hidden = Offer::factory()->create(['publicada' => false]);
        $aspirant = Aspirant::factory()->create();
        $token = $aspirant->user->createToken('test')->plainTextToken;

        $response = $this->withToken($token)
            ->getJson(route('api.ofertas.index'))
            ->assertOk();

        $ids = collect($response->json('data'))->pluck('id');
        $this->assertTrue($ids->contains($published->id));
        $this->assertFalse($ids->contains($hidden->id));

        $registration = $this->withToken($token)
            ->postJson(route('api.inscripciones.store'), [
                'offer_id' => $published->id,
            ])
            ->assertCreated()
            ->json('data');

        $this->assertSame('Registrado', $registration['estado']);
        $this->assertDatabaseHas('registrations', [
            'id' => $registration['id'],
            'aspirant_id' => $aspirant->id,
        ]);

        $this->withToken($token)
            ->getJson(route('api.inscripciones.index'))
            ->assertOk()
            ->assertJsonCount(1, 'data');
    }

    private function crearInstructorConFicha(): array
    {
        $user = User::factory()->instructor()->create();
        $teacher = Teacher::factory()->create(['user_id' => $user->id]);
        $ficha = Course_group::factory()->create(['teacher_id' => $teacher->id]);
        $aprendiz = Apprentice::factory()->create(['course_group_id' => $ficha->id]);

        return compact('user', 'teacher', 'ficha', 'aprendiz');
    }
}

<?php

namespace Tests\Feature;

use App\Dominios\Ambientes\Models\Environment;
use App\Dominios\Areas\Models\Area;
use App\Dominios\Asignaciones\Models\Assignment;
use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Competencias\Models\Competition;
use App\Dominios\Competencias\Models\CompetitionTeacher;
use App\Dominios\Equipos\Models\Equipment;
use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Fichas\Models\CourseGroupTeacher;
use App\Dominios\Inscripciones\Models\Registration;
use App\Dominios\Noticias\Models\News;
use App\Dominios\Ofertas\Models\Offer;
use App\Dominios\Programas\Models\Program;
use App\Dominios\Resultados\Models\Grade;
use App\Dominios\Resultados\Models\Result;
use App\Dominios\Usuarios\Models\Admin;
use App\Dominios\Usuarios\Models\Apprentice;
use App\Dominios\Usuarios\Models\Aspirant;
use App\Dominios\Usuarios\Models\Teacher;
use App\Dominios\Usuarios\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DomainFactoriesTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_domain_factories_create_valid_records(): void
    {
        $factories = [
            User::factory(),
            Trainingcenter::factory(),
            Area::factory(),
            Environment::factory(),
            Program::factory(),
            Admin::factory(),
            Teacher::factory(),
            Course_group::factory(),
            Apprentice::factory(),
            Aspirant::factory(),
            Competition::factory(),
            Result::factory(),
            Grade::factory(),
            Equipment::factory(),
            Assignment::factory(),
            News::factory(),
            Offer::factory(),
            Registration::factory(),
            CompetitionTeacher::factory(),
            CourseGroupTeacher::factory(),
        ];

        foreach ($factories as $factory) {
            $this->assertNotNull($factory->create());
        }
    }

    public function test_domain_seeders_are_idempotent(): void
    {
        $this->seed();
        $counts = [
            'users' => User::count(),
            'trainingcenters' => Trainingcenter::count(),
            'areas' => Area::count(),
            'environments' => Environment::count(),
            'programs' => Program::count(),
            'admins' => Admin::count(),
            'teachers' => Teacher::count(),
            'course_groups' => Course_group::count(),
            'apprentices' => Apprentice::count(),
            'aspirants' => Aspirant::count(),
            'competitions' => Competition::count(),
            'results' => Result::count(),
            'grades' => Grade::count(),
            'equipment' => Equipment::count(),
            'assignments' => Assignment::count(),
            'offers' => Offer::count(),
            'registrations' => Registration::count(),
            'news' => News::count(),
            'competition_teacher' => CompetitionTeacher::count(),
            'course_group_teacher' => CourseGroupTeacher::count(),
        ];

        $this->seed();

        foreach ($counts as $table => $count) {
            $this->assertSame($count, match ($table) {
                'users' => User::count(),
                'trainingcenters' => Trainingcenter::count(),
                'areas' => Area::count(),
                'environments' => Environment::count(),
                'programs' => Program::count(),
                'admins' => Admin::count(),
                'teachers' => Teacher::count(),
                'course_groups' => Course_group::count(),
                'apprentices' => Apprentice::count(),
                'aspirants' => Aspirant::count(),
                'competitions' => Competition::count(),
                'results' => Result::count(),
                'grades' => Grade::count(),
                'equipment' => Equipment::count(),
                'assignments' => Assignment::count(),
                'offers' => Offer::count(),
                'registrations' => Registration::count(),
                'news' => News::count(),
                'competition_teacher' => CompetitionTeacher::count(),
                'course_group_teacher' => CourseGroupTeacher::count(),
            }, $table);
        }
    }
}

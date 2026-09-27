<?php

namespace Database\Factories;

use App\Dominios\Competencias\Models\Competition;
use App\Dominios\Competencias\Models\CompetitionTeacher;
use App\Dominios\Usuarios\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CompetitionTeacher>
 */
class CompetitionTeacherFactory extends Factory
{
    protected $model = CompetitionTeacher::class;

    public function definition(): array
    {
        return [
            'competency_id' => Competition::factory(),
            'teacher_id' => Teacher::factory(),
        ];
    }
}

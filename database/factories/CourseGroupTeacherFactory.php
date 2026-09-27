<?php

namespace Database\Factories;

use App\Dominios\Fichas\Models\Course_group;
use App\Dominios\Fichas\Models\CourseGroupTeacher;
use App\Dominios\Usuarios\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CourseGroupTeacher>
 */
class CourseGroupTeacherFactory extends Factory
{
    protected $model = CourseGroupTeacher::class;

    public function definition(): array
    {
        return [
            'course_group_id' => Course_group::factory(),
            'teacher_id' => Teacher::factory(),
        ];
    }
}

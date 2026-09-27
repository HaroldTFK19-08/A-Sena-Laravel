<?php

namespace Database\Factories;

use App\Dominios\Areas\Models\Area;
use App\Dominios\Programas\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Program>
 */
class ProgramFactory extends Factory
{
    protected $model = Program::class;

    public function definition(): array
    {
        return [
            'area_id' => Area::factory(),
            'nombre' => fake()->unique()->jobTitle().' aplicado',
            'codigo_programa' => 'PROG-'.fake()->unique()->numerify('####'),
            'nivel_programa' => fake()->randomElement(['Tecnico', 'Tecnologo']),
        ];
    }
}

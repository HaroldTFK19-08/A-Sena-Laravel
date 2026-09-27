<?php

namespace Database\Seeders;

use App\Dominios\Usuarios\Models\Admin;
use App\Dominios\Usuarios\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $usuario = User::where('email', 'admin@adminsena.com')->firstOrFail();
        Admin::updateOrCreate(
            ['user_id' => $usuario->id],
            [
                'cargo' => 'Administrador del sistema',
                'ubicacion_oficina' => 'Oficina principal',
                'direccion' => 'Carrera 7 # 100-20, Bogotá',
            ]
        );
    }
}

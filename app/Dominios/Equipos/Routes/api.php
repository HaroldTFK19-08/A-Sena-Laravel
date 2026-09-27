<?php

use App\Dominios\Equipos\Controllers\Api\EquipmentApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('equipos', EquipmentApiController::class)
    ->parameters(['equipos' => 'equipo'])
    ->names('api.equipos');

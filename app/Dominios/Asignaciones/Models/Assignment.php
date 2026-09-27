<?php

namespace App\Dominios\Asignaciones\Models;

use App\Dominios\Equipos\Models\Equipment;
use App\Dominios\Usuarios\Models\Apprentice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_devolucion' => 'datetime',
    ];

    protected $fillable = [
        'equipment_id',
        'apprentice_id',
        'fecha_asignacion',
        'fecha_devolucion',
        'Estado',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function apprentice()
    {
        return $this->belongsTo(Apprentice::class);
    }
}

<?php

namespace App\Dominios\Areas\Models;

use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Programas\Models\Program;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainingcenter_id',
        'nombre',
    ];

    public function trainingcenter()
    {
        return $this->belongsTo(Trainingcenter::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }
}

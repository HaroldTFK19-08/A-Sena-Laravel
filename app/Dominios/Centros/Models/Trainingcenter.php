<?php

namespace App\Dominios\Centros\Models;
use App\Dominios\Ambientes\Models\Environment;
use App\Dominios\Areas\Models\Area;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainingcenter extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'direccion',
    ];
    public function areas(){
        return $this->hasMany(Area::class);
    }
    public function environments(){
        return $this->hasMany(Environment::class);
    }
}

<?php

namespace App\Dominios\Noticias\Models;

use App\Dominios\Centros\Models\Trainingcenter;
use App\Dominios\Usuarios\Models\Admin;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $fillable = [
        'trainingcenter_id',
        'admin_id',
        'titulo',
        'descripcion',
        'imagen',
        'estado',
        'categoria',
        'publicada',
    ];
    public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function trainingcenter(){
        return $this->belongsTo(Trainingcenter::class);
    }
}

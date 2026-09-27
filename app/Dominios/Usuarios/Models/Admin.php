<?php

namespace App\Dominios\Usuarios\Models;

use App\Dominios\Noticias\Models\News;
use App\Dominios\Ofertas\Models\Offer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cargo',
        'ubicacion_oficina',
        'direccion',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offers(){
        return $this->hasMany(Offer::class);
    }
    public function news(){
        return $this->hasMany(News::class);
    }
}

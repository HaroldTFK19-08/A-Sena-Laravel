<?php

namespace App\Dominios\Competencias\Models;

use App\Dominios\Usuarios\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionTeacher extends Model
{
    use HasFactory;

    protected $table = 'competition_teacher';

    protected $fillable = [
        'competency_id',
        'teacher_id',
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competency_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}

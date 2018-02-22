<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AvanceCursos;

class Cursos extends Model
{
    //
    protected $table ="wp_cursos";

    public function avanceCurso()
    {
        return $this->hasMany(AvanceCursos::class, 'id_curso');
    }

}

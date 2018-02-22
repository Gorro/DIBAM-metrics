<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UsuarioRecintos;

class AvanceCursos extends Model
{
    protected $table ="wp_avance_cursos";

    public function usuario()
    {
        return $this->belongsTo(UsuarioRecintos::class, 'id_usuario_recinto');
    }
    public function scopeCapacitados($query)
    {
       return $query->where('id_curso',8);
    }
}

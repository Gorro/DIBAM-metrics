<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsuarioRecintos extends Model
{
    protected $table = 'wp_usuario_recinto';

    public function seccionClick()
    {
        return $this->hasMany('App\SeccionClick', 'id_usuario_recinto');
    }

    public function lab()
    {
        return $this->belongsTo('App\LaboratoriosBiblioredes', 'recinto');
    }

    public function sesiones()
    {
        return $this->hasMany(SessionesCounts::class, 'id_usuario_recinto');
    }

    public function avanceCursos()
    {
        return $this->hasMany(AvanceCursos::class, 'id_usuario_recinto');
    }

    public function capacitado()
    {
        return $this->hasMany(AvanceCursos::class, 'id_usuario_recinto')->where('id_curso',8);
    }
}

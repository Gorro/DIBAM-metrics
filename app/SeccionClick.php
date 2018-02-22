<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeccionClick extends Model
{
    protected $table = 'wp_seccion_click';

    public $timestamps = false;

    public function getDates()
    {
        return array('fecha');
    }

    public function usuario()
    {
        return $this->belongsTo('App\UsuarioRecintos', 'id_usuario_recinto');
    }
}    

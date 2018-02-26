<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionesCounts extends Model
{
    //
    protected $table ="wp_sessiones_count";

    public function usuario()
    {
        return $this->belongsTo(UsuarioRecintos::class, 'id_usuario_recinto');
    }

}


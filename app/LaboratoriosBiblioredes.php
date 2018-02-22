<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cursos;

class LaboratoriosBiblioredes extends Model
{
    //
    protected $table ="wp_laboratorios_biblioredes";

    public function usuarios()
    {
        return $this->hasMany('App\UsuarioRecintos', 'recinto');
    }

    public function sesiones()
    {
        return $this->hasManyThrough(SessionesCounts::class, UsuarioRecintos::class, 'recinto', 'id_usuario_recinto');
    }
    public static function getRegiones()
    {
        return LaboratoriosBiblioredes::distinct()->select('region')->get();
    }
    public static function getLaboratoriosRegion($region){
        return LaboratoriosBiblioredes::where('region',$region)
            ->get();
    }
}

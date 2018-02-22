<?php

namespace App\Http\Controllers;

use App\AvanceCursos;
use App\LaboratoriosBiblioredes;
use App\SessionesCounts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Date;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MetricasController extends Controller
{
    public function index()
    {
        $capacitados = AvanceCursos::capacitados()->count();
        $sesionesUsuario =LaboratoriosBiblioredes::with('sesiones')->get();
        $cantidadSesiones = 0;
        foreach ($sesionesUsuario as $recinto) {
            $cantidad = count($recinto->sesiones);
            if($cantidad >0 ) {
                $cantidadSesiones += count($recinto->sesiones);
            }
        }
//        $capacitados = $cantidadSesiones = 1;
        return view('metricas.adminMaterial.index',compact('capacitados','cantidadSesiones'));
    }
    public function form(Request $request)
    {
        $result = [];
        if($request->tipo == 0){
            $result['capacitados'] = AvanceCursos::with('usuario.lab')->capacitados()->get();
        } elseif ( $request->tipo == 1){

        }elseif ( $request->tipo == 1 ){

        }
        $result['regiones']  = LaboratoriosBiblioredes::getRegiones();
        return view('metricas.adminMaterial.forms.form', $result);
    }
    public function prueba(){
        $capacitadosRecinto = LaboratoriosBiblioredes::with(['usuarios.avanceCursos' => function($query){
            $query->where('id_curso',8);
        }])->find(6); //capacitados por recinto
//        return response()->json($capacitados);
    }
    public function getLabs(Request $request){
        return LaboratoriosBiblioredes::getLaboratoriosRegion($request->input('region'));
    }

    public function getUsers(Request $request)
    {
        $termino = \DateTime::createFromFormat('d/m/Y', $request->fecha_termino)->format('Y-m-d');
        $inicio = \DateTime::createFromFormat('d/m/Y', $request->fecha_inicio)->format('Y-m-d');
        $result['capacitados'] = AvanceCursos::with('usuario.lab')
            ->capacitados()
            ->whereRaw("DATE(fecha_inicio) BETWEEN '$inicio' and '$termino'")
            ->whereHas('usuario.lab',function($query) use ($request){
            $query->where('id',$request->recinto);
        });
        dd($result['capacitados']->get());
    }
}

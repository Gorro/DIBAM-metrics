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
        $sesionesUsuario = LaboratoriosBiblioredes::with('sesiones')->get();
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
        $result = [
            'user' => true
        ];
        if($request->tipo == 0){
            $result['usuarios'] = AvanceCursos::with('usuario.lab')->capacitados()->get();
        } elseif ( $request->tipo == 1){
            $result = [
                'recintos' => LaboratoriosBiblioredes::with('sesiones')->get(),
                'user' => false
            ];
        }elseif ( $request->tipo == 2 ){

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
        $result = [
            'user' => true
        ];

        if($request->seleccion == 1){
            $result['usuarios'] = AvanceCursos::with('usuario.lab')->capacitados();
            if( !(empty($request->fecha_inicio) && empty($request->fecha_termino)) ){
                $termino = \DateTime::createFromFormat('d/m/Y', $request->fecha_termino)->format('Y-m-d');
                $inicio = \DateTime::createFromFormat('d/m/Y', $request->fecha_inicio)->format('Y-m-d');
                $result['usuarios'] = $result['usuarios']->whereRaw("DATE(fecha_inicio) BETWEEN '$inicio' and '$termino'");
            }
            if($request->has('region')){
                $result['usuarios'] = $result['usuarios']->whereHas('usuario.lab',function($query) use ($request){
                    $query->where('region',$request->region);
                });
            }
            if($request->has('recinto')){
                $result['usuarios'] = $result['usuarios']->whereHas('usuario.lab',function($query) use ($request){
                    $query->where('id',$request->recinto);
                });
            }
            $result['usuarios'] = $result['usuarios']->get();
        }
        if($request->seleccion == 2){
            $result = [
                'recintos' => LaboratoriosBiblioredes::with('sesiones.usuario')
                ->where('id',$request->recinto)
                ->whereHas('sesiones', function($query) use ($inicio,$termino){
                    $query->whereRaw("DATE(fecha_session) BETWEEN '$inicio' and '$termino'");
                })
                ->get(),
                'user' => false
            ];
        }

        return view('metricas.adminMaterial.tables.table',$result);
    }
}

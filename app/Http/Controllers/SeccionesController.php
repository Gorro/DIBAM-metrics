<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SeccionClick;
use App\LaboratoriosBiblioredes;
use Carbon\Carbon;
use App\AvanceCursos;

class SeccionesController extends Controller
{    
    public function index()
    {
        $result['anos']      = SeccionClick::getAnos();
        $result['regiones']  = LaboratoriosBiblioredes::getRegiones();
        return view('metricas.visita_a_secciones',$result);
    }    
    public function getLaboratorios(Request $request){
        return LaboratoriosBiblioredes::getLaboratoriosRegion($request->input('region'));
    }
    public function getSeccionClick(Request $request){
         return response()->json(SeccionClick::getSeccionClick($request->input('seccion_name'),$request->input('lab'),$request->input('year'),$request->input('month'),$request->input('seccion')));
    }
    public function prueba(){
//        $capacitados = AvanceCursos::capacitados()->get();
//        $capacitadosRecinto = LaboratoriosBiblioredes::with(['usuarios.avanceCursos' => function($query){
//            $query->where('id_curso',8);
//        }])->find(6);
//        $sesionesUsuario =LaboratoriosBiblioredes::all();
//        foreach ($sesionesUsuario as $recinto) {
//            $cantidad = count($recinto->sesiones);
//            if($cantidad >0 ) {
//                echo $recinto->laboratorio,' ',count($recinto->sesiones),'<br>';
//            }
//        }
//        return response()->json($capacitados);
        return view('metricas.adminMaterial.index');
    }
}

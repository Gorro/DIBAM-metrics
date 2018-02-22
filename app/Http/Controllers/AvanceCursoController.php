<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SeccionClick;
use App\LaboratoriosBiblioredes;
use App\AvanceCursos;

class AvanceCursoController extends Controller
{   
    public function index()
    {
        $result['regiones']  = LaboratoriosBiblioredes::getRegiones();
        return view('metricas.avance_cursos.avance_recinto',$result);
    }
    public function getAvance(Request $request){
        $cantidadUsuarios = LaboratoriosBiblioredes::find($request->input('lab'))->usuarioRecintos->count('id');
        $usuarios = LaboratoriosBiblioredes::find($request->input('lab'))->avanceCursos;
        $usuarios = hGetPorcentaje($usuarios,$cantidadUsuarios);
        return response()->json( $usuarios);
    }
    public function avanceAlumno(){ 
        $result['regiones']  = LaboratoriosBiblioredes::getRegiones();
        return view('metricas.avance_cursos.avance_alumno',$result);
    }
    public function getAlumnos(Request $request){
        $usuarios = LaboratoriosBiblioredes::find($request->input('lab'))->usuarioRecintos;
        return response()->json($usuarios);
    }
    public function getAvanceAlumno(Request $request)
    {
        $avance = AvanceCursos::pocentajeAlumno($request->input('alumno'));
        return response()->json($avance);
    }
    public function getIndex(){  
       return view('metricas.index');
    }    

    
}

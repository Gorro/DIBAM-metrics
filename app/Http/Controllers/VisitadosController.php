<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\LaboratoriosBiblioredes;

class VisitadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['regiones']  = LaboratoriosBiblioredes::getRegiones();
        return view('metricas.visitados.total_sitios',$result);  
    }
    public function getYear(Request $request){
        $lab = LaboratoriosBiblioredes::find($request->input('lab'))->webalizerStats;
        $dominio = $request->input('dominio');
        if(isset($dominio)){
            $lab = $lab->where('vh_name',$request->input('dominio'));
        }
        $years = [];
        foreach ($lab as $value) {
            $data = explode('#', $value->data);
            $years = hGetYears($years,$data);            
        }
        rsort($years);
        return response()->json($years);
    }
    public function getVisitados(Request $request){
        $result = hGetDominios($request->input('lab'),$request->input('year'));
        arsort($result);
        $resultado =[];
        foreach ($result as $key => $value) {
            $results['dominio'] = $key;
            $results['visitas'] = $value;
            array_push($resultado, $results);
        }
        return response()->json($resultado);
    }
    public function dominio(){
        $result['regiones']  = LaboratoriosBiblioredes::getRegiones();
        return view('metricas.visitados.sitio',$result);  
    }
    public function getDominios(Request $request){
        $lab = LaboratoriosBiblioredes::find($request->input('lab'))->getDominios;
        return response()->json($lab);
    }

    public function getDominioVisitado(Request $request){
        $lab = LaboratoriosBiblioredes::find($request->input('lab'))->webalizerStats->where('vh_name',$request->input('dominio'))->first();
        $data = explode('#', $lab->data);
        $result = [];
        foreach ($data as $value) {
            if($value != '' and $value != ' ' and $value != "\n"){
                $stats = explode(' ', $value);
                if((int)$stats[1] == (int)$request->input('year')){
                    $result[] = hGetMonth((int)$stats[0],(int)$stats[6]);                    
                }
            }
        }
        return response()->json($result);
    }
        
}

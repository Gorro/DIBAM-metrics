<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\LaboratoriosBiblioredes;
use App\SessionesCounts;
class SessionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showRecintos($region=null,$recinto=null)
    {
        
        //Asignacion si el parametro opcional es null se le asigna region Metropolitana
        $region= $region==null ? "VI - O*Higgins" : $region;
       
       //*** *************************************************/



        $listado_regiones =  LaboratoriosBiblioredes::getRegiones();
        $listado_recintos =  LaboratoriosBiblioredes::getLaboratorios($region); 
        $conteo_recintos =  SessionesCounts::getCountSessionesRecintos($region);
        $conteo_regiones= SessionesCounts::getCountSessionesRegiones();
        $anios= SessionesCounts::getAnios();

        
        $data= ['regiones'=>$listado_regiones,
                'recintos'=>$listado_recintos,
                'conteo_recintos'=>$conteo_recintos,
                'conteo_regiones'=>$conteo_regiones,
                'anios'=>$anios,
                ];
        return view('metricas.sessiones.recinto',$data);
       
    }

    public function getRecintos($region)
    {
        
        $conteo_recintos =  SessionesCounts::getCountSessionesRecintos($region); 
        $listado_recintos =  LaboratoriosBiblioredes::getLaboratorios($region);               
        $data= ['conteo_recintos'=>$conteo_recintos,
                'recintos'=>$listado_recintos];
        return $data;
       
    }

     public function getRecintoEspecifico($recinto,$anio)
    {
        $conteo_mensual =  SessionesCounts::getCountSessionesEspecificas($recinto,$anio); 
        $data= ['conteo_mensual'=>$conteo_mensual];
        return $data;
    }
      public function ShowFechas($id)
    {
        //
       
    }
      public function ShowDuracion($id)
    {
        //
       
    }

}

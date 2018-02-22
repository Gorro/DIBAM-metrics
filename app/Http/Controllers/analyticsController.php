<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SessionesCounts;
use App\LaboratoriosBiblioredes;
use Cookie;
use Illuminate\Http\Response;

class analyticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
        $laboratorios = LaboratoriosBiblioredes::getRegiones();
        return view('metricas.menu-2.menu2',['laboratorios'=>$laboratorios]);
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
  

    public function showSessions($seccion=null,$region=null)
    {   
         // $conn=DB::connection("mysql");
         // $query='SELECT DISTINCT(region) FROM laboratorios_biblioredes';
      
          $results =   LaboratoriosBiblioredes::getRegiones();
        $data= ['seccion'=>$seccion,
                'region'=>$region,
                'laboratorios'=>$results];
        return view('metricas.script.sesiones',$data);
        //
    }

    public function getSessiones(Request $request,$region)
    {
      if($request->ajax())
      {
          $sessiones= SessionesCounts::sessiones($region);
          return response()->json($sessiones);  
      }
    }

     public static function showcookies(Request $request){
        $login_user_level= substr($request, strpos($request,"login_user_level=")+17);
        $login_user_level= substr($login_user_level,0,10);
        if($login_user_level=="autorizado")
        {  //
            echo("usuario= $login_user_level");
        }
        else
        {
            echo("usuario= $login_user_level");
            return redirect("http://bibliotecasencarceles.biblioredes.cl/");
        }


    }

}

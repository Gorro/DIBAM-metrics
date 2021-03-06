<?php

namespace App\Http\Controllers;

use App\AvanceCursos;
use App\LaboratoriosBiblioredes;
use App\UsuarioRecintos;
use Illuminate\Http\Request;
use Date;
use App\CustomCollection;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class MetricasController extends Controller
{
    public function index()
    {
        $capacitados = AvanceCursos::capacitados()->count();
        $sesionesUsuario = LaboratoriosBiblioredes::with('sesiones')->get();
        $totalUsuarios = UsuarioRecintos::count();
        $cantidadSesiones = 0;
        $recintos = [];


        foreach ($sesionesUsuario as $recinto) {
            $cantidad = count($recinto->sesiones);
            if($cantidad >0 ) {
                $cantidadSesiones += count($recinto->sesiones);
            }
        }
        return view('metricas.adminMaterial.index',compact('capacitados','cantidadSesiones', 'totalUsuarios' , 'recintos'));
    }

    public function form(Request $request)
    {
        $result = $this->search($request);
        $result['regiones']  = LaboratoriosBiblioredes::getRegiones();
        return view('metricas.adminMaterial.forms.form', $result);
    }

    public function getUsers(Request $request)
    {
        $result = $this->search($request);

        return response()->json(['view' => view('metricas.adminMaterial.tables.table',$result)->render(),'chart' => $result['chart']]);
    }

    public function getLabs(Request $request){
        return LaboratoriosBiblioredes::getLaboratoriosRegion($request->input('region'));
    }

    public function exportExcel(Request $request)
    {
        if($request->seleccion == 1){
            $usuarios = $this->showUsersTrained($request);

            \Excel::create('Usuarios_Certificados', function($excel) use ($usuarios)  {
                $excel->sheet('Hoja 1', function($sheet) use ($usuarios){
                    $export = [
                        'Rut' => [],
                        'Nombre' => [],
                        'Laboratorio' => []
                    ];
                    $sheet->loadView('metricas.adminMaterial.tables.user_table_excel', ['usuarios' => $usuarios, 'certificado' =>true]);
                    $sheet->freezeFirstRow();
                });
            })->export('xls');
        }
        if($request->seleccion == 2){
            $recintos = $this->showLabs($request);

            \Excel::create('Sesiones_por_Recinto', function($excel) use ($recintos)  {
                $excel->sheet('Hoja 1', function($sheet) use ($recintos){
                    $export = [
                        'Rut' => [],
                        'Nombre' => [],
                        'Laboratorio' => []
                    ];
                    $sheet->loadView('metricas.adminMaterial.tables.session_table_excel', ['recintos' => $recintos]);

                    $sheet->freezeFirstRow();
                });
            })->export('xls');
        }
        if($request->seleccion == 3){
            $usuarios = $this->showUsers($request);

            \Excel::create('Usuarios_Registrados', function($excel) use ($usuarios)  {
                $excel->sheet('Hoja 1', function($sheet) use ($usuarios){
                    $export = [
                        'Rut' => [],
                        'Nombre' => [],
                        'Laboratorio' => []
                    ];
                    $sheet->loadView('metricas.adminMaterial.tables.user_table_excel', ['usuarios' => $usuarios, 'certificado' =>false]);
                    $sheet->freezeFirstRow();
                });
            })->export('xls');
        }

    }

    private function showUsersTrained($request)
    {
        $result['usuarios'] = AvanceCursos::with('usuario.lab')->capacitados();
        if($request->has('ano') && $request->ano > 0){
            $result['usuarios'] = $result['usuarios']->whereRaw("YEAR(fecha_inicio) = $request->ano");
        }
        if( !(empty($request->fecha_inicio) && empty($request->fecha_termino)) ){
            $termino = \DateTime::createFromFormat('m/Y', $request->fecha_termino)->format('Y-m');
            $inicio = \DateTime::createFromFormat('m/Y', $request->fecha_inicio)->format('Y-m');
            $result['usuarios'] = $result['usuarios']->whereRaw("DATE_FORMAT(fecha_inicio,'%Y-%m') BETWEEN '$inicio' and '$termino'");
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
        return $result['usuarios']->get();
    }

    private function showLabs($request)
    {
        $result['recintos'] = LaboratoriosBiblioredes::with('sesiones.usuario');
        if($request->has('region')){
            $result['recintos'] = $result['recintos']->where('region',$request->region);
        }
        if($request->has('recinto')) {
            $result['recintos'] = $result['recintos']->where('id', $request->recinto);
        }
        if($request->has('ano') && $request->ano > 0){
            $result['recintos'] = $result['recintos']->whereHas('sesiones', function ($query) use ($request) {
                $query->whereRaw("YEAR(fecha_session) = $request->ano");
            });
        }
        if( ($request->has('fecha_inicio') || $request->has('fecha_termino')) || !(empty($request->fecha_inicio) && empty($request->fecha_termino)) ) {
            $termino = \DateTime::createFromFormat('m/Y', $request->fecha_termino)->format('Y-m');
            $inicio = \DateTime::createFromFormat('m/Y', $request->fecha_inicio)->format('Y-m');
            $result['recintos'] = $result['recintos']->whereHas('sesiones', function ($query) use ($inicio, $termino) {
                $query->whereRaw("DATE_FORMAT(fecha_session,'%Y-%m') BETWEEN '$inicio' and '$termino'");
            });
        }
        return $result['recintos']->get();
    }

    private function showUsers(Request $request)
    {
        $result['usuarios'] = UsuarioRecintos::with('lab');

        if($request->has('region')){
            $result['usuarios'] = $result['usuarios']->whereHas('lab',function($query) use ($request){
                $query->where('region',$request->region);
            });
        }
        if($request->has('recinto')){
            $result['usuarios'] = $result['usuarios']->whereHas('lab',function($query) use ($request){
                $query->where('id',$request->recinto);
            });
        }
        return $result['usuarios']->get();

    }

    private function search(Request $request)
    {
        $result = [
            'seleccion' => $request->seleccion,
            'user' => true,
            'certificado' => true
        ];
        if($request->seleccion == 1){
            $result['usuarios'] = $this->showUsersTrained($request);
            $chart = [];
            foreach ($result['usuarios'] as $usuario){
                if(!is_null($usuario->usuario)){
                    $key = $usuario->usuario->lab->laboratorio;
                    if(isset($chart["$key"])){
                        $chart["$key"] += 1;
                    } else {
                        $chart["$key"] = 1;
                    }
                }
            }
            $result['chart'] = json_encode($chart);
        }
        if ( $request->seleccion == 2){
            $result['recintos'] = $this->showLabs($request);
            $result['user'] = false;
            $chart = [];
            foreach ( $result['recintos'] as $recinto ) {
                $cantidad = count($recinto->sesiones);
                if ($cantidad > 0){
                    $chart[$recinto->laboratorio] = $cantidad;
                }
            }
            $result['chart'] = json_encode($chart);
        }
        if($request->seleccion == 3){
            $result['usuarios'] = $this->showUsers($request);
            $result['certificado'] = false;
            foreach ($result['usuarios'] as $usuario){
                if(!is_null($usuario)){
                    $key = $usuario->lab->laboratorio;
                    if(isset($chart["$key"])){
                        $chart["$key"] += 1;
                    } else {
                        $chart["$key"] = 1;
                    }
                }
            }
            $result['chart'] = json_encode($chart);
        }
        return $result;
    }

    public function prueba()
    {
        dd(UsuarioRecintos::with('lab')->get());
    }
}

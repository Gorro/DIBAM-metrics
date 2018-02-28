<?php

namespace App\Http\Controllers;

use App\AvanceCursos;
use App\LaboratoriosBiblioredes;
use App\SessionesCounts;
use App\UsuarioRecintos;
use Carbon\Carbon;
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
            'seleccion' => $request->seleccion,
            'user' => true
        ];
        if($request->seleccion == 1){
            $result['usuarios'] = $this->showUsers($request);
        } elseif ( $request->seleccion == 2){
            $result['recintos'] = $this->showLabs($request);
            $result['user'] = false;
        }elseif ( $request->tipo == 2 ){
            return false;
        }
        $result['regiones']  = LaboratoriosBiblioredes::getRegiones();
        return view('metricas.adminMaterial.forms.form', $result);
    }
    public function prueba(){

        $usuarios = AvanceCursos::with('usuario.lab')->capacitados()->get();

        \Excel::create('users', function($excel) use ($usuarios)  {
            $excel->sheet('Sheet 1', function($sheet) use ($usuarios){
                $export = [
                    'Rut' => [],
                    'Nombre' => [],
                    'Laboratorio' => []
                ];
                foreach ($usuarios as $usuario){
                    if (!is_null($usuario->usuario)) {
                        $sheet->loadView('metricas.adminMaterial.tables.user_table_excel', ['usuarios' => $usuarios]);
                    }
                };
                $sheet->freezeFirstRow();
            });
        })->export('xls');
    }
    public function getLabs(Request $request){
        return LaboratoriosBiblioredes::getLaboratoriosRegion($request->input('region'));
    }
    public function getUsers(Request $request)
    {
        $result = [
            'seleccion' => $request->seleccion,
            'user' => true
        ];

        if($request->seleccion == 1){
            $result['usuarios'] = $this->showUsers($request);
        }
        if($request->seleccion == 2){
            $result['recintos'] = $this->showLabs($request);
            $result['user'] = false;
        }
        return view('metricas.adminMaterial.tables.table',$result);
    }
    private function showUsers($request)
    {
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
        if( ($request->has('fecha_inicio') || $request->has('fecha_termino')) || !(empty($request->fecha_inicio) && empty($request->fecha_termino)) ) {
            $result['recintos'] = $result['recintos']->whereHas('sesiones', function ($query) use ($inicio, $termino) {
                $query->whereRaw("DATE(fecha_session) BETWEEN '$inicio' and '$termino'");
            });
        }
        return $result['recintos']->get();
    }

    public function exportExcel(Request $request)
    {
        if($request->seleccion == 1){
            $usuarios = $this->showUsers($request);

            \Excel::create('users', function($excel) use ($usuarios)  {
                $excel->sheet('Sheet 1', function($sheet) use ($usuarios){
                    $export = [
                        'Rut' => [],
                        'Nombre' => [],
                        'Laboratorio' => []
                    ];
                    $sheet->loadView('metricas.adminMaterial.tables.user_table_excel', ['usuarios' => $usuarios]);
                    $sheet->freezeFirstRow();
                });
            })->export('xls');
        }
        if($request->seleccion == 2){
            $recintos = $this->showLabs($request);

            \Excel::create('users', function($excel) use ($recintos)  {
                $excel->sheet('Sheet 1', function($sheet) use ($recintos){
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

    }
}

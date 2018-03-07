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
        foreach ($sesionesUsuario as $recinto) {
            $cantidad = count($recinto->sesiones);
            if($cantidad >0 ) {
                $cantidadSesiones += count($recinto->sesiones);
            }
        }
        return view('metricas.adminMaterial.index',compact('capacitados','cantidadSesiones', 'totalUsuarios'));
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
        return view('metricas.adminMaterial.tables.table',$result);
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
            $result['usuarios'] = $result['usuarios']->whereRaw("YEAR(fecha_inicio)",$request->ano);
        }
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
        if($request->has('ano') && $request->ano > 0){
            $result['recintos'] = $result['recintos']->whereHas('sesiones', function ($query) use ($request) {
                $query->whereRaw("YEAR(fecha_session) = $request->ano");
            });
        }
        if( ($request->has('fecha_inicio') || $request->has('fecha_termino')) || !(empty($request->fecha_inicio) && empty($request->fecha_termino)) ) {
            $termino = \DateTime::createFromFormat('d/m/Y', $request->fecha_termino)->format('Y-m-d');
            $inicio = \DateTime::createFromFormat('d/m/Y', $request->fecha_inicio)->format('Y-m-d');
            $result['recintos'] = $result['recintos']->whereHas('sesiones', function ($query) use ($inicio, $termino) {
                $query->whereRaw("DATE(fecha_session) BETWEEN '$inicio' and '$termino'");
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
        }
        if ( $request->seleccion == 2){
            $result['recintos'] = $this->showLabs($request);
            $result['user'] = false;
        }
        if($request->seleccion == 3){
            $result['usuarios'] = $this->showUsers($request);
            $result['certificado'] = false;
        }
        return $result;
    }

    public function prueba()
    {
        dd(UsuarioRecintos::with('lab')->get());
    }
}

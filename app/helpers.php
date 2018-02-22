<?php
use App\LaboratoriosBiblioredes;
function hGetDominios($recinto,$year){
	$lab = LaboratoriosBiblioredes::find($recinto)->webalizerStats;
    $i = 0;
    foreach ($lab as $value) {
        $dominio = $value->vh_name;
        $data = $value->data;
        $data = explode('#', $data);
        $visitas = 0;
        foreach ($data as $value) {
            if($value != '' and $value != ' ' and $value != "\n"){
                $stats = explode(' ', $value);
                if($stats[1] == $year){
                    $visitas += (int) $stats[6];                        
                }
            }                
        }
        if($visitas != 0){                           
            $result["$dominio"] = $visitas;
        }
    }
    return $result;
}
function hGetYears($years,$data){
	foreach ($data as $value) {
		if($value != '' and $value != ' ' and $value != "\n"){
	        $stats = explode(' ', $value);
	        if(!in_array($stats[1], $years)){
	            $years[] = (int)trim($stats[1]);
	        }
	    }        
    }
	return $years;
}
function hGetMonth($month,$visitas){
	switch ($month) {
        case 1:
            $datos['mes'] = 'Enero';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 2:
            $datos['mes'] = 'Febrero';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 3:
            $datos['mes'] = 'Marzo';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 4:
            $datos['mes'] = 'Abril';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 5:
            $datos['mes'] = 'Mayo';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 6:
            $datos['mes'] = 'Junio';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 7:
            $datos['mes'] = 'Julio';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 8:
            $datos['mes'] = 'Agosto';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 9:
            $datos['mes'] = 'Septiembre';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 10:
            $datos['mes'] = 'Octubre';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 11:
            $datos['mes'] = 'Noviembre';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
        case 12:
            $datos['mes'] = 'Diciembre';
            $datos['visitas'] = $visitas;
            return $datos;
            break;
    }    
}
function hGetPorcentaje($usuarios,$cantidadUsuarios){
    foreach ($usuarios as $value) {
        $value->cantidad = round((($value->cantidad)/$cantidadUsuarios)*100,2);
    }
    return $usuarios;
}

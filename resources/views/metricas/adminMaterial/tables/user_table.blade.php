@if(count($usuarios) > 0)
<div class="col-12">
    <a href="" class="btn btn-primary pull-right" id="excel">Exportar Excel</a>
</div>
@endif
<table id="example" class="table table-striped table-bordered table-responsive-md" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Rut</th>
        <th>Nombre</th>
        <th>Escolaridad</th>
        <th>Laboratorio</th>
    </tr>
    </thead>
    <tbody>
    @if($certificado)
        @foreach($usuarios as $usuario)
            @if(!is_null($usuario->usuario))
                <tr>
                    <td>{{ number_format( substr ( $usuario->usuario->rut, 0 , -1 ) , 0, "", ".") . '-' . substr ( $usuario->usuario->rut, strlen($usuario->usuario->rut) -1 , 1 ) }}</td>
                    <td>{{$usuario->usuario->fullname}}</td>
                    <td>{{ \App\Constants\Escolaridad::NIVEL_ESCOLARIDAD[$usuario->usuario->codigo_escolaridad] }}</td>
                    <td>{{$usuario->usuario->lab->laboratorio}}</td>
                </tr>
            @endif
        @endforeach
    @else
        @foreach($usuarios as $usuario)
            @if(!is_null($usuario))
                <tr>
                    <td>{{ number_format( substr ( $usuario->rut, 0 , -1 ) , 0, "", ".") . '-' . substr ( $usuario->rut, strlen($usuario->rut) -1 , 1 ) }}</td>
                    <td>{{$usuario->fullname}}</td>
                    <td>{{ \App\Constants\Escolaridad::NIVEL_ESCOLARIDAD[$usuario->codigo_escolaridad] }}</td>
                    <td>{{$usuario->lab->laboratorio}}</td>
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
</table>
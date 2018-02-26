<table id="example" class="table table-striped table-bordered table-responsive-md" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>Rut</th>
        <th>Nombre</th>
        <th>Laboratorio</th>
    </tr>
    </thead>
    <tbody>
    @foreach($usuarios as $usuario)
        @if(!is_null($usuario->usuario))
            <tr>
                <td>{{ number_format( substr ( $usuario->usuario->rut, 0 , -1 ) , 0, "", ".") . '-' . substr ( $usuario->usuario->rut, strlen($usuario->usuario->rut) -1 , 1 ) }}</td>
                <td>{{$usuario->usuario->fullname}}</td>
                <td>{{$usuario->usuario->lab->laboratorio}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
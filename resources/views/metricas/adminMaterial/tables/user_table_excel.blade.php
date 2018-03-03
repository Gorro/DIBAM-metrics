<table>
    <thead>
    <tr>
        <th>Rut</th>
        <th>Nombre</th>
        <th>Escolaridad</th>
        <th>Laboratorio</th>
    </tr>
    </thead>
    <tbody>
    @foreach($usuarios as $usuario)
        @if(!is_null($usuario->usuario))
            <tr>
                <td>{{ trim(number_format( substr ( $usuario->usuario->rut, 0 , -1 ) , 0, "", ".") . '-' . substr ( $usuario->usuario->rut, strlen($usuario->usuario->rut) -1 , 1 )) }}</td>
                <td>{{$usuario->usuario->fullname}}</td>
                <td>{{ \App\Constants\Escolaridad::NIVEL_ESCOLARIDAD[$usuario->usuario->codigo_escolaridad] }}</td>
                <td>{{$usuario->usuario->lab->laboratorio}}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
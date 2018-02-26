<table id="example" class="table table-striped table-bordered table-responsive-md" cellspacing="0" width="100%">
    <thead>
    <tr>
        <th>laboratorio</th>
        <th>Cantidad de Sesiones</th>
    </tr>
    </thead>
    <tbody>
    @foreach ( $recintos as $recinto )
        <?php $cantidad = count($recinto->sesiones); ?>
        @if( $cantidad >0 )
            <tr>
                <td>{{ $recinto->laboratorio }}</td>
                <td>{{ $cantidad }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>
<form action="{{url('/getUsers')}}" style="width:100%" id="search">
    <div class="col-12 form-row">
        <div class="col animated fadeIn">
            <select name="seleccion" class="mdb-select" id="selecciona">
                <option value="" disabled selected>Selecciona</option>
                <option value="1">Usuarios Certificados</option>
                <option value="2">Sesiones de Usuario</option>
                <option value="3">Usuarios Registrados</option>
            </select>
        </div>
        <div class="col animated fadeIn">
            <select id="region" name="region" class="mdb-select" onchange="app.getLabs($(this).val())">
                <option value="" disabled selected>Regiones</option>
                @foreach ($regiones as $lab)
                    <option value="{{$lab->region}}">{{$lab->region}}</option>
                @endforeach
            </select>
        </div>
        <div class="col animated fadeIn">
            <select class="mdb-select" id="recintos" name="recinto" >
                <option value="" disabled selected>Recintos</option>
            </select>
        </div>
        <div class="col animated fadeIn">
            <select name="ano" class="mdb-select" id="ano">
                <option value="0" selected>Selecciona año</option>
                @for( $ano = 2017; $ano <= date('Y'); $ano++)
                    <option value="{{$ano}}">{{$ano}}</option>
                @endfor
            </select>
        </div>
        <div class="col animated fadeIn">
            <div class="md-form">
                <input placeholder="Fecha Inicio" name="fecha_inicio" type="text" id="startDate" class="form-control datepicker @if($seleccion == 3) d-none @endif">
            </div>
        </div>
        <div class="col animated fadeIn">
            <div class="md-form">
                <input placeholder="Fecha Termino" type="text" name="fecha_termino" id="endDate" class="form-control datepicker @if($seleccion == 3) d-none @endif">
            </div>
        </div>
        <div class="clear-fix"></div>
        <div class="col animated fadeIn">
            <input type="submit" class="btn btn-default" value="Buscar">
        </div>
    </div>
</form>
<canvas id="piechart"></canvas>
<div id="table_search" class="col-12">
    @include('metricas.adminMaterial.tables.table')
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-notify modal-info" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <p class="heading lead">Modal Info</p>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">×</span>
                </button>
            </div>


            <div class="modal-body">

            </div>


            <div class="modal-footer">
                <a type="button" class="btn btn-info waves-effect waves-light" data-dismiss="modal">Cerrar
                </a>
            </div>
        </div>

    </div>
</div>

<script>
app.dataChart = {!! $chart !!};
</script>
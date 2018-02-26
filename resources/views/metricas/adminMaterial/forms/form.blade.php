<form action="{{url('/getUsers')}}" style="width:100%" id="search">
    <div class="col-12 form-row">
        <div class="col animated fadeIn">
            <select name="seleccion" class="mdb-select">
                <option value="" disabled selected>Selecciona</option>
                <option value="1">Usuarios Certificados</option>
                <option value="2">Sesiones de Usuario</option>
                <option value="3">Usuarios Registrados</option>
            </select>
        </div>
        <div class="col animated fadeIn">
            <select id="region" name="region" class="mdb-select" onchange="getLabs($(this).val())">
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
            <div class="md-form">
                <input placeholder="Fecha Inicio" name="fecha_inicio" type="text" id="startDate" class="form-control datepicker">
            </div>
        </div>
        <div class="col animated fadeIn">
            <div class="md-form">
                <input placeholder="Fecha Termino" type="text" name="fecha_termino" id="endDate" class="form-control datepicker">
            </div>
        </div>
        <div class="clear-fix"></div>
        <div class="col animated fadeIn">
            <input type="submit" class="btn btn-default" value="Buscar">
        </div>
    </div>
</form>
<div id="table_search">
    @include('metricas.adminMaterial.tables.table')
</div>

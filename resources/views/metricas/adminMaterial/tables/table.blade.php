@if($user)
    @include('metricas.adminMaterial.tables.user_table')
@else
    @include('metricas.adminMaterial.tables.session_table')
@endif
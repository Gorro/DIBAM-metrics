@extends('metricas.menu-2.menu2')
@section('titulo','Visitas a secciones')
@section('titulo_seccion','Avance por recinto')
@section('center') 
    <div class="wrapper wrapper-content animated fadeInRight" id="visitados"> 
      <div class="row">
        <div class="col-lg-12">
            
        </div>             
      </div>
    </div>
@endsection
@section('script')
    <script>
     

        var data={!! $data_info !!};

        console.log(data)
    </script>    
@endsection
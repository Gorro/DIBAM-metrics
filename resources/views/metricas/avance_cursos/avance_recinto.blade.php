@extends('metricas.menu-2.menu2')
@section('titulo','Visitas a secciones')
@section('titulo_seccion','Avance por recinto')
@section('center') 
    <div class="wrapper wrapper-content animated fadeInRight" id="visitados"> 
      <div class="row">
        <div class="col-lg-12">
              <div class="">
                <!-- Seleccion de la region -->
                  <div class="form-group col-md-4">
                      <label for="region" class="font-noraml">Selecciona una region:</label>                      
                        <select style="width:350px;" name="region" data-placeholder="Elegir un año" class="form-control" tabindex="2" id="ano" v-model="region" v-on:change="getLaboratorios()">
                            <option disabled value="">--Regiones--</option>
                            @foreach ($regiones as $lab)
                              <option value="{{$lab->region}}">{{$lab->region}}</option>
                            @endforeach 

                        </select>
                  </div>
                   <!--Eleccion de recinto-->
                  <div  class="col-md-4">
                    <img src="{{url('/')}}/images/ajax-loader.gif" v-if="laboratorios.length == 0 && verLab" class="img-responsive" alt="">             
                    <div  v-if="laboratorios.length !=0 || !verLab" class="form-group">
                        <label class="font-noraml">Selecciona un Laboratorio:</label>
                          <select style="width:350px;" data-placeholder="Elegir un recinto" class="form-control"  tabindex="2" id="recinto" v-model="lab" v-on:change="getAvance"> 
                              <option disabled value="" selected>--Laboratorios--</option>                        
                              <option v-for="laboratorio in laboratorios" v-bind:value="laboratorio.id">@{{laboratorio.laboratorio}}</option>
                          </select>
                      </div>
                  </div>  
                </div>
                <div class="clearfix"></div>
                <hr>
          </div>
          <div class="col-lg-12">
            <div id="barchart" style="width: 100%; height: 500px;" ></div>
          </div>                                 
      </div>
    </div>
@endsection
@section('script')
    <script src="{{url('/')}}/js/vue.js"></script>
    <script>
      $('#courses').addClass('in');
      $('.lista-menu li a').eq(2).addClass('activo');
      $('.pure-menu-item span').eq(1).addClass('rotate-arrow');
      cargar();
      var app = new Vue({
        el : '#visitados',
        data : {verLab:false,region:'',lab:'',laboratorios:[],avance:[]},
        methods : {
          getLaboratorios : function(){
            if(!this.ververLab){
              this.verLab = true;
            }
            this.lab = '';
            app.laboratorios = [];
            $.get("{{url('/')}}/getlaboratorios",{region:this.region}, function(data, status){
              app.laboratorios = data;
            });
          },
          getAvance : function(){
            $.get("{{url('/')}}/porcentaje",{lab:this.lab}, function(data, status){
              app.avance = data;
              cargar();
            });
          }
        }
      }) 
      function cargar(){             
        google.charts.load('current', {'packages': ['bar']});        
        google.charts.setOnLoadCallback(drawChart);
        function drawChart(data) {
          var options = {
            legend: { position: 'none' },
            colors: ['#8642c0'],            
            axes: {
              x: {
                0: { side: 'top'} // Top x-axis.
              }
            }
          };
          var dataTable = new google.visualization.DataTable();
              dataTable.addColumn('string', 'Curso');
              dataTable.addColumn('number', 'Porcentaje');
          if(app.avance.length == 0){
            dataTable.addRow(['Sin Datos',0]);
          }else{            
            $.each( app.avance, function( key, value ) {
              dataTable.addRow([value.nombre_curso,parseInt(value.cantidad)]);
            });            
          }                       
          var chart = new google.charts.Bar(document.getElementById('barchart'));
          chart.draw(dataTable,google.charts.Bar.convertOptions(options));           
        }
      }
    </script>    
@endsection
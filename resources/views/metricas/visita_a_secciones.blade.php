@extends('metricas.menu-2.menu2')
@section('titulo','Visitas a secciones')
@section('titulo_seccion','Visitas a secciones')
 @section('center') 
  <div class="wrapper wrapper-content animated fadeInRight" id="seccionClick"> 
      <div class="row">
          <div class="col-lg-6">
              <h3>Secciones generales del sitio:</h3> 
              <div class="ibox-content">            
              <div id="donut_single" style="width: 100%; height: 350px; margin-bottom: 20px;"></div>
                <!-- Seleccion del año -->
                <div class="form-group">
                    <label class="font-noraml">Selecciona un Año:</label>
                    <div class="input-group ">
                        <select data-placeholder="Elegir un año" class="form-control" style="width:350px;" tabindex="2" id="ano" v-model="year" v-on:change="getSeccion('seccion_name','donut_single')">
                            <option disabled value="">--Años--</option>
                            @foreach($anos as $ano)
                              <option value="{{$ano->year}}">{{$ano->year}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>              
                <!-- Eleccion de mes-->
                <div class="form-group">
                    <label class="font-noraml">Selecciona un Mes:</label>
                    <div class="input-group ">
                        <select data-placeholder="Elegir un mes" class="form-control" style="width:350px;" tabindex="2" id="mes" v-model="month" v-on:change="getSeccion('seccion_name','donut_single')">
                            <option disabled value="">--Meses--</option>                          
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                    </div>
                </div>
                <!-- Seleccion de la region -->
                <div class="form-group">
                    <label class="font-noraml">Selecciona una region:</label>
                    <div class="input-group ">
                        <select data-placeholder="Elegir un año" class="form-control" style="width:350px;" tabindex="2" id="ano" v-model="region" v-on:change="getLaboratorios()">
                            <option disabled value="">--Regiones--</option>
                            @foreach ($regiones as $lab)
                              <option value="{{$lab->region}}">{{$lab->region}}</option>
                            @endforeach 

                        </select>
                    </div>
                </div>
                <div  v-if="laboratorios.length == 0 && verLab" class="form-group">
                  <img src="{{url('/')}}/images/ajax-loader.gif" alt="">
                </div>
                <!--Eleccion de recinto-->
                 <div  v-if="laboratorios.length !=0 || !verLab" class="form-group">
                    <label class="font-noraml">Selecciona un Laboratorio:</label>
                    <div class="input-group ">
                        <select data-placeholder="Elegir un recinto" class="form-control" style="width:350px;" tabindex="2" id="recinto" v-model="lab" v-on:change="getSeccion('seccion_name','donut_single')"> 
                            <option disabled value="" selected>--Laboratorios--</option>                        
                            <option v-for="laboratorio in laboratorios" v-bind:value="laboratorio.id">@{{laboratorio.laboratorio}}</option>
                        </select>
                    </div>
                </div>
              </div>
          </div>
          <div class="col-lg-6">
            <h3>Links más visitados según la sección</h3>
            <div id="piechart" style="width: 100%; height: 350px; margin-bottom: 20px;"></div>
            <div  v-if="verSeccion" class="form-group">
              <img src="{{url('/')}}/images/ajax-loader.gif" alt="">
            </div>
            <div v-if="!verSeccion" class="ibox-content">
              <label class="font-noraml">Selecciona una sección:</label>
                <div class="input-group ">
                    <select data-placeholder="Elige una sección" class="form-control" style="width:350px;" tabindex="2" id="secciones" v-model="seccion"  v-on:change="getSeccion('link_name','piechart')"> 
                        <option disabled value="" selected>--Secciones--</option>
                        <option v-for="seccion in secciones" v-bind:value="seccion.seccion_name">@{{seccion.seccion_name}}</option>
                    </select>
                </div>
            </div>
          </div>          
      </div>
  </div>
  @endsection
  @section('script')
    <script src="{{url('/')}}/js/vue.js"></script>
    <script>    
      $('#visitas').addClass('activo');
      cargarCategoria("")
      var app = new Vue({
        el : '#seccionClick',
        data : {
          verLab         : false,
          verSeccion     : false,
          year           : '',
          month          : '',
          region         : '',
          lab            : '',
          seccion        : '',
          laboratorios   : [],
          secciones      : [],
          seccionesClick : []
        },
        methods : {
          getLaboratorios : function(){
            cargarCategoria('');
            app.seccion = '';
            app.secciones = [];
            if(!this.verLab){
              this.verLab = true;
            }
            this.lab = '';
            app.laboratorios = [];
            $.get("{{url('/')}}/getlaboratorios",{region:this.region}, function(data, status){
              app.laboratorios = data;
            });
          },
          getSeccion : function(seccion,id){
            if(this.lab != '' && this.year != '' && this.month != ''){              
              if(id === 'donut_single'){
                app.verSeccion = true;
              }
              $.get("{{url('/')}}/getseccion",{seccion_name: seccion,lab : this.lab, year : this.year, month : this.month, seccion : this.seccion}, function(data, status){
                if(id === 'donut_single'){
                  app.secciones = data;
                  app.verSeccion = false;
                  app.seccion = '';
                  console.log(app.verSeccion + ' ' + app.verLab);
                }else{
                  app.seccionesClick = data;
                }
                cargarCategoria(id);
              }
              );              
            }
          }
        }
      })      
      
      function cargarCategoria(id){         
        google.charts.load('current', {
          'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart(data) {
          var dataTable = new google.visualization.DataTable();
          dataTable.addColumn('string', 'Leyenda');
          dataTable.addColumn('number', 'Cantidad');
          if(id === 'donut_single'){
            if(app.secciones.length === 0){                
              dataTable.addRow(['Sin datos',1]);
              id = '';
            }else{
              $.each( app.secciones, function( key, value ) {
                dataTable.addRow([value.seccion_name,parseInt(value.cantidad)]); 
              });                
            }
          }else if(id === 'piechart'){
            if(app.seccionesClick.length === 0){                
              dataTable.addRow(['Sin datos',1]);
            }else{
              $.each( app.seccionesClick, function( key, value ) {
                dataTable.addRow([value.link_name,parseInt(value.cantidad)]); 
              });                
            }
          }else{
            dataTable.addRow(['Sin datos',1]);
          }    
          var options = {
            pieHole: 0.4,          
          };
          if(id === ''){
            var chart = new google.visualization.PieChart(document.getElementById('donut_single'));
            chart.draw(dataTable, {colors: ['#5574A6']});
            chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(dataTable, {colors: ['#5574A6']});
          }else{            
            chart = new google.visualization.PieChart(document.getElementById(id));
            chart.draw(dataTable, options);
            if(id==='donut_single'){
              dataTable = new google.visualization.DataTable();
              dataTable.addColumn('string', 'Leyenda');
              dataTable.addColumn('number', 'Cantidad');
              dataTable.addRow(['Sin datos',1]);
              chart = new google.visualization.PieChart(document.getElementById('piechart'));
              chart.draw(dataTable, {colors: ['#5574A6']});
            }
          }          
        }
      }
    </script>
  @endsection
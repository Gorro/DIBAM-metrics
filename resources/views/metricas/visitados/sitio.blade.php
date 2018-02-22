@extends('metricas.menu-2.menu2')
@section('titulo','Visitas a dominios')
@section('titulo_seccion','Visitas por sitio')
 @section('center') 
    <div class="wrapper wrapper-content animated fadeInRight" id="visitados"> 
      <div class="row">
        <div class="col-lg-12">
              <h3>Sitios más visitados</h3> 
                <div class="">
                  <!-- Seleccion de la region -->
                  <div class="form-group col-md-3">
                      <label for="region" class="font-noraml">Selecciona una region:</label>                      
                        <select style="width:90%;" name="region" data-placeholder="Elegir un año" class="form-control" tabindex="2" id="ano" v-model="region" v-on:change="getLaboratorios()">
                            <option disabled value="">--Regiones--</option>
                            @foreach ($regiones as $lab)
                              <option value="{{$lab->region}}">{{$lab->region}}</option>
                            @endforeach 

                        </select>
                  </div>
                   <!--Eleccion de recinto-->
                  <div  class="col-md-3">
                    <img src="{{url('/')}}/images/ajax-loader.gif" v-if="laboratorios.length == 0 && verLab" class="img-responsive" alt="">             
                    <div  v-if="laboratorios.length !=0 || !verLab" class="form-group">
                        <label class="font-noraml">Selecciona un Laboratorio:</label>
                          <select style="width:90%;" data-placeholder="Elegir un recinto" class="form-control"  tabindex="2" id="recinto" v-model="lab" v-on:change="getDominios"> 
                              <option disabled value="" selected>--Laboratorios--</option>                        
                              <option v-for="laboratorio in laboratorios" v-bind:value="laboratorio.id">@{{laboratorio.laboratorio}}</option>
                          </select>
                      </div>
                  </div>
                  <!-- Seleccion del dominio -->
                  <div class="col-md-3">
                    <img src="{{url('/')}}/images/ajax-loader.gif"  v-if="dominios.length == 0 && verDominio" alt="">
                    <div class="form-group" v-if="dominios.length !=0 || !verDominio" >
                        <label class="font-noraml">Selecciona un Dominio:</label>                     
                          <select style="width:90%;" data-placeholder="Elegir un año" class="form-control"  tabindex="2" id="ano" v-model="dominio" v-on:change="getYear">
                              <option disabled value="">--Dominios--</option>
                              <option v-for="dominio in dominios" v-bind:value="dominio.vh_name">@{{dominio.vh_name}}</option>
                          </select>
                      </div>
                  </div>
                  <!-- Seleccion del año -->
                  <div  v-if="years.length == 0 && verYear" class="col-md-3">
                    <img src="{{url('/')}}/images/ajax-loader.gif" alt="">
                  </div>  
                  <div class="form-group col-md-3">
                    <div class="form-group" v-if="years.length !=0 || !verYear" >
                        <label class="font-noraml">Selecciona un año:</label>                     
                          <select style="width:90%;" data-placeholder="Elegir un año" class="form-control"  tabindex="2" id="ano" v-model="year" v-on:change="getMeses">
                              <option disabled value="">--Años--</option>
                              <option v-for="year in years" v-bind:value="year">@{{year}}</option>
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
      $('#sites').addClass('in');
      $('.pure-menu-item span').eq(0).addClass('rotate-arrow');
      $('.lista-menu li a').eq(1).addClass('activo');
      cargar();
      var app = new Vue({
        el : '#visitados',
        data : {verLab:false,verYear:false,verDominio:false,dominio:'',year:'',region:'',lab:'',laboratorios:[],years:[],dominios:[],meses:[]},
        methods : {
          getLaboratorios : function(){
            vaciar(true);
            if(!this.ververLab){
              this.verLab = true;
            }
            this.lab = '';
            app.laboratorios = [];
            $.get("{{url('/')}}/getlaboratorios",{region:this.region}, function(data, status){
              app.laboratorios = data;
            });
          },
          getDominios : function(){
            vaciar(true);
            if(!this.verDominio){
              this.verDominio = true;
            }
            $.get("{{url('/')}}/getdominios",{lab:this.lab}, function(data, status){
              app.dominios = data;
              app.verDominio = false;
            });
          },
          getYear : function(){
            vaciar(false);
            if(!this.verYear){
              this.verYear = true;
            }
            $.get("{{url('/')}}/years",{lab:this.lab,dominio:this.dominio}, function(data, status){
              app.years = data;
              app.verYear = false;
            });

          },
          getMeses : function(){
            $.get("{{url('/')}}/getmeses",{lab:this.lab,dominio:this.dominio,year:this.year}, function(data, status){
              app.meses = data;
              cargar();
            });
          }
        }
      })      
    
    function cargar(){ 
      google.charts.load('current', {'packages': ['bar']});        
      google.charts.setOnLoadCallback(drawChart);
      function drawChart(data) {
        var dataTable = new google.visualization.DataTable();
          dataTable.addColumn('string', 'Mes');
          dataTable.addColumn('number', 'Visitas');
          var i = 0;
          $.each( app.meses, function( key, value ) {
            dataTable.addRow([value.mes,value.visitas]);
          });
        if(app.meses.length == 0){
          dataTable.addRow(['Sin Datos',0]);
          var title = '';
        }else{
          var title = 'visitas en el '+ app.year;
        }
        var options = {
          title: 'Visitas del sitio por mes',
          colors: ['#8642c0'],
          legend: {
              position: 'none'
          },
          axes: {
              x: {
                  0: {
                      side: 'top',
                      label: title
                  } // Top x-axis.
              }
          },
          bar: {
              groupWidth: "80%"
          }
      };
        var chart = new google.charts.Bar(document.getElementById('barchart'));
        chart.draw(dataTable, google.charts.Bar.convertOptions(options));           
      }
    }
    
    vaciar = function(dominio){
      if(app.meses.length !== 0){              
          app.meses = [];
          cargar();
        }
      app.year = '';
      app.years = [];
      if(dominio){
        app.dominio = '';
        app.dominios = [];        
      }
    }
    </script>
  @endsection
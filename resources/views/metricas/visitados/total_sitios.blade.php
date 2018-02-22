@extends('metricas.menu-2.menu2')
@section('titulo','Visitas a secciones')
@section('titulo_seccion','Total de sitios')
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
	                        <select style="width:350px;" data-placeholder="Elegir un recinto" class="form-control"  tabindex="2" id="recinto" v-model="lab" v-on:change="getYears"> 
	                            <option disabled value="" selected>--Laboratorios--</option>                        
	                            <option v-for="laboratorio in laboratorios" v-bind:value="laboratorio.id">@{{laboratorio.laboratorio}}</option>
	                        </select>
	                    </div>
	                </div>
	                <!-- Seleccion del año -->
	                <div  v-if="years.length == 0 && verYear" class="col-md-4">
	                  <img src="{{url('/')}}/images/ajax-loader.gif" alt="">
	                </div>	
	                <div class="form-group col-md-4">
	                	<div class="form-group" v-if="years.length !=0 || !verYear" >
	                    	<label class="font-noraml">Selecciona un Año:</label>	                    
	                        <select style="width:350px;" data-placeholder="Elegir un año" class="form-control"  tabindex="2" id="ano" v-model="year" v-on:change="getDominios">
	                            <option disabled value="">--Años--</option>
	                            <option v-for="date in years" v-bind:value="date">@{{date}}</option>
	                        </select>
	                    </div>
	                </div>  
              	</div>
                <div class="clearfix"></div>
                <hr>
        	</div>
        	<div class="col-lg-12">
        		<div id="barchart" style="width: 100%; height: 700px;" ></div>
        	</div>           	                     
	  	</div>
  	</div>
  @endsection
  @section('script')
    <script src="{{url('/')}}/js/vue.js"></script>
    <script>
      $('#sites').addClass('in');
      $('.pure-menu-item span').eq(0).addClass('rotate-arrow');
      $('.lista-menu li a').eq(0).addClass('activo');
      cargar();
      var app = new Vue({
        el : '#visitados',
        data : {verLab:false,verYear:false,year:'',region:'',lab:'',laboratorios:[],years:[],dominios:[]},
        methods : {
          getLaboratorios : function(){
          	app.year = '';
          	app.years = [];
          	app.dominios = [];
          	cargar();
            if(!this.ververLab){
              this.verLab = true;
            }
            this.lab = '';
            app.laboratorios = [];
            $.get("{{url('/')}}/getlaboratorios",{region:this.region}, function(data, status){
              app.laboratorios = data;
            });
          },
          getYears : function(){
          	app.dominios = [];
          	cargar();
          	this.year = '';
          	if(!this.verYear){
          		this.verYear = true;
          	}
          	$.get("{{url('/')}}/years",{lab:this.lab}, function(data, status){
              app.years = data;
              app.verYear = false;
            });
          },
          getDominios : function(){
          	$.get("{{url('/')}}/dominios",{lab:this.lab,year:this.year}, function(data, status){
              app.dominios = data;
              cargar();
            });
          }
        }
      })      
    
    function cargar(){  
      google.charts.load('current', {'packages': ['corechart']});       
        google.charts.setOnLoadCallback(drawChart);
        function drawChart(data) {
	        var dataTable = new google.visualization.DataTable();
            dataTable.addColumn('string', 'Dominio');
            dataTable.addColumn('number', 'Visitas');
            var i = 0;
            $.each( app.dominios, function( key, value ) {
            	++i;
              dataTable.addRow([value.dominio,value.visitas]);
              if(i==20){return false;} 
            });
	        if(app.dominios.length == 0){
	        	dataTable.addRow(['Sin Datos',0]);
	        }
	        var chart = new google.visualization.BarChart(document.getElementById('barchart'));
	        chart.draw(dataTable,{title:'Ranking de sitios más visitados'});           
        }
    }
    </script>
  @endsection
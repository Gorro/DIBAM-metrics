@extends('metricas.menu-2.menu2')
@section('titulo','Sessiones por recinto')
@section('titulo_seccion','Sesiones por recinto')
@section('center') 
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
<!-- Eleccion de mes-->
<div class="form-group col-lg-12">
   <div class="col-lg-4">
      <label class="font-noraml">Filtra por año</label>
      <select data-placeholder="Selecciona un año" class="form-control" style="width: 350px;" tabindex="2" id="select-anio">
         <option value="" selected="" >Seleccione el año...</option>
         @foreach ($anios as $anio)
         <option value="{{$anio->year}}">{{$anio->year}}</option>
         @endforeach 
      </select>
   </div>
   <div class="col-lg-4 ">
      <label class="font-noraml">Filtra por región</label>
      <select data-placeholder="Elige una región" class="form-control" style="width:350px;" tabindex="2" id="select-region">
         <option value="0">Seleccione la región...</option>
         @foreach ($regiones as $reg)
         <option value="{{$reg->region}}">{{$reg->region}}</option>
         @endforeach 
      </select>
   </div>
   <div class="col-lg-4">
      <label class="font-noraml">Filtra por recinto</label>
      <select data-placeholder="Elige un recinto" class="form-control" style="width:350px;" tabindex="2" id="select-recinto">
         <option value='0'>Seleccione el recinto...</option>
         @foreach ($recintos as $rec)
         <option value="{{$rec->id}}">{{$rec->laboratorio}}</option>
         @endforeach 
      </select>
   </div>
   <div class="clearfix"></div>
   <hr>
</div>
<div id="charts" class="form-group col-lg-12">
<div class="col-lg-6" style="top: -30px;">
   <div id="piechart" style="width: 100%; height: 500px; "></div>
</div>
<div class="col-lg-6" style="top: -30px; left:-100px">
   <div id="donutchart" style="width: 100%; height: 500px;"></div>
</div>
<!--*******************************************************-->
<div class="col-lg-12" style="top: -100px" >
   <div id="barchart"  style="width: 100%; " ></div>
</div>
<div class="col-lg-12">
   <div id="chart_div"  style="width: 100%; "></div>
</div>
<div>
</div>
@endsection
@section('script')
<script type="text/javascript">
   $('#sessions').addClass('activo');
   
   
   google.charts.load('current', {'packages':['corechart','bar','line']});
   var data_recintos={!! $conteo_recintos !!};
   
   google.charts.setOnLoadCallback(drawPieChart);
   google.charts.setOnLoadCallback(drawDonutChart);
   /** PIE CHART **/
   function drawPieChart(json_data=null) {
              data_recintos= json_data!=null ? json_data: data_recintos;
   var dataTable = new google.visualization.DataTable();
      dataTable.addColumn('string', 'Leyenda');
      dataTable.addColumn('number', 'Cantidad');
      $.each( data_recintos, function( key, value ) {
           dataTable.addRow([data_recintos[key].laboratorio,parseInt(data_recintos[key].cantidad)]); 
           
       });
   
   var options = {
     //  title: 'Sesiones de la Región Metropolitana'
          title: 'Total de sesiones por región seleccionada',
        position: 'top'
   
   };
   
   var chart = new google.visualization.PieChart(document.getElementById('piechart'));
   
    if (dataTable.getNumberOfRows() == 0) { // if you have no data, add a data point and make the series transparent
        dataTable.addRow(["No hay datos", 1])
        chart.draw(dataTable, {colors: ['#5574A6']});
        }
    else
     {
                   
       chart.draw(dataTable, options);
     }
     
   }
   
   
   /** DONUT CHART **/
       
         function drawDonutChart() {
         //  var data = google.visualization.arrayToDataTable([
          //   ["Regiones", "Total sessiones"],
   
   conteo_regiones=  {!! $conteo_regiones !!};
   var data = new google.visualization.DataTable();
      data.addColumn('string', 'Región');
      data.addColumn('number', 'Cantidad');
      $.each( conteo_regiones, function( key, value ) {
           data.addRow([conteo_regiones[key].region,parseInt(conteo_regiones[key].cantidad)]); 
           
       });
   
   //   ]);
   
          var options = {
             
               title:'Total de sesiones por región',
               position: 'top',
   
             
               pieHole: 0.4,
               pieSliceTextStyle: {
                   color: '5574a6',
               },
              
           };
   
           var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
           chart.draw(data, options);
         }
   
   
   /** BAR CHART **/
   
   function getMonthName(num)
   {
       switch(num)
       {
           case 1: return "Enero"; break;
           case 2: return "Febrero"; break;
           case 3: return "Marzo"; break;
           case 4: return "Abril"; break;
           case 5: return "Mayo"; break;
           case 6: return "Junio"; break;
           case 7: return "Julio"; break;
           case 8: return "Agosto"; break;
           case 9: return "Septiembre"; break;
           case 10: return "Octubre"; break;
           case 11: return "Noviembre"; break;
           case 12: return "Diciembre"; break;
           default : return ""; break;
   
       }
   
   }
   
   function drawBarChart(json_data=null) {
     var options = {
     chart: {
     title: 'Cantidad de sesiónes por mes',
     position: 'top'
   
   },
     width: 800,
     legend: { position: 'left' },
     colors: ['#8642c0'],          
     axes: {  x: { 0: { side: 'top'} } },
     bar: { groupWidth: "50%" }
   };
   
        //json_data= json_data!=null ? json_data: data_recintos;
   var dataTable = new google.visualization.DataTable();
      dataTable.addColumn('string', 'Mes');
      dataTable.addColumn('number', 'Cantidad de sesiones');
      $.each( json_data, function( i, v ) {
           dataTable.addRow([getMonthName(parseInt(json_data[i].mes)),parseInt(json_data[i].cantidad)]); 
       });
   
   
   
   
   var chart = new google.charts.Bar(document.getElementById('barchart'));
   
   if (dataTable.getNumberOfRows() == 0) { // if you have no data, add a data point and make the series transparent
        dataTable.addRow(["No hay datos", 1])
        options.series = {
           0:  {
                   color: '#5574a6'
               }}
       }
   
        chart.draw(dataTable, options);
   } 
   /**********************************/
   
   // google.charts.setOnLoadCallback(drawChartTIME);
   function drawChartDuration(json_data) {
   
   
    $("#chart_div").html("");
   
   var data_sesion= json_data;
    if(data_sesion.length>0)
       {
   
   
   var chartDiv = document.getElementById('chart_div');
   var materialOptions = {
       chart: {
         title: 'Duración media de la sesión por mes',
          position: 'top'
       },
       position: 'top',
       width: 900,
       height: 500,
   };
   
   var dataTable = new google.visualization.DataTable();
       dataTable.addColumn('string', 'Mes');
       dataTable.addColumn('timeofday', "Duración media de la sesión");
       dataTable.addColumn('timeofday', "Duración maxima de la sesión");
       dataTable.addColumn('timeofday', "Duración mínima de la sesión");
     
      $.each( data_sesion, function( i, v ) {
       
          var h_med=parseInt(data_sesion[i].media.substr(0,2));
          var m_med=parseInt(data_sesion[i].media.substr(3,2));
          var s_med=parseInt(data_sesion[i].media.substr(6,2));
          
          var h_min=parseInt(data_sesion[i].minimo.substr(0,2));
          var m_min=parseInt(data_sesion[i].minimo.substr(3,2));
          var s_min=parseInt(data_sesion[i].minimo.substr(6,2));
          
          var h_max=parseInt(data_sesion[i].maximo.substr(0,2));
          var m_max=parseInt(data_sesion[i].maximo.substr(3,2));
          var s_max=parseInt(data_sesion[i].maximo.substr(6,2));
   
          dataTable.addRow([getMonthName(parseInt(json_data[i].mes)),[3+h_med, m_med, s_med],[3+h_max,m_max, s_max],[3+h_min ,m_min, s_min],]); 
          
       });
          
          var materialChart = new google.charts.Line(chartDiv);
          materialChart.draw(dataTable, materialOptions);
      }
     
   }
   
   function filtroAnioRecinto()
   {
       var recinto= $("#select-recinto").val()==null? "": $("#select-recinto").val();
       var fecha= $("#select-anio").val();
   
       if(recinto!=""  && fecha!="")
       {
           console.log("SELECT: "+recinto);
           console.log("Fecha: "+fecha);
   
           $.get("{{url('/')}}/sesiones/"+recinto+"/"+fecha,function(r,state)
           {
                   drawBarChart(r.conteo_mensual);
                   drawChartDuration(r.conteo_mensual)
           });
       }
   
   
    
   }
   
   
   
   
   /*============ SELECT DINAMICOS =============**/
   $("#select-region").change(function(event){
   var region= event.target.value;
   $.get("{{url('/')}}/sesiones/"+region,function(r,state)
   {
   drawPieChart(r.conteo_recintos);
   $("#select-recinto").empty();
   $("#select-recinto").append("<option value='0'>Seleccione el recinto...</option>");
   $.each( r.recintos, function(i, v) {
   
   
      $("#select-recinto").append("<option value='"+r.recintos[i].id+"'>"+r.recintos[i].laboratorio+"</option>");
   });
   
   });
   })
   
   
   $("#select-recinto").change(function(event){
   filtroAnioRecinto();
   })
   $("#select-anio").change(function(event){
   filtroAnioRecinto();
   })
   
   
</script>
@endsection
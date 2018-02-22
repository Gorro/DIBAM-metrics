@extends ('metricas.index')
@section('script')

   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">


     
   

      google.charts.load('current', {'packages':['corechart']});

        /** PIE CHART **/
      google.charts.setOnLoadCallback(drawPieChart);

      function drawPieChart() {

        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            ['Colina I', 11],
            ['Colina II', 4],
            ['Recinto III ', 2],
            ['Recinto IV', 5],
            ['Recinto V',2]
        ]);

        var options = {
          title: 'Sesiones de la Región Metropolitana'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
      /** DONUT CHART **/
      google.charts.setOnLoadCallback(drawDonutChart);
      function drawDonutChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
            ['Recinto I', 3],
            ['Recinto II', 5],
            ['Recinto III ', 11],
            ['Recinto III ', 5],
            ['Recinto IV', 6],
            ['Recinto V',7],
            ['Colina I', 9],
            ['Colina II', 4],
            ['Recinto III ', 9],
            ['Recinto IV', 5],
            ['Recinto V',2]
        ]);

       var options = {
                    pieHole: 0.5,
                    pieSliceTextStyle: {
                        color: 'black',
                    },
                    legend: 'none'
                };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
/*
$("#select-region").change(function(event){
  console.log("target: "+event.target);
  $.get("regiones/28",function(response,state)
  {
    console.log(response);
  });
})
*/

    </script>
 @endsection
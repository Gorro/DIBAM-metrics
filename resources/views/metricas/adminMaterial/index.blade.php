<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>DIBAM</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('mdb/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="{{ asset('mdb/css/mdb.min.css') }}" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="{{ asset('css/mdb-style-admin.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('mdb/css/style.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/datepicker.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>

    <style>
        body{
            background-color: white !important;
        }
        #inicio, #termino{
            height: 2.35rem !important;
        }
        .accordion.accordion-1 p {
            font-size: 1rem; }

        .accordion.accordion-1 .card {
            border: 0; }
        .accordion.accordion-1 .card .card-header {
            border: 0; }
        .accordion.accordion-1 .card .card-body {
            line-height: 1.4; }
        .pagination .page-link:focus {
            background-color: #007bff;
        }
        .dataTables_filter {
            text-align: left !important;
        }
        table{
            z-index: -1;
        }
        .detras{
            position: initial;
        }
        #load{
            position: absolute;
            width: 100vw;
            height: auto;
            background-color: grey;
            opacity: 0.5;
            z-index: 1000;
        }
        #accordion{
            width: 100%;
        }
        .sorting_asc{
            z-index: -1;
        }
    </style>

</head>

<body>
<div id="load" class="row h-100 justify-content-center align-items-center"><img src="images/ajax-loader2.gif" alt=""></div>
<!-- Start your project here-->
<div class="container">
    <div class="row">
        <div class="">
            <img src="images/biblioredes.jpg" width="200" id="img" >
        </div>
    </div>
    <div id="index" class="row align-items-center" style="height: 85vh;">
        <div class="col animated fadeIn">
                <div class="card testimonial-card hoverable">
                    <!--Bacground color-->
                    <div class="card-up indigo lighten-1 z-depth-3">
                    </div>
                    <!--Avatar-->
                    <div class="avatar z-depth-3">
                        <img src="images/statistics.png" alt="">
                    </div>
                    <div class="card-body">
                        <!--Name-->
                        <h4 class="card-title">{{$capacitados}}</h4>
                        <h4>Usuarios Certificados</h4>
                        <hr>
                        <!--Quotation-->
                        <div class="text-center"><button type="button" class="btn btn-primary" onclick="ver(1)">Ver</button></div>
                    </div>
                </div>
                <!--/.Card-->
            </div>
        <div class="col animated fadeIn">
                <div class="card testimonial-card hoverable">
                    <!--Bacground color-->
                    <div class="card-up indigo lighten-1 z-depth-3">
                    </div>
                    <!--Avatar-->
                    <div class="avatar z-depth-3">
                        <img src="images/growth.png" alt="">
                    </div>
                    <div class="card-body">
                        <!--Name-->
                        <h4 class="card-title">{{$cantidadSesiones}}</h4>
                        <h4>Sesiones de usuarios</h4>
                        <hr>
                        <!--Quotation-->
                        <div class="text-center"><button type="button" class="btn btn-primary" onclick="ver(2)">Ver</button></div>
                    </div>
                </div>
                <!--/.Card-->
            </div>
        <div class="col animated fadeIn">
                <div class="card testimonial-card hoverable">
                    <!--Bacground color-->
                    <div class="card-up indigo lighten-1 z-depth-3">
                    </div>
                    <!--Avatar-->
                    <div class="avatar z-depth-3">
                        <img src="images/student.png" alt="">
                    </div>
                    <div class="card-body">
                        <!--Name-->
                        <h4 class="card-title">{{ $totalUsuarios }}</h4>
                        <h4>Usuarios Registrados</h4>
                        <hr>
                        <!--Quotation-->
                        <div class="text-center"><button type="button" class="btn btn-primary" onclick="ver(3)">Ver</button></div>
                    </div>
                </div>
                <!--/.Card-->
            </div>
    </div>
</div>
<!-- /Start your project here-->
<div id="formAjax" class="container">
    <div id="form" class="row"></div>
</div>


<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="{{ asset('mdb/js/jquery-3.2.1.min.js') }}"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="{{ asset('mdb/js/popper.min.js')}}"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="{{ asset('mdb/js/bootstrap.min.js')}}"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="{{ asset('mdb/js/mdb.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-datepicker.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/locales/bootstrap-datepicker.es.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('js/datatable.options.js') }}" charset="UTF-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>

<!-- MDB DataTables -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>


<script>
    load = $('#load');
    load.hide();
    var dataTable = '';

    var ver = function($tipo){
        load.show();
        $('#index').addClass('animated fadeOut');
        setTimeout(
            function(){
                $('#index').hide();
                $.ajax({
                    url:"{{url('/form')}}",
                    type: 'GET',
                    data : {seleccion : $tipo},
                    success: function (view) {
                        load.hide();
                        $('#formAjax').css('margin-top','5vh')
                        $('#form').html(view);
                        $('#selecciona').val($('#seleccion').val());
                        $('select').addClass('mdb-select');
                        $('.mdb-select').material_select();
                        dataTable = $('#example').DataTable(optionsDataTable);
                        $('.dataTables_wrapper').find('label').each(function() {
                            $(this).parent().append($(this).children());
                        });
                        $('.datepicker').datepicker({
                            language:'es',
                            autoclose:true,
                            format: 'dd/mm/yyyy'
                        }).on('changeDate', function(ev){
                            moment.locale('es');
                            var startDate = moment( $('#startDate').val(), 'DD/MM/YYYY' ).toDate();
                            if (ev.date.valueOf() < startDate.valueOf()){
                                $('#endDate').val('');
                            }
                        });
                        $('#search').submit(function(e){
                            e.preventDefault();
                            getSearch($(this));
                        });

                        exportExcel($('#search'));
                        formFunctions();
                    },
                    error: function (data) {
                        //
                    }
                });
            }, 1000);
    }

    var getLabs = function($region){
        $('html, body').css({
            overflow: 'hidden',
            height: '100%'
        });
        load.show();
        recintos = $('#recintos');
        $.ajax({
            type:'GET',
            data : {region:$region},
            url: "{{url('/getLabs')}}",
            success: function(result){
                load.hide();
                $('html, body').css({
                    overflow: '',
                    height: ''
                });
                recintos.material_select("destroy");
                recintos.find('option').remove();
                recintos.append('<option value="" disabled selected>Recintos</option>');
                $.each(result, function (i, item) {
                    $('#recintos').append($('<option>', {
                        value: item.id,
                        text : item.laboratorio
                    }));
                });
                $("#recintos").material_select();
            }
        })
    }

    var getSearch = function($form){
        if($('#startDate').val() != '' && $('#endDate').val() == ''){
            toastr.error('Debe seleccionar la fecha de termino');
            return false;
        }
        load.show();
        dataTable.destroy();
        $('#table_search').html('');
        $.ajax({
            url:"{{url('/getUsers')}}",
            type: 'GET',
            data : $form.serialize(),
            success: function (view) {
                $('#table_search').html(view);
                load.hide();
                dataTable = $('#example').DataTable(optionsDataTable);
                exportExcel($form);
            }
        });
    }

    var exportExcel = function($form){
        var url = "{{url('/eportexcel')}}?"+$form.serialize();
        $('#excel').attr('href',url);
        $('#excel').trigger('click');
    }

    var formFunctions = function(){
        $('#selecciona').change(function(){
           if($(this).val() == 3){
               $('#startDate, #endDate').addClass('d-none').val('');
           } else {
               $('#startDate, #endDate').removeClass('d-none');
           }
        });
    }
</script>
</body>

</html>

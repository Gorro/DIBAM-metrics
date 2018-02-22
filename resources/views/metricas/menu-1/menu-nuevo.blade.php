<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Simple Sidebar - Start Bootstrap Template</title>
    
    <!-- Bootstrap Core CSS -->
    <link href="{{url('/')}}/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{url('/')}}/css/simple-sidebar.css" rel="stylesheet">

    <!-- font-awesome CSS -->
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    
</head>

<body>
    <div id="wrapper" class="toggled">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" >
            <ul class="sidebar-nav">
                <li class="sidebar-brand hidden-xs">
                    <p style="color:white;">
                        Estadisticas online
                    </p>
                </li>
                <li>
                    <a href="#" aria-controls="sessions" aria-expanded="true" data-target="#sessions" data-toggle="collapse"><i class="fa fa-edit"></i> <span class="hidden-xs hidden-sm">Sesiones</span> <span class="glyphicon glyphicon-menu-down hidden-xs"></span></a>
                    <ul style="color:white;" class="collapse lista-menu hidden-xs hidden-sm" id="sessions" aria-expanded="false">
                        <li><a href="recinto">Recinto</a></li>
                        <li><a href="recinto">Fecha</a></li>
                        <li>Duración</li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-files-o"></i><span class="hidden-xs hidden-sm"><span class="hidden-xs hidden-sm">Visitas a secciones</span></span> </a>
                </li>
                <li>
                    <a href="#" aria-controls="sites" aria-expanded="true" data-target="#sites" data-toggle="collapse"><i class="fa fa-bar-chart-o"></i> <span class="hidden-xs hidden-sm">Sitios más visitados</span><span class="glyphicon glyphicon-menu-down"></span></a>
                    <ul style="color:white;" class="collapse lista-menu hidden-xs hidden-sm" id="sites" aria-expanded="false">
                        <li >Total de sitios</li>
                        <li >Por sitio</li>
                    </ul>
                </li>
                <li>
                    <a href="#" aria-controls="courses" aria-expanded="true" data-target="#courses" data-toggle="collapse"><i class="fa fa-sitemap"></i> <span class="hidden-xs hidden-sm">Avance Cursos</span><span class="glyphicon glyphicon-menu-down"></span></a>
                    <ul style="color:white;" class="collapse lista-menu hidden-xs hidden-sm" id="courses" aria-expanded="false">
                        <li >Avance por Recinto</li>
                        <li >Avance por Alumno</li>
                    </ul>
                </li>
                <li class="dropdown"> 
                    <a href="#" class="dropdown-toggle hidden-xs" id="drop1" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> 
                        Dropdown <span class="caret"></span>
                    </a> 
                    <ul class="dropdown-menu" aria-labelledby="drop1" style="z-index:10000;"> 
                        <li><a href="#">Action</a></li> 
                        <li><a href="#">Another action</a></li> 
                        <li><a href="#">Something else here</a></li> 
                        <li role="separator" class="divider"></li> 
                        <li><a href="#">Separated link</a></li> 
                    </ul> 
                </li>                
            </ul>
        </div>
        <!-- menu XS -->
        
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" >
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">
                            <img src="{{url('/')}}/images/menu.png" alt="">
                        </a>                        
                    </div>
                    <div id="page-wrapper" class="gray-bg">
                        @include('metricas.header')
                        @yield('center','hola mundo mundial')
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{url('/')}}/js/bootstrap.min.js"></script>
   
    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
    @yield('script')

</body>

</html>

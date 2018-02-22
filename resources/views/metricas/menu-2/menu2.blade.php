<!doctype html>
<html lang="ES">
<head>
   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A layout example with a side menu that hides on mobile, just like the Pure website.">
    <title>@yield('titulo','Métricas')</title>
    
    <link rel="stylesheet" href="{{url('/')}}/css/pure-min.css">
    <!-- Bootstrap Core CSS -->
    <link href="{{url('/')}}/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animate CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!--[if lte IE 8]>
        <link rel="stylesheet" href="css/layouts/side-menu-old-ie.css">
    <![endif]-->
    <!--[if gt IE 8]>
        <link rel="stylesheet" href="{{url('/')}}/css/side-menu.css">
    <![endif]-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>






<div id="layout">
    <!-- Menu toggle -->
    <a href="#menu" id="menuLink" class="menu-link">
        <!-- Hamburger icon -->
        <span>
            <img src="{{url('/')}}/images/cuadrado100.png" width="36" >
        </span>
    </a>

    <div id="menu">
        <div class="pure-menu">
            <a class="pure-menu-heading" href="{{url('/')}}">Estadisticas online</a>

            <ul class="pure-menu-list">
                  <li class="pure-menu-item"><a href="{{url('sesiones')}}" class="pure-menu-link" id="sessions"><i class="fa fa-files-o"></i> Sesiones</a></li>

                <li class="pure-menu-item"><a href="{{url('secciones')}}" class="pure-menu-link" id="visitas"><i class="fa fa-files-o"></i> Visitas a secciones</a></li>

                <li class="pure-menu-item">
                    <a href="#" class="pure-menu-link" aria-controls="sites" aria-expanded="true" data-target="#sites" data-toggle="collapse"><i class="fa fa-bar-chart-o"></i> Sitios más visitados <span class="glyphicon glyphicon-menu-down pull-right"></span></a>
                    <ul class="collapse pure-menu-list lista-menu" aria-expanded="false" id="sites" aria-expanded="false">
                        <li class="pure-menu-item"><a class="pure-menu-link" href="{{url('visitados')}}">Total de sitios</a></li>
                        <li class="pure-menu-item"><a class="pure-menu-link" href="{{url('dominio')}}">Por sitio</a></li>
                    </ul>
                </li>
                <li class="pure-menu-item">
                    <a href="#" class="pure-menu-link" aria-controls="courses" aria-expanded="true" data-target="#courses" data-toggle="collapse"><i class="fa fa-sitemap"></i> Avance Cursos<span class="glyphicon glyphicon-menu-down pull-right"></span></a>
                    <ul style="color:white;" class="collapse lista-menu hidden-xs hidden-sm" id="courses" aria-expanded="false">
                        <li class="pure-menu-item"><a class="pure-menu-link" href="{{url('avance')}}">Avance por Recinto</a></li>
                        <li class="pure-menu-item"><a class="pure-menu-link" href="{{url('avance-alumno')}}">Avance por Alumno</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div id="main">
        <div class="content">
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-12">
                    <h2>@yield('titulo_seccion','')</h2>
                    <hr>
                    
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            @yield('center','hola mundo mundial')
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{url('/')}}/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/js/ui.js"></script>
    @yield('script')
<script>
    $('.pure-menu-item').on('click',function(){
        console.log('click');
        if($(this).find('span').hasClass('rotate-arrow')){
            $(this).find('span').eq(0).removeClass('rotate-arrow');
        }else{            
            $(this).find('span').eq(0).addClass('rotate-arrow');
        }
    });
</script>
</body>
</html>

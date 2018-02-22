<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadisticas Online</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{url('/')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{url('/')}}/css/animate.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Hind" rel="stylesheet">
    <style>
        #green{
            background-color: rgb(26, 188, 156);
        }
        #yellow{
            background-color: #f1c40f;
        }
        #orange{
            background-color: rgb(230, 126, 34);
        }
        #purple{
            background-color: rgb(155, 89, 182);
        }
        .default{
            color: white;
            padding: 30px 0px;
            margin: 10px;
            cursor: pointer;
            float: left;
            -webkit-transition: all 2s; /* Safari */
            transition: all .5s;
            
        }
        .max1{                        
            width: 60%;
        }
        .max2{                        
            width: 30%;
        }
        .default:hover{
        }
        .centrar{
            padding: 10%;
        }
        .arriba{
        }
        #img{
            position: absolute;
        }
        h2{
            margin-bottom: 40px;
            padding-top: 30px;
            color: white;
        }
        body{
            font-family: 'Hind', sans-serif;
            background-image: url('http://portalbiblioredes.cl/wp-content/uploads/2017/01/foto_fondo_login.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        a:hover{
            text-decoration: none;
        }
        header{
            
        }

    </style>
</head>
<body>     
<div class="container" id="app">
    <header>      
        <img src="images/biblioredes.jpg" width="200" id="img"> 
        <h2 class="text-center">Estadisticas Online</h2>
    </header>
    <section>
        <div class="row">
            <div class="col-md-12 arriba">
             <a href="sesiones">
                <div class="">
                    <div id="green" class="default max1">
                        <h4 class="text-center">SESIONES</h4>
                        <center><img src="images/student.png" alt=""></center>
                    </div>
                </div>
                </a>
                <div class="">
                    <a href="secciones">
                        <div id="yellow" class="default max2">
                            <h4 class="text-center">VISITA A SECCIONES</h4>
                            <center><img src="images/user.png" alt=""></center>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 arriba">
                <div class="">
                    <a href="visitados">
                        <div id="orange" class="default max2">
                            <h4 class="text-center">SITIOS MÁS VISITADOS</h4>
                            <center><img src="images/analytics.png" alt=""></center>
                        </div>
                    </a>
                </div>                    
                <div class="">
                    <a href="avance">
                        <div id="purple" class="default max1">
                            <h4 class="text-center">AVANCE DE CURSOS</h4>
                            <center><img src="images/statistics.png" alt=""></center>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>

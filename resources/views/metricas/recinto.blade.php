 @extends('metricas.menu-2.menu2')
 @section('center')
 <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-6">
                        <h3>Sesiones de recintos por Región:</h3>
                        <div id="donutchart" style="width: 100%; height: 500px;"></div>
                    </div>
                    <div class="col-lg-6">
                        <h3>Sesiones de recintos Región Metropolitana</h3>
                        <div id="piechart" style="width: 100%; height: 350px; margin-bottom: 27px;"></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ibox-content">
                            <p>
                                Selecciona una Región para ver las sesiones de sus recintos:
                            </p>
                        <div class="form-group">
                            <!--<label class="font-noraml">Secciones</label>-->
                            <div class="input-group ">
                                <select data-placeholder="Elige una sección" class="chosen-select" style="width:350px;" tabindex="2" id="select-region">
                                    @foreach ($laboratorios as $lab)
                                       <option>{{$lab->region}}</option>
                                     @endforeach 
                                </select>
                            </div>
                        </div>
                   </div>
             </div>
        </div>
  </div>
  @endsection
  @section('script')
  <script>
    $('#sessions').addClass('in');
    $('.lista-menu li a').eq(0).addClass('activo');
    $('.pure-menu-item span').eq(0).addClass('rotate-arrow');
  </script>
  </script>
  @endsection
var app = {
    //variables
    dataChart : '',
    dataTable : '',
    urlVer: '',
    urLabs : '',
    urlUsers : '',
    urlExcel : '',
    myPieChart :'',
    //funciones
    init : function(){
        load = $('#load');
        load.hide();
    },
    ver : function($tipo){
        load.show();
        $('#index').addClass('animated fadeOut');
        setTimeout(
            function(){
                $('#index').hide();
                $.ajax({
                    url: app.urlVer,
                    type: 'GET',
                    data : {seleccion : $tipo},
                    success: function (view) {
                        load.hide();
                        $('#formAjax').css('margin-top','5vh')
                        $('#form').html(view);
                        $('#selecciona').val($('#seleccion').val());
                        $('select').addClass('mdb-select');
                        $('.mdb-select').material_select();

                        app.dataTable = $('#example').DataTable(optionsDataTable);

                        $('.dataTables_wrapper').find('label').each(function() {
                            $(this).parent().append($(this).children());
                        });

                        app.loadDatePicker();

                        $('#search').submit(function(e){
                            e.preventDefault();
                            app.getSearch($(this));
                        });

                        app.exportExcel($('#search'));
                        app.formFunctions();
                        if(app.dataChart != ''){
                            app.charts();
                        }
                    },
                    error: function (data) {
                        //
                    }
                });
            }, 1000);
    },
    getLabs : function($region){
        $('html, body').css({
            overflow: 'hidden',
            height: '100%'
        });
        load.show();
        recintos = $('#recintos');
        $.ajax({
            type:'GET',
            data : {region:$region},
            url: app.urLabs,
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
    },
    getSearch : function($form){
        if($('#startDate').val() != '' && $('#endDate').val() == ''){
            toastr.error('Debe seleccionar la fecha de termino');
            return false;
        } else if($('#startDate').val() == '' && $('#endDate').val() != ''){
            toastr.error('Debe seleccionar la fecha de inicio');
            return false;
        }
        load.show();
        app.myPieChart.destroy();
        app.dataTable.destroy();
        $('#table_search').html('');
        $.ajax({
            url: app.urlUsers,
            type: 'GET',
            data : $form.serialize(),
            success: function (data) {
                $('#table_search').html(data.view);
                load.hide();
                app.dataChart = JSON.parse(data.chart);
                app.dataTable = $('#example').DataTable(optionsDataTable);
                app.exportExcel($form);
                if(app.dataChart != ''){
                    app.charts();
                }
            }
        });
    },
    exportExcel : function($form){
        var url = app.urlExcel+$form.serialize();
        $('#excel').attr('href',url);
        $('#excel').trigger('click');
    },
    formFunctions : function(){
        $('#selecciona').change(function(){
            if($(this).val() == 3){
                $('#startDate, #endDate').addClass('d-none').val('');
                $('#ano').val(0).material_select('destroy');
            } else if($('#ano').val() == 0){
                $('#startDate, #endDate').removeClass('d-none');
                $('#ano').material_select();
            }
        });
        $('#ano').change(function(){
            if($(this).val() != 0){
                $('#startDate, #endDate').addClass('d-none').val('');
            } else {
                $('#startDate, #endDate').removeClass('d-none');
            }
        });
    },
    loadDatePicker: function(){
        var startDate = new Date();
        var fechaFin = new Date();
        var FromEndDate = new Date();
        var ToEndDate = new Date();




        $('.from').datepicker({
            language:'es',
            autoclose: true,
            minViewMode: 1,
            format: 'mm/yyyy',
            weekStart: 1
        }).on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
            $('.to').datepicker('setStartDate', startDate);
        });

        $('.to').datepicker({
            language:'es',
            autoclose: true,
            minViewMode: 1,
            format: 'mm/yyyy',
            weekStart: 1
        }).on('changeDate', function(selected){
            FromEndDate = new Date(selected.date.valueOf());
            FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
            $('.from').datepicker('setEndDate', FromEndDate);
        });
    },
    charts : function(){
        var $data = [];
        var $labels = [];
        var $colors = [];
        var ctx = $("#piechart");

        var $options = {
            legend: {
                display: true,
                position : 'right'
            },
            title : {
                display : false
            }
        }

        $.each( app.dataChart, function( key, value ) {
            if(value > 0){
                $data.push(parseInt(value));
                $labels.push(key);
                $colors.push(app.dynamicColors());
            }
        });

        data = {
            datasets:[{
                "label":"grafic",
                "data":$data,
                "backgroundColor": $colors
            }
            ],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: $labels
        };

        app.myPieChart = new Chart(ctx,{
            type: 'pie',
            data: data,
            options : $options
        });

    },
    dynamicColors :function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    }
}
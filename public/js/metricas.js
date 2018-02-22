$( document ).ready(function() {
	$.ajax({
        url: 'http://bibliotecasencarceles.biblioredes.cl/wp-content/themes/edition/session2.php?callback=?',
        dataType: "jsonp",        
        type: 'GET',
        success: function(response){
            if (response.id != 1) {
                window.location.href = "http://bibliotecasencarceles.biblioredes.cl"
            }else{
                recinto = response.recinto;                
                $('.container-fluid').removeClass('hidden');
                $('#fountainG').addClass('hidden');
            }
        },
        error: function(xhr,status,error){
            alert(error,' ',status);
        }
    });
});
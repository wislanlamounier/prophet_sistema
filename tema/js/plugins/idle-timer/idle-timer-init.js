$(function() {
    // Set idle time
    $( document ).idleTimer( 600000 ); // 10 minutos
});

$(function() {
    $( document ).on( "idle.idleTimer", function(event, elem, obj){
        $.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "main", acao : "mainIdle"}
	    }).done(function(resultado){

	    });
    });

    $( document ).on( "active.idleTimer", function(event, elem, obj, triggerevent){
    	html = '<b>Por favor, entre com a sua senha novamente.</b><br><input type="password" id="senha">';
        swal({
	        title: 'Você ficou fora muito tempo!',
	        html: html,
	        showCancelButton: false,
	        confirmButtonText: "Entrar",
	        closeOnConfirm: true,
        }, function(isConfirm){
        	senha = $('#senha').val();
            $.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "main", acao : "mainLoginIdle", param : senha}
		    }).done(function(resultado){
		    	if(resultado == 1){
		    		swal('Sucesso!', 'Login realizado novamente!', 'success');
		    	}else{
		    		$(location).attr('href', '/usuario/sairIdle');
		    	}
		    });
        });
    });

});
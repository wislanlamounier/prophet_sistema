$(function(){

	$('.iptCdnPaciente').on('change', function(){
		mudaPaciente();
	})

	function mudaPaciente(){
		id = $('.iptCdnPaciente').val();

		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "paciente", acao : "pacienteRetornaCaracteristica", param : id, caracteristica : 'codRg'}
	    }).done(function(rg){
	    	$('#iptRg').val(rg);
	    })
	}

})
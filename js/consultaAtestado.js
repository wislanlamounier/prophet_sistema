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

		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "paciente", acao : "pacienteRetornaCaracteristica", param : id, caracteristica : 'nomBairro'}
	    }).done(function(bairro){
	    	val = $('#iptEndereco').val();
	    	if(bairro != '')
	    		$('#iptEndereco').val(val + bairro + ' - ');
	    })

		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "paciente", acao : "pacienteRetornaCaracteristica", param : id, caracteristica : 'strEndereco'}
	    }).done(function(endereco){
	    	val = $('#iptEndereco').val();
	    	$('#iptEndereco').val(val + endereco);
	    })

		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "paciente", acao : "pacienteRetornaCaracteristica", param : id, caracteristica : 'numCasa'}
	    }).done(function(numero){
	    	val = $('#iptEndereco').val();
	    	if(numero != '')
	    		$('#iptEndereco').val(val + ', ' + numero);
	    })

	}

})
$(function(){

	iptDatNascimento = $('input[name=datNascimento]');
	if(typeof iptDatNascimento != 'undefined'){
		verificaResponsavel();
	}



	$('.mask-cpf').each(function(){
		$(this).focusout(function(){
			cpf = $(this).val();
			verificaCpf(cpf, $(this));
		})
	})

	$('.mask-cnpj').each(function(){
		$(this).focusout(function(){
			cnpj = $(this).val();
			verificaCnpj(cnpj, $(this));
		})
	})

	$('.mask-cpfcnpj').each(function(){
		$(this).focusout(function(){
			cpfcnpj = $(this).val();
			verificaCpf(cpfcnpj);
			verificaCnpj(cpfcnpj);
		})
	})

	$('input[name=datNascimento]').focusout(function(){
		date = $(this).val();
		verificaNascimento(date, $(this));
		verificaResponsavel();
	})
})

function verificaResponsavel(){
	data = $('input[name=datNascimento]').val();
	if(data.indexOf('/') > 0){
		data = data.split('/');
		data = data[2] + '-' + data[1] + data[0];
	}

	data = data.split('-');

	diaAniversario = data[2];
	mesAniversario = data[1];
	anoAniversario = data[0];

    var d = new Date;
    anoAtual = d.getFullYear();
    mesAtual = d.getMonth() + 1;
    diaAtual = d.getDate();

    anoAniversario = +anoAniversario;
    mesAniversario = +mesAniversario;
    diaAniversario = +diaAniversario;

    quantosAnos = anoAtual - anoAniversario;

    if (mesAtual < mesAniversario || mesAtual == mesAniversario && diaAtual < diaAniversario) {
        quantosAnos--;
    }

    if(quantosAnos < 18){

		if(typeof iptDatNascimento.attr('disabled') == 'undefined')
			visualizando = ''
		else
			visualizando = 1;
    	if(typeof $('form').attr('id') != 'undefined'){
    		cdnPaciente = $('form').attr('id');
    	}else{
    		cdnPaciente = '';
    	}

    	$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "paciente", acao : "pacienteFormularioRespLegal", param : cdnPaciente, visualizando : visualizando}
    	}).done(function(form){
    		$('#divresplegal').append(form);
    	});

    }else{
    	$('#divresplegal').html(' ');
    }

}

function verificaCpf(cpf, obj){
	cdnPacienteForm = $('form').attr('id');
    $.ajax({
        type: "GET",
        url: "index.php",
        data: { controle : "paciente", acao : "pacienteVerificaCpf", param : cpf, cdnPaciente : cdnPacienteForm}
    }).done(function(resultado){
    	if(resultado != 0){
    		resultado = $.parseJSON(resultado);
    		if(obj.parent().find('div.alert').length == 0)
				obj.parent().append('<div class="alert alert-danger">Paciente já cadastrado com este CPF: </div>');
			divErro = obj.next();

    		for (var i = 0; i < resultado.length; i++) {
    			nomPaciente = resultado[i].nomPaciente;
    			cdnPaciente = resultado[i].cdnPaciente;
    			if (typeof resultado[i].nomSobrenome != 'undefined') {
					nomPaciente = nomPaciente + ' ' + resultado[i].nomSobrenome;
				}

				if(divErro.find('a.linkPaciente').length == 0){
					divErro.append('<a class="linkPaciente" href="/paciente/consultarFim/' + cdnPaciente + '">' + nomPaciente + '</a>');
				}else{
					divErro.find('a.linkPaciente').remove();
					divErro.append('<a class="linkPaciente" href="/paciente/consultarFim/' + cdnPaciente + '">' + nomPaciente + '</a>');
				}

    		};
    	}else{
	    	if(obj.parent().find('div.alert').length != 0){
				obj.parent().find('div.alert').remove();
	    	}
	    }
    });
}

function verificaCnpj(cnpj, obj){
	cdnPacienteForm = $('form').attr('id');
    $.ajax({
        type: "GET",
        url: "index.php",
        data: { controle : "paciente", acao : "pacienteVerificaCnpj", param : cnpj, cdnPaciente : cdnPacienteForm}
    }).done(function(resultado){
    	if(resultado != 0){
    		resultado = $.parseJSON(resultado);
    		if(obj.parent().find('div.alert').length == 0)
				obj.parent().append('<div class="alert alert-danger">Paciente já cadastrado com este CNPJ: </div>');
			divErro = obj.next();

    		for (var i = 0; i < resultado.length; i++) {
    			nomPaciente = resultado[i].nomPaciente;
    			cdnPaciente = resultado[i].cdnPaciente;
    			if (typeof resultado[i].nomSobrenome != 'undefined') {
					nomPaciente = nomPaciente + ' ' + resultado[i].nomSobrenome;
				}

				if(divErro.find('a.linkPaciente').length == 0){
					divErro.append('<a class="linkPaciente" href="/paciente/consultarFim/' + cdnPaciente + '">' + nomPaciente + '</a>');
				}else{
					divErro.find('a.linkPaciente').remove();
					divErro.append('<a class="linkPaciente" href="/paciente/consultarFim/' + cdnPaciente + '">' + nomPaciente + '</a>');
				}

    		};
    	}else{
	    	if(obj.parent().find('div.alert').length != 0){
				obj.parent().find('div.alert').remove();
	    	}
	    }
    });
}

function verificaNascimento(data, obj){
	cdnPacienteForm = $('form').attr('id');
    $.ajax({
        type: "GET",
        url: "index.php",
        data: { controle : "paciente", acao : "pacienteVerificaNascimento", param : data, cdnPaciente : cdnPacienteForm}
    }).done(function(resultado){

    	if(resultado != 0){
    		resultado = $.parseJSON(resultado);
    		if(obj.parent().find('div.alert').length == 0)
				obj.parent().append('<div class="alert alert-danger">Pacientes já cadastrados com esta data: </div>');
			divErro = obj.next();

    		for (var i = 0; i < resultado.length; i++) {
    			nomPaciente = resultado[i].nomPaciente;
    			cdnPaciente = resultado[i].cdnPaciente;
    			if (typeof resultado[i].nomSobrenome != 'undefined') {
					nomPaciente = nomPaciente + ' ' + resultado[i].nomSobrenome;
				}

				divErro.append('<li><a href="/paciente/consultarFim/' + cdnPaciente + '">' + nomPaciente + '</a></li>');

    		};
    	}else{
	    	if(obj.parent().find('div.alert').length != 0){
				obj.parent().find('div.alert').remove();
	    	}
	    }
    });
}
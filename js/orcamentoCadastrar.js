$(function(){


	$('#datOrcamento').datepicker({
		'language' : 'pt-BR',
		'disableTouchKeyboard' : true,
		'todayHighlight' : true,
	}).on('changeDate', function(){
		data = $('#datOrcamento').val();
		data = data.split('/');
		if(data.length > 0){
			mes = data[1];
			if(mes < 12){
				data[1] = Number(data[1]) + 1;
			}else{
				data[1] = 01;
				data[2] = Number(data[2]) + 1;
			}
			if(data[1] == 2 && data[0] > 28)
				data[0] = 27;
			if(data[1] < 10)
				data[1] = '0' + data[1];
		}
		$('#datValidade').val(data.join('/'));
	})

	$('#datValidade').datepicker({
		'language' : 'pt-BR',
		'disableTouchKeyboard' : true,
		'todayHighlight' : true,
	})


	$('#datInicioPagamento').datepicker({
		'language' : 'pt-BR',
		'disableTouchKeyboard' : true,
		'todayHighlight' : true,
	});


	$('#fechaModalPaciente').on('click', function(){

		cdnPaciente = cdnPacienteMODAL;

		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "paciente", acao : "pacienteDependentes", param : cdnPaciente}
	    }).done(function(select){
    		$('#divCdnTitular').html(select);
	    	$('#divCdnTitular').find('select.form-control').select2({
        		language: 'pt-BR'
    		});
	    })

		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "paciente", acao : "pacienteTabelasPreco", param : cdnPaciente}
	    }).done(function(select){
    		$('#tabelapreco').html(select);
	    	$('#tabelapreco').find('select.form-control').select2({
        		language: 'pt-BR'
    		});
            $('#tabelapreco').find('select.form-control').on('change', function(){
                atualizarPrecos();
                calcularPrecos();
            })
            atualizarPrecos();
    		calcularPrecos();
	    })
	})


	$('#calcular').click(function(){
		valor = $('#valor').val();
		if(valor == ''){
			swal('Informe um valor válido.');
			$('#valor').focus();
			return;
		}
		valor = transformaNumero(valor, false);

		quantidade = $('#numVezesOferecidas').val();
        if(!isNumber(quantidade)){
            swal('Informe um número de vezes válido.');
            $('#numVezesOferecidas').focus();
            return;
        }

        if($('#indCobrarJuros').prop('checked')){
            $.ajax({
                method: 'GET',
                url: 'index.php',
                data: {controle: 'orcamento', acao: 'orcamentoTaxa'}
            }).done(function(porcentagem){
                montarTabela(quantidade, valor, porcentagem);
            });
        }else{
            montarTabela(quantidade, valor, 0);
        }
	});




	// Procedimentos
    qtdProcedimentos = $('.procedimento').length;
    $('#addProcedimento').click(function(){
        qtdProcedimentos++;
        $.ajax({
            type: "GET",
            url: "index.php",
            data: { controle : "orcamento", acao : "orcamentoAdicionarProcedimento", param : qtdProcedimentos}
        }).done(function(div){
            $('#rowProcedimentos').append(div);
            $('#iptValProcedimento' + qtdProcedimentos).maskMoney({thousands:'.', decimal:',', allowZero:true, prefix: 'R$'});
        });
    })
    $('#removerProcedimento').click(function(){
        if(qtdProcedimentos > 0){
            $('#procedimento'+qtdProcedimentos).remove();
            qtdProcedimentos--;
        }
    })

    $('body').on('click', 'button.btnRemover', function(){
        id = parseInt($(this).attr('id'));
        if(id < qtdProcedimentos){
            for (i = id + 1; i <= qtdProcedimentos; i++) {
            	$('#lblCdnDentista' + i).html('Dentista ' + (parseInt(i) - 1));
                $('#lblCdnDentista' + i).attr('for', 'cdnDentista' + (parseInt(i) - 1));
                $('#lblCdnDentista' + i).attr('id', 'lblCdnDentista' + (parseInt(i) - 1));
                $('#iptCdnDentista' + i).attr('name', 'cdnDentista' + (parseInt(i) - 1));
                $('#iptCdnDentista' + i).attr('id', 'iptCdnDentista' + (parseInt(i) - 1));

                $('#lblCdnAreaAtuacao' + i).html('Area de atuação ' + (parseInt(i) - 1));
                $('#lblCdnAreaAtuacao' + i).attr('for', 'cdnAreaAtuacao' + (parseInt(i) - 1));
                $('#lblCdnAreaAtuacao' + i).attr('id', 'lblCdnAreaAtuacao' + (parseInt(i) - 1));
                $('#iptCdnAreaAtuacao' + i).attr('name', 'cdnAreaAtuacao' + (parseInt(i) - 1));
                $('#iptCdnAreaAtuacao' + i).attr('id', 'iptCdnAreaAtuacao' + (parseInt(i) - 1));

                $('#lblCdnProcedimento' + i).html('Procedimento ' + (parseInt(i) - 1));
                $('#lblCdnProcedimento' + i).attr('for', 'cdnProcedimento' + (parseInt(i) - 1));
                $('#lblCdnProcedimento' + i).attr('id', 'lblCdnProcedimento' + (parseInt(i) - 1));
                $('#iptCdnProcedimento' + i).attr('name', 'cdnProcedimento' + (parseInt(i) - 1));
                $('#iptCdnProcedimento' + i).attr('id', 'iptCdnProcedimento' + (parseInt(i) - 1));


                $('#' + i).attr('id', (parseInt(i) - 1));

                $('#procedimento' + i).attr('id', 'procedimento' + (parseInt(i) - 1));
            }
        }

        $('#procedimento' + id).remove();
        qtdProcedimentos = qtdProcedimentos - 1;
    })

	$('body').on('change', 'select.selectDentista', function(){
		cdnDentista = $(this).val();

		id = $(this).attr('id').replace ( /[^\d.]/g, '' );

		// Preenche select de áreas de atuação
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "areaAtuacao", acao : "areaAtuacaoDentista", param : cdnDentista}
	    }).done(function(select){
	    	idArea = 'iptCdnAreaAtuacao'+id;
	    	selectArea = $('body').find('select#'+idArea);
	    	selectArea.html(select);
	    	selectArea.trigger('change');
	    })
	})

	$('body').on('change', 'select.selectArea', function(){
		cdnAreaAtuacao = $(this).val();

		id = $(this).attr('id').replace ( /[^\d.]/g, '' );

		// Preenche select de procedimentos
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "procedimento", acao : "procedimentoArea", param : cdnAreaAtuacao}
	    }).done(function(select){
	    	idProcedimento = 'iptCdnProcedimento'+id;
	    	selectProcedimento = $('body').find('select#'+idProcedimento);
	    	selectProcedimento.html(select);
	    	selectProcedimento.trigger('change');
	    })
	})

	$('body').on('change', 'select.selectProcedimento', function(){
		cdnProcedimento = $(this).val();
        tabelaPreco = $('#selectTabelaPreco').val();
        id = $(this).attr('id').replace ( /[^\d.]/g, '' );

        // Preenche valor do procedimento
        if(cdnProcedimento != '') {
            $.ajax({
                type: "GET",
                url: "index.php",
                async : false,
                data: { controle : "procedimento", acao : "procedimentoValor", cdnProcedimento : cdnProcedimento, tabela : tabelaPreco}
            }).done(function(val){
                val = 'R$'+number_format(val, 2, ',', '.');
                $('.form-control#iptValProcedimento'+id).val(val);
            })
        }

		calcularPrecos();
	})

	$('body').on('change', 'input.inputQuantidade', function(){
		calcularPrecos();
	})

    $('body').on('change', 'input.inputValor', function(){
        calcularPrecos();
    })


})

function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function calcularPrecos(){
	$('#valor').val(0);
    $('.inputValor').each(function(){
        id = $(this).attr('id').replace ( /[^\d.]/g, '' );
        quantidade = $('.form-control#iptNumQuantidade'+id).val();
        valor =  $(this).val();
        valor = transformaNumero(valor, false);
        valor = quantidade * valor;
        $('#valor').val(parseFloat($('#valor').val()) + parseFloat(valor));

    });
	valor = $('#valor').val();
	valor = 'R$'+number_format(valor, 2, ',', '.');
	$('#valor').val(valor);
	$('#valor').trigger('change');
}

function transformaNumero(valor, porcentagem){
	valor = valor.replace('R$', '');
	valor = valor.replace('%', '');
	if(!porcentagem)
		valor = valor.replace('.', '');
	valor = valor.replace(',', '.');
	return valor;
 }

function calcularJuros(valor, vezes, taxa){
	total = valor * Math.pow((1 + (taxa/100)), vezes);
	total = total.toFixed(2);
	return total;
}

function montarTabela(vezes, original, taxas){
	tabela = '<table class="table table-striped table-bordered table-hover">' +
			 	'<tr>' +
			 		'<th>Quantidade de parcelas</th>' +
					'<th>Valores das parcelas</th>' +
			 		'<th>Valor final</th>' +
			 		'<th>Taxas</th>' +
			 	'</tr>';
	tabela += '<tr>' +
			      '<th>A VISTA</th>' +
				  '<th>R$' + number_format(original, 2, ',', '.') + '</th>' +
			      '<th>R$' + number_format(original, 2, ',', '.') + '</th>' +
			      '<th>R$' + number_format(0.00, 2, ',', '.') + '</th>' +
			  '</tr>';
	soma = 0;
	for(i = 2; i <= vezes; i++){
		valor = calcularJuros(original, i, taxas);
		parcelas = {
		    unica : 0,
		    geral : 0,
		    vezes: 0,
		};
		soma = 0;
		for(j = 1; j < i; j++){
		    valorMes = valor/i;
		    valorMes = valorMes.toFixed(2);
		    parcelas.geral = valorMes;
		    soma = parseFloat(soma) + parseFloat(valorMes);
		}
		valorMes = parseFloat(valor) - parseFloat(soma);
		valorMes = valorMes.toFixed(2);
		parcelas.unica = valorMes;
		if(parcelas.unica != parcelas.geral){
			parcelas.vezes = i - 1;
			texto = parcelas.vezes + 'x de R$' + number_format(parcelas.geral, 2, ',', '.') +
					' + 1x de R$' + number_format(parcelas.unica, 2, ',', '.');
		}else{
			parcelas.vezes = i;
			texto = parcelas.vezes + 'x de R$' + number_format(parcelas.geral, 2, ',', '.');
		}

		tabela += '<tr>' +
				      '<td>' + i + '</td>' +
					  '<td>' + texto + '</td>' +
				      '<td>R$' + number_format(valor, 2, ',', '.') + '</td>' +
				      '<td>R$' + number_format(valor - original, 2, ',', '.') + '</td>' +
				  '</tr>';
	}
	// soma.replace(',', '.');
	// valorMes = valor - Number(soma);
	// valorMes = valorMes.toFixed(2);
	// tabela += '<tr>' +
	// 		      '<td>' + vezes + '</td>' +
	// 		      '<td>R$' + number_format(valorMes, 2, ',', '.') + '</td>' +
	// 		      '<td>R$' + number_format(valor, 2, ',', '.') + '</td>' +
	// 		  '</tr>' +
	// 		  '<tr>' +
	// 		      '<th>Valor inicial:</th>' +
	// 		      '<td colspan="2">R$' + number_format(original, 2, ',', '.') + '</td>' +
	// 		  '</tr>' +
 //  			  '<tr>' +
	// 		      '<th>Valor com taxas:</th>' +
	// 		      '<td colspan="2">R$' + number_format(valor, 2, ',', '.') + '</td>' +
	// 		  '</tr>';
	// valor = valor.replace(',', '.');
	// original = original.replace(',', '.');
	// taxas = Number(valor) - Number(original);
	// taxas = taxas.toFixed(2);
	// tabela += '<tr>' +
	// 		      '<th>Taxas:</th>' +
	// 		      '<td colspan="2">R$' + number_format(taxas, 2, ',', '.') + '</td>' +
	// 		  '</tr>';
	$('#tabelaCalculo').html(tabela);
}


function number_format(number, decimals, dec_point, thousands_sep) {

  number = (number + '')
    .replace(/[^0-9+\-Ee.]/g, '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
    .split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '')
    .length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1)
      .join('0');
  }
  return s.join(dec);
}

function atualizarPrecos(){
    $('select.selectProcedimento').each(function(){
        $(this).trigger('change');
    })
}
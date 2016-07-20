$(function(){



    $(".iptCdnPaciente").select2({
        language: 'pt-BR'
    });
	
	$('.iptCdnAreaAtuacao').on('select2:close', function(){
		mudaProcedimento();
		// $('#datConsulta').datepicker('update', '');
		$('#divCdnSecao').html(' ');
	})
	function mudaProcedimento(){
		id = $('.iptCdnAreaAtuacao').val();
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "procedimento", acao : "procedimentoArea", param : id}
	    }).done(function(select){
	    	$('#divCdnProcedimento').html(select);
	    	$('#divCdnProcedimento').find('select.form-control').select2({
        		language: 'pt-BR'
    		});
    		$('#divCdnProcedimento').find('select.form-control').on("select2:close", function(e){
    			mudaSecao($(this).val());
    		})
	    })
	}

	$('#iptCdnDentista').on("select2:close", function(e){
		mudaAreaAtuacao();
		// $('#datConsulta').datepicker('update', '');
		cdnDentista = $(this).val();
	})

	function mudaAreaAtuacao(){
		id = $('#iptCdnDentista').val();
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "areaAtuacao", acao : "areaAtuacaoDentista", param : id}
	    }).done(function(select){
	    	$('#divAreaAtuacao').html(select);
	    	$('#divAreaAtuacao').find('select.form-control').select2({
        		language: 'pt-BR'
    		});
    		$('#divAreaAtuacao').find('select.form-control').on("select2:close", function(e){
				mudaProcedimento();
				// $('#datConsulta').datepicker('update', '');
				$('#divCdnSecao').html(' ');
    		})
	    })
	}

	function mudaDentista(){
		id = $('.iptCdnAreaAtuacao').val();
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "dentista", acao : "dentistaArea", param : id}
	    }).done(function(select){
	    	$('#divCdnDentista').html(select);
			cdnDentista = $('.iptCdnDentista').val();
    		$('#divFechado').html(' ');
    		$('#divFechado').hide();
	    })
	}

	$(document).on('click', '.iptCdnProcedimento', function(){
		mudaSecao($(this).val());
	})

	var dateElement = $('#datConsulta').val().split("/");
    var dateFormat = dateElement[2]+'-'+dateElement[1]+'-'+dateElement[0];
    var date = new Date(dateFormat);
    var weekday = ["Segunda", "Terca", "Quarta", "Quinta", "Sexta", "Sabado", "Domingo"];
    var day = weekday[date.getDay()];
	cdnDentista = $('#iptCdnDentista').val();
	montaHorarios($('#datConsulta').val(), day);

	$('#datConsulta').datepicker({
		language: 'pt-BR',
        format: "dd/mm/yyyy",
        default: 'dd/mm/yyyy',
	}).on('changeDate', function(e){
		var dateElement = $('#datConsulta').val().split("/");
	    var dateFormat = dateElement[2]+'-'+dateElement[1]+'-'+dateElement[0];
	    var date = new Date(dateFormat);
	    var weekday = ["Segunda", "Terca", "Quarta", "Quinta", "Sexta", "Sabado", "Domingo"];
	    var day = weekday[date.getDay()];

		mudaHorario($('#datConsulta').val());
		checaFechado($('#datConsulta').val());
		montaHorarios($('#datConsulta').val(), day);
	})
	$.ajax({
        type: "GET",
        url: "index.php",
        data: { controle : "dentista", acao : "dentistaDiasSemanaArray", param : cdnDentista}
    }).done(function(disabled_days){
    	disabled_days = eval(disabled_days);
		// $('#datConsulta').datepicker('setDaysOfWeekDisabled', disabled_days);
		// $('#datConsulta').setDate(datConsulta);
		// $('#datConsulta').datepicker('update', '');
    })



	$('#iptCdnDentista').on('select2:close', function(){
		cdnDentista = $(this).val();
		datConsulta = $('#datConsulta').val().split('/');
		datConsulta = new Date(datConsulta[2], datConsulta[1] - 1, datConsulta[0]);
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "dentista", acao : "dentistaDiasSemanaArray", param : $(this).val()}
	    }).done(function(disabled_days){
	    	disabled_days = eval(disabled_days);
			// $('#datConsulta').setDate(datConsulta);
			// $('#datConsulta').datepicker('setDaysOfWeekDisabled', disabled_days);
			// $('#datConsulta').datepicker('update', '');
	    })
	})

	function mudaHorario(data){
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "consulta", acao : "consultaVerificaData", datConsulta : data, cdnDentista : cdnDentista}
	    }).done(function(lista){
	    	if(lista == false){
	    		$('#divHorarios').html(' ');
	    		$('#divHorarios').hide();
	    	}else{
	    		$('#divHorarios').show();
	    		$('#divHorarios').html(lista);
	    	}
	    })
	}

	function checaFechado(data){
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "dentista", acao : "dentistaVerificaFechado", param : data, cdnDentista : cdnDentista}
	    }).done(function(lista){
	    	if(lista == false){
	    		$('#divFechado').html(' ');
	    		$('#divFechado').hide();
	    	}else{
	    		$('#divFechado').show();
	    		$('#divFechado').html(lista);
	    	}
	    })
	}

	function montaHorarios(data, diaSemana){
		if(data != ''){
			if(typeof(cdnDentista) != 'undefined'){
				horaConsulta = $('#horaConsulta').val() + ':00';
				if(!$('#indEncaixe').prop('checked')){
					cdnConsulta = $('.id').attr('id');
					$.ajax({
				        type: "GET",
				        url: "index.php",
				        data: { controle : "dentista", acao : "dentistaMontaHorarios", param : cdnDentista, datConsulta : data, remarcar:cdnConsulta}
				    }).done(function(lista){
				    	if(lista == 'nenhum'){
				    		$('#horaConsulta').remove();
				    		$('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
							$('#horaConsulta').inputmask('99:99');
							$('#horaConsulta').on('change', function(){
								verificaHorario($(this).val());
							})
				    		$('#divHorarios').text('O dentista não possui horários disponíveis nesta data!');
				    		$('#divHorarios').show();
				    		return;
				    	}
				    	if(lista == 'nconfigurado'){
				    		$('#horaConsulta').remove();
							$('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
							$('#horaConsulta').inputmask('99:99');
							$('#horaConsulta').on('change', function(){
								verificaHorario($(this).val());
							})
				    		return;
				    	}
				    	
				    	lista = $.parseJSON(lista);
				    	lista = lista[diaSemana];
				    	if(typeof lista != 'undefined'){
					    	if(typeof lista.length != 'undefined'){
					    		$('#horaConsulta').remove();
					    		$('#horario').append('<select name="horaConsulta" class="form-control" id="horaConsulta">');
						    	for(i = 0; i < lista.length; i++){
						    		horario = lista[i];
					    			if(horario.length != 3){
						    			selected = '';
						    			if(horaConsulta == lista[i]){
						    				selected = ' selected ';
						    			}
							    		$('#horaConsulta').append('<option ' + selected + 'value="' + lista[i] + '">' + lista[i] + '</option>');	
							    	}
						    	}
						    	$('#horario').append('</select>');
						    	$('#horaConsulta').on('change', function(){
									verificaHorario($(this).val());
								})
						    }
					    }else{
					    	$('#horaConsulta').remove();
							$('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
							$('#horaConsulta').inputmask('99:99');
				    		$('#divHorarios').text('O dentista não possui horários disponíveis nesta data!');
				    		$('#divHorarios').show();
				    		$('#horaConsulta').on('change', function(){
								verificaHorario($(this).val());
							})
				    		return;
					    }
				    })
				}
			}
		}
	}

	$('#indEncaixe').click(function(){
		if($(this).prop('checked')){
			$('#horaConsulta').remove();
			$('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
			$('#horaConsulta').inputmask('99:99');
			$('#horaConsulta').on('change', function(){
				verificaHorario($(this).val());
			})
		}else{
			$('#datConsulta').trigger('changeDate');
		}
	})

	$('#indEncaixe').click(function(){
		$('#numHorarios').attr('disabled', $(this).prop('checked'));
		$('#numHorarios').val(0);
		$('#numHorarios').trigger('change');

		if($(this).prop('checked')){
			$('#horaConsulta').remove();
			$('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
			$('#horaConsulta').inputmask('99:99');
			$('#horaConsulta').on('change', function(){
				verificaHorario($(this).val());
			})
		}else{
			$('#datConsulta').trigger('changeDate');
		}
	})

	$('#numHorarios').on('change', function(){
    	if($('#horaConsulta').val() != ''){
    		hora = $('#horaConsulta').val().split(':')[0];
    		minuto = $('#horaConsulta').val().split(':')[1];
    		if(hora < 24 && minuto < 59){
				$.ajax({
			        type: "GET",
			        url: "index.php",
			        data: { controle : "dentista", acao : "dentistaTempoConsulta", param : $('#horaConsulta').val(), cdnDentista : cdnDentista, numHorarios : $(this).val()}
			    }).done(function(hora){
			    	if(hora != ''){
			    		$('#divEsperado').show();
			    		$('#divEsperado').html(hora);
			    	}else{
			    		$('#divEsperado').hide();
			    		$('#divEsperado').html(' ');
			    	}
			    })
			}else{
		    		$('#divEsperado').hide();
		    		$('#divEsperado').html(' ');
			}
		}else{
	    		$('#divEsperado').hide();
	    		$('#divEsperado').html(' ');
		}
	})


	function mudaSecao(id){
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "secao", acao : "secaoArea", param : id}
	    }).done(function(select){
	    	$('#divCdnSecao').html(select);
	    })
	}

	$('.fechaModalPaciente').on('click', function(){
		$(this).val(cdnPacienteMODAL);
		if($(this).val() != ''){
			$.ajax({
		        type: "GET",
		        url: "index.php",
		        data: { controle : "paciente", acao : "pacienteVerificaCadastro", param : $(this).val()}
		    }).done(function(verificacao){
		    	if(verificacao != ''){
		    		$('#divCadastro').show();
		    		$('#divCadastro').html(verificacao);
		    	}else{
		    		$('#divCadastro').hide();
		    		$('#divCadastro').html(' ');
		    	}
		    })

			$.ajax({
		        type: "GET",
		        url: "index.php",
		        data: { controle : "procedimento", acao : "procedimentoAviso", param : $(this).val()}
		    }).done(function(verificacao){
		    	if(verificacao != ''){
		    		$('#divProcedimento').show();
		    		$('#divProcedimento').html(verificacao);
		    	}else{
		    		$('#divProcedimento').hide();
		    		$('#divProcedimento').html(' ');
		    	}
		    })

			$.ajax({
		        type: "GET",
		        url: "index.php",
		        data: { controle : "secao", acao : "secaoAviso", param : $(this).val()}
		    }).done(function(verificacao){
		    	if(verificacao != ''){
		    		$('#divSecao').show();
		    		$('#divSecao').html(verificacao);
		    	}else{
		    		$('#divSecao').hide();
		    		$('#divSecao').html(' ');
		    	}
		    })

			$.ajax({
		        type: "GET",
		        url: "index.php",
		        data: { controle : "desmarque", acao : "desmarqueAviso", param : $(this).val()}
		    }).done(function(verificacao){
		    	if(verificacao != ''){
		    		$('#divDesmarque').show();
		    		$('#divDesmarque').html(verificacao);
		    	}else{
		    		$('#divDesmarque').hide();
		    		$('#divDesmarque').html(' ');
		    	}
		    })

			$.ajax({
		        type: "GET",
		        url: "index.php",
		        data: { controle : "clinica", acao : "clinicaProntuarioAviso", param : $(this).val()}
		    }).done(function(verificacao){
		    	if(verificacao != ''){
		    		$('#divProntuario').show();
		    		$('#divProntuario').html(verificacao);
		    	}else{
		    		$('#divProntuario').hide();
		    		$('#divProntuario').html(' ');
		    	}
		    })

		}else{
    		$('#divCadastro').hide();
    		$('#divCadastro').html(' ');

    		$('#divProcedimento').hide();
    		$('#divProcedimento').html(' ');

    		$('#divSecao').hide();
    		$('#divSecao').html(' ');

    		$('#divProntuario').hide();
    		$('#divProntuario').html(' ');

    		$('#divDesmarque').hide();
    		$('#divDesmarque').html(' ');
		}
	})

	function verificaHorario(horaConsulta){
		datConsulta = $('#datConsulta').val();
		cdnConsulta = $('.id').attr('id');
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "consulta", acao : "consultaVerificaExistente", horaConsulta : horaConsulta, datConsulta : datConsulta, cdnDentista : cdnDentista, cdnConsulta : cdnConsulta}
	    }).done(function(back){
	    	if(back == 'ndisponivel'){
				swal({
    				title:'Atenção!',
    				text:'Já existe uma consulta neste horário para este dia.',
    				type: 'error'
    			});
	    	}
	    	if(back == 'bloqueado'){
				swal({
    				title: 'Atenção!',
    				text: 'Este horário está bloqueado por outra consulta. Não será possível realizar a marcação.',
    				type: 'error'
    			});	
	    	}
	    })
	}

	$('#horaConsulta').on('change', function(){
		verificaHorario($(this).val());
	})
})
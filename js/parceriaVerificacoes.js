$(function(){
	$('input[name="indPaciente"]').click(function(){
		if($(this).val() == 1){
			$('#paciente').show();
			$('#funcionario').hide();
		}else{
			$('#paciente').hide();
			$('#funcionario').show();
		}
	})

	$('input[name="indPaciente"]').each(function(){
		if(typeof $(this).attr('checked') != 'undefined'){
			if($(this).val() == 1){
				$('#paciente').show();
				$('#funcionario').hide();
			}else{
				$('#paciente').hide();
				$('#funcionario').show();
			}
		}
	})


})
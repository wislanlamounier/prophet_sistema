$(function(){
	$('#datIntervalo').datepicker({
		'language' : 'pt-BR',
		'disableTouchKeyboard' : true,
		'todayHighlight' : true,
	});

	
	hide = false;
	$('.diasSemana').each(function(){
		if($(this).prop('checked'))
			hide = true;
	})
	if(hide)
		$('#data').hide();
	else
		$('#data').show();

	$('#indPermanente').on('click', function(){
		if(!$(this).prop('checked')){
			$('#data').show();
		}else{
			$('#data').hide();
		}

		$('.diasSemana').each(function(){
			$(this).prop('checked', $('#indPermanente').prop('checked'));
		})
	})

	$('.diasSemana').on('click', function(){
		hide = false;
		$('.diasSemana').each(function(){
			if($(this).prop('checked'))
				hide = true;
		})
		if(hide)
			$('#data').hide();
		else
			$('#data').show();
		$('#indPermanente').prop('checked', false);
	})
})
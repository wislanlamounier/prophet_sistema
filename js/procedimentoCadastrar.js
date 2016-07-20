$(function(){
	ultimoValor = '';
	$('#valor').on('change', function(){
		$('.valProcedimento').each(function(){
			if($(this).val() == '' || $(this).val() == 'R$0,00' || $(this).val() == ultimoValor){
				$(this).val($('#valor').val());
			}
		})
		ultimoValor = $('#valor').val();
	})
})
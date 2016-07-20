$(function(){
	$('.copiar').on('change', function(){
		if($(this).val() == 'parceria'){
			$('#divParcerias').show();
			$('#divTabelas').hide();
		}else{
			$('#divParcerias').hide();
			$('#divTabelas').show();
		}
	})
})
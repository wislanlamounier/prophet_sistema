$(function(){
    // $('#datIntervalo').daterangepicker();

    $('#datIntervalo').inputmask('99/99/9999 - 99/99/9999');

    // $('#datIntervalo').change(function(){
    // 	verificaData($(this).val());
    // })

	// $('#datIntervalo').on('apply.daterangepicker', function(ev, picker) {
	// 	alert('teste');
	// });
})

function verificaData(val){
	if(val != ''){
        id = $('form').attr('id');
		$('#repeticao').html(' ');
		$.ajax({
	        type: "GET",
	        url: "index.php",
	        data: { controle : "prontuario", acao : "prontuarioVerificaDatas", param : val, cdnPaciente : id}
    	}).done(function(list){
    		if(list != 1){
    			$('#repeticao').show();
	    		$('#repeticao').append(list);
    		}else{
    			$('#repeticao').html(' ');
    			$('#repeticao').hide();
    		}
    	});
	}
}
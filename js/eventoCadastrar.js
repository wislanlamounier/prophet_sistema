$(function(){

    $('#datFim').prop('disabled', $('#indAllDay').prop('checked'));
    $('#horaFim').prop('disabled', $('#indAllDay').prop('checked'));

    $('#indAllDay').on('click', function(){
        $('#datFim').prop('disabled', $(this).prop('checked'));
        $('#horaFim').prop('disabled', $(this).prop('checked'));
    });

    $('#datInicio').focusout(function(){
        if($(this).val() == '' || $(this).val() != 'dd/mm/yyyy'){
	        if($('#datFim').val() == '' || $('#datFim').val() == 'dd/mm/yyyy'){
	            $('#datFim').val($('#datInicio').val());
	        }
        }
        $(this).val($(this).val());
    })
    
    $('#iptNumDiasAviso').attr('disabled', !$('#iptIndAviso').prop('checked'));
    $('#iptIndAviso').on('click', function(){
    	$('#iptNumDiasAviso').attr('disabled', !$(this).prop('checked'));
    })
});

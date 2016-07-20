$(function(){
	$('input').each(function(){
		$(this).prop('disabled', true);
	});
	$('select').each(function(){
		$(this).prop('disabled', true);
	})
	$('textarea').each(function(){
		$(this).prop('disabled', true);
	})
})
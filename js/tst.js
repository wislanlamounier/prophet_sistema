$(function(){
	$.ajax({
		url : 'http://projeto1ufcg20152.esy.es/php/',
		data : {nome: 'teste'},
		type: 'post'
	}).done(function(ret){
		alert(ret);
	});
});
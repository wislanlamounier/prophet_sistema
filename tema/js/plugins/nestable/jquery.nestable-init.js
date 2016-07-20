$(function(){
	var updateOutput = function (e) {
		var list = e.length ? e : $(e.target),
		output = list.data('output');
	};

	qtdNestable = 0;
	$('.nestable').each(function(){
		qtdNestable++;
		$(this).nestable({
			group: qtdNestable
		}).on('change', updateOutput);
	})

})
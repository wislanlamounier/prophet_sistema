$(function(){

	tipo = 'ativas';
	opts = {
        "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        "aaSorting": [],
        "serverside" : true,
        "ajax" : {
            "url" : "index.php?controle=json&acao=jsonConsultas&param=" + tipo,
            "type" : "GET"
        },
        "language": {
            "url": "plugins/datatables_new/datatables.portuguese.lang"
        }
    }

     $('.datatable').dataTable(opts);

	$('.tipo').on('change', function(){
		tipo = $(this).val();
		$('.datatable').dataTable().fnDestroy();
		url = "index.php?controle=json&acao=jsonConsultas&param=" + tipo,
		opts.ajax.url = url;
    	$('.datatable').dataTable(opts);
	});


})
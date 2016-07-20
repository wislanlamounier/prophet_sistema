$(function(){
	opts = {
        "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        "aaSorting": [],
        "serverside" : true,
        "ajax" : {
            "url" : "index.php?controle=json&acao=jsonProntuarios",
            "type" : "GET"
        },
        "language": {
            "url": "plugins/datatables_new/datatables.portuguese.lang"
        }
    }

     $('.datatable').dataTable(opts);
});
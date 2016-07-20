$(function(){
	opts = {
        "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        "aaSorting": [],
        "serverside" : false,
        "language": {
            "url": "plugins/datatables/datatables.portuguese.lang"
        }
    }

     $('.datatable').dataTable(opts);
})
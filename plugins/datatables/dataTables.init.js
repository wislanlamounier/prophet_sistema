$(function(){

    $('table.datatable').dataTable({
        "bProcessing": true,
        "bDeferRender": true,
        "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
        "aaSorting": []
    });

});

$(function () {
    $('#geral').on('click', function(){
        $('#modalGeral').modal('toggle');
    })
    
    $('#modalGeral').on('show.bs.modal', function (event) {

        if (typeof chart == 'undefined') {
            chart = true;
            graficoGeral();
        }


    });
    
    $.ajax({
        type: "GET",
        url: "index.php",
        data: {controle: "dentista", acao: "dentistaJsonGrafico"}
    }).done(function (json) {
        json = $.parseJSON(json);
        geraGrafico('lineChart', json);
    })

})
// Este arquivo contém apenas as funções
// para executar e criar um gráfico geral, ver dentistaInicio.js ou init.graficoInicio.js

function graficoGeral(){
    $.ajax({
        type: "GET",
        url: "index.php",
        data: {controle: "consulta", acao: "consultaJsonGraficoInicio"}
    }).done(function (json) {
        json = $.parseJSON(json);
        geraGrafico('graficoGeral', json);
    })
}

function geraGrafico(el, json) {
    var lineData = {
        labels: json.labels,
        datasets: [
            {
                label: "Desmarques",
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: json.desmarques
            },
            {
                label: "Consultas",
                fillColor: "rgba(26,179,148,0.5)",
                strokeColor: "rgba(26,179,148,0.7)",
                pointColor: "rgba(26,179,148,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(26,179,148,1)",
                data: json.consultas
            },
            {
                label: "Faltas",
                fillColor: "rgba(122, 147, 255, 0.5)",
                strokeColor: "rgba(122, 147, 255, 0.7)",
                pointColor: "rgba(122, 147, 255, 1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(122, 147, 255, 1)",
                data: json.faltas
            },
            {
                label: "Remarques",
                fillColor: "rgba(255, 168, 211, 0.5)",
                strokeColor: "rgba(255, 168, 211, 0.7)",
                pointColor: "rgba(255, 168, 211, 1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(255, 168, 211, 1)",
                data: json.remarques
            },
        ]
    };

    var lineOptions = {
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        bezierCurve: true,
        bezierCurveTension: 0.4,
        pointDot: true,
        pointDotRadius: 4,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        responsive: true,
    };


    var ctx = document.getElementById(el).getContext("2d");
    var chart = new Chart(ctx).Line(lineData, lineOptions);
    return chart;
}
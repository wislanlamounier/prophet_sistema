$().ready(function() {
    $('#filtroData').datepicker({
        'language': 'pt-BR',
        'disableTouchKeyboard': true,
        'todayHighlight': true
    }).on('changeDate', function() {
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "consulta", acao: "consultaConsultaMapaData", param: $("#filtroData").val()}
        }).done(function(val) {
            var json = $.parseJSON(val);
            var html = "";

            $.each(json, function(k, consultorio) {
                html += "<div class='col-md-4 col-sm-6 col-xs-12'>";
                html += "<fieldset><legend>Consultório " + consultorio.numConsultorio + "</legend>";

                if (consultorio.hasOwnProperty('consultas')) {
                    html += "<table class='table table-striped table-bordered table-hover'>";
                    html += "<tr><th>Dentista</th><th>Horário</th></tr>";

                    $.each(consultorio.consultas, function(key, consulta) {
                        html += "<tr>";
                        html += "<td>" + consulta.nomDentista + "</td>";
                        html += "<td>" + consulta.horaConsulta + "</td>";
                        html += "</tr>";
                    });

                    html += "</table>";
                } else {
                    html += "<div class='well well-sm' style='text-align: center;'>Sem consultas marcadas</div>";
                }

                html += "</fieldset></div>";
            });
            
            $("#divMapa").html(html);
        });
    });
});
$(function () {
    $.ajax({
        type: "GET",
        url: "index.php",
        data: {controle: "dentista", acao: "dentistaDiasFechadosArray"}
    }).done(function (available_Dates) {
        available_Dates = eval(available_Dates);
        $('#datDias').datepicker({
            multidate: true,
            language: 'pt-BR',
            format: "dd/mm/yyyy",
            default: 'dd/mm/yyyy',
            beforeShowDay: function (date) {
                // var formattedDate = $.fn.datepicker.DPGlobal.formatDate(date, 'dd/mm/yyyy', 'pt-BR');
                // if ($.inArray(formattedDate.toString(), available_Dates) == -1){
                //     return {
                //         enabled : true
                //     };
                // }else{
                //     return {
                //         enabled : false
                //     };
                // }
                // return;
            }
        }).on('changeDate', function (e) {
            eDates = e.dates;
            nDates = [];
            for (i in eDates) {
                eDate = eDates[i];
                nDates.push(moment(eDate).format('DD/MM/YYYY'));
            }
            e.dates = nDates;
            atualizaObs(e);
        })
    })

    $('#indGeral').click(function () {
        if (this.checked) {
            $("#divObs").hide();

            $("#obsGeral").show();
        } else {
            $("#divObs").show();

            $("#obsGeral").hide();
        }
    });

    datas = [];

    function atualizaObs(e) {
        diferente = diferenca(e.dates, datas);
        diferente = JSON.stringify(diferente);
        diferente = diferente.replace('"', '');
        diferente = diferente.replace('"', '');
        diferente = diferente.replace('[', '');
        diferente = diferente.replace(']', '');
        datas = e.dates;
        if (diferente == '') {
            $('#divObs').html(' ');
            return;
        }
        id = diferente;
        id = id.replace('/', '');
        id = id.replace('/', '');

        if ($('#divObs').find('div.' + id).length == 0) {
            $('#divObs').append('<div class="row">');
            $('#divObs').append('<div class="' + id + ' col-sm-6 col-lg-6 form-group"><label for="' + id + '" class="control-label">' +
                    'Observação dia ' + diferente + ' </label> <textarea class="form-control" name="' + id + '"' +
                    '></textarea>');
            $('#divObs').append('<div class="' + id + ' col-sm-2 col-lg-1 form-group"><label for="dia' + id + '" class="control-label">' +
                    'Fechar o dia todo</label><br> <input type="checkbox" checked name="dia' + id + '"></div>');
            $('#divObs').append('<div class="' + id + ' col-sm-4 col-lg-5 form-group"><label for="hora' + id + '" class="control-label">' +
                    'Horário (ignorar se for dia inteiro)</label><input type="text" class="form-control ' +
                    'mask-timeInterval" name="hora' + id + '">');
            $('#divObs').append('</div>');

            $('.mask-timeInterval').each(function () {
                $(this).inputmask('99:99 - 99:99');
            })
        } else {
            // existe
            $('.' + id).remove();

        }
    }

    function diferenca(a1, a2) {
        var a = [], diff = [];
        for (var i = 0; i < a1.length; i++)
            a[a1[i]] = true;
        for (var i = 0; i < a2.length; i++)
            if (a[a2[i]])
                delete a[a2[i]];
            else
                a[a2[i]] = true;
        for (var k in a)
            diff.push(k);
        return diff;
    }
})
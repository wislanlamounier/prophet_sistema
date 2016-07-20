$(function () {
    $('.sortable').sortable({
        update: function (event, ui) {
            item = ui.item;
            $.ajax({
                type: "GET",
                url: "index.php",
                data: {controle: "campo", acao: "campoCallbackExiste", param: item.attr('cdnCampo')}
            }).done(function (resultado) {
                if (resultado == 1) {
                    if (typeof item.attr('cdnPai') == 'undefined') {
                        codSeq = 1;
                        $('.campoPai').each(function () {
                            codSeq++;
                            cdnCampo = $(this).attr('cdnCampo');
                            $.ajax({
                                type: "GET",
                                url: "index.php",
                                data: {controle: 'campo', acao: 'campoOrdenacaoFim', cdnCampo: cdnCampo, codSequencial: codSeq}
                            });
                            $(this).attr('codSequencial', codSeq);
                        })
                    } else {
                        codSeq = 0;
                        $('li[cdnPai="' + item.attr('cdnPai') + '"]').each(function () {
                            codSeq++;
                            cdnCampo = $(this).attr('cdnCampo');
                            $.ajax({
                                type: "GET",
                                url: "index.php",
                                data: {controle: 'campo', acao: 'campoOrdenacaoFim', cdnCampo: cdnCampo, codSequencial: codSeq}
                            });
                            $(this).attr('codSequencial', codSeq);
                        })
                    }
                } else {
                    $('.sortable').sortable('cancel');
                }
            });
        }
    });

})
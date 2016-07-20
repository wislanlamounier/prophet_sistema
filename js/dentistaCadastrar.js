$(function(){

    // Areas
    qtdAreas = $('.area').length;
    $('#addArea').click(function(){
        qtdAreas++;
        $.ajax({
            type: "GET",
            url: "index.php",
            data: { controle : "dentista", acao : "dentistaAdicionarArea", param : qtdAreas}
        }).done(function(div){
            $('#rowAreas').append(div)
        });
    })
    $('#removerArea').click(function(){
        if(qtdAreas > 0){
            $('#area'+qtdAreas).remove();
            qtdAreas--;
        }
    })

    $('body').on('click', 'button.btnRemover', function(){
        id = parseInt($(this).attr('id'));
        if(id < qtdAreas){
            for (i = id + 1; i <= qtdAreas; i++) {
                $('#lblCdnAreaAtuacao' + i).html('Area de atuação ' + (parseInt(i) - 1));
                $('#lblCdnAreaAtuacao' + i).attr('for', 'cdnAreaAtuacao' + (parseInt(i) - 1));
                $('#lblCdnAreaAtuacao' + i).attr('id', 'lblCdnAreaAtuacao' + (parseInt(i) - 1));

                $('#iptCdnAreaAtuacao' + i).attr('name', 'cdnAreaAtuacao' + (parseInt(i) - 1));
                $('#iptCdnAreaAtuacao' + i).attr('id', 'iptCdnAreaAtuacao' + (parseInt(i) - 1));

                $('#' + i).attr('id', (parseInt(i) - 1));

                $('#area' + i).attr('id', 'area' + (parseInt(i) - 1));
            }
        }

        $('#area' + id).remove();
        qtdAreas = qtdAreas - 1;


    })


});

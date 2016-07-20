$(function(){

    // Procedimentos
    qtdProcedimentos = $('.procedimento').length;
    $('#addProcedimento').click(function(){
        qtdProcedimentos++;
        $.ajax({
            type: "GET",
            url: "index.php",
            data: { controle : "areaAtuacao", acao : "areaAtuacaoAdicionarProcedimento", param : qtdProcedimentos}
        }).done(function(div){
            $('#rowProcedimentos').append(div)
        });
    })
    $('#removerProcedimento').click(function(){
        if(qtdProcedimentos > 0){
            $('#procedimento'+qtdProcedimentos).remove();
            qtdProcedimentos--;
        }
    })

    $('body').on('click', 'button.btnRemover', function(){
        id = parseInt($(this).attr('id'));
        if(id < qtdProcedimentos){
            for (i = id + 1; i <= qtdProcedimentos; i++) {
                $('#lblNomProcedimento' + i).html('Procedimento ' + (parseInt(i) - 1));
                $('#lblNomProcedimento' + i).attr('for', 'nomProcedimento' + (parseInt(i) - 1));
                $('#lblNomProcedimento' + i).attr('id', 'lblNomProcedimento' + (parseInt(i) - 1));

                $('#iptNomProcedimento' + i).attr('name', 'nomProcedimento' + (parseInt(i) - 1));
                $('#iptNomProcedimento' + i).attr('id', 'iptNomProcedimento' + (parseInt(i) - 1));

                $('#' + i).attr('id', (parseInt(i) - 1));

                $('#procedimento' + i).attr('id', 'procedimento' + (parseInt(i) - 1));
            }
        }

        $('#procedimento' + id).remove();
        qtdProcedimentos = qtdProcedimentos - 1;


    })

});

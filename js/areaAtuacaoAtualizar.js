$(function(){

    procedimentos = $('.procedimento').length;
    $('#addProcedimento').click(function(){
        procedimentos++;
        $.ajax({
            type: "GET",
            url: "index.php",
            data: { controle : "areaAtuacao", acao : "areaAtuacaoAdicionarProcedimento", param : procedimentos}
        }).done(function(div){
            $('#rowProcedimentos').append(div)
        });
    })
    $('#removerProcedimento').click(function(){
        if(procedimentos > 0){
            $('#procedimento'+procedimentos).remove();
            procedimentos--;
        }
    })
    $('body').on('click', 'button.btnRemover', function(){
        id = parseInt($(this).attr('id'));
        if(id < procedimentos){
            for (i = id + 1; i <= procedimentos; i++) {
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

        procedimentos = procedimentos - 1;
    })

});

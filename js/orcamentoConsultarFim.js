$().ready(function() {
    $("#fechaModalJustificativa").click(function() {
        if($("#cdnOrcamento").val() != '') {
            var params = {
                cdnOrcamento : $("#cdnOrcamento").val(), 
                strJustificativa : $("#strJustificativa").val()
            };
            
            $.ajax({
                type: "GET",
                url: "index.php",
                async : false,
                data: { controle : "orcamento", acao : "orcamentoDesativar", param: params}
            }).done(function(val){
                window.location.href = "orcamento/consultarFim/" + $("#cdnOrcamento").val();
            })
        }
    });
    
     $('#datOrcamento').datepicker({
        'language': 'pt-BR',
        'disableTouchKeyboard': true,
        'todayHighlight': true
    });
    
     $('#datValidade').datepicker({
        'language': 'pt-BR',
        'disableTouchKeyboard': true,
        'todayHighlight': true
    });
});

function openModalJustificativa() {
    $("#modalJustificativa").modal("show");
}

function salvarEdicao(){
    if($("#cdnOrcamento").val() != '') {
        var params = {
            cdnOrcamento : $("#cdnOrcamento").val(), 
            datOrcamento : $("#datOrcamento").val(),
            datValidade : $("#datValidade").val(),
            desOrcamento : $("#desOrcamento").val(),
            valOrcamento : $("#valor").val()
        };

        $.ajax({
            type: "GET",
            url: "index.php",
            async : false,
            data: { controle : "orcamento", acao : "orcamentoSalvarEdicao", param: params}
        }).done(function(val){
            window.location.href = "orcamento/consultarFim/" + $("#cdnOrcamento").val();
        })
    }
}
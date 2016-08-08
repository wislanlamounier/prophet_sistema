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
});

function openModalJustificativa() {
    $("#modalJustificativa").modal("show");
}
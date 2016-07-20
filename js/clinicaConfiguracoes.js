$(function(){
    $('#banco').select2('val', $('#bancoInicio').val());
    $.ajax({
        type: "GET",
        url: "index.php",
        data: { controle : "boleto", acao : "boletoMontaFormulario", param : $('#banco').val()}
    }).done(function(resultado){
        $('#formulario').html(resultado);
    });
})

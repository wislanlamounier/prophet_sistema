$(function(){
    $.ajax({
        type: "GET",
        url: "index.php",
        data: { controle: 'estilo', acao:'estiloGetJson'}
    })
    .done(function(msg){
        msg = $.parseJSON(msg);

        $('body').toggleClass(msg['nomSkin']);
        $('#page-header-parent').toggleClass(msg['nomFundoHeader']);
        $('#page-wrapper').toggleClass(msg['nomFundoConteudo']);

        $('.btn-success').each(function(){
            $(this).toggleClass('.btn-success');
            $(this).toggleClass(msg['nomBotaoSucesso']);
        })

        $('.btn-primary').each(function(){
            $(this).toggleClass('.btn-primary');
            $(this).toggleClass(msg['nomBotaoPrimario']);
        })
    });
});

$(function () {
    $('a').click(function (event) {
        event.preventDefault();
        url = $(this).attr('href');
        if(typeof $(this).attr('target') != 'undefined'){
            blank = true;
        }else{
            blank = false;
        }
        urlOriginal = url;
        controlador = '';
        acao = '';
        if (typeof url != 'undefined') {
            url = url.split('/');



            if (url[url.length - 1] != '#' && urlOriginal.indexOf('#') == -1) {
                if (url.length > 3) {
                    if (url[0] == 'http:') {
                        if (typeof url[3] != 'undefined' && typeof url[4] != 'undefined') {
                            controlador = url[3];
                            acao = url[4];
                        }
                    } else {
                        if (typeof url[1] != 'undefined' && typeof url[2] != 'undefined') {
                            controlador = url[1];
                            acao = url[2];
                        }
                    }
                    if (controlador != '' && acao != '') {
                        $.ajax({
                            type: "GET",
                            url: "index.php",
                            data: {controle: "main", acao: "mainPermissao", controlador: controlador, funcao: acao}
                        }).done(function (result) {
                            if (result == 'erro') {
                                swal({
                                    title: 'Ops!',
                                    text: 'Você não possui permissão para acessar esta página!',
                                    showCancelButton: true,
                                    showConfirmButton: false,
                                    cancelButtonText: "Ok",
                                    timer: 1500,
                                    type: 'error'
                                });
                            } else {
                                if(blank){
                                    window.open(urlOriginal);
                                }else {
                                    $(location).attr('href', urlOriginal)
                                }
                            }
                        })
                    }
                } else {
                    if(blank){
                        window.open(urlOriginal);
                    }else {
                        $(location).attr('href', urlOriginal)
                    }
                }
            }

        }


    });
});
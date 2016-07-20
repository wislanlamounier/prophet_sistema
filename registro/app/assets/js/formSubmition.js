$(function(){
    $('form').submit(function(e){

        if($(this).attr('target') != '_blank'){
            var event = $(document).click(function(e) {
                            e.stopPropagation();
                            e.preventDefault();
                            e.stopImmediatePropagation();
                            return false;
                        });
            swal({
                title: 'Aguarde...',
                text: 'A ação desejada foi efetuada. Por favor, aguarde o carregamento da página.',
                showCancelButton: false,
                confirmButtonText: "Aguarde...",
                closeOnConfirm: false,
            },
            function(){

            });
        }


        $('input').each(function(){
            if(!isChrome && !isSafari){
                if($(this).attr('type') == 'date'){
                    if($(this).val() !== ''){
                        data = $(this).val();
                        data = data.split('/');
                        if(data.length > 0){
                            data = data[2] + '-' + data[1] + '-' + data[0];
                            $(this).inputmask('9999-99-99');
                            $(this).val(data);
                        }
                    }
                }
            }
        });

        // $('.mask-date').each(function(){
        //     // alert('oi');
        //     // if(!isChrome && !isSafari){
        //         if($(this).attr('type') == 'text'){
        //             if($(this).val() !== ''){
        //                 data = $(this).val();
        //                 data = data.split('/');
        //                 if(data.length > 0){
        //                     data = data[2] + '-' + data[1] + '-' + data[0];
        //                     $(this).inputmask('9999-99-99');
        //                     $(this).val(data);
        //                 }
        //             }
        //         }
        //     // }
        // })
        // return true;
    });
})

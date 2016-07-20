$(function(){
    $('.mask-cpf').each(function(){
        $(this).inputmask('999.999.999-99');
    })

    $('.mask-cnpj').each(function(){
        $(this).inputmask('99.999.999/9999-99')
    })

    $('.mask-cpfcnpj').focusout(function(){
        valor = $(this).val();

    	if(valor.length == 11){
    		$(this).inputmask('999.999.999-99');
    		$(this).val(valor);
    	}

    	if(valor.length == 14){
    		$(this).inputmask('99.999.999/9999-99');
    		$(this).val(valor);
    	}
    })

    // Telefone
    $('.mask-phone').each(function(){
        $(this).inputmask('(99) 9999-99999');
    })
    $('.mask-phone').focusout(function(){
        valor = $(this).val();
        ultimo = valor.substr(valor.length - 1);

        if(valor.length == 15 || valor.length == 0){
            if(ultimo != '_' || ultimo == ''){
                $(this).inputmask('(99) 99999-9999');
            }else{
                $(this).inputmask('(99) 9999-9999');
            }
        }
    })
    $('.mask-phone').keyup(function(e){
        valor = $(this).val();
        if(e.keyCode == 8){
            if(valor == '')
                $(this).inputmask('(99) 9999-99999');
        }
    })

    $('.mask-date').each(function(){
        if(!isChrome && !isSafari){
            if($(this).attr('type') == 'date'){
                if($(this).val() != 'dd/mm/yyyy'){
                    if($(this).val() === ''){
                        $(this).inputmask('99/99/9999');
                    }else{
                        data = $(this).val();
                        data = data.split('-');

                        if(data.length === 3){
                            data = data[2] + '/' + data[1] + '/' + data[0];
                            $(this).inputmask('99/99/9999');
                            $(this).val(data);
                        }
                    }
                }
            }
        }
    })

    $('.mask-cep').each(function(){
        $(this).inputmask('99999-999');
    })

    $('.mask-money').each(function(){
        $(this).maskMoney({thousands:'.', decimal:',', allowZero:true, prefix: 'R$'});
    })

    $('.mask-time').each(function(){
        $(this).inputmask('99:99');
    })

    $('.mask-timeInterval').each(function(){
        $(this).inputmask('99:99 - 99:99');
    })

    $('.mask-datetime').each(function(){
        $(this).inputmask('99/99/9999 99:99');
    })

    $('.mask-dateinterval').each(function(){
        $(this).inputmask('99/99/9999 - 99/99/9999');
    })

    // Porcentagem
    $('.mask-percentage').focusout(function(){
        if($(this).val() != ''){
            if($(this).val().slice(-1) != '%'){
                if(Number($(this).val()) == $(this).val())
                    $(this).val($(this).val().toString() + '%');
                else
                    $(this).val('');
            }
        }
    })
    $('.mask-percentage').each(function(){
        $(this).keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A, Command+A
                (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });    
    })

})

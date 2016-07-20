$(function(){

    // orcamentoEscolherForma.php

    $('.tipo').on('change', function(){
        tipo = $(this).val();
        if(tipo == 'qtd'){
            $('#desconto').remove();
            $('#divDesconto').append('<input id="desconto" name="valDesconto" class="form-control">');
            $('#desconto').maskMoney({thousands:'.', decimal:',', allowZero:true, prefix: 'R$'});


            $('#desconto').on('change', function(){
                validaEntrada();
            })

        }else{
            $('#desconto').remove();
            $('#divDesconto').append('<input id="desconto" name="valDesconto" class="form-control">');


            $('#desconto').on('change', function(){
                validaEntrada();
            })


            $('#desconto').focusout(function(){
                if($(this).val() != ''){
                    if($(this).val().slice(-1) != '%'){
                        if(Number($(this).val()) == $(this).val())
                            $(this).val($(this).val().toString() + '%');
                        else
                            $(this).val('');
                    }
                }
            })
            $('#desconto').each(function(){
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
        }
        validaEntrada();
    })

    $('#entrada').on('change', function(){
        validaEntrada();
    })

    $('#desconto').on('change', function(){
        validaEntrada();
    })
})


function transformaNumero(valor, porcentagem){
    valor = valor.replace('R$', '');
    valor = valor.replace('%', '');
    if(!porcentagem)
        valor = valor.replace('.', '');
    valor = valor.replace(',', '.');
    return valor;
}

function validaEntrada(){
    entrada = $('#entrada').val();
    if(entrada == '')
        entrada = 'R$0,00';

    entrada = Number(transformaNumero(entrada, false));
    valor = $('#valor').html();
    if(valor == '')
        return false;
    valor = Number(transformaNumero(valor, false));

    if(entrada > valor)
        swal('A entrada não pode ser superior ao valor do orçamento.');
    else
        valor = valor - entrada


    desconto = $('#desconto').val();
    if(desconto != ''){
        tipo = $('input[name=indTipoDesconto]:checked').val()
        if(tipo == 'qtd'){
            desconto = transformaNumero($('#desconto').val(), false);
            if(valor < desconto)
                swal('O desconto não pode ser superior ao valor do orçamento.');
            else
                valor = valor - desconto;
        }else{
            desconto = desconto.replace('%', '');
            desconto = Number(desconto);
            desconto = desconto / 100;
            valorNovo = Number(valor) - Number((Number(valor) * Number(desconto)));
            if(valorNovo < 0)
                swal('O desconto não pode ser superior ao valor do orçamento.');
            else
                valor = valorNovo
        }
    }

    $('#restante').text('R$'+number_format(valor, 2, ',', '.'))
}


function number_format(number, decimals, dec_point, thousands_sep) {
    //  discuss at: http://phpjs.org/functions/number_format/
    // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: davook
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Theriault
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Michael White (http://getsprink.com)
    // bugfixed by: Benjamin Lupton
    // bugfixed by: Allan Jensen (http://www.winternet.no)
    // bugfixed by: Howard Yeend
    // bugfixed by: Diogo Resende
    // bugfixed by: Rival
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    //  revised by: Luke Smith (http://lucassmith.name)
    //    input by: Kheang Hok Chin (http://www.distantia.ca/)
    //    input by: Jay Klehr
    //    input by: Amir Habibi (http://www.residence-mixte.com/)
    //    input by: Amirouche
    //   example 1: number_format(1234.56);
    //   returns 1: '1,235'
    //   example 2: number_format(1234.56, 2, ',', ' ');
    //   returns 2: '1 234,56'
    //   example 3: number_format(1234.5678, 2, '.', '');
    //   returns 3: '1234.57'
    //   example 4: number_format(67, 2, ',', '.');
    //   returns 4: '67,00'
    //   example 5: number_format(1000);
    //   returns 5: '1,000'
    //   example 6: number_format(67.311, 2);
    //   returns 6: '67.31'
    //   example 7: number_format(1000.55, 1);
    //   returns 7: '1,000.6'
    //   example 8: number_format(67000, 5, ',', '.');
    //   returns 8: '67.000,00000'
    //   example 9: number_format(0.9, 0);
    //   returns 9: '1'
    //  example 10: number_format('1.20', 2);
    //  returns 10: '1.20'
    //  example 11: number_format('1.20', 4);
    //  returns 11: '1.2000'
    //  example 12: number_format('1.2000', 3);
    //  returns 12: '1.200'
    //  example 13: number_format('1 000,50', 2, '.', ' ');
    //  returns 13: '100 050.00'
    //  example 14: number_format(1e-8, 8, '.', '');
    //  returns 14: '0.00000001'

    number = (number + '')
        .replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}
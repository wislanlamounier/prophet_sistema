$(function(){
    $('#btnDesmarcar').on('click', function(){
        $('input[type=checkbox]').each(function(){
            $(this).prop('checked', false);
        });
    });
    
    $('#btnMarcar').on('click', function(){
        $('input[type=checkbox]').each(function(){
            $(this).attr('checked', true);
        });
    });
});
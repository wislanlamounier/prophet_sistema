$(function () {
    // Pertencente à página consulta/cadastrar.php


    clicou = false;

    oldJson = '';
    cdnDentista = 'null';

    function getDates(){
        var curr = new Date; // get current date
        var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
        var last = first + 6; // last day is the first day + 6

        var firstday = new Date(curr.setDate(first));
        var lastday = new Date(curr.setDate(last));

        day = firstday.getDate();
        if(day < 10){
            day = '0' + day;
        }

        month = firstday.getMonth();
        month += 1;
        if(month < 10){
            month = '0' + month;
        }
        firstday = firstday.getFullYear() + '-' + month + '-' + day;

        month = lastday.getMonth();
        month += 1;
        if(month < 10){
            month = '0' + month;
        }
        day = lastday.getDate();
        if(day < 10){
            day = '0' + day;
        }
        lastday = lastday.getFullYear() + '-' + month + '-' + day;

        dates = [firstday, lastday];
        return dates;
    }

    $('#iptCdnDentista').on('change', function(e){
        cdnDentista = $(this).val();
        $('#calendario').fullCalendar('destroy');

        $('#divAgenda').show();

        if(clicou)
            $('#calendario').fullCalendar('destroy');
        clicou = true;
        montarCalendario([], false, 'basicWeek', false);

    });




    function montarCalendario(json, primeiro, view, date){
        if(date !== false){
            defaultDate = moment(date);
        }else{
            defaultDate = moment();
        }
        $('#calendario').fullCalendar({
            height: 400,
            lang: 'pt-br',
                header: {
                left: 'prev,next,today',
                center: 'title',
                right: 'month,basicWeek,basicDay'
            },
            buttonText: {
                today: 'hoje',
                month: 'mês',
                week: 'semana',
                day: 'dia'
            },
            defaultView: view,
            defaultDate: defaultDate,
            events: json,
            eventClick: function(calEvent, jsEvent, view) {
                $.ajax({
                    type: "GET",
                    url: "index.php",
                    data: { controle : "agenda", acao : "agendaConsultaVisualizar", param : calEvent.id }
                }).done(function(html){
                    swal({
                        title: 'Agenda geral',
                        html: html
                    });
                })
            },

            dayClick: function(date, allDay, jsEvent, view) {
                $('#calendario').fullCalendar('gotoDate', date);
                $('#calendario').fullCalendar('changeView', 'basicDay');
            },

            viewRender: function(view, element){

                if(!primeiro){
                    m = $.fullCalendar.moment(view.intervalStart);
                    inicio = m.format();
                    m = $.fullCalendar.moment(view.intervalEnd);
                    final = m.format();
                    dates = [inicio, final];
                    
                    $.ajax({
                        type: "GET",
                        url: "index.php",
                        data: { controle : "agenda", acao : "agendaConsultaJson", param: cdnDentista, dates: dates}
                    }).done(function(json){
                        $('#calendario').fullCalendar('destroy');
                        json = $.parseJSON(json);
                        montarCalendario(json, true, view.name, inicio);
                    });
                }else{
                    primeiro = false;
                }
            }

        });

    }

    $('#iptCdnDentista').trigger('change');
});

$(function () {

    clicou = false;

    function getDates(){
        var curr = new Date; // get current date
        var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
        var last = first + 6; // last day is the first day + 6

        var firstday = new Date(curr.setDate(first));
        var lastday = new Date(curr.setDate(last));


        month = firstday.getMonth();
        month += 1;
        if(month < 10){
            month = '0' + month;
        }
        firstday = firstday.getFullYear() + '-' + month + '-' + firstday.getDate();

        month = lastday.getMonth();
        month += 1;
        if(month < 10){
            month = '0' + month;
        }
        lastday = lastday.getFullYear() + '-' + month + '-' + lastday.getDate()
        dates = [firstday, lastday];
        return dates;
    }

    $('#divAgenda').show();
    /* initialize the external events

    // ini_events($('#external-events div.external-event'));

    /* initialize the calendar
    -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)



    $('#iptCdnConsultorio').on('change', function(e){
        cdnConsultorio = $(this).val();
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
                        data: { controle : "agenda", acao : "agendaConsultorioJson", param: cdnConsultorio, dates: dates}
                    }).done(function(json){
                        // alert(json);
                        // return;
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

    $('#iptCdnConsultorio').trigger('change');
});

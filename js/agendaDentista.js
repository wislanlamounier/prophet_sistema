$(function () {



    // ESTE ARQUIVO NÃO ESTÁ MAIS SENDO UTILIZADO.




    clicou = false;

    $('#iptCdnDentista').on('select2:close', function (e) {
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "agenda", acao: "agendaDentistaJson", param: $(this).val()}
        }).done(function (json) {

            json = $.parseJSON(json);
            /* initialize the external events
             -----------------------------------------------------------------*/
            function ini_events(ele) {
                ele.each(function () {

                    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                    // it doesn't need to have a start or end
                    var eventObject = {
                        title: $.trim($(this).text()) // use the element's text as the event title
                    };

                    // store the Event Object in the DOM element so we can get to it later
                    $(this).data('eventObject', eventObject);

                    // make the event draggable using jQuery UI
                    $(this).draggable({
                        zIndex: 1070,
                        revert: true, // will cause the event to go back to its
                        revertDuration: 0  //  original position after the drag
                    });

                });
            }
            // ini_events($('#external-events div.external-event'));

            /* initialize the calendar
             -----------------------------------------------------------------*/
            //Date for the calendar events (dummy data)
            var date = new Date();
            var d = date.getDate(),
                    m = date.getMonth(),
                    y = date.getFullYear();


            if (clicou)
                $('#calendario').fullCalendar('destroy');
            clicou = true;
            $('#calendario').fullCalendar({
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
                defaultView: 'basicWeek',
                //Random default events
                events: json,
                eventClick: function (calEvent, jsEvent, view) {
                    $.ajax({
                        type: "GET",
                        url: "index.php",
                        data: {controle: "agenda", acao: "agendaConsultaVisualizar", param: calEvent.id}
                    }).done(function (html) {
                        swal({
                            title: 'Agenda geral',
                            html: html
                        });
                    })
                },
                dayClick: function (date, allDay, jsEvent, view) {
                    $('#calendario').fullCalendar('gotoDate', date);
                    $('#calendario').fullCalendar('changeView', 'basicDay');
                }

            });
            // $('#calendario').fullCalendar('render');
        });
    });

    $('#iptCdnDentista').trigger('select2:close');
});

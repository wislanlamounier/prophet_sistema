$(function () {

    function getDates() {
        var curr = new Date; // get current date
        var first = curr.getDate() - curr.getDay(); // First day is the day of the month - the day of the week
        var last = first + 6; // last day is the first day + 6

        var firstday = new Date(curr.setDate(first));
        var lastday = new Date(curr.setDate(last));


        month = firstday.getMonth();
        month += 1;
        if (month < 10) {
            month = '0' + month;
        }
        firstday = firstday.getFullYear() + '-' + month + '-' + firstday.getDate();

        month = lastday.getMonth();
        month += 1;
        if (month < 10) {
            month = '0' + month;
        }
        lastday = lastday.getFullYear() + '-' + month + '-' + lastday.getDate()
        dates = [firstday, lastday];
        return dates;
    }

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
    ini_events($('#external-events div.external-event'));

    dates = getDates('basicWeek');
    $('#divAgenda').show();

    montarCalendario([], false, 'basicWeek', false);


    function atualizarHorario(evento) {
        datInicio = evento.start;
        datFim = evento.end;
        allDay = !datInicio.hasTime();
        if (datFim === null) {
            datFim = datInicio.year() + '-' + (datInicio.month() + 1) + '-' + datInicio.date() + ' ' + (datInicio.hour() + 2) + ':' + datInicio.minute() + ':00';
        } else {
            datFim = datFim.year() + '-' + (datFim.month() + 1) + '-' + datFim.date() + ' ' + datFim.hour() + ':' + datFim.minute() + ':00';
        }
        datInicio = datInicio.year() + '-' + (datInicio.month() + 1) + '-' + datInicio.date() + ' ' + datInicio.hour() + ':' + datInicio.minute() + ':00';
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "agendaEvento", acao: "agendaEventoAtualizarHorario", param: evento.id, datInicio: datInicio, datFim: datFim, allDay: allDay}
        }).done(function (msg) {

        })
    }

    function atualizarEvento(cdnEvento) {
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "agendaEvento", acao: "agendaEventoAtualizar", param: cdnEvento}
        }).done(function (html) {
            swal({
                title: 'Atualizar evento',
                html: html,
                showCancelButton: true,
                confirmButtonText: "Atualizar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    desEvento = $('#desEvento').val();
                    cdnTipoEvento = $('#cdnTipoEvento').val();
                    cdnCliente = $('#cdnCliente').val();
                    if (typeof cdnCliente === 'undefined')
                        cdnCliente = 0;
                    if (cdnTipoEvento == '') {
                        swal('Erro!', 'Informe o tipo de evento.', 'error');
                    } else {
                        $.ajax({
                            type: "GET",
                            url: "index.php",
                            data: {controle: "agendaEvento", acao: "agendaEventoAtualizarFim", param: cdnEvento, desEvento: desEvento, cdnTipoEvento: cdnTipoEvento, cdnCliente: cdnCliente}
                        }).done(function (msg) {
                            if (msg == parseInt(msg)) {
                                swal('Sucesso!', 'Evento atualizado com sucesso.', 'success');
                                $(location).attr('href', '/agenda/calendario');
                            } else {
                                swal('Erro!', 'Um problema ocorreu na atualizacao.', 'error');
                            }
                        })
                    }
                }
            });
        })
    }

    function deletarEvento(cdnEvento) {
        swal({
            title: "Deletar evento?",
            text: "Tem certeza que quer deletar este evento do sistema?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Sim, deletar!",
            cancelButtonText: "Nao, cancelar!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "GET",
                            url: "index.php",
                            data: {controle: 'agendaEvento', acao: 'agendaEventoDeletarFim', param: cdnEvento},
                        })
                                .done(function (msg) {
                                    swal("Deletado!", "O evento foi deletado.", "success");
                                    $(location).attr('href', '/agenda/calendario');
                                });
                    } else {
                        swal("Cancelado", "O evento não foi deletado.", "error");
                    }
                }
        );
    }

    function finalizaCadastro(backgroundColor, borderColor, originalEventObject, date, allDay, id) {

        // retrieve the dropped element's stored Event Object
        // var originalEventObject = evento.data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);
        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.id = id;
        copiedEventObject.backgroundColor = backgroundColor;
        copiedEventObject.borderColor = borderColor;
        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendario').fullCalendar('renderEvent', copiedEventObject, true);
    }

    function cadastraNoBanco(backgroundColor, borderColor, originalEventObject, date, allDay, cdnTipoEvento) {
        date2 = date.year() + '-' + (date.month() + 1) + '-' + date.date() + ' ' + date.hour() + ':' + date.minute() + ':00';

        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "agendaEvento", acao: "agendaEventoCadastrarFim", param: date2, allDay: allDay, cdnTipoEvento: cdnTipoEvento}
        }).done(function (msg) {
            if (msg == parseInt(msg)) {
                finalizaCadastro(backgroundColor, borderColor, originalEventObject, date, allDay, msg);
                swal('Sucesso!', 'Evento cadastrado com sucesso.', 'success');
            } else {
                swal('Erro!', 'Algum problema ocorreu. Tente novamente.', 'error');
            }
        });
    }

    $('.external-event').draggable({
        start: function (event, ui) {
            $(this).addClass('noclick');
        },
        stop: function (event, ui) {
            $(this).removeClass('noclick');
        }
    });

    $('.external-event').click(function () { // esse evento está errado
        if ($(this).hasClass('noclick')) {
            return;
        }
        id = $(this).attr('id');
        $(location).attr('href', '/agendaEvento/cadastrar/' + id);
    });

    function montarCalendario(json, primeiro, view, date) {
        
        if (date !== false) {
            defaultDate = moment(date);
        } else {
            defaultDate = moment();
        }

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
            defaultView: view,
            defaultDate: defaultDate,
            //Random default events
            events: json,
            editable: true,
            droppable: true,
            drop: function (date) {
                allDay = !date.hasTime();
                evento = $(this);
                cdnTipoEvento = evento.attr('id');
                var originalEventObject = evento.data('eventObject');
                var backgroundColor = evento.css('background-color');
                var borderColor = evento.css('border-color');
                cadastraNoBanco(backgroundColor, borderColor, originalEventObject, date, allDay, cdnTipoEvento);
            },
            eventClick: function (calEvent, jsEvent, view) {
                $.ajax({
                    type: "GET",
                    url: "index.php",
                    data: {controle: "agendaEvento", acao: "agendaEventoConsultarFim", param: calEvent.id}
                }).done(function (html) {
                    swal({
                        title: 'Consulta de evento',
                        html: html,
                        showCancelButton: true,
                        confirmButtonText: "Atualizar evento",
                        cancelButtonText: "Deletar evento",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    }, function (isConfirm) {
                        if (isConfirm) {
                            atualizarEvento(calEvent.id);
                        } else {
                            deletarEvento(calEvent.id);
                        }
                    });
                })
            },
            eventResize: function (event, jsEvent, ui, view) {
                atualizarHorario(event);
            },
            eventDrop: function (event, jsEvent, ui, view) {
                atualizarHorario(event);
            },
            dayClick: function (date, allDay, jsEvent, view) {
                $('#calendario').fullCalendar('gotoDate', date);
                $('#calendario').fullCalendar('changeView', 'basicDay');
            },
            viewRender: function (view, element) {
                if (!primeiro) {
                    m = $.fullCalendar.moment(view.intervalStart);
                    inicio = m.format();
                    m = $.fullCalendar.moment(view.intervalEnd);
                    final = m.format();
                    dates = [inicio, final];

                    $('#calendario').fullCalendar('destroy');
                    $.ajax({
                        type: "GET",
                        url: "index.php",
                        data: {controle: "agendaEvento", acao: "agendaEventoRetornaJson", dates: dates}
                    }).done(function (json) {

                        json = $.parseJSON(json);
                        montarCalendario(json, true, view.name, inicio);
                    });
                } else {
                    primeiro = false;
                }
            }


        });

    }

});

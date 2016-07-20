$(function () {

    /*
     #############################################################
     #							ATENÇÃO							#
     # MUDANÇAS REALIZADAS AQUI INTERFEREM NAS SEGUINTES PÁGINAS #
     # - consulta/cadastrar.php									#
     # - orcamento/cadastrar.php									#
     #############################################################
     */
    
    verificacoesPaciente($('input[name=cdnPaciente]').val());
    $('#cdnAreaAtuacao').on('select2:close', function () {
        mudaProcedimento();
        $('#divCdnSecao').html(' ');
        $('#datConsulta').datepicker('update', '');
    })
    cdnPaciente = '';
    cdnDentista = $('#iptCdnDentista').val();
    function mudaProcedimento() {
        id = $('#cdnAreaAtuacao').val();
        if (typeof (id) == 'undefined') {
            id = $('.iptCdnAreaAtuacao').val();
        }
        if (typeof id != 'undefined') {
            $.ajax({
                type: "GET",
                url: "index.php",
                data: {controle: "procedimento", acao: "procedimentoArea", param: id}
            }).done(function (select) {
                $('#divCdnProcedimento').html(select);
                $('#divCdnProcedimento').find('select.form-control').select2({
                    language: 'pt-BR'
                });
                $('#divCdnProcedimento').find('select.form-control').on("select2:close", function (e) {
                    mudaSecao($(this).val());
                })
                $('#divCdnProcedimento').find("select.form-control option:eq(0)").prop("selected", true);

                mudaSecao($('#divCdnProcedimento').find('select.form-control').val());
            })
        }
    }

    $('#indEnviarSms').on('change', function () {
        $('#numSegAntecedencia').attr('disabled', !$(this).prop('checked'));
        $('#divTelefone').toggle();
    })

    $('#iptCdnDentista').on("select2:close", function (e, cdnAreaAtuacao) {
        mudaAreaAtuacao(cdnAreaAtuacao);
        $('#datConsulta').datepicker('update', '');
        cdnDentista = $(this).val();

        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "dentista", acao: "dentistaConsultorio", param: cdnDentista}
        }).done(function (cdnConsultorio) {
            if (cdnConsultorio != 'nenhum') {
                $('#iptCdnConsultorio').select2('val', cdnConsultorio);
            }
        })

    })

    function mudaAreaAtuacao(cdnAreaAtuacao) {
        cdnAreaAtuacao = cdnAreaAtuacao || 0;
        id = $('#iptCdnDentista').val();
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "areaAtuacao", acao: "areaAtuacaoDentista", param: id}
        }).done(function (select) {
            $('#divAreaAtuacao').html(select);
            $('#divAreaAtuacao').find('select.form-control').select2({
                language: 'pt-BR'
            });
            $('#divAreaAtuacao').find('select.form-control').on("select2:close", function (e) {
                mudaProcedimento();
                $('#datConsulta').datepicker('update', '');
                $('#divCdnSecao').html(' ');
            })
            if (cdnAreaAtuacao == 0) {
                $('#divAreaAtuacao').find("select.form-control option:eq(0)").prop("selected", true);
            } else {
                $('#divAreaAtuacao').find("select.form-control").select2('val', cdnAreaAtuacao);
            }

            mudaProcedimento();
        })
    }

    function mudaDentista() {
        id = $('#cdnAreaAtuacao').val();
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "dentista", acao: "dentistaArea", param: id}
        }).done(function (select) {
            $('#divCdnDentista').html(select);
            cdnDentista = $('.iptCdnDentista').val();
            $('#horaConsulta').remove();
            $('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
            $('#horaConsulta').inputmask('99:99');
        })
    }

    hoje = new Date();
    hoje = hoje.getDate() + '/' + (hoje.getMonth() + 1) + '/' + hoje.getFullYear();
    $('#datConsulta').datepicker({
        language: 'pt-BR',
        format: "dd/mm/yyyy",
        default: 'dd/mm/yyyy',
        startDate: hoje
    }).on('changeDate', function () {
        var dateElement = $('#datConsulta').val().split("/");
        var dateFormat = dateElement[2] + '-' + dateElement[1] + '-' + dateElement[0];
        var date = new Date(dateFormat);
        var weekday = ["Segunda", "Terca", "Quarta", "Quinta", "Sexta", "Sabado", "Domingo"];
        var day = weekday[date.getDay()];

        mudaHorario($('#datConsulta').val());
        checaFechado($('#datConsulta').val());
        montaHorarios($('#datConsulta').val(), day);
    })
    $(document).on('click', '.iptCdnDentista', function () {
        cdnDentista = $(this).val();
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "dentista", acao: "dentistaDiasSemanaArray", param: $(this).val()}
        }).done(function (disabled_days) {
            disabled_days = eval(disabled_days);
            $('#datConsulta').datepicker('setDaysOfWeekDisabled', disabled_days);
            $('#datConsulta').datepicker('update', '');
        })
    })

    function mudaHorario(data) {
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "consulta", acao: "consultaVerificaData", datConsulta: data, cdnDentista: cdnDentista}
        }).done(function (lista) {
            if (lista == false) {
                $('#divHorarios').html(' ');
                $('#divHorarios').hide();
            } else {
                $('#divHorarios').show();
                $('#divHorarios').html(lista);
            }
        })

    }

    function checaFechado(data) {
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "dentista", acao: "dentistaVerificaFechado", param: data, cdnDentista: cdnDentista}
        }).done(function (lista) {
            if (lista == false) {
                $('#divFechado').html(' ');
                $('#divFechado').hide();
            } else {
                $('#divFechado').show();
                $('#divFechado').html(lista);
            }
        })
    }

    function montaHorarios(data, diaSemana) {
        if (data != '') {
            if (typeof (cdnDentista) != 'undefined') {
                if (!$('#indEncaixe').prop('checked')) {
                    $.ajax({
                        type: "GET",
                        url: "index.php",
                        data: {controle: "dentista", acao: "dentistaMontaHorarios", param: cdnDentista, datConsulta: data}
                    }).done(function (lista) {

                        if (lista == 'nenhum') {
                            $('#horaConsulta').remove();
                            $('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
                            $('#horaConsulta').inputmask('99:99');
                            $('#horaConsulta').on('change', function () {
                                verificaHorario($(this).val());
                            })
                            $('#divHorarios').text('O dentista não possui horários disponíveis nesta data!');
                            $('#divHorarios').show();
                            return;
                        }
                        if (lista == 'nconfigurado') {
                            $('#horaConsulta').remove();
                            $('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
                            $('#horaConsulta').inputmask('99:99');
                            $('#horaConsulta').on('change', function () {
                                verificaHorario($(this).val());
                            })
                            return;
                        }
                        lista = $.parseJSON(lista);
                        lista = lista[diaSemana];
                        if (typeof lista != 'undefined') {
                            if (typeof lista.length != 'undefined') {
                                $('#horaConsulta').remove();
                                $('#horario').append('<select name="horaConsulta" class="form-control" id="horaConsulta">');
                                for (i = 0; i < lista.length; i++) {
                                    horario = lista[i];
                                    if (horario.length != 3)
                                        $('#horaConsulta').append('<option value="' + lista[i] + '">' + lista[i] + '</option>');
                                }
                                $('#horario').append('</select>');
                                $('#horaConsulta').on('change', function () {
                                    verificaHorario($(this).val());
                                })
                            }
                        } else {
                            $('#horaConsulta').remove();
                            $('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
                            $('#horaConsulta').inputmask('99:99');
                            $('#divHorarios').text('O dentista não possui horários disponíveis nesta data!');
                            $('#divHorarios').show();
                            $('#horaConsulta').on('change', function () {
                                verificaHorario($(this).val());
                            })
                            return;
                        }


                    })
                }
            }
        }
    }

    $('#indEncaixe').click(function () {
        $('#numHorarios').attr('disabled', $(this).prop('checked'));
        $('#numHorarios').val(0);
        $('#numHorarios').trigger('change');
        if ($(this).prop('checked')) {
            $('#horaConsulta').remove();
            $('#horario').append('<input type="text" id="horaConsulta" name="horaConsulta" class="form-control">');
            $('#horaConsulta').inputmask('99:99');
            $('#horaConsulta').on('change', function () {
                verificaHorario($(this).val());
            })
        } else {
            $('#datConsulta').trigger('changeDate');
        }
    })

    $('#numHorarios').on('change', function () {
        if ($('#horaConsulta').val() != '') {
            hora = $('#horaConsulta').val().split(':')[0];
            minuto = $('#horaConsulta').val().split(':')[1];
            if (hora < 24 && minuto < 59) {
                $.ajax({
                    type: "GET",
                    url: "index.php",
                    data: {controle: "dentista", acao: "dentistaTempoConsulta", param: $('#horaConsulta').val(), cdnDentista: cdnDentista, numHorarios: $(this).val()}
                }).done(function (hora) {
                    if (hora != '') {
                        $('#divEsperado').show();
                        $('#divEsperado').html(hora);
                    } else {
                        $('#divEsperado').hide();
                        $('#divEsperado').html(' ');
                    }
                })
            } else {
                $('#divEsperado').hide();
                $('#divEsperado').html(' ');
            }
        } else {
            $('#divEsperado').hide();
            $('#divEsperado').html(' ');
        }
    })


    function mudaSecao(id) {
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "secao", acao: "secaoArea", param: id}
        }).done(function (select) {
            $('#divCdnSecao').html(select);
            $('#divCdnSecao').find('select.form-control').select2({
                language: 'pt-BR'
            });
            $('#divCdnSecao').find("select.form-control option:eq(0)").prop("selected", true);
        })
    }

    $('#fechaModalPaciente').on('click', function () {
        verificacoesPaciente(cdnPacienteMODAL);
    })
    
    function verificacoesPaciente(cdnPaciente){
        if (cdnPaciente != '') {
            
            $.ajax({
                type: "GET",
                url: "index.php",
                data: {controle: "paciente", acao: "pacienteVerificaCadastro", param: cdnPaciente}
            }).done(function (verificacao) {
                if (verificacao != '') {
                    $('#divCadastro').show();
                    $('#divCadastro').html(verificacao);
                } else {
                    $('#divCadastro').hide();
                    $('#divCadastro').html(' ');
                }
            })

            $.ajax({
                type: "GET",
                url: "index.php",
                data: {controle: "paciente", acao: "pacienteVerificaTelefone", param: cdnPaciente}
            }).done(function (verificacao) {
                if (verificacao != '') {
                    $('#divTelefoneErr').show();
                    $('#divTelefoneErr').html(verificacao);
                } else {
                    $('#divTelefoneErr').hide();
                    $('#divTelefoneErr').html(' ');
                }
            })

            $.ajax({
                type: "GET",
                url: "index.php",
                data: {controle: "procedimento", acao: "procedimentoAviso", param: cdnPaciente}
            }).done(function (verificacao) {
                if (verificacao != '') {
                    $('#divProcedimento').show();
                    $('#divProcedimento').html(verificacao);
                } else {
                    $('#divProcedimento').hide();
                    $('#divProcedimento').html(' ');
                }
            })

            $.ajax({
                type: "GET",
                url: "index.php",
                data: {controle: "secao", acao: "secaoAviso", param: cdnPaciente}
            }).done(function (verificacao) {
                if (verificacao != '') {
                    $('#divSecao').show();
                    $('#divSecao').html(verificacao);
                } else {
                    $('#divSecao').hide();
                    $('#divSecao').html(' ');
                }
            })

            $.ajax({
                type: "GET",
                url: "index.php",
                data: {controle: "desmarque", acao: "desmarqueAviso", param: cdnPaciente}
            }).done(function (verificacao) {
                if (verificacao != '') {
                    $('#divDesmarque').show();
                    $('#divDesmarque').html(verificacao);
                } else {
                    $('#divDesmarque').hide();
                    $('#divDesmarque').html(' ');
                }
            })

            $.ajax({
                type: "GET",
                url: "index.php",
                data: {controle: "clinica", acao: "clinicaProntuarioAviso", param: cdnPaciente}
            }).done(function (verificacao) {
                if (verificacao != '') {
                    $('#divProntuario').show();
                    $('#divProntuario').html(verificacao);
                } else {
                    $('#divProntuario').hide();
                    $('#divProntuario').html(' ');
                }
            })

            $.ajax({
                type: "GET",
                url: "index.php",
                data: {controle: "paciente", acao: "pacienteRetornaTelefone", param: cdnPaciente}
            }).done(function (telefone) {
                $('#numTelefone').val(telefone);
            })

        } else {
            $('#divCadastro').hide();
            $('#divCadastro').html(' ');

            $('#divProcedimento').hide();
            $('#divProcedimento').html(' ');

            $('#divSecao').hide();
            $('#divSecao').html(' ');

            $('#divProntuario').hide();
            $('#divProntuario').html(' ');

            $('#divDesmarque').hide();
            $('#divDesmarque').html(' ');
        }
    }

    function verificaHorario(horaConsulta) {
        datConsulta = $('#datConsulta').val();
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "consulta", acao: "consultaVerificaExistente", horaConsulta: horaConsulta, datConsulta: datConsulta, cdnDentista: cdnDentista}
        }).done(function (back) {
            if (back == 'ndisponivel') {
                swal({
                    title: 'Atenção!',
                    text: 'Já existe uma consulta neste horário para este dia.',
                    type: 'error'
                });
            }
            if (back == 'bloqueado') {
                swal({
                    title: 'Atenção!',
                    text: 'Este horário está bloqueado por outra consulta. Não será possível realizar a marcação.',
                    type: 'error'
                });
            }
        })
    }

    $('#horaConsulta').on('change', function () {
        verificaHorario($(this).val());
    })
})

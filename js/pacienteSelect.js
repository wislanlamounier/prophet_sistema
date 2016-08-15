$(function () {

    cdnPacienteMODAL = '';
    nomPacienteMODAL = '';

    $('#nomPaciente').on('click', function () {
        if (typeof cdnOrcamentoMODAL != 'undefined')
            if (cdnOrcamentoMODAL != '')
                return false;
        $('#modalPaciente').modal('toggle');
    })

    $('#modalPaciente').on('show.bs.modal', function (event) {

        if (typeof table == 'undefined') {
            opts = {
                "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                "aaSorting": [],
                "serverside": true,
                "ajax": {
                    "url": "index.php?controle=json&acao=jsonPacientes&param=modal",
                    "type": "GET"
                },
                "language": {
                    "url": "plugins/datatables_new/datatables.portuguese.lang"
                }
            }

            table = $('#selectpaciente').dataTable(opts);
        }


    });
    $('#selectpaciente tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            cdnPacienteMODAL = '';
            nomPacienteMODAL = 'Selecionar paciente...';
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            cdnPacienteMODAL = $(this).find('td:first').text();
            nomPacienteMODAL = $(this).find('td:last').text();
        }

    });

    $('#fechaModalPaciente').on('click', function () {
        $('#nomPaciente').text(nomPacienteMODAL);

        $('input[name=cdnPaciente]').val(cdnPacienteMODAL);

        //$('input[name=cdnOrcamento]').val('');
        //$('#cdnOrcamento').text('Selecionar orçamento...');


    })



    $('#novoPaciente').click(function () {
        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "paciente", acao: "pacienteCadastrarSwal"}
        }).done(function (html) {
            swal({
                title: 'Cadastrar paciente',
                html: html,
                showCancelButton: true,
                confirmButtonText: "Cadastrar",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    cadastraPaciente();
                } else {
                    swal('Cancelado', 'O paciente não foi cadastrado.', 'error');
                }
            });
        })
    })



    function cadastraPaciente() {
        nomPaciente = $('#nomPacienteSwal').val();
        if (nomPaciente == '') {
            swal('Erro!', 'Informe o nome do paciente.', 'error');
            return;
        }


        if ($('#nomSobrenomeSwal').length > 0) {
            nomSobrenome = $('#nomSobrenomeSwal').val();
            if (nomSobrenome == '') {
                swal('Erro!', 'Informe o sobrenome do paciente.', 'error');
                return;
            }
        } else {
            nomSobrenome = '';
        }

        if ($('#numTelefone1Swal').length > 0) {
            numTelefone1 = $('#numTelefone1Swal').val();
        } else {
            numTelefone1 = '';
        }

        $.ajax({
            type: "GET",
            url: "index.php",
            data: {controle: "paciente", acao: "pacienteCadastrarSwalFim", nomPaciente: nomPaciente, nomSobrenome: nomSobrenome, numTelefone: numTelefone1}
        }).done(function (retorno) {
            if (retorno == 0) {
                swal('Erro!', 'Parece que algum erro ocorreu. Por favor, tente novamente.', 'error');
            } else {
                retorno = $.parseJSON(retorno);
                nomPacienteMODAL = retorno.nomPaciente;
                cdnPacienteMODAL = retorno.cdnPaciente;

                $('#nomPaciente').text(nomPacienteMODAL);

                $('input[name=cdnPaciente]').val(cdnPacienteMODAL);

                $('#selectpaciente').dataTable().fnDestroy();
                $('#selectpaciente tbody').html(' ');
                $('#fechaModalPaciente').trigger('click');

                swal({
                    title: 'Sucesso!',
                    text: 'Paciente cadastrado com sucesso.',
                    type: 'success',
                    timer: 1000
                });
            }
        });
    }

})

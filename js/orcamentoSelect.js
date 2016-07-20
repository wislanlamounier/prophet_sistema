$(function(){
    // deve ser colocado após o script "pacienteSelect.js"
	cdnOrcamentoMODAL = '';
    cdnProcedimentoMODAL = '';
    nomProcedimentoMODAL = '';
	cdnDentistaMODAL = '';
	cdnAreaAtuacaoMODAL = '';

	$('#cdnOrcamento').on('click', function(){
		$('#modalOrcamento').modal('toggle');
	})

	$('#modalOrcamento').on('show.bs.modal', function (event) {

		if(typeof tableOrcamento == 'undefined'){
			opts = {
				"aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
				"aaSorting": [],
				"serverside" : true,
				"ajax" : {
					"url" : "index.php?controle=json&acao=jsonOrcamentos&param=modal",
					"type" : "GET"
				},
				"language": {
					"url": "plugins/datatables_new/datatables.portuguese.lang"
				}
			}

			tableOrcamento = $('#selectorcamento').dataTable(opts);
		}


	});
	$('#selectorcamento tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            cdnPacienteMODAL = '';
            nomPacienteMODAL = 'Selecionar paciente...';
            cdnOrcamentoMODAL = '';
        }else {
            tableOrcamento.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            cdnOrcamentoMODAL = $(this).find('td:first').text();
	        cdnPacienteMODAL = $(this).find('td:last').text();
            nomPacienteMODAL = $(this).find('td:not(:first-child):not(:last-child)').text();
        }
    });

	$('#fechaModalOrcamento').on('click', function(){
		if(cdnOrcamentoMODAL != ''){
			if(parseInt(cdnOrcamentoMODAL) == cdnOrcamentoMODAL){
		        $('#fechaModalPaciente').trigger('click');
		        $('input[name=cdnOrcamento]').val(cdnOrcamentoMODAL);
		        $('#cdnOrcamento').text('Orçamento número ' + cdnOrcamentoMODAL);

		        //Delete the datable object first
		        if(typeof tableProcedimento != 'undefined'){
		            if(tableProcedimento != null) tableProcedimento.fnDestroy();
		            //Remove all the DOM elements
		            $('#selectprocedimento tbody').empty();

		            tableProcedimento = 'destruct';
		        }
			}
		}
	})










    $('#cdnOrcamentoProcedimento').on('click', function(){
        $('#modalProcedimento').modal('toggle');
    })

    $('#modalProcedimento').on('show.bs.modal', function (event) {
        if(cdnOrcamentoMODAL != ''){
            if(typeof tableProcedimento == 'undefined' || tableProcedimento == 'destruct'){
                opts = {
                    "aLengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                    "aaSorting": [],
                    "serverside" : true,
                    "ajax" : {
                        "url" : "index.php?controle=json&acao=jsonProcedimentos&param="+cdnOrcamentoMODAL,
                        "type" : "GET"
                    },
                    "language": {
                        "url": "plugins/datatables_new/datatables.portuguese.lang"
                    }
                }

                tableProcedimento = $('#selectprocedimento').dataTable(opts);
            }
        }


    });
    $('#selectprocedimento tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
            nomProcedimentoMODAL = 'Selecionar procedimento...';
            cdnProcedimentoMODAL = '';
        }else {
            tableProcedimento.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            cdnProcedimentoMODAL = $(this).find('td:first').text();
            nomProcedimentoMODAL = $(this).find('td:first').next().text();

            cdnAreaAtuacaoMODAL = $(this).find('td:first').next().next().text();
			cdnAreaAtuacaoMODAL = cdnAreaAtuacaoMODAL.split('-');
			cdnAreaAtuacaoMODAL = cdnAreaAtuacaoMODAL[1].trim();

			cdnDentistaMODAL = $(this).find('td:first').next().next().next().text();
			cdnDentistaMODAL = cdnDentistaMODAL.split('-');
			cdnDentistaMODAL = cdnDentistaMODAL[1].trim();
        }
    });

    $('#fechaModalProcedimento').on('click', function(){
		if(parseInt(cdnProcedimentoMODAL) == cdnProcedimentoMODAL){
			$('input[name=cdnOrcamentoProcedimento]').val(cdnProcedimentoMODAL);
			$('#cdnOrcamentoProcedimento').text(nomProcedimentoMODAL);
			if(cdnProcedimentoMODAL != ''){
				$('#iptCdnDentista').select2('val', cdnDentistaMODAL);
				$('#iptCdnDentista').trigger('select2:close', cdnAreaAtuacaoMODAL);
			}else{
				$('#iptCdnDentista').trigger('select2:close');
			}
		}
    })

	$('#resetarOrcamento').on('click', function(){
		cdnOrcamentoMODAL = '';
	    cdnProcedimentoMODAL = '';
	    nomProcedimentoMODAL = 'Selecionar procedimento...';
		cdnDentistaMODAL = '';
		cdnAreaAtuacaoMODAL = '';
		$('#cdnOrcamento').text('Selecionar orçamento...');
		$('#fechaModalProcedimento').trigger('click');
		$('input[name=cdnOrcamento]').val(cdnOrcamentoMODAL);
		if(typeof tableProcedimento != 'undefined'){
            if(tableProcedimento != null) tableProcedimento.fnDestroy();
            //Remove all the DOM elements
            $('#selectprocedimento tbody').empty();

            tableProcedimento = 'destruct';
        }
		tableOrcamento.$('tr.selected').removeClass('selected');
		// no back basear-se somente no procedimento
	})

})

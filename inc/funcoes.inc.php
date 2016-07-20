<?php

$liberadas = array(
    'agendaEventoCadastrarFim',
    'agendaEventoCadastrar',
    'agendaEventoCadastrarFimMobile',
    'agendaEventoValidaData',
    'agendaEventoValidaHorario',
    'agendaEventoConsultarFim',
    'agendaEventoAtualizar',
    'agendaEventoAtualizarMobile',
    'agendaEventoAtualizarMobileFim',
    'agendaEventoAtualizarFim',
    'agendaEventoAtualizarHorario',
    'agendaEventoDeletarFim',
    'agendaEventoRetornaJson',
    'agendaTipoEventoCadastrar',
    'agendaTipoEventoCadastrarFim',
    'agendaTipoEventoAtualizar',
    'agendaTipoEventoAtualizarFim',
    'agendaTipoEventoConsultar',
    'agendaTipoEventoDeletar',
    'agendaTipoEventoDeletarFim',
    'colaboradorInicio',
    'dentistaInicio',
    'dentistaFecharAgenda',
    'estiloCadastrarFim',
    'estiloAtualizar',
    'estiloAtualizarFim',
    'estiloGetJson',
    'mainLogin',
    'mainLoginFim',
    'mainSairFim',
    'mainIdle',
    'mainIdleFim',
    'mainSairIdle',
    'mainMaster',
    'mainDesfazerMaster',
    'mainBackup',
    'mainBackupFim',
    'mainDownloadBackup',
    'mainPermissao',
    'pacienteVerificaCpf',
    'pacienteVerificaCnpj',
    'pacienteVerificaNascimento',
    'pacienteFormularioRespLegal',
    'pacienteVerificaCadastro',
    'procedimentoAviso',
    'prontuarioVerificaDatas',
    'prontuarioAviso',
    'secaoAviso',
    'usuarioInicio',
    'campoExiste',
    'orcamentoAprovar',
    'orcamentoAprovarFim',
    'inicio',
    'consultaJsonGraficoInicio',
    'orcamentoTaxa',
);

$bloqueadas = array(
    // Agenda
    'agenda1' => 'agendaCalendario',
    'agenda2' => 'agendaConsulta',
    'agenda3' => 'agendaConsultaJson',
    'agenda4' => 'agendaConsultaVisualizar',
    'agenda5' => 'agendaConsultorio',
    'agenda6' => 'agendaConsultorioJson',
    'agenda7' => 'agendaConsultorioImprimir',
    'agenda8' => 'agendaConsultorioImprimirFim',
    'agenda9' => 'agendaDetista',
    'agenda10' => 'agendaDentistaJson',
    'agenda11' => 'agendaDentistaImprimir',
    'agenda12' => 'agendaDentistaImprimirFim',
    
    // Área de atuação
    'areaAtuacao1' => 'areaAtuacaoCadastrar',
    'areaAtuacao2' => 'areaAtuacaoCadastrarFim',
    'areaAtuacao3' => 'areaAtuacaoAtualizar',
    'areaAtuacao4' => 'areaAtuacaoAtualizarFim',
    'areaAtuacao5' => 'areaAtuacaoConsultar',
    'areaAtuacao6' => 'areaAtuacaoConsultarFim',
    'areaAtuacao7' => 'areaAtuacaoDeletar',
    'areaAtuacao8' => 'areaAtuacaoDeletarFim',
    'areaAtuacao9' => 'areaAtuacaoRetornaSelect',
    'areaAtuacao10' => 'areaAtuacaoDentista',
    'areaAtuacao11' => 'areaAtuacaoAdicionarProcedimento',
    
    // Visualização dos campos
    'campo1' => 'campoOrdenacao',
    'campo2' => 'campoOrdenacaoFim',
    'campo3' => 'campoCallbackExiste',
    'campo4' => 'campoExiste',
    
    // Dados da clínica
    'clinica1' => 'clinicaAtualizar',
    'clinica2' => 'clinicaAtualizarFim',
    'clinica3' => 'clinicaConsultarFim',
    'clinica4' => 'clinicaDisponivel',
    'clinica5' => 'clinicaDisponivelFim',
    'clinica6' => 'clinicaProntuarioAviso',
    
    // Clínicas radiologicas
    'clinicaRadiologica1' => 'clinicaRadiologicaCadastrar',
    'clinicaRadiologica2' => 'clinicaRadiologicaCadastrarFim',
    'clinicaRadiologica3' => 'clinicaRadiologicaAtualizar',
    'clinicaRadiologica4' => 'clinicaRadiologicaAtualizarFim',
    'clinicaRadiologica5' => 'clinicaRadiologicaConsultar',
    'clinicaRadiologica6' => 'clinicaRadiologicaConsultarFim',
    'clinicaRadiologica7' => 'clinicaRadiologicaDeletar',
    'clinicaRadiologica8' => 'clinicaRadiologicaDeletarFim',
    
    // Colaborador
    'colaborador1' => 'colaboradorCadastrar',
    'colaborador2' => 'colaboradorCadastrarFim',
    'colaborador3' => 'colaboradorAtualizar',
    'colaborador4' => 'colaboradorAtualizarFim',
    'colaborador5' => 'colaboradorConsultar',
    'colaborador6' => 'colaboradorConsultarFim',
    'colaborador7' => 'colaboradorDeletar',
    'colaborador8' => 'colaboradorDeletarFim',
    
    // Consulta
    'consulta1' => 'consultaCadastrar',
    'consulta2' => 'consultaCadastrarFim',
    'consulta3' => 'consultaDesmarcadas',
    'consulta4' => 'consultaConsultar',
    'consulta5' => 'consultaCosultarFim',
    'consulta6' => 'consultaVerificaData',
    'consulta7' => 'consultaAtestado',
    'consulta8' => 'consultaAtestadoFim',
    'consulta9' => 'consultaRemarcar',
    'consulta10' => 'consultaRemarcarFim',
    'consulta11' => 'consultaData',
    'consulta12' => 'consultaVerificaExistente',
    'consulta13' => 'consultaCadastrarAviso',
    'consulta14' => 'consultaCadastrarAvisoFim',
    'consulta15' => 'consultaMudarAviso',
    'consulta16' => 'consultaMudarAvisoFim',

    // Consultório
    'consultorio1' => 'consultorioCadastrar',
    'consultorio2' => 'consultorioCadastrarFim',
    'consultorio3' => 'consultorioAtualizar',
    'consultorio4' => 'consultorioAtualizarFim',
    'consultorio5' => 'consultorioConsultar',
    'consultorio6' => 'consultorioConsultarFim',
    'consultorio7' => 'consultorioDeletar',
    'consultorio8' => 'consultorioDeletarFim',
    'consultorio9' => 'consultorioRetornaSelect',
    
    // Cronometro
    'cronometro1' => 'cronometroSalaEspera',
    'cronometro2' => 'cronometroConsultorio',
    'cronometro3' => 'cronometroChegada',
    'cronometro4' => 'cronometroChegadaFim',
    'cronometro5' => 'cronometroEntrada',
    'cronometro6' => 'cronometroEntradaFim',
    'cronometro7' => 'cronometroSaida',
    'cronometro8' => 'cronometroSaidaFim',
    'cronometro9' => 'cronometroDeletar',
    'cronometro10' => 'cronometroDeletarFim',
    'cronometro11' => 'cronometroVoltar',
    'cronometro12' => 'cronometroVoltarFim',
    
    // Dentista
    'dentista1' => 'dentistaCadastrar',
    'dentista2' => 'dentistaCadastrarFim',
    'dentista3' => 'dentistaAtualizar',
    'dentista4' => 'dentistaAtualizarFim',
    'dentista5' => 'dentistaConsultar',
    'dentista6' => 'dentistaConsultarFim',
    'dentista7' => 'dentistaDeletar',
    'dentista8' => 'dentistaDeletarFim',
    'dentista9' => 'dentistaAdicionarArea',
    'dentista10' => 'dentistaDiasFechadosArray',
    'dentista11' => 'dentistaDiasSemanaArray',
    'dentista12' => 'dentistaRetornaSelect',
    'dentista13' => 'dentistaArea',
    'dentista14' => 'dentistaTempoConsulta',
    'dentista15' => 'dentistaVerificaFechado',
    'dentista16' => 'dentistaAbrirAgenda',
    'dentista17' => 'dentistaAbrirAgendaFim',
    'dentista18' => 'dentistaDeletarAberto',
    'dentista19' => 'dentistaDeletarAbertoFim',
    'dentista20' => 'dentistaDeletarFechado',
    'dentista21' => 'dentistaDeletarFechadoFim',
    'dentista22' => 'dentistaFecharAgenda',
    'dentista23' => 'dentistaFecharAgendaFim',
    'dentista24' => 'dentistaMontaHorarios',
    
    // Dependente
    'dependente1' => 'dependenteCadastrar',
    'dependente2' => 'dependenteCadastrarFim',
    'dependente3' => 'dependenteDeletar',
    'dependente4' => 'dependenteDeletarFim',
    
    // Desmarque
    'desmarque1' => 'desmarqueCadastrar',
    'desmarque2' => 'desmarqueCadastrarFim',
    'desmarque3' => 'desmarqueCancelar',
    'desmarque4' => 'desmarqueCancelarFim',
    'desmarque5' => 'desmarqueAviso',
    
    // Falta
    'falta1' => 'faltaCadastrar',
    'falta2' => 'faltaCadastrarFim',
    'falta3' => 'faltaDesmarcar',
    'falta4' => 'faltaDesmarcarFim',
    
    // Anamnese
    'anamnese1' => 'anamneseConsultar',
    'anamnese2' => 'anamneseConsultarFim',
    'anamnese3' => 'anamneseImprimir',
    'anamnese4' => 'anamneseImprimirFim',
    'anamnese5' => 'anamneseResponder',
    'anamnese6' => 'anamneseResponderFim',
    
    // Fornecedor
    'fornecedor1' => 'fornecedorCadastrar',
    'fornecedor2' => 'fornecedorCadastrarFim',
    'fornecedor3' => 'fornecedorAtualizar',
    'fornecedor4' => 'fornecedorAtualizarFim',
    'fornecedor5' => 'fornecedorConsultar',
    'fornecedor6' => 'fornecedorConsultarFim',
    'fornecedor7' => 'fornecedorDeletar',
    'fornecedor8' => 'fornecedorDeletarFim',
    
    // Frase
    'frase1' => 'fraseCadastrar',
    'frase2' => 'fraseCadastrarFim',
    'frase3' => 'fraseAtualizar',
    'frase4' => 'fraseAtualizarFim',
    'frase5' => 'fraseConsultar',
    'frase6' => 'fraseConsultarFim',
    'frase7' => 'fraseDeletar',
    'frase8' => 'fraseDeletarFim',
    'frase9' => 'fraseAtivar',
    'frase10' => 'fraseAtivarFim',
    
    // Main
    'main1' => 'mainConfiguracoes',
    'main2' => 'mainConfiguracoesFim',
    'main3' => 'mainPerfil',
    
    // Paciente
    'paciente1' => 'pacienteCadastrar',
    'paciente2' => 'pacienteCadastrarFim',
    'paciente3' => 'pacienteAtualizar',
    'paciente4' => 'pacienteAtualizarFim',
    'paciente5' => 'pacienteConsultar',
    'paciente6' => 'pacienteConsultarFim',
    'paciente7' => 'pacienteDeletar',
    'paciente8' => 'pacienteDeletarFim',
    'paciente9' => 'pacienteRetornaSelect',
    'paciente10' => 'pacienteRetornaCaracteristica',
    'paciente11' => 'pacienteDependentes',
    'paciente12' => 'pacienteCadastrarSwal',
    'paciente13' => 'pacienteCadastrarSwalFim',
    'paciente14' => 'pacienteRetornaTelefone',
    'paciente15' => 'pacienteVerificaTelefone',
    'paciente16' => 'pacienteVerificaNascimento',
    
    // Parceria
    'parceria1' => 'parceriaCadastrar',
    'parceria2' => 'parceriaCadastrarFim',
    'parceria3' => 'parceriaAtualizar',
    'parceria4' => 'parceriaAtualizarFIm',
    'parceria5' => 'parceriaConsultar',
    'parceria6' => 'parceriaConsultarFim',
    'parceria7' => 'parceriaDeletar',
    'parceria8' => 'parceriaDeletarFim',
    
    // Procedimento
    'procedimento1' => 'procedimentoCadastrar',
    'procedimento2' => 'procedimentoCadastrarFim',
    'procedimento3' => 'procedimentoAtualizar',
    'procedimento4' => 'procedimentoAtualizarFim',
    'procedimento5' => 'procedimentoConsultarFim',
    'procedimento6' => 'procedimentoDeletar',
    'procedimento7' => 'procedimentoDeletarFim',
    'procedimento8' => 'procedimentoRetornaSelect',
    'procedimento9' => 'procedimentoArea',
    
    // Prontuario
    'prontuario1' => 'prontuarioCadastrarTratamento',
    'prontuario2' => 'prontuarioCadastrarTratamentoFim',
    'prontuario3' => 'prontuarioAtualizarTratamento',
    'prontuario4' => 'prontuarioAtualizarTratamentoFim',
    'prontuario5' => 'prontuarioConsultar',
    'prontuario6' => 'prontuarioConsultarFim',
    'prontuario7' => 'prontuarioDeletarTratamento',
    'prontuario8' => 'prontuarioDeletarTratamentoFim',
    'prontuario9' => 'prontuarioImprimir',
    'prontuario10' => 'prontuarioImprimirFim',
    'prontuario11' => 'prontuarioVerAnexos',
    'prontuario12' => 'prontuarioAnexo',
    'prontuario13' => 'prontuarioAnexoFim',
    'prontuario14' => 'prontuarioAbrirAnexo',
    'prontuario15' => 'prontuarioDeletarAnexo',
    'prontuario16' => 'prontuarioDeletarAnexoFim',
    
    // Questionario
    'questionario1' => 'questionarioCadastrarPergunta',
    'questionario2' => 'questionarioCadastrarPerguntaFim',
    'questionario3' => 'questionarioAtualizarPergunta',
    'questionario4' => 'questionarioAtualizarPerguntaFim',
    'questionario5' => 'questionarioConsultar',
    'questionario6' => 'questionarioConsultarPergunta',
    'questionario7' => 'questionarioDeletarPerguta',
    'questionario8' => 'questionarioDeletarPerguntaFim',
    'questionario9' => 'questionarioVisualizacao',
    'questionario10' => 'questionarioVisualizacaoAtualizar',
    'questionario11' => 'questionarioCadastrarOpcao',
    'questionario12' => 'questionarioCadastrarOpcaoFim',
    'questionario13' => 'questionarioAtualizarOpcao',
    'questionario14' => 'questionarioAtualizarOpcaoFim',
    'questionario15' => 'questionarioDeletarOpcao',
    'questionario16' => 'questionarioDeletarOpcaoFim',
    'questionario17' => 'questionarioImprimir',
    
    // Secao
    'secao1' => 'secaoCadatrar',
    'secao2' => 'secaoCadastrarFim',
    'secao3' => 'secaoAtualizar',
    'secao4' => 'secaoAtualizarFim',
    'secao5' => 'secaoConsultarFim',
    'secao6' => 'secaoDeletar',
    'secao7' => 'secaoDeletarFim',
    'secao8' => 'secaoRetornaSelect',
    'secao9' => 'secaoArea',
    
    // SMS
    'sms1' => 'smsEnviar',
    'sms2' => 'smsEnviarFim',
    'sms3' => 'smsHistorico',
    'sms4' => 'smsConsultarFim',
    'sms5' => 'smsBaixarHistorico',
    'sms6' => 'smsBaixarHistoricoFim',
    'sms7' => 'smsRespostas',
    'sms8' => 'smsConfiguracoes',
    'sms9' => 'smsConfiguracoesFim',
    'sms10' => 'smsBaixarRespostas',
    'sms11' => 'smsBaixarRespostasFim',
    
    // Usuario
    'usuario1' => 'usuarioCadastrar',
    'usuario2' => 'usuarioCadastrarFim',
    'usuario3' => 'usuarioAtualizar',
    'usuario4' => 'usuarioAtualiarFim',
    'usuario5' => 'usuarioConsultar',
    'usuario6' => 'usuarioConsultarFim',
    'usuario7' => 'usuarioDeletar',
    'usuario8' => 'usuarioDeletarFim',
    
    // Permissao
    'permissao1' => 'permissaoAtualizar',
    'permissao2' => 'permissaoAtualizarFim',
    
    // Orçamento
    'orcamento1' => 'orcamentoCadastrar',
    'orcamento2' => 'orcamentoCadastrarFim',
    'orcamento3' => 'orcamentoConsultar',
    'orcamento4' => 'orcamentoConsultarFim',
    'orcamento5' => 'orcamentoNotaPromissoria',
    'orcamento6' => 'orcamentoCarne',
    'orcamento7' => 'orcamentoEscolherForma',
    'orcamento8' => 'orcamentoAprovarFim',
    'orcamento9' => 'orcamentoParcelaAtualizar',
    'orcamento10' => 'orcamentoParcelaAtualizarFim',
    
    // Pagamento
    'pagamento1' => 'pagamentoCadastrar',
    'pagamento2' => 'pagamentoCadastrarFim',
    
    // Json
    'json1' => 'jsonConsultas',
    'json2' => 'jsonParcerias',
    'json3' => 'jsonPacientes',
    'json4' => 'jsonProcedimentos',
    'json5' => 'jsonProntuarios',

    // Retorno
    'retorno1' => 'retornoConsultar',
    'retorno2' => 'retornoImprimir',
    'retorno3' => 'retornoImprimirFim',
);

$pacotes = array(
    'ControleAgenda' => array(
        'Visualizar' => array(
            'agenda1',
            'agenda2',
            'agenda3',
            'agenda4',
            'agenda5',
            'agenda6',
            'agenda7',
            'agenda8',
            'agenda9',
            'agenda10',
            'agenda11',
            'agenda12',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
        ),
    ),
    'ControleAreaAtuacao' => array(
        'Visualizar' => array(
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
        ),
        'Cadastrar' => array(
            'areaAtuacao1',
            'areaAtuacao2',
            'areaAtuacao9',
            'areaAtuacao10',
        ),
        'Editar' => array(
            // Tem que visualizar para editar
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            'areaAtuacao3',
            'areaAtuacao4',
        ),
        'Deletar' => array(
            // Tem que visualizar para deletar
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            'areaAtuacao7',
            'areaAtuacao8',
        )
    ),
    'ControleCampo' => array(
        'Ordenar' => array(
            'campo1',
            'campo2',
            'campo3',
            'campo4',
        ),
    ),
    'ControleClinica' => array(
        'Visualizar' => array(
            'clinica3',
        ),
        'Editar' => array(
            'clinica1',
            'clinica2',
            'clinica3',
        ),
    ),
    'ControleClinicaRadiologica' => array(
        'Visualizar' => array(
            'clinicaRadiologica5',
            'clinicaRadiologica6',
        ),
        'Cadastrar' => array(
            'clinicaRadiologica1',
            'clinicaRadiologica2',
        ),
        'Editar' => array(
            // Visualizar
            'clinicaRadiologica5',
            'clinicaRadiologica6',
            'clinicaRadiologica3',
            'clinicaRadiologica4',
        ),
        'Deletar' => array(
            // Visualizar
            'clinicaRadiologica5',
            'clinicaRadiologica6',
            'clinicaRadiologica7',
            'clinicaRadiologica8',
        ),
    ),
    'ControleColaborador' => array(
        'Visualizar' => array(
            'colaborador5',
            'colaborador6',
            'main3',
        ),
        'Cadastrar' => array(
            'colaborador1',
            'colaborador2',
        ),
        'Editar' => array(
            // Visualizar
            'colaborador5',
            'colaborador6',
            'colaborador3',
            'colaborador4',
        ),
        'Deletar' => array(
            // Visualizar
            'colaborador5',
            'colaborador6',
            'colaborador7',
            'colaborador8',
        ),
    ),
    'ControleConsulta' => array(
        'Visualizar' => array(
            'consulta4',
            'consulta5',
            'consulta3',
            'agenda1',
            'agenda2',
            'agenda3',
            'agenda4',
            'agenda5',
            'agenda6',
            'agenda7',
            'agenda8',
            'agenda9',
            'agenda10',
            'agenda11',
            'agenda12',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            'desmarque5',
            'json1',
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            // Visualizar procedimento
            'procedimento5',
            'procedimento9',
            // Visualizar consultório
            'consultorio5',
            'consultorio6',
            'consultorio9',
            // Visualizar secao
            'secao8',
            'secao9',
            // Retornos
            'retorno1',
            'retorno2',
            'retorno3',
        ),
        'Cadastrar' => array(
            'consulta1',
            'consulta2',
            'consulta6',
            'consulta11',
            'consulta12',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            // Visualizar desmarque
            'desmarque5',
            // Cadastrar paciente
            'paciente12',
            'paciente13',
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            // Visualizar procedimento
            'procedimento5',
            'procedimento9',
            // Visualizar consultório
            'consultorio5',
            'consultorio6',
            'consultorio9',
            // Visualizar secao
            'secao8',
            'secao9',
            // Visualizar retornos
            'retorno1',
            'retorno2',
            'retorno3',
        ),
        'Remarcar' => array(
            // Visualizar
            'consulta4',
            'consulta5',
            'consulta3',
            'consulta11',
            'consulta12',
            'agenda1',
            'agenda2',
            'agenda3',
            'agenda4',
            'agenda5',
            'agenda6',
            'agenda7',
            'agenda8',
            'agenda9',
            'agenda10',
            'agenda11',
            'agenda12',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            // Visualizar desmarque
            'desmarque5',
            'consulta9',
            'consulta10',
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            // Visualizar procedimento
            'procedimento5',
            'procedimento9',
            // Visualizar consultório
            'consultorio5',
            'consultorio6',
            'consultorio9',
            // Visualizar secao
            'secao8',
            'secao9',
            // Visualizar retornos
            'retorno1',
            'retorno2',
            'retorno3',
        ),
        'Atestado/Comunicacao' => array(
            // Visualizar
            'consulta4',
            'consulta5',
            'consulta3',
            'agenda1',
            'agenda2',
            'agenda3',
            'agenda4',
            'agenda5',
            'agenda6',
            'agenda7',
            'agenda8',
            'agenda9',
            'agenda10',
            'agenda11',
            'agenda12',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            'consulta7',
            'consulta8',
            // Visualizar retornos
            'retorno1',
            'retorno2',
            'retorno3',
        ),
    ),
    'ControleConsultorio' => array(
        'Visualizar' => array(
            'consultorio5',
            'consultorio6',
            'consultorio9',
        ),
        'Cadastrar' => array(
            'consultorio1',
            'consultorio2',
            'consultorio9',
        ),
        'Editar' => array(
            // Visualizar
            'consultorio5',
            'consultorio6',
            'consultorio9',
            'consultorio3',
            'consultorio4',
        ),
        'Deletar' => array(
            // Visualizar
            'consultorio5',
            'consultorio6',
            'consultorio9',
            'consultorio7',
            'consultorio8',
        ),
    ),
    'ControleCronometro' => array(
        'Controlar' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            'cronometro1',
            'cronometro2',
            'cronometro3',
            'cronometro4',
            'cronometro5',
            'cronometro6',
            'cronometro7',
            'cronometro8',
            'cronometro9',
            'cronometro10',
            'cronometro11',
            'cronometro12',
        ),
    ),
    'ControleDentista' => array(
        'Visualizar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            'main3',
            'dentista5',
            'dentista6',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            'dentista24',
        ),
        'Cadastrar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            'dentista1',
            'dentista2',
            'dentista9',
            'dentista24',
        ),
        'Editar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            // Visualizar
            'dentista5',
            'dentista6',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            'dentista3',
            'dentista4',
            'dentista24',
        ),
        'Deletar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            // Visualizar
            'dentista5',
            'dentista6',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            'dentista7',
            'dentista8',
        ),
        'Horarios' => array(
            'dentista16',
            'dentista17',
            'dentista18',
            'dentista19',
            'dentista20',
            'dentista21',
            'dentista22',
            'dentista23',
            
        )
    ),
    'ControleDesmarque' => array(
        'Cadastrar' => array(
            // Visualizar consulta
            'consulta4',
            'consulta5',
            'consulta3',
            'json1',
            'desmarque1',
            'desmarque2',
        ),
        'Deletar' => array(
            // Visualizar consulta
            'consulta4',
            'consulta5',
            'consulta3',
            'agenda1',
            'agenda2',
            'agenda3',
            'agenda4',
            'agenda5',
            'agenda6',
            'agenda7',
            'agenda8',
            'agenda9',
            'agenda10',
            'agenda11',
            'agenda12',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            'json1',
            'desmarque3',
            'desmarque4',
        ),
    ),
    'ControleFalta' => array(
        'Cadastrar' => array(
            // Visualizar consulta
            'consulta4',
            'consulta5',
            'consulta3',
            'agenda1',
            'agenda2',
            'agenda3',
            'agenda4',
            'agenda5',
            'agenda6',
            'agenda7',
            'agenda8',
            'agenda9',
            'agenda10',
            'agenda11',
            'agenda12',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            'json1',
            'falta1',
            'falta2',
        ),
        'Deletar' => array(
            // Visualizar consulta
            'consulta4',
            'consulta5',
            'consulta3',
            'agenda1',
            'agenda2',
            'agenda3',
            'agenda4',
            'agenda5',
            'agenda6',
            'agenda7',
            'agenda8',
            'agenda9',
            'agenda10',
            'agenda11',
            'agenda12',
            'dentista10',
            'dentista11',
            'dentista12',
            'dentista13',
            'dentista14',
            'dentista15',
            'json1',
            'falta3',
            'falta4',
        ),
    ),
    'ControleAnamnese' => array(
        'Visualizar' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            'anamnese1',
            'anamnese2',
        ),
        'Imprimir' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            // Visualizar
            'anamnese1',
            'anamnese2',
            'anamnese3',
            'anamnese4',
        ),
        'Responder' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            // Visualizar
            'anamnese1',
            'anamnese2',
            'anamnese5',
            'anamnese6',
        ),
    ),
    'ControleFornecedor' => array(
        'Visualizar' => array(
            'fornecedor5',
            'fornecedor6',
        ),
        'Cadastrar' => array(
            'fornecedor1',
            'fornecedor2',
        ),
        'Editar' => array(
            // Visualizar
            'fornecedor5',
            'fornecedor6',
            'fornecedor3',
            'fornecedor4',
        ),
        'Deletar' => array(
            // Visualizar
            'fornecedor5',
            'fornecedor6',
            'fornecedor7',
            'fornecedor8',
        ),
    ),
    'ControleFrase' => array(
        'Cadastrar' => array(
            'frase1',
            'frase2',
            'frase3',
            'frase4',
            'frase5',
            'frase6',
            'frase7',
            'frase8',
        ),
        'Controlar' => array(
            'frase9',
            'frase10',
        ),
    ),
    'ControleMain' => array(
        'Configuracoes' => array(
            'main1',
            'main2',
        ),
    ),
    'ControlePaciente' => array(
        'Visualizar' => array(
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            'paciente14',
            'paciente15',
            'paciente16',
            'json3',
        ),
        'Cadastrar' => array(
            'paciente1',
            'paciente2',
            'paciente9',
            'paciente10',
            'paciente11',
            'paciente12',
            'paciente13',
            'paciente14',
            'paciente15',
            'paciente16',
        ),
        'Editar' => array(
            // Visualizar
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            'paciente3',
            'paciente4',
            'paciente14',
            'paciente15',
            'paciente16',
        ),
        'Deletar' => array(
            // Visualizar
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            'paciente7',
            'paciente8',
            'paciente14',
            'paciente15',
            'paciente16',
        ),
    ),
    'ControleParceria' => array(
        'Visualizar' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            'parceria5',
            'parceria6',
            'json2',
        ),
        'Cadastrar' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            'paciente1',
            'paciente2',
        ),
        'Editar' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            // Visualizar
            'parceria5',
            'parceria6',
            'parceria3',
            'parceria4',
        ),
        'Deletar' => array(
            // Visualizar
            'parceria5',
            'parceria6',
            'parceria7',
            'parceria8',
        ),
    ),
    'ControleProcedimento' => array(
        'Visualizar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            'procedimento5',
            'procedimento9',
        ),
        'Cadastrar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            'procedimento1',
            'procedimento2',
        ),
        'Editar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            // Visualizar
            'procedimento5',
            'procedimento3',
            'procedimento4',
        ),
        'Deletar' => array(
            // Visualizar
            'procedimento5',
            'procedimento6',
            'procedimento7',
        ),
    ),
    'ControleProntuario' => array(
        'Visualizar' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            'prontuario5',
            'prontuario6',
        ),
        'Cadastrar tratamento' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            'prontuario1',
            'prontuario2',
        ),
        'Editar tratamento' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            // Visualizar
            'prontuario5',
            'prontuario6',
            'prontuario3',
            'prontuario4',
        ),
        'Deletar tratamento' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            // Visualizar
            'prontuario5',
            'prontuario6',
            'prontuario7',
            'prontuario8',
        ),
        'Imprimir' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            // Visualizar
            'prontuario5',
            'prontuario6',
            'prontuario9',
            'prontuario10',
        ),
        'Visualizar anexos' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            // Visualizar
            'prontuario5',
            'prontuario6',
            'prontuario11',
            'prontuario14',
        ),
        'Cadastrar anexo' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            // Visualizar
            'prontuario5',
            'prontuario6',
            'prontuario12',
            'prontuario13',
        ),
        'Deletar anexo' => array(
            // Visualizar pacientes
            'paciente5',
            'paciente6',
            'paciente9',
            'paciente10',
            'paciente11',
            // Visualizar
            'prontuario5',
            'prontuario6',
            'prontuario15',
            'prontuario16',
        ),
    ),
    'ControleQuestionario' => array(
        'Visualizar' => array(
            'questionario5',
            'questionario6',
        ),
        'Cadastrar' => array(
            'questionario1',
            'questionario2',
            'questionario11',
            'questionario12',
        ),
        'Editar' => array(
            // Visualizar
            'questionario5',
            'questionario6',
            'questionario3',
            'questionario4',
            'questionario13',
            'questionario14',
        ),
        'Deletar' => array(
            // Visualizar
            'questionario5',
            'questionario6',
            'questionario7',
            'questionario8',
            'questionario15',
            'questionario16',
        ),
        'Campos' => array(
            'questionario9',
            'questionario10',
        ),
        'Imprimir' => array(
            'questionario17',
        ),
    ),
    'ControleSecao' => array(
        'Visualizar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            // Visualizar procedimento
            'procedimento5',
            'procedimento9',
            'secao5',
            'secao8',
            'secao9',
        ),
        'Cadastrar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            // Visualizar procedimento
            'procedimento5',
            'procedimento9',
            'secao1',
            'secao2',
        ),
        'Editar' => array(
            // Visualizar area de atuação
            'areaAtuacao5',
            'areaAtuacao6',
            'areaAtuacao9',
            'areaAtuacao10',
            // Visualizar procedimento
            'procedimento5',
            'procedimento9',
            // Visualizar
            'secao5',
            'secao8',
            'secao9',
            'secao3',
            'secao4',
        ),
        'Deletar' => array(
            // Visualizar
            'secao5',
            'secao8',
            'secao9',
            'secao6',
            'secao7',
        ),
    ),
    'ControleSms' => array(
        'Visualizar' => array(
            'sms3',
            'sms4',
            'sms5',
            'sms6',
        ),
        'Respostas' => array(
            'sms7',
            'sms10',
            'sms11',
        ),
        'Configuracoes' => array(
            'sms8',
            'sms9',
        ),
        'Enviar' => array(
            'sms1',
            'sms2',
        ),
        'Controlar avisos' => array(
            // Visualizar
            'sms3',
            'sms4',
            'sms5',
            'sms6',

            // Respostas
            'sms7',

            // Enviar
            'sms1',
            'sms2',

            // Funções que na realidade estão no Controle Consulta
            'consulta13',
            'consulta14',
            'consulta15',
            'consulta16',
        ),
    ),
    'ControleUsuario' => array(
        'Visualizar' => array(
            'usuario5',
            'usuario6',
            'main3',
        ),
        'Cadastrar' => array(
            'usuario1',
            'usuario2',
        ),
        'Editar' => array(
            // Visualizar
            'usuario5',
            'usuario6',
            'usuario3',
            'usuario4',
        ),
        'Deletar' => array(
            // Visualizar
            'usuario5',
            'usuario6',
            'usuario7',
            'usuario8',
        ),
    ),
    'ControlePermissao' => array(
        'Controlar' => array(
            'permissao1',
            'permissao2',
        ),
    ),
    'ControleOrcamento' => array(
        'Visualizar' => array(
            'orcamento3',
            'orcamento4',
        ),
        'Cadastrar' => array(
            'orcamento1',
            'orcamento2',
            'orcamento9',
            'orcamento10',
        ),
        'Gerar nota promissoria' => array(
            'orcamento5',
        ),
        'Gerar carne' => array(
            'orcamento6',
        ),
        'Aprovar' => array(
            'orcamento7',
            'orcamento8',
        ),
    ),
    'ControlePagamento' => array(
        'Registrar pagamento' => array(
            // Visualizar orçamentos
            'orcamento3',
            'orcamento4',
            'pagamento1',
            'pagamento2',
        ),
    ),
);

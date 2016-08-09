<!DOCTYPE html>
<html>

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title><?php echo $titulo; ?> | Prophet</title>
    
    <base href="<?php echo BASE_URL; ?>">
    
    <link href="tema/css/bootstrap.min.css" rel="stylesheet">
    <link href="tema/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="tema/fontello/css/fontello.css" rel="stylesheet">
    <link href="tema/fontello/css/animation.css" rel="stylesheet">
    <link href="plugins/sweetalert2/dist/sweetalert2.css" rel="stylesheet">
    <!--[if IE 7]><link rel="stylesheet" href="tema/fontello/css/fontello-ie7.css"><![endif]-->
    <link href="tema/css/animate.css" rel="stylesheet">
    <link href="tema/css/style.css" rel="stylesheet">
    <link href="plugins/select2/dist/css/select2.css" rel="stylesheet" >


</head>

<body>
<!-- Conteúdo !-->
<div id="wrapper">
    
    <!-- Menu lateral !-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        
                        <!-- Imagem !-->
                        <!-- <span>
                            <img alt="image" class="img-circle" src="tema/img/profile_small.jpg" />
                        </span> -->
                        
                        <!-- Nome !-->
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear">
                                        <span class="block m-t-xs">
                                            <strong class="font-bold">
                                                <?php echo $_SESSION['nomUsuario']; ?>
                                            </strong>
                                        </span>
                                        <span class="text-muted text-xs block">
                                            <?php echo $_SESSION['nomClinica']; ?><b class="caret"></b>
                                        </span>
                                    </span>
                        </a>
                        <!-- Menu de usuário !-->
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li>
                                <?php echo $this->link($_SESSION['usuAtual'], 'consultarFim', 'Meu perfil', array($_SESSION['cdnUsuario'])); ?>
                            </li>
                            <li>
                                <?php echo $this->link('clinica', 'consultarFim', 'Clínica'); ?>
                            </li>
                            <li>
                                <?php echo $this->link('estilo', 'atualizar', 'Estilos', array($_SESSION['cdnUsuario'])); ?>
                            </li>
                            <li>
                                <?php echo $this->link('agenda', 'calendario', 'Agenda'); ?>
                            </li>
                            <li>
                                <?php echo $this->link('frase', 'consultar', 'Frases'); ?>
                            </li>
                            <li>
                                <?php echo $this->link('main', 'backup', 'Segurança da informação'); ?>
                            </li>
                        </ul>
                    </div>
                    
                    <!-- Logo quando está com sidebar fechada !-->
                    <div class="logo-element">
                        <?php echo $this->link($_SESSION['usuAtual'], 'consultarFim', 'Prophet', array($_SESSION['cdnUsuario'])); ?>
                    </div>
                </li>
                
                <!-- Menus !-->
                <li class="">
                    <a href="<?php echo BASE_URL; ?>">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">Início</span>
                    </a>
                </li>
                
                <li class="">
                    <a>
                        <i class="fa fa-sticky-note"></i>
                        <span class="nav-label">Orçamento</span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li class="visible-xs special_link">
                            <a>
                                Orçamento
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/orcamento/cadastrar">
                                <i class="fa fa-edit"></i>
                                Cadastrar
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/orcamento/consultar">
                                <i class="fa fa-list"></i>
                                Consultar
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/orcamento/relatorio">
                                <i class="fa fa-paperclip"></i>
                                Relatório
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="">
                    <a>
                        <i class="fa fa-calendar"></i>
                        <span class="nav-label">Consultas/Agenda</span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li class="visible-xs special_link">
                            <a>
                                Consulta/Agenda
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/consulta/cadastrar">
                                <i class="fa fa-calendar-plus-o"></i>
                                Marcar
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/consulta/consultar">
                                <i class="fa fa-list"></i>
                                Consultar
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/agenda/consulta">
                                <i class="fa fa-calendar-o"></i>
                                Ver agenda
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/consulta/consultaMapa">
                                <i class="fa fa-map-o"></i>
                                Ver Mapa
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/retorno/consultar">
                                <i class="fa fa-backward"></i>
                                Retornos
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a>
                        <i class="fa fa-group"></i>
                        <span class="nav-label">Pacientes</span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li class="visible-xs special_link">
                            <a>
                                Pacientes
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/paciente/consultar">
                                <i class="fa fa-bars"></i>
                                Consultar
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/paciente/cadastrar">
                                <i class="fa fa-edit"></i>
                                Cadastrar
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/campo/ordenacao/paciente">
                                <i class="fa fa-desktop"></i>
                                Visualização
                            </a>
                        </li>
                        <li>
                            <a>
                                <i class="fa fa-sticky-note-o"></i>
                                Prontuários
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a>
                                        <i class="fa fa-lock"></i>
                                        Ver prontuários
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/anamnese/consultar">
                                        <i class="fa fa-list"></i>
                                        Ver anamnese
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/questionario/consultar">
                                        <i class="fa fa-question"></i>
                                        Perguntas anamnese
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/questionario/visualizacao">
                                        <i class="fa fa-desktop"></i>
                                        Campos visualização
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a>
                                <i class="fa fa-building-o"></i>
                                Parcerias
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/parceria/consultar">
                                        <i class="fa fa-bars"></i>
                                        Consultar
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/parceria/cadastrar">
                                        <i class="fa fa-edit"></i>
                                        Cadastrar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="">
                            <a href="<?php echo BASE_URL; ?>/tabelaPreco/consultar">
                                <i class="fa fa-dollar"></i>
                                Tabelas de preço
                            </a>
                        </li>
                    
                    </ul>
                </li>
                <li class="">
                    <a>
                        <i class="fa fa-envelope"></i>
                        <span class="nav-label">Relacionamento</span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li class="visible-xs special_link">
                            <a>
                                Relacionamento
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/sms/historico">
                                <i class="fa fa-history"></i>
                                Histórico de SMS
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/sms/respostas">
                                <i class="fa fa-reply-all"></i>
                                Respostas
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/sms/configuracoes">
                                <i class="fa fa-cogs"></i>
                                Configurações de SMS
                            </a>
                        </li>
                    </ul>
                </li>
                <!--
                        <li class="">
                            <a>
                                <i class="fa fa-dollar"></i>
                                <span class="nav-label">Financeiro</span>
                            </a>
                            <ul class="nav nav-second-level collapse">
                                <li class="visible-xs special_link">
                                    <a>
                                        Financeiro
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/boleto/historico">
                                        <i class="fa fa-history"></i>
                                        Histórico de boletos
                                    </a>
                                </li>
                            </ul>
                        </li>
                        !-->
                <li class="">
                    <a>
                        <i class="fa fa-cogs"></i>
                        <span class="nav-label">Clínica</span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li class="visible-xs special_link">
                            <a>
                                Clínica
                            </a>
                        </li>
                        <li class="">
                            <a>
                                <i class="fa fa-truck"></i>
                                Fornecedores
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/fornecedor/consultar">
                                        <i class="fa fa-bars"></i>
                                        Consultar
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/fornecedor/cadastrar">
                                        <i class="fa fa-edit"></i>
                                        Cadastrar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a>
                                <i class="fa fa-flask"></i>
                                <small>Clínicas radiológicas</small>
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/clinicaRadiologica/consultar">
                                        <i class="fa fa-bars"></i>
                                        Consultar
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/clinicaRadiologica/cadastrar">
                                        <i class="fa fa-edit"></i>
                                        Cadastrar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a>
                                <i class="fa fa-building-o"></i>
                                Áreas de atuação
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/areaAtuacao/consultar">
                                        <i class="fa fa-bars"></i>
                                        Consultar
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/areaAtuacao/cadastrar">
                                        <i class="fa fa-edit"></i>
                                        Cadastrar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a>
                                <i class="icon-bed"></i>
                                Consultórios
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/consultorio/consultar">
                                        <i class="fa fa-bars"></i>
                                        Consultar
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/consultorio/cadastrar">
                                        <i class="fa fa-edit"></i>
                                        Cadastrar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a>
                                <i class="icon-tooth"></i>
                                Dentistas
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/dentista/consultar">
                                        <i class="fa fa-bars"></i>
                                        Consultar
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/dentista/cadastrar">
                                        <i class="fa fa-edit"></i>
                                        Cadastrar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a>
                                <i class="fa fa-suitcase"></i>
                                Colaboradores
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/colaborador/consultar">
                                        <i class="fa fa-bars"></i>
                                        Consultar
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/colaborador/cadastrar">
                                        <i class="fa fa-edit"></i>
                                        Cadastrar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="">
                            <a>
                                <i class="fa fa-male"></i>
                                Usuário Master
                                <span class="fa arrow"></span>
                            </a>
                            <ul class="nav nav-third-level collapse">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/usuario/consultar">
                                        <i class="fa fa-bars"></i>
                                        Consultar
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/usuario/cadastrar">
                                        <i class="fa fa-edit"></i>
                                        Cadastrar
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- Menus !-->
                        <li class="">
                            <a href="<?php echo BASE_URL; ?>/clinica/consultarFim">
                                <i class="fa fa-home"></i>
                                Dados da clínica
                            </a>
                        </li>
                        <li class="">
                            <a href="<?php echo BASE_URL; ?>/main/logs">
                                <i class="fa fa-history"></i>
                                Logs
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>/main/configuracoes">
                                <i class="fa fa-cogs"></i>
                                Configurações
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    
    <div id="page-wrapper">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header float-left">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary ">
                        <i class="fa fa-bars"></i>
                    </a>
                    <a class="minimalize-styl-2 btn btn-primary" onClick="history.go(-1);return true;">
                        <i class="fa fa-arrow-left"></i> Voltar
                    </a>
                    <a class="minimalize-styl-2 btn btn-primary visible-xs" href="<?php echo BASE_URL; ?>/main/sairFim">
                        <i class="fa fa-sign-out"></i> Sair
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right hidden-xs float-right">
                    <li>
                                <span class="m-r-sm text-muted welcome-message">
                                    <?php
                                        $nomUsuario = explode(' ', $_SESSION['nomUsuario'])[0];
                                        echo $this->link($_SESSION['usuAtual'], 'consultarFim', 'Olá, '.$nomUsuario.'!', array($_SESSION['cdnUsuario']));
                                    ?>
                                </span>
                    </li>
                    <?php
                        if($_SESSION['respostasNaoLidas'] > 0){
                            ?>
                            <li>
                                <a class="count-info" href="<?php echo BASE_URL; ?>/sms/respostas">
                                    <i class="fa fa-envelope"></i>
                                    <span class="label label-warning">
                                        <?php echo $_SESSION['respostasNaoLidas']; ?>
                                    </span>
                                </a>
                            </li>
                            <?php
                        }
                    ?>
                    <li>
                        <a href="<?php echo BASE_URL; ?>/main/sairFim">
                            <i class="fa fa-sign-out"></i> Sair
                        </a>
                    </li>
                </ul>
                <h3 class="text-center hidden-xs">Prophet - <?php echo $_SESSION['nomClinica']; ?></h3>
            
            </nav>
        </div>
        
        <div class="row page-heading" id="page-header-parent">
            <div class="col-md-12">
                <h2 class="white-font"><?php echo $titulo; ?></h2>
            </div>
        </div>
        <div class="wrapper-content">
            <?php include 'inc/getErrors.inc.php'; ?>
            <div class="row white-bg" id="conteudo">

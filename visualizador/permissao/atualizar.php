			
<?php
if (Modelo::donoStatic()) {
    if (!Modelo::masterStatic($cdnUsuario)) {
        ?>
        <div class="col-md-12">
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <a href="<?php echo BASE_URL; ?>/main/master/<?php echo $cdnUsuario; ?>">
                    <button type="button" class="btn btn-block btn-lg btn-primary">
                        Conceber permissões master
                    </button>
                </a>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div class="col-md-12">
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <a href="<?php echo BASE_URL; ?>/main/desfazerMaster/<?php echo $cdnUsuario; ?>">
                    <button type="button" class="btn btn-block btn-lg btn-primary">
                        Retirar permissões master
                    </button>
                </a>
            </div>
        </div>
        <?php
    }
}
?>
<br>
<div class="col-sm-4 col-sm-offset-2">
    <button type="button" id="btnDesmarcar" class="btn btn-default btn-lg btn-block">Desmarcar todas</button>
</div>
<div class="col-sm-4">
    <button type="button" id="btnMarcar" class="btn btn-default btn-lg btn-block">Marcar todas</button>
</div>
<br>
<div class="col-md-12">
    <form action="<?php echo BASE_URL; ?>/permissao/atualizarFim/<?php echo $cdnUsuario; ?>" method="post">

        <!-- Agenda !-->
        <div class="col-sm-6 form-group">

            <label for="ControleAgenda" class="control-label">Agenda</label><br>

            <!-- Visualizar !-->
            <input name="ControleAgenda[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleAgenda']) ? 'checked' : ''; ?>> 
            Visualizar

        </div>

        <!-- Campo !-->
        <div class="col-sm-6 form-group">

            <label for="ControleCampo" class="control-label">Campos de visualização</label><br>

            <!-- Ordenar !-->
            <input name="ControleCampo[]" type="checkbox" value="Ordenar" 
                   <?php echo in_array('Ordenar', $arrPacotes['ControleCampo']) ? 'checked' : ''; ?>> 
            Ordenar

        </div>

        <br>

        <!-- Área de atuação !-->
        <div class="col-md-12 form-group">
            <label for="ControleAreaAtuacao" class="control-label">Áreas de atuação</label><br>

            <!-- Visualizar !-->
            <input name="ControleAreaAtuacao[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleAreaAtuacao']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleAreaAtuacao[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleAreaAtuacao']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleAreaAtuacao[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleAreaAtuacao']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleAreaAtuacao[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleAreaAtuacao']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Clínica !-->
        <div class="col-sm-6 form-group">
            <label for="ControleClinica" class="control-label">Dados cadastrais da clínica</label><br>

            <!-- Visualizar !-->
            <input name="ControleClinica[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleClinica']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleClinica[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleClinica']) ? 'checked' : ''; ?>> 
            Editar

        </div>

        <!-- Cronômetro !-->
        <!--
        <div class="col-sm-6 form-group">
            <label for="ControleCronometro" class="control-label">Cronômetro</label><br>

        <!-- Controlar 
        <input name="ControleCronometro[]" type="checkbox" value="Controlar" 
        <?php //echo in_array('Controlar', $arrPacotes['ControleCronometro']) ? 'checked' : ''; ?>> 
        Controlar


    </div>
    !-->

        <br>

        <!-- Clínica radiológica !-->
        <div class="col-md-12 form-group">
            <label for="ControleClinicaRadiologica" class="control-label">Clínicas radiológicas</label><br>

            <!-- Visualizar !-->
            <input name="ControleClinicaRadiologica[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleClinicaRadiologica']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleClinicaRadiologica[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleClinicaRadiologica']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleClinicaRadiologica[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleClinicaRadiologica']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleClinicaRadiologica[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleClinicaRadiologica']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Colaboradores !-->
        <div class="col-md-12 form-group">
            <label for="ControleColaborador" class="control-label">Colaboradores</label><br>

            <!-- Visualizar !-->
            <input name="ControleColaborador[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleColaborador']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleColaborador[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleColaborador']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleColaborador[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleColaborador']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleColaborador[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleColaborador']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Consultas !-->
        <div class="col-md-12 form-group">
            <label for="ControleConsulta" class="control-label">Consultas</label><br>

            <!-- Visualizar !-->
            <input name="ControleConsulta[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleConsulta']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleConsulta[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleConsulta']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Remarcar !-->
            <input name="ControleConsulta[]" type="checkbox" value="Remarcar" 
                   <?php echo in_array('Remarcar', $arrPacotes['ControleConsulta']) ? 'checked' : ''; ?>> 
            Remarcar

            &nbsp;&nbsp;&nbsp;

            <!-- Atestado/Comunicacao !-->
            <input name="ControleConsulta[]" type="checkbox" value="Atestado/Comunicacao" 
                   <?php echo in_array('Atestado/Comunicacao', $arrPacotes['ControleConsulta']) ? 'checked' : ''; ?>> 
            Atestado/Comunicação

        </div>

        <br>

        <!-- Consultório !-->
        <div class="col-md-12 form-group">
            <label for="ControleConsultorio" class="control-label">Consultórios</label><br>

            <!-- Visualizar !-->
            <input name="ControleConsultorio[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleConsultorio']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleConsultorio[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleConsultorio']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleConsultorio[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleConsultorio']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleConsultorio[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleConsultorio']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Dentistas !-->
        <div class="col-md-12 form-group">
            <label for="ControleDentista" class="control-label">Dentistas</label><br>

            <!-- Visualizar !-->
            <input name="ControleDentista[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleDentista']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleDentista[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleDentista']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleDentista[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleDentista']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleDentista[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleDentista']) ? 'checked' : ''; ?>> 
            Deletar

            &nbsp;&nbsp;&nbsp;

            <!-- Horários !-->
            <input name="ControleDentista[]" type="checkbox" value="Horarios" 
                   <?php echo in_array('Horarios', $arrPacotes['ControleDentista']) ? 'checked' : ''; ?>> 
            Abrir/Fechar horários

        </div>

        <br>

        <!-- Desmarques !-->
        <div class="col-sm-6 form-group">
            <label for="ControleDesmarque" class="control-label">Desmarques</label><br>

            <!-- Cadastrar !-->
            <input name="ControleDesmarque[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleDesmarque']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleDesmarque[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleDesmarque']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <!-- Faltas !-->
        <div class="col-sm-6 form-group">
            <label for="ControleFalta" class="control-label">Faltas</label><br>

            <!-- Cadastrar !-->
            <input name="ControleFalta[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleFalta']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleFalta[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleFalta']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Anamnese !-->

        <div class="col-md-12 form-group">
            <label for="ControleAnamnese" class="control-label">Questionário anamnese</label><br>

        <!-- Visualizar -->
        <input name="ControleAnamnese[]" type="checkbox" value="Visualizar" 
        <?php echo in_array('Visualizar', $arrPacotes['ControleAnamnese']) ? 'checked' : ''; ?>>
        Visualizar

        &nbsp;&nbsp;&nbsp;

        <!-- Imprimir -->
        <input name="ControleAnamnese[]" type="checkbox" value="Imprimir" 
        <?php echo in_array('Imprimir', $arrPacotes['ControleAnamnese']) ? 'checked' : ''; ?>>
        Imprimir

        &nbsp;&nbsp;&nbsp;

        <!-- Responder -->
        <input name="ControleAnamnese[]" type="checkbox" value="Responder" 
        <?php echo in_array('Responder', $arrPacotes['ControleAnamnese']) ? 'checked' : ''; ?>>
        Responder

    </div>

        <br>

        <!-- Fornecedores !-->
        <div class="col-md-12 form-group">
            <label for="ControleFornecedor" class="control-label">Fornecedores</label><br>

            <!-- Visualizar !-->
            <input name="ControleFornecedor[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleFornecedor']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleFornecedor[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleFornecedor']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleFornecedor[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleFornecedor']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleFornecedor[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleFornecedor']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Frases da semana !-->
        <div class="col-sm-6 form-group">
            <label for="ControleFrase" class="control-label">Frases da semana</label><br>

            <!-- Cadastrar !-->
            <input name="ControleFrase[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleFrase']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Controlar !-->
            <input name="ControleFrase[]" type="checkbox" value="Controlar" 
                   <?php echo in_array('Controlar', $arrPacotes['ControleFrase']) ? 'checked' : ''; ?>> 
            Controlar

        </div>

        <!-- Configurações !-->
        <div class="col-sm-6 form-group">
            <label for="ControleMain" class="control-label">Configurações</label><br>

            <!-- Configuracoes !-->
            <input name="ControleMain[]" type="checkbox" value="Configuracoes" 
                   <?php echo in_array('Configuracoes', $arrPacotes['ControleMain']) ? 'checked' : ''; ?>> 
            Configurações

        </div>

        <br>

        <!-- Paciente !-->
        <div class="col-md-12 form-group">
            <label for="ControlePaciente" class="control-label">Pacientes</label><br>

            <!-- Visualizar !-->
            <input name="ControlePaciente[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControlePaciente']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControlePaciente[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControlePaciente']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControlePaciente[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControlePaciente']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControlePaciente[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControlePaciente']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Parcerias !-->
        <div class="col-md-12 form-group">
            <label for="ControleParceria" class="control-label">Parcerias</label><br>

            <!-- Visualizar !-->
            <input name="ControleParceria[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleParceria']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleParceria[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleParceria']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleParceria[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleParceria']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleParceria[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleParceria']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Procedimentos !-->
        <div class="col-md-12 form-group">
            <label for="ControleProcedimento" class="control-label">Procedimentos</label><br>

            <!-- Visualizar !-->
            <input name="ControleProcedimento[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleProcedimento']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleProcedimento[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleProcedimento']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleProcedimento[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleProcedimento']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleProcedimento[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleProcedimento']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Prontuários !-->
        <!--
        <div class="col-md-12 form-group">
            <label for="ControleProntuario" class="control-label">Prontuários</label><br>
            <!-- Visualizar 
            <input name="ControleProntuario[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleProntuario']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar tratamento 
            <input name="ControleProntuario[]" type="checkbox" value="Cadastrar tratamento" 
                   <?php echo in_array('Cadastrar tratamento', $arrPacotes['ControleProntuario']) ? 'checked' : ''; ?>> 
            Cadastrar tratamento

            &nbsp;&nbsp;&nbsp;

            <!-- Editar tratamento 
            <input name="ControleProntuario[]" type="checkbox" value="Editar tratamento" 
                   <?php echo in_array('Editar tratamento', $arrPacotes['ControleProntuario']) ? 'checked' : ''; ?>> 
            Editar tratamento

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar tratamento 
            <input name="ControleProntuario[]" type="checkbox" value="Deletar tratamento" 
                   <?php echo in_array('Deletar tratamento', $arrPacotes['ControleProntuario']) ? 'checked' : ''; ?>> 
            Deletar tratamento

            &nbsp;&nbsp;&nbsp;

            <!-- Imprimir 
            <input name="ControleProntuario[]" type="checkbox" value="Imprimir"
                   <?php echo in_array('Imprimir', $arrPacotes['ControleProntuario']) ? 'checked' : ''; ?>>
            Imprimir

            &nbsp;&nbsp;&nbsp;

            <!-- Visualizar anexos 
            <input name="ControleProntuario[]" type="checkbox" value="Visualizar anexos"
                   <?php echo in_array('Visualizar anexos', $arrPacotes['ControleProntuario']) ? 'checked' : ''; ?>>
            Visualizar anexos

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar anexo 
            <input name="ControleProntuario[]" type="checkbox" value="Cadastrar anexo"
                   <?php echo in_array('Cadastrar anexo', $arrPacotes['ControleProntuario']) ? 'checked' : ''; ?>>
            Cadastrar anexo

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar anexo 
            <input name="ControleProntuario[]" type="checkbox" value="Deletar anexo"
                   <?php echo in_array('Deletar anexo', $arrPacotes['ControleProntuario']) ? 'checked' : ''; ?>>
            Deletar anexo
        </div>
        !-->
        <br>

        <!-- Questionário !-->
        <div class="col-md-12 form-group">
            <label for="ControleQuestionario" class="control-label">Questionário</label><br>

        <!-- Visualizar !-->
        <input name="ControleQuestionario[]" type="checkbox" value="Visualizar" 
        <?php echo in_array('Visualizar', $arrPacotes['ControleQuestionario']) ? 'checked' : ''; ?>> 
        Visualizar

        &nbsp;&nbsp;&nbsp;

        <!-- Cadastrar !-->
        <input name="ControleQuestionario[]" type="checkbox" value="Cadastrar" 
        <?php echo in_array('Cadastrar', $arrPacotes['ControleQuestionario']) ? 'checked' : ''; ?>> 
        Cadastrar

        &nbsp;&nbsp;&nbsp;

        <!-- Editar !-->
        <input name="ControleQuestionario[]" type="checkbox" value="Editar" 
        <?php echo in_array('Editar', $arrPacotes['ControleQuestionario']) ? 'checked' : ''; ?>> 
        Editar

        &nbsp;&nbsp;&nbsp;

        <!-- Campos !-->
        <input name="ControleQuestionario[]" type="checkbox" value="Campos" 
        <?php echo in_array('Campos', $arrPacotes['ControleQuestionario']) ? 'checked' : ''; ?>> 
        Campos impressos

        &nbsp;&nbsp;&nbsp;

        <!-- Imprimir !-->
        <input name="ControleQuestionario[]" type="checkbox" value="Imprimir" 
        <?php echo in_array('Imprimir', $arrPacotes['ControleQuestionario']) ? 'checked' : ''; ?>> 
        Imprimir

    </div>

        <br>

        <!-- Seções de procedimento !-->
        <div class="col-md-12 form-group">
            <label for="ControleSecao" class="control-label">Seções de procedimento</label><br>

            <!-- Visualizar !-->
            <input name="ControleSecao[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleSecao']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleSecao[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleSecao']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleSecao[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleSecao']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleSecao[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleSecao']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- SMS !-->
        <div class="col-md-12 form-group">
            <label for="ControleSms" class="control-label">Envio de SMS</label><br>

            <!-- Visualizar !-->
            <input name="ControleSms[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleSms']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Respostas !-->
            <input name="ControleSms[]" type="checkbox" value="Respostas" 
                   <?php echo in_array('Respostas', $arrPacotes['ControleSms']) ? 'checked' : ''; ?>> 
            Respostas

            &nbsp;&nbsp;&nbsp;

            <!-- Configuracoes !-->
            <input name="ControleSms[]" type="checkbox" value="Configuracoes" 
                   <?php echo in_array('Configuracoes', $arrPacotes['ControleSms']) ? 'checked' : ''; ?>> 
            Configurações

            &nbsp;&nbsp;&nbsp;

            <!-- Enviar !-->
            <input name="ControleSms[]" type="checkbox" value="Enviar" 
                   <?php echo in_array('Enviar', $arrPacotes['ControleSms']) ? 'checked' : ''; ?>> 
            Enviar

            &nbsp;&nbsp;&nbsp;

            <!-- Controlar avisos !-->
            <input name="ControleSms[]" type="checkbox" value="Controlar avisos"
                    <?php echo in_array('Controlar avisos', $arrPacotes['ControleSms']) ? 'checked' : ''; ?>>
            Controlar avisos

        </div>

        <br>

        <!-- Usuários master !-->
        <div class="col-md-12 form-group">
            <label for="ControleUsuario" class="control-label">Usuários master</label><br>

            <!-- Visualizar !-->
            <input name="ControleUsuario[]" type="checkbox" value="Visualizar" 
                   <?php echo in_array('Visualizar', $arrPacotes['ControleUsuario']) ? 'checked' : ''; ?>> 
            Visualizar

            &nbsp;&nbsp;&nbsp;

            <!-- Cadastrar !-->
            <input name="ControleUsuario[]" type="checkbox" value="Cadastrar" 
                   <?php echo in_array('Cadastrar', $arrPacotes['ControleUsuario']) ? 'checked' : ''; ?>> 
            Cadastrar

            &nbsp;&nbsp;&nbsp;

            <!-- Editar !-->
            <input name="ControleUsuario[]" type="checkbox" value="Editar" 
                   <?php echo in_array('Editar', $arrPacotes['ControleUsuario']) ? 'checked' : ''; ?>> 
            Editar

            &nbsp;&nbsp;&nbsp;

            <!-- Deletar !-->
            <input name="ControleUsuario[]" type="checkbox" value="Deletar" 
                   <?php echo in_array('Deletar', $arrPacotes['ControleUsuario']) ? 'checked' : ''; ?>> 
            Deletar

        </div>

        <br>

        <!-- Permissões !-->
        <div class="col-md-12 form-group">
            <label for="ControlePermissao" class="control-label">Permissões</label><br>

            <!-- Controlar !-->
            <input name="ControlePermissao[]" type="checkbox" value="Controlar"
                   <?php echo in_array('Controlar', $arrPacotes['ControlePermissao']) ? 'checked' : ''; ?>>
            Controlar permissões

        </div>

        <br>

        <!-- Orçamentos !-->

        <div class="col-md-12 form-group">
            <label for="ControleOrcamento" class="control-label">Orçamentos e pagamentos</label><br>

        <!-- Visualizar !-->
        <input name="ControleOrcamento[]" type="checkbox" value="Visualizar" 
        <?php echo in_array('Visualizar', $arrPacotes['ControleOrcamento']) ? 'checked' : ''; ?>> 
        Visualizar

        &nbsp;&nbsp;&nbsp;

        <!-- Cadastrar !-->
        <input name="ControleOrcamento[]" type="checkbox" value="Cadastrar" 
        <?php echo in_array('Cadastrar', $arrPacotes['ControleOrcamento']) ? 'checked' : ''; ?>> 
        Cadastrar

        &nbsp;&nbsp;&nbsp;

        <!-- Gerar nota promissória !-->
        <input name="ControleOrcamento[]" type="checkbox" value="Gerar nota promissoria" 
        <?php echo in_array('Gerar nota promissoria', $arrPacotes['ControleOrcamento']) ? 'checked' : ''; ?>> 
        Gerar nota promissória

        &nbsp;&nbsp;&nbsp;

        <!-- Gerar carnê !-->
        <input name="ControleOrcamento[]" type="checkbox" value="Gerar carne" 
        <?php echo in_array('Gerar carne', $arrPacotes['ControleOrcamento']) ? 'checked' : ''; ?>> 
        Gerar carnê

        &nbsp;&nbsp;&nbsp;

        <!-- Registrar pagamento !-->
        <input name="ControlePagamento[]" type="checkbox" value="Registrar pagamento" 
        <?php echo in_array('Registrar pagamento', $arrPacotes['ControlePagamento']) ? 'checked' : ''; ?>> 
        Registrar pagamento

        &nbsp;&nbsp;&nbsp;

        <!-- Aprovar orçamento !-->
        <input name="ControleOrcamento[]" type="checkbox" value="Aprovar"
                <?php echo in_array('Aprovar', $arrPacotes['ControleOrcamento']) ? 'checked' : ''; ?>>
        Aprovar orçamentos

    </div>

        <br>
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <button type="submit" class="btn btn-block btn-lg btn-primary">
                    Salvar
                </button>
            </div>
        </div>
    </form>
</div>	
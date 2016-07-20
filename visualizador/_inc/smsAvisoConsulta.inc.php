

    <div class="col-md-12">
        <?php if(isset($arrAvisosConsulta)){ ?>
        <h3 class="page-header">Enviar SMS de aviso de consulta</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" >
                <thead>
                    <tr>
                        <th>
                            Paciente
                        </th>
                        <th>
                            Horário da consulta
                        </th>
                        <th>
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($arrAvisosConsulta as $arrAviso) {
                            if(isset($arrAviso['nomSobrenome']))
                                $arrAviso['nomPaciente'] .= ' '.$arrAviso['nomSobrenome'];
                    ?>
                        <tr>
                            <td>
                                <?php echo $arrAviso['nomPaciente']; ?>
                            </td>
                            <td>
                                <?php echo $arrAviso['horaConsulta']; ?>
                            </td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>/consulta/consultarFim/<?php echo $arrAviso['cdnConsulta']; ?>" target="_blank">
                                    <button class="btn btn-success" type="button">
                                        Visualizar consulta
                                    </button>
                                </a>
                                <a href="<?php echo BASE_URL; ?>/sms/enviar/aviso_consulta/<?php echo $arrAviso['cdnPaciente']; ?>/<?php echo $arrAviso['cdnConsulta']; ?>">
                                    <button class="btn btn-primary" type="button">
                                        Enviar SMS
                                    </button>
                                </a>
                            </td>
                        </tr>
                    <?php
                        }
                    ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

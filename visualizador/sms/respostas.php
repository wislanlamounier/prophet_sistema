<div class="col-md-12">
    <div class="ibox float-e-margins"><div class="ibox-header">
            <a class="pull-right" href="<?php echo BASE_URL; ?>/sms/baixarRespostas">
                <button class="btn btn-success">
                    Baixar histórico
                </button>
            </a>
        </div>
        <div class="ibox-content p-md">
            <?php include_once('visualizador/sms/filtroResp.inc.php'); ?>
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <span class="text-muted">Novas mensagens aparecem grifadas.</span>
                    <table class="table table-striped table-bordered table-hover datatable" >
                        <thead>
                            <tr>
                                <th>Paciente</th>
                                <th>Dentista</th>
                                <th>Data</th>
                                <th>Mensagem</th>
                                <th>
                                    Data-hora consulta
                                </th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $dtoSms = new DTOSms();
                                foreach($arrRespostas as $sms){
                                    if(isset($sms['nomSobrenome']))
                                        $sms['nomPaciente'] .= ' '.$sms['nomSobrenome'];
                                    $back = '';
                                    if(isset($sms['indVisualizado'])){
                                        if(!$sms['indVisualizado']){
                                            $back = 'style="background-color:#ECFFB3"';
                                        }
                                    }
                                    if($dtoSms->validacaoDatetime($sms['datResposta']))
                                        $datResposta = $dtoSms->transformacaoDatetime($sms['datResposta']);
                                    else
                                        $datResposta = $dtoSms->transformacaoData($sms['datResposta']);
                            ?>
                            <tr <?php echo $back; ?>>
                                <td>
                                    <?php echo $sms['nomPaciente']; ?>
                                </td>
                                <td>
                                    <?php echo $sms['nomUsuario']; ?>
                                </td>
                                <td>
                                    <?php echo $datResposta; ?>
                                </td>
                                <td>
                                    <?php
                                        $resposta = $sms['strResposta'];
                                        if(strpos(strtolower($resposta), 'cance') === false)
                                            $font = '';
                                        else
                                            $font = 'style="color:red!important"';

                                        echo '<span '.$font.'>'.$resposta.'</span>';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        echo $dtoSms->transformacaoData($sms['datConsulta']);
                                        echo ' - ';
                                        echo $sms['horaConsulta'];
                                    ?>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/consulta/consultarFim/<?php echo $sms['cdnConsulta']; ?>">
                                        <button class="btn btn-primary">Visualizar consulta</button>
                                    </a>
                                </td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Paciente</th>
                                <th>Dentista</th>
                                <th>Data</th>
                                <th>Mensagem</th>
                                <th>
                                    Data-hora consulta
                                </th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

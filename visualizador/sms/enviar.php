

    <div class="col-md-12">
        <div class="row">
            <form method="post" action="<?php echo BASE_URL; ?>/sms/enviarFim/<?php echo $tipoSms.'/'.$cdnPaciente.$argumentosUrl; ?>">
                <div class="col-md-12 form-group">
                    <label for="numTelefone" class="control-label">
                        Telefone que será enviado o SMS
                        <small class="text-muted">Formato: (xx) xxxx-xxxx</small>
                    </label>
                    <?php
                        $numTelefone = '';
                        foreach($arrPaciente as $key=>$value){
                            if (strpos($key, 'numTelefone') !== false) {
                                $numTelefone .= ' - '.$arrPaciente[$key];
                            }
                        }
                    ?>
                    <input required type="text" name="numTelefone" class="form-control" />
                </div>
                <div class="col-md-12 form-group">
                    <label for="strTexto" class="control-label">
                        Mensagem de texto
                    </label>
                    <?php
                        switch ($tipoSms) {
                            case 'aviso_consulta':
                                $modConsulta = new ModeloConsulta();
                                $dtoConsulta = $modConsulta->getConsulta($argumentos[0]);
                                $texto = 'Ola, '.$arrPaciente['nomPaciente'].'! Voce tem uma consulta no dia '.
                                         $dtoConsulta->getDatConsulta(true).' as '.$dtoConsulta->getHoraConsulta().
                                         ' na clinica '.$_SESSION['nomClinica'].'.';
                                break;

                            default:
                                $texto = '';
                                break;
                        }
                    ?>
                    <textarea required name="strTexto" class="form-control"><?php echo $texto; ?></textarea>
                </div>
                <div class="col-sm-offset-4 col-sm-4">
                    <button class="btn btn-lg btn-block btn-success">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>

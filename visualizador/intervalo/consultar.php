                    <div class="col-md-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-header">
                                <a class="pull-right" href="<?php echo BASE_URL; ?>/intervalo/cadastrar/<?php echo $cdnDentista; ?>">
                                    <button class="btn btn-success">
                                        Cadastrar
                                    </button>
                                </a>
                            </div>
                            <div class="ibox-content p-md">
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo $this->link('dentista', 'consultarFim', '<span class="fa fa-arrow-left"></span> Voltar para dentista', array($cdnDentista)); ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 table-responsive">
                                        <table class="table table-striped table-bordered table-hover datatable" >
                                            <thead>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Horário</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    foreach($arrIntervalos as $arrIntervalo){
                                                        $dtoIntervalo = $modIntervalo->getIntervalo($arrIntervalo['cdnIntervalo']);
                                                        if($dtoIntervalo->getIndPermanente()){
                                                            $data = 'Permanente';
                                                        }else{
                                                            $data = '';
                                                            if(is_null($dtoIntervalo->getDatIntervalo())){
                                                                $semana = array('Domingo', 'Segunda', 'Terca', 'Quarta', 'Quinta', 'Sexta', 'Sabado');

                                                                foreach($semana as $dia){
                                                                    $nomFuncao = 'getInd'.$dia;
                                                                    if($dtoIntervalo->{$nomFuncao}())
                                                                        $data .= $dia.', ';
                                                                }

                                                                $data = trim($data, ', ');
                                                            }else{
                                                                $data = $dtoIntervalo->getDatIntervalo(true);
                                                            }
                                                        }
                                                ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo $data; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo $dtoIntervalo->getHoraInicio().' - '.$dtoIntervalo->getHoraFinal(); ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?php echo BASE_URL; ?>/intervalo/atualizar/<?php echo $dtoIntervalo->getCdnIntervalo(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-edit"></i>
                                                                </button>
                                                            </a>
                                                            <a href="<?php echo BASE_URL; ?>/intervalo/deletar/<?php echo $dtoIntervalo->getCdnIntervalo(); ?>">
                                                                <button type="button" class="btn btn-success">
                                                                    <i class="fa fa-remove"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Data</th>
                                                    <th>Horário</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

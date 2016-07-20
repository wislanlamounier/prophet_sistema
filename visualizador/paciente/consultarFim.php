                    <div class="col-md-12">
                        <div class="col-md-12">
                            <a class="pull-right" href="<?php echo BASE_URL; ?>/paciente/cadastrar">
                                <button class="btn btn-success">
                                    Cadastrar novo paciente
                                </button>
                            </a>
                        </div>
                        <?php echo $formulario; ?>

                        <?php
                            if(count($arrDependentes) > 0){
                        ?>
                        <div class="row">
                            <div class="col-md-12 table-responsive text-justify">
                                <h4 class="text-center">Dependentes</h4>
                                <table class="table table-striped table-bordered table-hover datatable" >
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            foreach($arrDependentes as $arrDependente){
                                                $modPaciente = new ModeloPaciente();
                                                $arrPacienteDependentes = $modPaciente->getPaciente($arrDependente['cdnPaciente']);
                                        ?>
                                            <tr>
                                                <td>
                                                    <?php echo $this->link('paciente', 'consultarFim', $arrPacienteDependentes['nomPaciente'], array($arrPacienteDependentes['cdnPaciente']));?>
                                                </td>
                                                <td>
                                                    <a href="<?php echo BASE_URL; ?>/paciente/consultarFim/<?php echo $arrPacienteDependentes['cdnPaciente']; ?>">
                                                        <button class="btn btn-success">
                                                            <span class="fa fa-hand-o-right"></span>
                                                        </button>
                                                    </a>
                                                    <a href="<?php echo BASE_URL; ?>/dependente/deletar/<?php echo $arrDependente['cdnDependente']; ?>">
                                                        <button class="btn btn-success">
                                                            <span class="fa fa-times"></span>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                            }
                        ?>

                        <div class="col-md-12 page-header">
                            <h4>Consultas do paciente</h4>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        foreach($arrConsultas as $arrConsulta){
                                            $dtoConsulta = $modConsulta->getConsulta($arrConsulta['cdnConsulta']);                                                        $dtoConsulta = $modConsulta->getConsulta($arrConsulta['cdnConsulta']);
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $arrPaciente['nomPaciente']; ?>
                                            </td>
                                            <td>
                                                <?php echo $this->link('consulta', 'consultarFim', $dtoConsulta->getDatConsulta(true), array($dtoConsulta->getCdnConsulta()));?>
                                            </td>
                                            <td>
                                                <?php echo $this->link('consulta', 'consultarFim', $dtoConsulta->getHoraConsulta(), array($dtoConsulta->getCdnConsulta()));?>
                                            </td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/consulta/consultarFim/<?php echo $dtoConsulta->getCdnConsulta(); ?>">
                                                    <button type="button" class="btn btn-success">
                                                        Visualizar
                                                    </button>
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>/consulta/atualizar/<?php echo $dtoConsulta->getCdnConsulta(); ?>">
                                                    <button type="button" class="btn btn-success">
                                                        Editar
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
                                        <th>Nome</th>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-md-12 page-header">
                            <h4>Consultas desmarcadas</h4>
                        </div>
                        <div class="col-md-12 table-responsive">
                            <table class="table table-striped table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                        foreach($arrDesmarques as $arrConsulta){
                                            $dtoConsulta = $modConsulta->getConsulta($arrConsulta['cdnConsulta']);                                                        $dtoConsulta = $modConsulta->getConsulta($arrConsulta['cdnConsulta']);
                                    ?>
                                        <tr>
                                            <td>
                                                <?php echo $arrPaciente['nomPaciente']; ?>
                                            </td>
                                            <td>
                                                <?php echo $this->link('consulta', 'consultarFim', $dtoConsulta->getDatConsulta(true), array($dtoConsulta->getCdnConsulta()));?>
                                            </td>
                                            <td>
                                                <?php echo $this->link('consulta', 'consultarFim', $dtoConsulta->getHoraConsulta(), array($dtoConsulta->getCdnConsulta()));?>
                                            </td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/consulta/consultarFim/<?php echo $dtoConsulta->getCdnConsulta(); ?>">
                                                    <button type="button" class="btn btn-success">
                                                        Visualizar
                                                    </button>
                                                </a>
                                                <a href="<?php echo BASE_URL; ?>/consulta/atualizar/<?php echo $dtoConsulta->getCdnConsulta(); ?>">
                                                    <button type="button" class="btn btn-success">
                                                        Editar
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
                                        <th>Nome</th>
                                        <th>Data</th>
                                        <th>Horário</th>
                                        <th>Ações</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-lg-offset-2 col-md-offset-2 col-lg-4">
                                <a href="<?php echo BASE_URL; ?>/paciente/atualizar/<?php echo $cdnPaciente; ?>">
                                    <button type="button" class="btn btn-block btn-lg btn-success">
                                        Editar
                                    </button>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <a href="<?php echo BASE_URL; ?>/dependente/cadastrar/<?php echo $cdnPaciente ?>/0">
                                    <button type="button" class="btn btn-block btn-lg btn-primary">
                                        Cadastrar dependente
                                    </button>
                                </a>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4 col-lg-offset-2 col-md-offset-2 col-lg-4">
                                <a href="<?php echo BASE_URL; ?>/prontuario/consultarFim/<?php echo $cdnPaciente; ?>">
                                    <button type="button" class="btn btn-outline btn-block btn-lg btn-info">
                                        Prontuário
                                    </button>
                                </a>
                            </div>
                            <div class="col-md-4 col-lg-4">
                                <a href="<?php echo BASE_URL; ?>/anamnese/consultarFim/<?php echo $cdnPaciente ?>">
                                    <button type="button" class="btn btn-outline btn-block btn-lg btn-info">
                                        Anamnese
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="row text-justify">

                            <div class="col-md-12">
                                <span class="text-muted">
                                    <?php echo $this->link('paciente', 'deletar', 'Deletar paciente', array($cdnPaciente)); ?>
                                </span>
                            </div>

                        </div>
                    </div>

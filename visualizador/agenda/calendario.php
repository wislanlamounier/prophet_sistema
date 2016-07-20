<div class="col-md-3 text-center no-print">
    <div class="ibox float-e-margins">
            <h5>Tipos de evento</h5>

        <div class="col-md-12">
            <a href="<?php echo BASE_URL; ?>/agendaTipoEvento/cadastrar">
                <button class="btn btn-primary btn-block btn-outline">
                    Cadastrar tipo de evento
                </button>
            </a>
        </div>
        <?php
            $modDentista = new ModeloDentista();
            if ($modDentista->checaExiste('dentista', 'cdnUsuario', $_SESSION['cdnUsuario'])) {
                ?>
                <div class="col-md-12">
                    <a href="<?php echo BASE_URL; ?>/dentista/fecharAgenda">
                        <button class="btn btn-success btn-block btn-outline">
                            Fechar agenda
                        </button>
                    </a>
                </div>
                <?php
            }

        ?>
        <div class="col-md-12">
            <div id='external-events' style="color: white;">
                <?php
                    foreach ($arrTipoEventos as $arrTipoEvento) {
                        $dtoAgendaTipoEvento = $modAgendaTipoEvento->getTipoEvento($arrTipoEvento['cdnTipoEvento']);
                        ?>
                        <div id="<?php echo $dtoAgendaTipoEvento->getCdnTipoEvento(); ?>"
                             class='external-event <?php echo $dtoAgendaTipoEvento->getCodCor(); ?>-bg'>
                            <?php echo $dtoAgendaTipoEvento->getNomTipoEvento(); ?>
                            <a style="color: white;"
                               href="<?php echo BASE_URL; ?>/agendaTipoEvento/atualizar/<?php echo $dtoAgendaTipoEvento->getCdnTipoEvento(); ?>">
                                <span class="pull-right fa fa-edit"></span>
                            </a>
                            <a style="color: white;"
                               href="<?php echo BASE_URL; ?>/agendaTipoEvento/deletar/<?php echo $dtoAgendaTipoEvento->getCdnTipoEvento(); ?>">
                                <span class="pull-right fa fa-times"></span>
                            </a>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</div><!-- /.col -->

<div class="col-md-9">
    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <!-- THE CALENDAR -->
            <div id="calendario"></div>
        </div><!-- /.box-body -->
    </div><!-- /. box -->
</div><!-- /.col -->


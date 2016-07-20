        <div class="col-md-12">
            <?php echo $this->link('agenda', 'calendario', '<- Voltar para calendário'); ?>
        </div>
        <div class="col-md-12">
            <form action="<?php echo BASE_URL; ?>/agendaEvento/atualizarMobileFim/<?php echo $cdnEvento; ?>" method="post">
                <div class="row">
            	    <div class="col-md-6">
            	        <div class="form-group">
            	            <label for="datInicio" type="date" class="control-label">Data de Início</label>
            	            <input type="date" id="datInicio" name="datInicio" class="form-control mask-date" placeholder="Dia/Mês/Ano" value="<?php echo $datInicio; ?>">
            	        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="horaInicio" class="control-label">Horário de Início</label>
                            <input type="horaMinuto" id="horaInicio" name="horaInicio" class="form-control mask-time" placeholder="Hora:Minuto" value="<?php echo $horaInicio; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="indAllDay" class="control-label">Evento de dia inteiro?</label><br>
                            <input <?php echo $dtoAgendaEvento->getIndAllDay() ? 'checked' : ''; ?> id="indAllDay" type="checkbox" name="indAllDay">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="datFim" type="date" class="control-label">Data Final</label>
                            <input type="date" id="datFim" name="datFim" class="form-control mask-date" placeholder="Dia/Mês/Ano" value="<?php echo $datFim; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="horaFim" class="control-label">Horário Final</label>
                            <input type="horaMinuto" id="horaFim" name="horaFim" class="form-control mask-time" placeholder="Hora:Minuto" value="<?php echo $horaFim; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                	<div class="col-md-6">
                		<div class="form-group">
                			<label for="indAviso" class="control-label">Avisar na página inicial?</label> <br>
                			<input <?php echo $dtoAgendaEvento->getIndAviso() ? 'checked' : '' ?> type="checkbox" id="iptIndAviso" name="indAviso">
                		</div>
                	</div>
                	<div class="col-md-6">
                		<div class="form-group">
                			<label for="numDiasAviso" class="control-label">Número de dias de antecedência</label>
                			<input value="<?php echo $dtoAgendaEvento->getNumDiasAviso(); ?>" class="form-control" type="number" id="iptNumDiasAviso" name="numDiasAviso">
                		</div>
                	</div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="desEvento" class="control-label">Descrição</label>
                            <textarea id="desEvento" class="form-control" name="desEvento"><?php echo $dtoAgendaEvento->getDesEvento(); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                        <button type="submit" class="btn btn-block btn-lg btn-success">
                            Atualizar
                        </button>
                    </div>
                </div>
            </form>
        </div><!-- /.col -->

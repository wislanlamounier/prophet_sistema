	    	<?php

	    		$modAgendaEvento = new ModeloAgendaEvento();
	    		$modAgendaTipoEvento = new ModeloAgendaTipoEvento();

        		$sql = 'SELECT * FROM agenda_evento WHERE indAviso = 1 AND datFim >= "'.date('Y-m-d H:i:s').'" and cdnUsuario = '.$_SESSION['cdnUsuario'].' ORDER BY datInicio';
        		$arrEventos = $modAgendaEvento->query($sql);
        		if(count($arrEventos) > 0){

	    	?>
	    	<div class="col-md-12">
	    		<h4>Eventos</h4>
	    	</div>
			<div class="col-md-12">
	            <div class="table-responsive">
	                <table class="table no-margin">
	                    <thead>
	                        <tr>
	                            <th>Tipo</th>
	                            <th>Decrição</th>
	                            <th>Data - Hora Início</th>
	                            <th>Data - Hora Final</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<?php
	                    		foreach($arrEventos as $arrEvento){
	                    			$dtoAgendaEvento = $modAgendaEvento->getEvento($arrEvento['cdnEvento']);
	                    			if((strtotime(date('Y-m-d 23:59:00')) + (86400 * $dtoAgendaEvento->getNumDiasAviso())) >= strtotime($dtoAgendaEvento->getDatFim())){
	                    				$dtoAgendaTipoEvento = $modAgendaTipoEvento->getTipoEvento($arrEvento['cdnTipoEvento']);
	                    	?>
	                    	<tr>
	                    		<td><?php echo $dtoAgendaTipoEvento->getNomTipoEvento(); ?></td>
	                    		<td><?php echo $dtoAgendaEvento->getDesEvento(); ?></td>
	                    		<td><?php echo date('d/m/Y - H:i:s', strtotime($dtoAgendaEvento->getDatInicio())); ?></td>
	                    		<td><?php echo date('d/m/Y - H:i:s', strtotime($dtoAgendaEvento->getDatFim())); ?></td>
	                    	</tr>
	                    	<?php
	                    			}

	                    		}
	                    	?>
	        			</tbody>
	        		</table>
	        	</div>
	        </div>

	        <?php

	        	}

	        ?>
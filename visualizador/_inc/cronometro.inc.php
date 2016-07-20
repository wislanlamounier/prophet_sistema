			<?php
				if(!isset($modCronometro))
					$modCronometro = new ModeloCronometro();

				if(!isset($modConsulta))
					$modConsulta = new ModeloConsulta();

				if(!isset($modPaciente))
					$modPaciente = new ModeloPaciente();

				if(!isset($modMain))
					$modMain = new ModeloMain(true);

				if(!isset($dtoConfiguracoes))
					$dtoConfiguracoes = $modMain->getConfiguracoes();

				$sql = 'SELECT COUNT(cdnPaciente) AS qtd FROM cronometro WHERE
						ISNULL(horaEntrada) AND ISNULL(horaSaida)';

				$arrSalaEspera = $modCronometro->query($sql);

				$sql = 'SELECT COUNT(cdnPaciente) AS qtd FROM cronometro WHERE
						!ISNULL(horaEntrada) AND ISNULL(horaSaida)';

				$arrConsultorio = $modCronometro->query($sql);

				if(count($arrSalaEspera) > 0)
					$qtdSalaEspera = $arrSalaEspera[0]['qtd'];
				else
					$qtdSalaEspera = 0;

				if(count($arrConsultorio) > 0)
					$qtdConsultorio = $arrConsultorio[0]['qtd'];
				else
					$qtdConsultorio = 0;
			?>
			<div class="col-md-12">
				<div class="col-sm-6">
					<h2><?php echo $this->link('cronometro', 'salaEspera', 'Sala de espera'); ?></h2>
					<h2><?php echo $this->link('cronometro', 'salaEspera', $qtdSalaEspera  ); ?></h2>
				</div>
				<div class="col-sm-6">
					<h2><?php echo $this->link('cronometro', 'consultorio', 'Em atendimento'); ?></h2>
					<h2><?php echo $this->link('cronometro', 'consultorio', $qtdConsultorio ); ?></h2>
				</div>
			</div>

			<?php

				$sqlCronometro = 'SELECT cr.cdnPaciente
								  FROM cronometro cr
								  WHERE horaChegada IS NOT NULL AND
								  		horaEntrada IS 	   NULL AND
								  		horaSaida   IS     NULL AND
								  		datCronometro = "'.date('Y-m-d').'"';
								  		
				$sql = 'SELECT p.cdnPaciente as cdnPaciente,
							   c.cdnConsulta as cdnConsulta
						FROM paciente p 
						JOIN consulta c ON p.cdnPaciente = c.cdnPaciente
						WHERE TIMESTAMP("'.date('Y-m-d').'", c.horaConsulta) < TIMESTAMP("'.date('Y-m-d H:i:s', time() + ($dtoConfiguracoes->getNumMinutosAvisoPrevio() * 60)).'") AND
							  datConsulta = "'.date('Y-m-d').'" AND 
							  p.cdnPaciente IN ('.$sqlCronometro.')
						ORDER BY c.horaConsulta';


				$arrAtrasos = $modCronometro->query($sql);

				if(count($arrAtrasos) > 0){
			?>
			<div class="col-md-12 page-header">
				<h3>Próximas consultas</h3>
			</div>
			<div class="col-md-12">
				<div class="table-responsive">
	                <table class="table no-margin">
	                    <thead>
	                        <tr>
	                            <th>Paciente</th>
	                            <th>Horário</th>
	                            <th>Falta</th>
	                            <th>Chegada</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    	<?php
	                    		foreach($arrAtrasos as $arrAtraso){
	                    			if($modConsulta->checaExiste('falta', 'cdnConsulta', $arrAtraso['cdnConsulta']))
	                    				continue;

	                    			if($modConsulta->checaExiste('desmarque', 'cdnConsulta', $arrAtraso['cdnConsulta']))
	                    				continue;
	                    			
	                    			$dtoConsulta = $modConsulta->getConsulta($arrAtraso['cdnConsulta']);
	                    			$arrPaciente = $modPaciente->getPaciente($arrAtraso['cdnPaciente'], true);
	                    	?>
	                    	<tr>
	                    		<td><?php echo $this->link('paciente', 'consultarFim', $arrPaciente['nomPaciente'], array($arrPaciente['cdnPaciente']), '_blank'); ?></td>
	                    		<td><?php echo $dtoConsulta->getHoraConsulta(); ?></td>
	                    		<td><?php echo $this->link('falta', 'cadastrar', 'Marcar falta', array($arrPaciente['cdnPaciente'], $arrAtraso['cdnConsulta'])); ?></td>
	                    		<td><?php echo $this->link('cronometro', 'chegada', 'Registrar chegada', array($arrPaciente['cdnPaciente'], $dtoConsulta->getCdnConsulta())); ?></td>
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
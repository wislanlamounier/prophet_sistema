	<div class="col-md-12">
		<form action="<?php echo BASE_URL; ?>/agenda/dentistaImprimir" method="post">
			<div class="form-group col-xs-6">
				<label for="datConsulta" class="control-label">Trocar data</label>
				<input type="text" name="datConsulta" class="form-control mask-dateinterval">
			</div>
			<div class="form-group col-xs-6">
				<label for="cdnDentista" class="control-label">Dentista</label>
				<select name="cdnDentista" class="form-control select2">
					<option value="">Todos</option>
					<?php
						foreach($arrDentistas as $arrDentista){
							$arrUsuario = $modMain->getUsuario($arrDentista['cdnUsuario']);
					?>
					<option value="<?php echo $arrUsuario['cdnUsuario']; ?>">
						<?php echo $arrUsuario['nomUsuario']; ?>
					</option>
					<?php
						}
					?>
				</select>
			</div>
			<div class="col-xs-12">
				<button type="submit" class="btn btn-primary">Trocar</button>
			</div>
		</form>
	</div>

	<div class="col-md-12 page-header">
		<h2>Consultas do dia <?php echo $datConsulta; ?></h2>
		<a href="<?php echo BASE_URL; ?>/agenda/dentistaImprimirFim/<?php echo $datConsultaIni.'/'.$datConsultaFim.'/'.$cdnDentista; ?>" target="_blank">
			<button class="btn btn-default">
				Imprimir/Visualizar
			</button>
		</a>
	</div>

	<div class="col-md-12">
		<?php
			foreach($arrFinal as $cdnDentista=>$arrConsultas){
				if(count($arrConsultas) > 0){
					$arrDentista = $modMain->getUsuario($cdnDentista);
					echo '<h4>Dentista: '.$arrDentista['nomUsuario'].'</h4>';
		?>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Data</th>
					<th>Horário</th>
					<th>Paciente</th>
					<th>Consultório</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($arrConsultas as $cdnConsulta){
						$dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
						$arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente(), true);
						$dtoConsultorio = $modConsultorio->getConsultorio($dtoConsulta->getCdnConsultorio());
				?>
				<tr>
					<td><?php echo $dtoConsulta->getDatConsulta(true); ?></td>
					<td><?php echo $dtoConsulta->getHoraConsulta(); ?></td>
					<td><?php echo $this->link('paciente', 'consultarFim', $arrPaciente['nomPaciente'], array($dtoConsulta->getCdnPaciente())); ?></td>
					<td><?php echo $dtoConsultorio->getNumConsultorio(); ?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
		<?php
				}
			}
		?>
	</div>
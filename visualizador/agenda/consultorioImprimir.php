	<div class="col-md-12">
		<form action="<?php echo BASE_URL; ?>/agenda/consultorioImprimir" method="post">
			<div class="form-group col-xs-6">
				<label for="datConsulta" class="control-label">Trocar data</label>
				<input type="text" name="datConsulta" class="form-control mask-dateinterval">
			</div>
			<div class="form-group col-xs-6">
				<label for="cdnConsultorio" class="control-label">Consultório</label>
				<select name="cdnConsultorio" class="form-control select2">
					<option value="">Todos</option>
					<?php
						foreach($arrConsultorios as $arrConsultorio){
					?>
					<option value="<?php echo $arrConsultorio['cdnConsultorio']; ?>">
						<?php echo $arrConsultorio['numConsultorio']; ?>
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
		<a href="<?php echo BASE_URL; ?>/agenda/consultorioImprimirFim/<?php echo $datConsultaIni.'/'.$datConsultaFim.'/'.$cdnConsultorio; ?>" target="_blank">
			<button class="btn btn-default">
				Imprimir/visualizar
			</button>
		</a>
	</div>

	<div class="col-md-12">
		<?php
			foreach($arrFinal as $cdnConsultorio=>$arrConsultas){
				if(count($arrConsultas) > 0){
					$dtoConsultorio = $modConsultorio->getConsultorio($cdnConsultorio);
					echo '<h4>Consultório: '.$dtoConsultorio->getNumConsultorio().'</h4>';
		?>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Data</th>
					<th>Horário</th>
					<th>Paciente</th>
					<th>Dentista</th>
				</tr>
			</thead>
			<tbody>
				<?php
					foreach($arrConsultas as $cdnConsulta){
						$dtoConsulta = $modConsulta->getConsulta($cdnConsulta);
						$arrPaciente = $modPaciente->getPaciente($dtoConsulta->getCdnPaciente(), true);
						$arrUsuario = $modMain->getUsuario($dtoConsulta->getCdnDentista());
				?>
				<tr>
					<td><?php echo $dtoConsulta->getDatConsulta(true); ?></td>
					<td><?php echo $dtoConsulta->getHoraConsulta(); ?></td>
					<td><?php echo $this->link('paciente', 'consultarFim', $arrPaciente['nomPaciente'], array($dtoConsulta->getCdnPaciente())); ?></td>
					<td><?php echo $arrUsuario['nomUsuario']; ?></td>
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
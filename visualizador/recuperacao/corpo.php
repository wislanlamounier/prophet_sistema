<?php
	$email->Body = '
	<center><b>Recuperação de senha - Sistema Prophet</b></center>
	<p>Olá! Detectamos que você solicitou uma recuperação de senha no nosso sistema. Caso não
	tenha sido você, por favor, ignore esta mensagem.</p>
	<b>Dados do solicitante:</b> <br>
	<u>E-mail do usuário:</u> '.$arrUsuario['strEmail'].' <br>
	<u>IP:</u> '.$dtoRecuperacao->getNumIp().' <br>
	<u>Data:</u> '.$dtoRecuperacao->getDatRecuperacao().' <br>
	<hr>
	<p>Para finalizar a recuperação, por favor, <b><a href="'.BASE_URL.'/recuperacao/finalizar/'.$dtoRecuperacao->getCodRecuperacao().'">clique aqui.</a></b></p>
	';
?>
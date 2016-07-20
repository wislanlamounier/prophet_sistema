<?php

// criar uma função para isso
$_flash = $this->getFlash();

if ($_flash) {
    foreach ($_flash as $_class => $_messages) {
        echo '
				  	<div class="row">
				  		<div class="col-md-12 alert alert-' . $_class . ' text-center">';
        foreach ($_messages as $_message) {
            echo $_message . '<br>';
        }
        echo '</div></div>';
    }
}

if (isset($_SESSION['phpError'])) {
    if ($_SESSION['phpError'] != '') {
        echo '<div class="container">
					<div class="row">
						<div class="col-md-12 alert alert-warning text-center">
							<span>' . $_SESSION['phpError'] . '</span>
						</div>
					</div>
				</div>';
        $_SESSION['phpError'] = '';
    }
}

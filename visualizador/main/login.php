
<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $titulo; ?> | Prophet</title>

        <base href="<?php echo BASE_URL; ?>">

        <link href="tema/css/bootstrap.min.css" rel="stylesheet">
        <link href="tema/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="tema/css/animate.css" rel="stylesheet">
        <link href="tema/css/style.css" rel="stylesheet">

    </head>

    <body class="gray-bg">

        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <?php include 'inc/getErrors.inc.php'; ?>
                <div class="center-block">
                    <h1 class="logo-name text-center">Prophet</h1>
                </div>
                <h3>Bem-vindo ao Prophet!</h3>
                <b>
                    De DENTISTA para DENTISTA.
                </b>
                <p>Entre com seus dados para acessar o sistema.</p>
                <form class="m-t" role="form" method="post" action="<?php echo BASE_URL; ?>/main/loginFim/<?php echo $ref; ?>">
                    <div class="form-group">
                        <input autofocus type="email" name="strEmail" class="form-control" placeholder="E-mail" required="" >
                    </div>
                    <div class="form-group">
                        <input type="password" name="strSenha" class="form-control" placeholder="Senha" required="">
                    </div>
                    <button type="submit" class="btn btn-primary block full-width m-b">Entrar!</button>

                </form>
                <p class="m-t"> <small></small> </p>
            </div>
        </div>

        <!-- Mainly scripts -->
        <script src="tema/js/jquery-2.1.1.js"></script>
        <script src="tema/js/bootstrap.min.js"></script>

    </body>

</html>

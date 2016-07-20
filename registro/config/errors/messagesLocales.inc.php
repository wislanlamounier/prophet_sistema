<?php
	switch(_LOCALE){
		case 'en':

			// Internal
			define('_LOG_ERROR', 'Log table has not been created in database.');
			define('_PDO_ERROR', 'An error ocurred: ');

			// Data transaction
			define('_EXISTS_ERROR', "Data doesn't exists.");
			define('_INSERT_ERROR', 'An error occurred inserting the data. Please, try again.');
			define('_INSERT_SUCCESS', 'Data registered with success.');

			// Permission
			define('_PERMISSION_ERROR', "You don't have the neccessary permission to realize that action.");
			define('_AUTH_ERROR', 'You need authentication to acccess this system area.');

			// Login
			define('_LOGIN_ERROR', "Login/password don't match.");
			define('_LOGIN_SUCCESS', 'Login performed with success.');
			define('_LOGIN_NEED', "You need to auth to access that page.");

			// Error
			define('_PHP_ERROR', 'Ops! An error occurred. Please, contact the system administration.');

			// User
			define('_USER_EXISTS', 'User already exists.');

			break;

		case 'ptbr':

			// Interno
			define('_LOG_ERROR', 'Tabela de log não foi criada na base de dados.');
			define('_PDO_ERROR', 'Um erro ocorreu: ');

			// Transação de dados
			define('_EXISTS_ERROR', 'Registro não existente.');
			define('_INSERT_ERROR', 'Algum problema ocorreu ao registrar os dados. Por favor, tente novamente.');
			define('_INSERT_SUCCESS', 'Dados registrados com sucesso.');

			// Permissão
			define('_PERMISSION_ERROR', 'Você não tem permissão para realizar esta ação.');
			define('_AUTH_ERROR', 'Realize login para acessar esta área do site.');

			// Login
			define('_LOGIN_ERROR', 'Dados não conferem.');
			define('_LOGIN_SUCCESS', 'Login realizado com sucesso.');
			define('_LOGIN_NEED', 'Você precisa se autenticar para acessar esta página.');

			// Erro
			define('_PHP_ERROR', 'Ops! Um erro ocorreu. Por favor, contate a administração do sistema.');

			// User
			define('_USER_EXISTS', 'Usuário já cadastrad no sistema.');

			break;
	}

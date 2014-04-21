<?php
	session_start();

	include("functions.php");

	if(isset($_SESSION['id_user'])){
		unset($_SESSION['id_user']);
		unset($_SESSION['user']);
		unset($_SESSION['tipo']);
		unset($_SESSION['nome_user']);
	}
	if (isset($_COOKIE['id_user'])) {
			unset($_COOKIE['id_user']);
			unset($_COOKIE['user']);
			unset($_COOKIE['nome_user']);
			unset($_COOKIE['tipo']);
			unset($_COOKIE['token']);
			setcookie('id_user', null, -1, $caminho);
			setcookie('user', null, -1, $caminho);
			setcookie('tipo', null, -1, $caminho);
			setcookie('token', null, -1, $caminho);
			setcookie("nome_user",null, -1, $caminho);
	} else {
		// set the expiration date to one hour ago
		setcookie("id_user",  "", time()-3600);
		setcookie("user",  "", time()-3600);
		setcookie("tipo",  "", time()-3600);
		setcookie("nome_user",  "", time()-3600);
		setcookie("token",  "", time()-3600);
	}

	session_destroy();
	header("location: ../index.php")
?>
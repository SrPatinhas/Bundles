<?php
	session_start();
	include("../config/config.php");
	include("../config/functions.php");

	$caminho = caminholocal();

	$user   = $_POST["entrar_user"];
	$pass   = $_POST["entrar_password"];
	
	$pass_user = md5($pass);
	$response = 'erro';
	$msg = "";
	$user_name = "";

	if (($user != "") and ($pass != "")) {
		$query_user= "SELECT id_user, nome_user, username, token, verificado, type from user where username = ? and pass_user = ?"; 
		$stmt_user = $mydb->prepare($query_user);
		$stmt_user->bind_param("ss", $user, $pass_user); 
		$stmt_user->execute();

		$stmt_user->bind_result($id_user, $nome_user, $username, $token_ver, $verificado, $tipo); 
		while ($stmt_user->fetch()) { 
			$user_name = $username;
			$id_user = $id_user;
			$token_ver = $token_ver;
			$verificado = $verificado;
			$user_tipo = $tipo;
		}

		if ($verificado === "ativo") {
			$response = 'success';
			$token = getToken(125);

			$query_update= "UPDATE user SET token = ? WHERE id_user = ?"; 
			$stmt_update = $mydb->prepare($query_update);
			$stmt_update->bind_param('si', $token, $id_user);
			$stmt_update->execute(); 
			$stmt_update->close();

			if (isset($_POST["entrar_save"])) {
				$expire=time()+60*60*24*30; //expira dentro de um mes
				setcookie("user", $user_name, $expire, $caminho);
				setcookie("id_user", $id_user, $expire, $caminho);
				setcookie("nome_user", $nome_user, $expire, $caminho);
				setcookie("tipo", $user_tipo, $expire, $caminho);
				setcookie("token", $token, $expire, $caminho);

			}
			$_SESSION["user"] = $user_name;
			$_SESSION["nome_user"] = $user_name;
			$_SESSION["id_user"] = $id_user;
			$_SESSION["tipo"] = $user_tipo;
		} else if ($verificado === "no") {
			$response = 'erro';
			$msg = "Tem de confirmar o seu email, ou reenviar o email de confirmação!";
			$msg .= "<br><a href='/escola/Semestre%203/Design/config/reset.php?type=email'>Enviar novo email</a>";
		} else {
			$response = 'erro';
			$msg = "Nome ou password erradas!<br>Tente novamente ou registe-se no site!";
			$msg .= "<br><a href='/escola/Semestre%203/Design/config/reset.php?type=pass'>Esqueceu-se da Password?</a>";
			$msg .= "<br><a href='/escola/Semestre%203/Design/config/reset.php?type=user'>Esqueceu-se do Nome de Utilizdor?</a>";
		}
		$stmt_user->close();
	} else {
		$response = 'erro';
		$msg = "Nome ou password vazio!<br>Tente novamente ou registe-se no site!";
		$msg .= "<br><a href='/escola/Semestre%203/Design/config/reset.php?type=pass'>Esqueceu-se da Password?</a>";
		$msg .= "<br><a href='/escola/Semestre%203/Design/config/reset.php?type=user'>Esqueceu-se do Nome de Utilizdor?</a>";
	}
	$success = array(
		"tipo" => 'success',
		"nome" => $user_name,
		"msg" => 'Bem vindo de novo ',
		"login" => $token_ver
	);
	$erro = array(
		"tipo" => 'erro',
		"msg" => $msg
	);
	// Finally depending on the button value, JSON encode our winetable and print it
	if ($response == "success") {
	  print json_encode($success);
	}
	else {
	  print json_encode($erro);
	}
?>

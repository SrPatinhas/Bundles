<?php
	session_start();
	include("../config/config.php");
	include("../config/functions.php");

	$error = "";

	$nome   = $_POST["registar_nome"];
	$user   = $_POST["registar_user"];
	$email  = $_POST["registar_email"];
	$pass   = $_POST["registar_password"];
	$pass_2 = $_POST["registar_pass"];
	
	if (isset($_POST["registar_agree"])) {
		$agree  = $_POST["registar_agree"];
	} else {
		$agree = "";
	}

	if (isset($_POST["registar_notificar"])) {
		$notif  = $_POST["registar_notificar"];
	} else {
		$notif = "";
	}
	
	if ($pass === $pass_2 ) {
		$pass_user = $pass;
		$pass_user = md5($pass_user);
	} else {
		$error.= "<li>Password diferentes!!</li>";
	}
	if ($agree != "on") {
		$error.="<li>Tem de aceitar os termos e condições de comprar!!</li>";
	}
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	  $error.="<li>Email inválido!!</li>";
	}

	$query_v_email= "select id_user from user where email_user=?"; 
	$stmt_v_email = $mydb->prepare($query_v_email); 
	$stmt_v_email->bind_param("s", $email); 
	$stmt_v_email->execute();
	$stmt_v_email->bind_result($id); 
	if ($stmt_v_email->fetch()){
		$bd_first = false;
		$error.="<li>Email já existente!!</li>";
	} else {
		$bd_first = true;
	}
	$stmt_v_email->close(); 

	$query_v_user= "select id_user from user where username=?"; 
	$stmt_v_user = $mydb->prepare($query_v_user); 
	$stmt_v_user->bind_param("s", $user); 
	$stmt_v_user->execute();
	$stmt_v_user->bind_result($id); 
	if ($stmt_v_user->fetch()){
		$bd_first_user = false;
		$error.="<li>Nome de utilizador já existente!!</li>";
	} else {
		$bd_first_user = true;
	}
	$stmt_v_user->close();

	$type = "utilizador";

	if ($error === "" and $bd_first === true and $bd_first_user === true) {
		#inserir dados na tabela user
		$token = getToken(50);
		$verificado = "pendente";

		$query= "insert into user ". 
			 	"(nome_user, pass_user, username, email_user, type, token, verificado) ". 
			 	"value (?, ?, ?, ?, ?, ?, ?)"; 
		$stmt = $mydb->prepare($query); 
		$stmt->bind_param("sssssss", $nome, $pass_user, $user, $email, $type, $token, $verificado); 
		$stmt->execute();
		$stmt->close();

		$query_email= "select id_user from user where email_user=?"; 
		$stmt_email = $mydb->prepare($query_email); 
		$stmt_email->bind_param("s", $email); 
		$stmt_email->execute();
		$stmt_email->bind_result($id); 
		if ($stmt_email->fetch()){
			$response = 'success';
		} else {
			$response = 'erro';
		}
 		$stmt_email->close(); 

		#verificar o ultimo utilizador inserido
		$query_id= "select last_insert_id()"; 
		$stmt_id = $mydb->prepare($query_id); 
		$stmt_id->execute(); 
		$stmt_id->bind_result($id_user); 
		if ($stmt_id->fetch()) 
		 	$id_user = $id_user; 

		$stmt_id->close();

		$query_user= "select id_user, username from user where id_user=?"; 
		$stmt_user = $mydb->prepare($query_user);
		$stmt_user->bind_param("i", $id_user); 
		$stmt_user->execute();

		$stmt_user->bind_result($id_user, $username); 
		while ($stmt_user->fetch()) { 
			$user_name = $username;
		} 
		$stmt_user->close();

		if ($notif != "") {

			

			$query_email_s= "SELECT id_subscritor FROM subscritor where email_subscritor=?"; 
			$stmt_email_s = $mydb->prepare($query_email_s); 
			$stmt_email_s->bind_param("s", $email); 
			$stmt_email_s->execute();
			$stmt_email_s->bind_result($id); 
			if ($stmt_email_s->fetch()){
			} else {
				$query= "INSERT into subscritor ". 
				 	"(email_subscritor) ". 
				 	"VALUE (?)"; 
				$stmt = $mydb->prepare($query); 
				$stmt->bind_param("s", $email); 
				$stmt->execute();
				$stmt->close();
			}
	 		$stmt_email_s->close(); 
	 	}
		$success = array(
			"tipo" => 'success',
			"nome" => $user_name,
			"msg" => ' registado com sucesso;',
			"name_email" => $nome,
			"username" => $user_name,
			"email" => $email,
			"token" => $token
		);

	} else {
		$response = 'erro';
		$erro = array(
			"tipo" => 'erro',
			"msg" => "<ul style='display: inline-block;'>".$error."</ul>",
		);

	}
		// Finally depending on the button value, JSON encode our winetable and print it
	if ($response == "success") {
	  print json_encode($success);
	}
	else {
	  print json_encode($erro);
	}

		
?>

<?php
	session_start();
	include("../config/config.php");
	include("../config/functions.php");

	$error = "";

	$email  = $_POST["email"];

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	  $error.="<li>Email inválido!!</li>";
	  $response = 'erro';
		
	} else {
		$query_email_s= "SELECT id_subscritor FROM subscritor where email_subscritor=?"; 
		$stmt_email_s = $mydb->prepare($query_email_s); 
		$stmt_email_s->bind_param("s", $email); 
		$stmt_email_s->execute();
		$stmt_email_s->bind_result($id); 
		if ($stmt_email_s->fetch()){
			$error.="<li>Email já existente!!</li>";
	  		$response = 'erro';
		} else {
			$query= "INSERT into subscritor ". 
			 	"(email_subscritor) ". 
			 	"VALUE (?)"; 
			$stmt = $mydb->prepare($query); 
			$stmt->bind_param("s", $email); 
			$stmt->execute();
			$stmt->close();

	 		$query_email= "SELECT id_subscritor FROM subscritor where email_subscritor=?"; 
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
		}
 		$stmt_email_s->close(); 
	}
	$erro = array(
		"tipo" => 'erro',
		"msg" => "<ul style='display: inline-block;'>".$error."</ul>",
	);
	$success = array(
		"tipo" => 'success'
	);
		// Finally depending on the button value, JSON encode our winetable and print it
	if ($response == "success") {
	  print json_encode($success);
	}
	else {
	  print json_encode($erro);
	}

		
?>

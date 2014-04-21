<?php
	session_start();
	include("../config/config.php");

	$email   = "{$_POST['email']}";

	$query_email= "select id_user from user where email_user like ?"; 
	$stmt_email = $mydb->prepare($query_email); 
	$stmt_email->bind_param("s", $email); 
	$stmt_email->execute();
	$stmt_email->bind_result($id); 
	if ($stmt_email->fetch()){
		$response = 'erro';
	} else {
		$response = 'success';
	}
	$stmt_email->close(); 

	$success = array(
		"tipo" => 'success'
	);
	$erro = array(
		"tipo" => 'erro'
	);

		// Finally depending on the button value, JSON encode our winetable and print it
		if ($response == "success") {
		  print json_encode($success);
		}
		else {
		  print json_encode($erro);
		}

		
?>
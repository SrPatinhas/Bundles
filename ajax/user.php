<?php
	session_start();
	include("../config/config.php");

	$user   = "{$_POST['user']}";

	$query_user= "select id_user from user where username like ?"; 
	$stmt_user = $mydb->prepare($query_user); 
	$stmt_user->bind_param("s", $user); 
	$stmt_user->execute();
	$stmt_user->bind_result($id); 
	if ($stmt_user->fetch()){
		$response = 'erro';
	} else {
		$response = 'success';
	}
	$stmt_user->close(); 

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

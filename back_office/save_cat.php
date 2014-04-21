<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
		header("location:index.php");
	}
	require_once ("config/config.php");
	include("config/functions.php");

		$nome 	= $_POST['nome_cat'];

		$response = 'success';
		$erro_tipo ='';
		
		$query_cat= "INSERT INTO `categorias`(`nome_cat`) VALUES (?)"; 
		$stmt_cat = $mydb->prepare($query_cat); 
		$stmt_cat->bind_param("s", $nome); 
		if ($stmt_cat->execute()) { // exactly like this!
		    $successo = true;
		} else {
			$response = 'erro';
			$erro_tipo = 'categoria';
		}

		$stmt_cat->close();
		
		//************************************************************************************************************

		$success = array(
			"tipo" => 'success',
			"titulo" => $nome,
		);
		$erro = array(
			"tipo" => 'erro',
			"titulo" => 'Sem dados!',
			"erro" => $erro_tipo,
			"img" => 'http://www.pontikis.net/blog/media/2013/03/how-to-use-php-improved-mysqli-extension-and-why-you-should/post/tuscan_hills.png',
		);

		// Finally depending on the button value, JSON encode our winetable and print it
		if ($response == "success") {
		  print json_encode($success);
		}
		else {
		  print json_encode($erro);
		}

		
?>

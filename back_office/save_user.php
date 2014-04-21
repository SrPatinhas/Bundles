<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
		header("location:index.php");
	}
	require_once ("config/config.php");
	include("config/functions.php");

		$nome 	= $_POST['nome'];
		$pass 	= $_POST['pass'];
		$n_pas 	= $_POST['n_pass'];
		$avatar	= $_POST['avatar'];
		$email 	= $_POST['email'];
		$tipo 	= $_POST['tipo_user'];
		$verifi	= $_POST['ver_user'];

		$response = 'success';
		$erro_tipo ='';
		$query_jogos= "INSERT INTO `user`".
				 "(`nome_user`, `pass_user`, `username`, `email_user`, `type`, `avatar_user`, `verificado`)". 
				 " VALUES (?,?,?,?,?,?,?)"; 
		$stmt_jogos = $mydb->prepare($query_jogos); 
		$stmt_jogos->bind_param("sssssss", $nome, $info, $video, $capa, $dt); 
		if ($stmt_jogos->execute()) { // exactly like this!
		    $successo = true;
		} else {
			$response = 'erro';
			$erro_tipo = 'jogo';
		}

		$stmt_jogos->close();

		$query= "select last_insert_id()"; 
		$stmt = $mydb->prepare($query); 
		$stmt->execute(); 
		$stmt->bind_result($id); 
		if ($stmt->fetch()) 
	 		$id_game = $id;

		$stmt->close();
		
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

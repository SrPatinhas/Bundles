<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
		header("location:index.php");
	}
	require_once ("config/config.php");
	include("config/functions.php");

		$nome 	= $_POST['nome_bundle'];
		$capa 	= $_POST['capa_bundle'];
		$price 	= $_POST['preco_bundle'];
		$dt_beg	= $_POST['data_inicio'];
		$dt_fim	= $_POST['data_fim'];
		$games	= $_POST['game'];

		$response = 'success';
		$erro_tipo ='';
		$query_jogos= "INSERT INTO `bundles`".
					"(`nome_bundle`, `preco_bundle`, `capa_bundle`, `data_ini_bundle`, `data_fim_bundle`)".
					"VALUES (?, ?, ?, ?, ?)";
		$stmt_jogos = $mydb->prepare($query_jogos); 
		$stmt_jogos->bind_param("sdsss", $nome, $price, $capa, $dt_beg, $dt_fim); 
		if ($stmt_jogos->execute()) { // exactly like this!
		    $successo = true;
		} else {
			$response = 'erro';
			$erro_tipo = 'bundle';
		}

		$stmt_jogos->close();

		$query= "select last_insert_id()"; 
		$stmt = $mydb->prepare($query); 
		$stmt->execute(); 
		$stmt->bind_result($id); 
		if ($stmt->fetch()) 
	 		$id_bundle = $id;

		$stmt->close();
		//separa e insere as categorias do jogo
		$games_split = explode(',',$games);
		if ($games_split[0] != 0) {
			foreach($games_split as $id_game) {
				if (insert_game_bundle($id_game, $id_bundle) == false) {
					$response = 'erro';
					$erro_tipo = 'jogo';
				}
			}
		}

		$bundle_list = list_game_bundle($id_bundle);
		
		//************************************************************************************************************

		$success = array(
			"tipo" => 'success',
			"id_bundle" => $id_bundle,
			"titulo" => $nome,
			"img" => $capa,
			"preco" => $price,
			"jogos" => $bundle_list,
			"inicio" => $dt_beg,
			"fim" => $dt_fim,
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

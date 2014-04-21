<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
		header("location:index.php");
	}
	require_once ("config/config.php");
	include("config/functions.php");

		$nome 	= $_POST['nome'];
		$capa 	= $_POST['capa'];
		$video 	= $_POST['trailler'];
		$info 	= $_POST['info'];
		$dt 	= $_POST['data'];
		$plat 	= $_POST['plat'];
		$cat 	= $_POST['cat'];

		$video	= str_replace("watch?v=", "embed", $video);

		$response = 'success';
		$erro_tipo ='';
		$query_jogos= "INSERT INTO `jogos`".
				 "(`nome_jogo`, `informacao`, `trailer`, `img_jogo`, `lanc_jogo`)". 
				 " VALUES (?,?,?,?,?)"; 
		$stmt_jogos = $mydb->prepare($query_jogos); 
		$stmt_jogos->bind_param("sssss", $nome, $info, $video, $capa, $dt); 
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
		//separa e insere as categorias do jogo
		$cat_split = explode(',',$cat);
		if ($cat_split[0] != 0) {
			foreach($cat_split as $id_cat) {
				if (insert_game_cat($id_game, $id_cat) == false) {
					$response = 'erro';
					$erro_tipo = 'categoria';
				}
			}
		}
		//separa e insere as plataformas do jogo
		$plat_split = explode(',',$plat);

		if ($plat_split[0] != 0) {
			foreach($plat_split as $id_plat) {
				if (insert_game_plat($id_game, $id_plat) == false) {
					$response = 'erro';
					$erro_tipo = 'plataforma';
				}
			}
		}

		$categoria 	= list_game_cat($id_game);
		$plataforma = list_game_plat($id_game);
		
		//************************************************************************************************************

		$success = array(
			"tipo" => 'success',
			"id_game" => $id_game,
			"titulo" => $nome,
			"img" => $capa,
			"categoria" => $categoria,
			"plataforma" => $plataforma,
			"lancamento" => $dt,
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

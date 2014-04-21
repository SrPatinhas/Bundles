<?php
	$stmt = null;
	require_once ("config.php");
//inserir as categorias pertencentes ao jogo
	function insert_game_cat($id_game, $id_cat){
		global $mydb;
	    $query_cat_in= "INSERT INTO `jogos_cat` (`id_jogo`, `id_cat`) VALUES (?,?)"; 
		$stmt_cat_in = $mydb->prepare($query_cat_in); 
		$stmt_cat_in->bind_param("ii", $id_game, $id_cat); 
		if ($stmt_cat_in->execute()) { // exactly like this!
		    $success = true;
		} else {
			$success = false;
		}
		$stmt_cat_in->close();
		return $success;
	}
//inserir as plataformas pertencentes ao jogo
	function insert_game_plat($id_game, $id_plat){
		global $mydb;
	    $query= "INSERT INTO `jogos_plat` (`id_jogo`, `id_plat`) VALUES (?,?)"; 
		$stmt = $mydb->prepare($query); 
		$stmt->bind_param("ii", $id_game, $id_plat); 
		if ($stmt->execute()) { // exactly like this!
		    $success = true;
		} else {
			$success = false;
		}
		$stmt->close();
		return $success;
	}
//listar as plataformas do jogo 
	function list_game_plat($id_game){
		global $mydb;
		$success = array();

	    $query= "SELECT plat.nome_plat FROM plataforma as plat LEFT JOIN jogos_plat as jpl on plat.id_plat = jpl.id_plat WHERE jpl.id_jogo = ?"; 
		$stmt = $mydb->prepare($query); 
		$stmt->bind_param("i", $id_game); 
		$stmt->execute();
		$stmt->bind_result($nome_plat); 
		while ($stmt->fetch()) { 
			$success[] = $nome_plat;
		}
		$stmt->close();
		return $success;
	}
//listar as categorias do jogo
	function list_game_cat($id_game){
		global $mydb;
		$success = array();

	    $query= "SELECT cat.nome_cat FROM categorias as cat LEFT JOIN jogos_cat as jc on cat.id_cat = jc.id_cat WHERE jc.id_jogo = ?"; 
		$stmt = $mydb->prepare($query); 
		$stmt->bind_param("i", $id_game);
		$stmt->execute();
		$stmt->bind_result($nome_cat); 
		while ($stmt->fetch()) { 
			$success[] = $nome_cat;
		}
		$stmt->close();
		return $success;
	}
//inserir os jogos pertencentes aos bundles
	function insert_game_bundle($id_game, $id_bundle){
		global $mydb;
	    $query_game_in= "INSERT INTO `bundle_jogos`(`id_bundle`, `id_jogo`) VALUES (?, ?)"; 
		$stmt_game_in = $mydb->prepare($query_game_in); 
		$stmt_game_in->bind_param("ii",$id_bundle, $id_game); 
		if ($stmt_game_in->execute()) { // exactly like this!
		    $success = true;
		} else {
			$success = false;
		}
		$stmt_game_in->close();
		return $success;
	}
//listar os jogos pertencentes aos bundles
	function list_game_bundle($id_bundle){
		global $mydb;
		$success = array();

	    $query= "SELECT j.nome_jogo FROM jogos as j LEFT JOIN bundle_jogos as bj on j.id_jogo = bj.id_jogo WHERE bj.id_bundle = ?"; 
		$stmt = $mydb->prepare($query); 
		$stmt->bind_param("i", $id_bundle);
		$stmt->execute();
		$stmt->bind_result($nome_jogo); 
		while ($stmt->fetch()) { 
			$success[] = $nome_jogo;
		}
		$stmt->close();
		return $success;
	}
//atualizar os utilizadores
	function alterarUser($id, $campo, $valor) { 
		global $mydb; 
		$query= "UPDATE user SET $campo=? WHERE id_user = ? "; 
		$stmt = $mydb->prepare($query);
		$stmt->bind_param("si" , $valor, $id); 
		$stmt->execute(); 
		return $stmt->affected_rows==1; // TRUE se alterou 1 linha 
		$stmt->close();
	} 
//apagar os utilizadores
	function apagarUser($id) { 
		global $mydb; 
		$query= "DELETE FROM user WHERE id_user = ? "; 
		$stmt = $mydb->prepare($query);
		$stmt->bind_param("i" , $id); 
		$stmt->execute(); 
		return $stmt->affected_rows==1; // TRUE se alterou 1 linha 
		$stmt->close();
	} 
?>
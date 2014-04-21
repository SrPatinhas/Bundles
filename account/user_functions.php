<?php
	$stmt = null;
	require_once ("../config/config.php");

//listar as o nome de utilizador 
		function disp_name($valor){
			global $mydb;
		    $query= "SELECT * FROM user WHERE username = ?"; 
			$stmt = $mydb->prepare($query); 
			$stmt->bind_param("s", $valor); 
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows; // TRUE se alterou 1 linha 
			$stmt->close();
		}
//listar as o nome de utilizador 
		function disp_mail($valor){
			global $mydb;
		    $query= "SELECT * FROM user WHERE email_user = ?"; 
			$stmt = $mydb->prepare($query); 
			$stmt->bind_param("s", $valor); 
			$stmt->execute(); 
			return $stmt->mysqli_num_rows; // TRUE se alterou 1 linha 
			$stmt->close();
		}
//atualizar o nome das informações pertencentes ao utilizador
	function func_name($valor, $id){
		global $mydb;
	    $query= "UPDATE user SET nome_user=? WHERE id_user = ? "; 
		$stmt = $mydb->prepare($query);
		$stmt->bind_param("si" , $valor, $id); 
		$stmt->execute(); 
		return $stmt->affected_rows==1; // TRUE se alterou 1 linha 
		$stmt->close();
	}
//atualizar o username das informações pertencentes ao utilizador
	function func_username($new_valor, $old_valor, $id){
		global $mydb;
		if (disp_name($new_valor) == 0) {
		    $query= "UPDATE user SET username=? WHERE id_user = ? "; 
			$stmt = $mydb->prepare($query);
			$stmt->bind_param("si" , $new_valor, $id); 
			$stmt->execute();
			if (($stmt->affected_rows)==1){
				return $new_valor;
			}
			$stmt->close();
		} else {
			if ($old_valor == $new_valor) {
				return "<b>$old_valor</b>";
			}else{
				return "<b>$new_valor</b> já existe! O nome continuará a ser <b>$old_valor</b>";
			}
		}
	}
//atualizar o email das informações pertencentes ao utilizador
	function func_email($new_valor, $old_valor, $id){
		global $mydb;
		if (disp_mail($new_valor) == 0) {
		    $query= "UPDATE user SET email_user=? WHERE id_user = ? "; 
			$stmt = $mydb->prepare($query);
			$stmt->bind_param("si" , $new_valor, $id); 
			$stmt->execute(); 
			if (($stmt->affected_rows)==1){
				return $new_valor;
			}
			$stmt->close();
		} else {
			if ($old_valor == $new_valor) {
				return "<b>$old_valor</b>";
			}else{
				return "<b>$new_valor</b> já existe! O nome continuará a ser <b>$old_valor</b>";
			}
		}
	}
//atualizar o avatar das informações pertencentes ao utilizador
	function func_avatar($valor, $id){
		global $mydb;
	    $query= "UPDATE user SET avatar_user=? WHERE id_user = ? "; 
		$stmt = $mydb->prepare($query);
		$stmt->bind_param("si" , $valor, $id); 
		$stmt->execute(); 
		return $stmt->affected_rows==1; // TRUE se alterou 1 linha 
		$stmt->close();
	}
?>
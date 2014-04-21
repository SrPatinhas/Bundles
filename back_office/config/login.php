<?php
	session_start();
	include("config.php");

	$is_ajax = $_REQUEST['is_ajax'];
	if(isset($is_ajax) && $is_ajax){
		$user = $_REQUEST['username'];
		$pass = md5($_REQUEST['password']);
		
		$query_nome= "SELECT id_user, type from user where (username=?) and (pass_user=?)"; 
		$stmt_nome = $mydb->prepare($query_nome); 
		$stmt_nome->bind_param("ss", $user, $pass); 
		$stmt_nome->execute(); 
		$stmt_nome->bind_result($id, $tipo); 

		if($stmt_nome->fetch()){
			if (($tipo=="administrador") or ($tipo=="developer")){
				$_SESSION["admin_log"]=$tipo;
				echo "success";
			}
		}
	}
	$stmt_nome->close();
	$mydb->close(); 

?>

<?php
	include("../config/config.php");
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_COOKIE["id_user"])){
        $_SESSION["id_user"] = $_COOKIE["id_user"];
        $user = $_COOKIE["id_user"];
    }else{
        if (isset($_SESSION["id_user"])){
            $user = $_SESSION["id_user"];
        }
    }
	
	if($_POST['id']){
		$id_bundle = $_POST['id'];

		$query_fav= "select id_user from favoritos where id_user=? and id_bundle=?"; 
		$stmt_fav = $mydb->prepare($query_fav); 
		$stmt_fav->bind_param("ii", $user, $id_bundle); 
		$stmt_fav->execute();
		$stmt_fav->store_result();
		if ($stmt_fav->num_rows == 0) {
			$query= "insert into favoritos ". 
				 	"(id_user, id_bundle) ". 
				 	"value (?, ?)"; 
			$stmt = $mydb->prepare($query); 
			$stmt->bind_param("ii", $user, $id_bundle); 
			$stmt->execute();
			if (($stmt->affected_rows)==1){
				echo "ok";
			}
			$stmt->close();
		} else {
			$query= "DELETE FROM favoritos WHERE id_user=? and id_bundle=?";
			$stmt = $mydb->prepare($query); 
			$stmt->bind_param("ii", $user, $id_bundle); 
			$stmt->execute();
			if (($stmt->affected_rows)==1){
				echo "ok";
			}
			$stmt->close();
		}
		$stmt_fav->close();
	}
?>
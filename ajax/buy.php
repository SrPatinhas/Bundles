<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_COOKIE["id_user"])){
        $_SESSION["id_user"] = $_COOKIE["id_user"];
        $_SESSION["user"] = $_COOKIE["user"];
        $user = $_COOKIE["id_user"];
    }else{
        if (isset($_SESSION["id_user"])){
            $user = $_SESSION["id_user"];
        } else {
            $user = "";
        }
    }
	include("../config/config.php");
	include("../config/functions.php");

	$error = "";

	$id_bundle  = $_POST["id"];
	$preco  = $_POST["preco"];
	$email 	= $_POST["email"];
	$gift 	= $_POST["gift"];
	
	if (isset($_POST["preco"])) {
		$preco  = $_POST["preco"];
	} else {
		$error.= "<li>Preço vazio!!</li>";
	}

	if (isset($_POST["email"])) {
		$email  = $_POST["email"];
	} else {
		$error.= "<li>Email vazio!!</li>";
	}
	if (isset($_POST["gift"])) {
		$gift  = $_POST["gift"];
	}

	if (strlen($gift) > 5) {
		$email = $gift;
	}

	if ($error === "") {
		#inserir dados na tabela user
		$key = array(getKey(4), getKey(4), getKey(4), getKey(4));


		$key = implode(" - ", $key);

		$query= "INSERT INTO `compras`( `id_user`, `email_gift`, `valor`, `id_bundle`, `key`) VALUES (?,?,?,?,?)"; 
		$stmt = $mydb->prepare($query); 
		$stmt->bind_param("sssss", $user, $email, $preco, $id_bundle, $key); 
		$stmt->execute();
		$stmt->close();
		$response = 'success';

	} else {
		$response = 'erro';
		$erro = array(
			"tipo" => 'erro',
			"msg" => "<ul style='display: inline-block;'>".$error."</ul>",
		);

	}
		// Finally depending on the button value, JSON encode our winetable and print it
	if ($response == "success") {
	  print json_encode($success);
	}
	else {
	  print json_encode($erro);
	}

		
?>
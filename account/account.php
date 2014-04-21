<?php
    if (isset($_SESSION["user"])){
        $user = $_SESSION["user"];
    } else {
        $user = "";
    }

	include("../config/config.php");
	include("../config/functions.php");

	$type   = $_GET["type"];
	$token  = $_GET["token"];
	$email  = $_GET["email"];

	if ($type === "cancel") {

		$query_cancel = "DELETE FROM user WHERE token = ? and email_user = ?  "; 
		$stmt_cancel = $mydb -> prepare($query_cancel); 
		$stmt_cancel -> bind_param("ss", $token, $email); 
		$stmt_cancel -> execute(); 
		if ($stmt_cancel->affected_rows==1){
			$msg = "success";
			$msg_text = "Cancelamento do registo feito com sucesso!!";
		} else {
			$stmt_cancel->close();
			$msg = "error";

			$query_user_c_email= "SELECT id_user from user where email_user = ?"; 
			$stmt_user_c_email = $mydb->prepare($query_user_c_email);
			$stmt_user_c_email->bind_param("s", $email); 
			$stmt_user_c_email->execute();
			$stmt_user_c_email->bind_result($id); 

			if ($stmt_user_c_email->fetch()){
				$msg_text = "Erro ao cancelar o registo!!";
			} else {
				$msg_text = "Esse email não está registado no nosso site!!";
			}
			$stmt_user_c_email->close();		
		} 
	} else if ($type === "confirm") {

		$token_new = getToken(50);
		$verificar = "yes";

		$query_confirm= "UPDATE user set verificado = ?, token = ? where token = ? and email_user = ?"; 
		$stmt_confirm = $mydb->prepare($query_confirm); 
		$stmt_confirm->bind_param("ssss", $verificar, $token_new, $token, $email); 
		$stmt_confirm->execute(); 

		if ($stmt_confirm->affected_rows==1){
			$stmt_confirm->close();

			$msg = "success";
			$msg_text = "Confirmação do registo feito com sucesso!!";
		} else{
			$stmt_confirm->close();
			$msg = "error";

			$query_user= "SELECT id_user from user where email_user = ? and verificado = 'yes'"; 
			$stmt_user = $mydb->prepare($query_user);
			$stmt_user->bind_param("s", $email); 
			$stmt_user->execute();
			$stmt_user->bind_result($id); 

			if ($stmt_user->fetch()){
				$stmt_user->close();
				$type_email = "double";
				$msg_text = "Email já registado!!";
			} else {
				$stmt_user->close();
				$query_user_email= "SELECT id_user from user where email_user = ?"; 
				$stmt_user_email = $mydb->prepare($query_user_email);
				$stmt_user_email->bind_param("s", $email); 
				$stmt_user_email->execute();
				$stmt_user_email->bind_result($id); 

				if ($stmt_user_email->fetch()){
					$msg_text = "Erro ao confirmar o registo!!";
				} else {
					$msg_text = "Esse email não está registado no nosso site!!";
				}
				$stmt_user_email->close();
			}				
		} 
	}
?>
<!doctype html>
<html lang="pt">
	<head>
		<meta charset="UTF-8">
		<title>Confirmação - Bundles&Bundles.net</title>
		<?php include("../header.php"); ?>
	</head>
	<body>
		<div class="top_menu">
			<?php include("../menu.php"); ?>
		</div>
		<div class="dead_space"></div>
		<div class="conteudo">
		<?php 
			if ($user == "") {
				if ($msg == "success") { 
		?>
					<div class="alert-box success">
					    <span>sucesso: </span><?php echo $msg_text; ?>
					</div>
		<?php 
					if ($type == "cancel") { 
		?>
						<a href="#" data-toggle="modal" data-target="#Modal_register">
			      			<button class="btn btn-default">Registar</button>
			            </a>
		<?php
					} else {
		?>
			            <a href="#" data-toggle="modal" data-target="#Modal_login">
			      			<button class="btn btn-default">Login</button>
			            </a>
		<?php
					}
				}
				if ($msg == "error") { 
		?>
					<div class="alert-box error">
					    <span>erro: </span><?php echo $msg_text; ?>
					</div>
		<?php 
					if ($type_email == "double") { 
		?>
			            <a href="#" data-toggle="modal" data-target="#Modal_login">
			      			<button class="btn btn-default">Login</button>
			            </a>
		<?php
					} else {
		?>
						<a href="#" data-toggle="modal" data-target="#Modal_register">
			      			<button class="btn btn-default">Registar</button>
			            </a>
		<?php
					}
				}
			} else { 
		?>
				<div class="alert-box error">
				    <span>erro: </span>Voçe já se encontra ligado ao site!! Pretende 
				    <a href="../config/logout.php">sair?</a>
				</div>
		<?php
			}
		?>

			
			
		</div>
		<div class="footer">
			<div class="footer_back"></div>
			<?php include("../footer.php"); ?>
		</div>
			<?php include("../modal_search.php"); ?>
	</body>
</html>
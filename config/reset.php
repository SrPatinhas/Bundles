<?php
	include("config.php");
	//include("functions.php");

	$type   = $_GET["type"];

	// if (isset($_GET["email"])) {
	// 	$email  = $_GET["email"];
	// } else {
	// 	$email = "";
	// }
	// if (($type === "email") and ($email !="" )) {
	// 	$token_new = getToken(50);
	// 	$query_confirm= "UPDATE user set token = ? where email_user = ?"; 
	// 	$stmt_confirm = $mydb->prepare($query_confirm); 
	// 	$stmt_confirm->bind_param("ss", $token_new, $email); 
	// 	$stmt_confirm->execute(); 
	// }

	if ($type === "user") {

	} else if ($type === "pass") {
		
	} else {

	}
?>
<!doctype html>
<html lang="pt">
	<head>
		<meta charset="UTF-8">
		<title>Reset de dados - Bundles&Bundles.net</title>
		<?php include("../header.php"); ?>
	</head>
	<body>
		<div class="top_menu">
			<?php include("../menu.php"); ?>
		</div>
		<div class="dead_space"></div>
		<div class="conteudo">

		</div>
		<div class="footer">
			<div class="footer_back"></div>
			<?php include("../footer.php"); ?>
		</div>
			<?php include("../modal_search.php"); ?>
	</body>
</html>
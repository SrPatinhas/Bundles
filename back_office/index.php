<?php
	session_start();
	if (isset($_SESSION["admin_log"])){
		if (($_SESSION["admin_log"]=="administrador") or  ($_SESSION["admin_log"]=="developer")){
			header("location:home.php");
		}
	}
    if (isset($_COOKIE["id_user"])){
        $_SESSION["tipo"] = $_COOKIE["tipo"];
        $_SESSION["admin_log"] = $_SESSION["tipo"];
        header("location:home.php");
    }else{
        if (isset($_SESSION["id_user"])){
	        $_SESSION["admin_log"] = $_SESSION["tipo"];
	        header("location:home.php");
        } else {
            $user = "";
            $tipo = "";
        }
    }
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Login PHP</title>
	<link rel="stylesheet" href="public/css/style_base.css" />
	<link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="public/js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript">
	
	$(document).ready(function(){
		$("#login").click(function(){
			
			var action = $("#lg-form").attr('action');
			var form_data = {
				username: $("#username").val(),
				password: $("#password").val(),
				is_ajax: 1
			};
			
			$.ajax({
				type: "POST",
				url: action,
				data: form_data,
				success: function(response)
				{
					if(response == "success"){
						$("#lg-form").slideUp('slow', function(){
							$("#message").html('<p class="success">Login efectuado!</p><p>Redirecionando....</p>');
						});
						setTimeout(function () {
						   window.location.href = "home.php"; //will redirect to your page
						}, 2000); //will call the function after 2 secs.
					} else
						$("#message").html('<p class="error">ERROR: Nome Utilizador e/ou password errada</p>');
				}	
			});
			return false;
		});
	});
	</script>
</head>
<body>
	<div class="lg-container">
		<h1>Admin Area</h1>
		<form action="config/login.php" id="lg-form" name="lg-form" method="post">
			
			<div>
				<label for="username">Username:</label>
				<input type="text" name="username" id="username" placeholder="username"/>
			</div>
			
			<div>
				<label for="password">Password:</label>
				<input type="password" name="password" id="password" placeholder="password" />
			</div>
			
			<div>				
				<button type="submit" id="login">Login</button>
			</div>
			
		</form>
		<div id="message"></div>
	</div>
</body>
</html>
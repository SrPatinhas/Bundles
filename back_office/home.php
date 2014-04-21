<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
		header("location:index.php");
	}
	require_once ("config/config.php");
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Entrada</title>

		<script type="text/javascript" src="public/js/jquery-1.10.2.min.js"></script>
		<link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="public/css/jquery-ui-1.10.3.custom.css" />
		<link rel="stylesheet" href="public/css/style_base.css" />
	<!-- jquery e css de bootstrap  -->
		<link rel="stylesheet" href="public/css/bootstrap.css" />
		<link rel="stylesheet" href="public/css/bootstrap-theme.css" />
		<script src="public/js/bootstrap.js"></script>

		<script src="../public/jquery/jquery-ui-1.10.3.custom.js"></script>
		
		<!-- tabs jquery -->
			<script>
				$(function() {
					$("#tabs_conteudo").tabs({
						beforeLoad: function (event, ui) {
							if (ui.tab.data("loaded")) {
								event.preventDefault();
								return;
							}
							ui.ajaxSettings.cache = false,
							ui.panel.html('<img src="../public/img/loader.gif" width="24" height="24" style="vertical-align:middle;"> Loading...'),
							ui.jqXHR.success(function() {
								ui.tab.data( "loaded", true );
							}),
							ui.jqXHR.error(function () {
								ui.panel.html("Erro ao Carregar a página desejada, recarregue a página e aguarde. ");
							});
						}
					});
					$("#tab_out").click(function(){
						window.location.href = 'config/logout.php';
					});
					$("#tab_site").click(function(){
						window.location.href = '../index.php';
					});
			   		$("#tabs_conteudo").tabs({
			   			hide: { effect: "drop", duration: 500 },
					    show: { effect: "drop", duration: 500 }
					});
				});
			</script>
</head>
<body>
	<div class="office">
		<div id="tabs_conteudo">
				<ul >
					<li><a href="jogos.php" class="tab_change" id="tab_game">Jogos</a></li>
					<li><a href="bundle.php" class="tab_change" id="tab_bundle">Bundles</a></li>
					<li><a href="user.php" class="tab_change" id="tab_user">Utilizadores</a></li>
					<li><a href="cat.php" class="tab_change" id="tab_cat">Categorias</a></li>
					<li><a href="plat.php" class="tab_change" id="tab_plat">Plataformas</a></li>
					<li style="float: right;"><a href="#" id="tab_site">Front-office</a></li>
					<li style="float: right;"><a href="#" id="tab_out">Sair</a></li>
				</ul>
		</div>
	</div>
</body>
</html>
<?php
	$page_now = basename($_SERVER['PHP_SELF']);
	if ($page_now === "account.php") {
		$caminho = caminholocal();
	} else {
		require("config/functions.php");
		$caminho = caminholocal();
	}
?> 
	<!-- meta Tags -->

		<meta name="description" 	content="Bundles & Bundles">
		<meta name="keywords" 		content="bundles,jogo,PC,Steam,bundle bundle">
		<meta name="author" 		content="Miguel Cerejo, João Duarte, João Tavares, Ricardo Gomes">

	<!-- CSS -->
		
		<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/style_index.css">
		<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/style_menu.css">
		<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/bootstrap_custom.css">
		<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/css_menu_bar.css" />
		<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/menu_base.css" />
		<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/account.css">
		<!-- Load Icons -->
		<link rel="stylesheet" href="<?php echo $caminho; ?>public/font/bundle_icons.css">
		<link rel="stylesheet" href="<?php echo $caminho; ?>public/font/style_plat.css">
		<!-- Load Fonts -->
		<link href="http://fonts.googleapis.com/css?family=PT+Sans:regular,bold" rel="stylesheet" type="text/css" />
		<link href='http://fonts.googleapis.com/css?family=Terminal+Dosis' rel='stylesheet' type='text/css' />

		<!-- css tabs -->

			<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/jquery-ui-1.10.3.custom.css" />
		<!-- css modal popup-box search -->
			<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/bootstrap.min.css">
		<!-- Load CSS for search-->
			<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/css_search.css"/>
		<!-- Load CSS for countdown-->
			<link rel="stylesheet" href="<?php echo $caminho; ?>public/css/countdown.css">

	<!-- JavaScript -->

		<script src="<?php echo $caminho; ?>public/jquery/jquery-1.10.2.min.js"></script>
		
		<!-- menu jquery -->
			<script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

		<!-- jquery effects/ modal bootstrap - popup box -->
				<!-- modal -->
				<script src="<?php echo $caminho; ?>public/jquery/bootstrap.min.js"></script>
				<!-- Load custom js for search -->
				<script type="text/javascript" src="<?php echo $caminho; ?>ajax/search_js.php" ></script>

				<!-- Load custom js for subscriver, register and login -->
				<script type="text/javascript" src="<?php echo $caminho; ?>ajax/account.php"></script>
				
	<!-- Jquery -->

		<!-- menu jquery -->
	        <script>
	            $( "#label_pesquisa" ).click(function() {
	              $( "#div_pesquisa" ).toggle( "fast" );
	              $( "#label_pesquisa" ).toggle( "fast" );
	              $( "#label_pesquisa" ).css( "top", "9px" );
	            });
	            $( "#pesquisar_button" ).click(function() {
	              $( "#div_pesquisa" ).toggle( "fast" );
	              $( "#label_pesquisa" ).toggle( "fast" );
	              $( "#label_pesquisa" ).css( "top", "0px" );
	            });
	            $( "#Modal_login" ).keypress(function() {
	            	onKeyPress($( this).keypress());
	            });
	            $(document).on('keyup keydown keypress', '#Modal_login', function(event) {
					console.log(event);
					if(event.keyCode== 13) {
						$("#bt_login").trigger('click');
					}
				});
	            $(document).on('keyup keydown keypress', '#Modal_register', function(event) {
					console.log(event);
					if(event.keyCode== 13) {
						$("#bt_registar").trigger('click');
					}
				});
	        </script>
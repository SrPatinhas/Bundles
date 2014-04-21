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
?> 
			<script src="public/jquery/jquery-ui-1.10.3.custom.js"></script>
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
							ui.panel.html('<img src="public/img/loader.gif" width="24" height="24" style="vertical-align:middle; margin:auto;"> Loading...'),
							ui.jqXHR.success(function() {
								ui.tab.data( "loaded", true );
							}),
							ui.jqXHR.error(function () {
								ui.panel.html("Erro ao Carregar a página desejada, recarregue a página e aguarde. ");
							});
						}
					});
			   		$("#tabs_conteudo").tabs({
			   			hide: { effect: "fade", duration: 500 },
					    show: { effect: "fade", duration: 500 }
					});
					$( "#tabs_conteudo" ).tabs({ active: 1 });
					$('.check_paint[name*="plataforma"], .check_paint[name*="categoria"]').change(function() {
						$( "#tabs_conteudo" ).tabs({ active: 0 });
					});
					$("#tabs_conteudo").tabs({
						activate: function(event, ui) {
							var activa = $( "#tabs_conteudo" ).tabs( "option", "active" );
							if (activa != 0){
								$('#menu_bar_p').fadeOut();
							} else{
								$('#menu_bar_p').fadeIn();
							}
						}
					});
				});
			</script>

	<div id="tabs_conteudo">
		<ul>
			<li><a href="feed.php" class="tab_change" id="tab_feed">Pesquisa Personalizada</a></li>
			<li><a href="featured.php" class="tab_change" id="tab_featured">Bundle da Semana</a></li>
		<?php if ($user != "") { ?>
			<li><a href="account/history.php" class="tab_change" id="tab_recently">Histórico</a></li>
		<?php } ?>
		</ul>
	</div>
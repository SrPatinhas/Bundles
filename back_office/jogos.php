<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
		header("location:index.php");
	}
	include("config/config.php");
?>
		<script type="text/javascript" src="public/js/youtube_search.js"></script> 
		<script>
			$(function() {
				$("#confirm_game").click(function(e) {
					e.preventDefault();
					var plat_check = $('input.plataforma:checked').map(function(){
										return $(this).val();
									});
					var cat_check = $('input.categoria:checked').map(function(){
										return $(this).val();
									}); 
					var valor_form = $('#form_game').serialize() + "&plat=" + plat_check.get() + "&cat=" + cat_check.get();
					$.ajax({
						type: "POST",
						url: "save_game.php",
						data: valor_form,
						cache: false,
						dataType: 'json', // Choosing a JSON datatype
						success: function(data){ // Variable data contains the data we get from serverside
							$('#success_div').html(''); // Clear #success_div div
							$('#success_div').css('display','initial');
							if (data.tipo == 'success') { // If clicked buttons value is all, we post every wine
								$("#message").fadeIn(400).html("<p class='success'>Registo efectuado com successo!</p>");
									//limpar formulario
								$('#form_game').trigger("reset");
									//colocar resultado anterior numa div
								$("#success_div").fadeIn(400).append("<span class='close_success'>&#10006;</span>");
								$("#success_div").fadeIn(400).append("<div class='titulo_game'> " + data.titulo + "</div>");
								$("#success_div").fadeIn(400).append("<img class='image_game' src=" + data.img + " alt=" + data.titulo + ">");
								$("#success_div").fadeIn(400).append("<div class='cat_game' id='cat_" + data.id_game + "'>");
									$("#cat_"+data.id_game).fadeIn(400).append("<label> Categoria: </label>");
									for (var c in data.categoria) {
										$("#cat_"+data.id_game).fadeIn(400).append("<span class='mini_cat_game'> " + data.categoria[c] + "</span>");
									};
								$("#success_div").fadeIn(400).append("</div>");
								$("#success_div").fadeIn(400).append("<div class='plat_game' id='plat_" + data.id_game + "''>");
									$("#plat_"+data.id_game).fadeIn(400).append("<label> Plataforma: </label>");
									for (var p in data.plataforma) {
										$("#plat_"+data.id_game).fadeIn(400).append("<span class='mini_plat_game'> " + data.plataforma[p] + "</span>");
									};
								$("#success_div").fadeIn(400).append("</div>");
								$("#success_div").fadeIn(400).append("<div class='data_game'><label>Data de Lançamento: </label><span class='mini_data_game'>" + data.lancamento + "</span></div>");
								$('#form_game').trigger("reset");
								$('.clear_input').removeClass('x onX').val('');
							}
							else if (data.tipo == 'erro') { // If clicked buttons value is red, we post only red wines
								$('#success_div').html(''); // Clear #success_div div
								$('#success_div').css('display','initial');
								$("#message").fadeIn(400).html('<p class="error">ERROR: Falha no registo de dados</p>');	
								$("#success_div").fadeIn(400).append("<div class='titulo_game'> " + data.titulo + "</div>");
								$("#success_div").fadeIn(400).append("<img class='image_game' src=" + data.img + " alt=" + data.titulo + ">");
							}
						}
					});
      				return false;
				});
				$('#video_youtube').on('click', '.add_video_youtube', function (event) {
		        	event.preventDefault();
					var link = $(this).attr("rel-link"); 
					$("#trailler").val(link);
					$(".search_input_youtube").val('');
					$(".search_input_youtube").keyup();
				});
				$('#success_div').on('click', '.close_success', function (event) {
		        	event.preventDefault();
					$('#success_div').html(''); // Clear #success_div div
					$('#success_div').css('display','none');
				});
			}); 
		</script>
	</head>
	<body>
		<div id="success_div"></div>
		<div class="lg-container">
			<form name="produto" id="form_game">
				<fieldset>
					<legend><h1>Registo de Jogos</h1></legend>
					<div>
						<label for="nome" id="Nome">Nome</label><br>
						<input id="nome" name="nome" type="text" class="required clear_input">
					</div>
					<br>
					<div>
						<label for="capa" id="capa">Capa do Jogo</label><br>
						<input id="capa" name="capa" type="text" class="required clear_input">
					</div>
					<br>
					<div>
						<label for="trailler" id="trailler_lb">Trailer</label><br>
						<input id="trailler" name="trailler" type="text" class="required clear_input">
					</div>
					<br>
					<div>
						<label for="info" id="info">Descrição do jogo</label><br>
						<textarea name="info" id="info" cols="30" rows="10" class="info clear_input"></textarea>
					</div>
					<br>
					<div style="float: left; margin-bottom:50px;">
						<label for="categorias" id="categorias">Categorias</label><br>
						<?php
							$query_cat= "select id_cat, nome_cat from categorias"; 
							$stmt_cat = $mydb->prepare($query_cat);
							$stmt_cat->execute(); 

							$stmt_cat->bind_result($id, $nome); 
							while ($stmt_cat->fetch()) { 
								echo "<input id='categorias_$id' class='categoria' type='checkbox' value='$id'>";
								echo "<label for='categorias_$id' id='categorias'>$nome</label><br>";
							} 	

							$stmt_cat->close();
						?>
					</div>
					<br>
					<div style="float: left; margin: 10px 50px;">
						<label for="plataforma" id="plataforma">Plataformas</label><br>
						<?php
							$query_plat= "select id_plat, nome_plat, img_plat from plataforma"; 
							$stmt_plat = $mydb->prepare($query_plat);
							$stmt_plat->execute(); 

							$stmt_plat->bind_result($id, $nome, $img); 
							while ($stmt_plat->fetch()) { 
								echo "<img src='../$img' alt='capa' style='width:30px;height: 30px;'>";
								echo "<input id='plataforma_$id' class='plataforma' type='checkbox' value='$id'>";
								echo "<label for='plataforma_$id' id='plataforma'>$nome</label><br>";
							} 
							$stmt_plat->close();
							$mydb->close(); 
						?>
					</div>
					<br>
					<div style="clear: both;">
						<label for="data" id="data">Data de Lançamento</label><br>
						<input id="data" name="data" type="date" class="required">
					</div>
					<div class="row">
						<button id="confirm_game">Guardar</button>
					</div>
					<div id="message"></div>
				</fieldset>
			</form>
		</div>
		<!--pesquisa de videos no youtube -->
		<div id="input_box_youtube">
			<input id="pesquisa_youtube" type="text" class='search_input_youtube clear_input' placeholder="Pesquisar videos no Youtube...">
			<div class="video_up_youtube" id="video_youtube"></div>
		</div>
	</body>
</html>
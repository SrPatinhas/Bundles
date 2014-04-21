<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
		header("location:index.php");
	}
	require_once ("config/config.php");
?>
		 <script>
			$(function() {
				$("#confirm_bundle").click(function(e) {
					e.preventDefault();
					var game_check = $('input.games:checked').map(function(){
										return $(this).val();
									}); 
					var valor_form = $('#form_bundle').serialize() + "&game=" + game_check.get();
					$.ajax({
						type: "POST",
						url: "save_bundle.php",
						data: valor_form,
						cache: false,
						dataType: 'json', // Choosing a JSON datatype
						success: function(data){ // Variable data contains the data we get from serverside
							$('#success_div_bundle').html(''); // Clear #success_div div
							$('#success_div_bundle').css('display','initial');
							if (data.tipo == 'success') { // If clicked buttons value is all, we post every wine
								$("#message_bundle").html("<p class='success'>Registo efectuado com successo!</p>");
									//limpar formulario
								$('#form_bundle').trigger("reset");
									//colocar resultado anterior numa div
								$("#success_div_bundle").append("<span class='close_success'>&#10006;</span>");
								$("#success_div_bundle").append("<div class='titulo_game'> " + data.titulo + "</div>");
								$("#success_div_bundle").append("<img class='image_game' src=" + data.img + " alt=" + data.titulo + ">");
								$("#success_div_bundle").append("<div class='preco_game'><label>Preço: </label><span class='mini_data_game'>" + data.preco + "€</span></div>");
								$("#success_div_bundle").append("<div class='data_game'><label>Data de Lançamento: </label><span class='mini_data_game'>" + data.inicio + " até " + data.fim + "</span></div>");
								$("#success_div_bundle").append("<div class='cat_game' id='game_" + data.id_game + "'>");
								$("#game_"+data.id_game).append("<label> Jogos: </label>");
									for (var j in data.jogos) {
										$("#game_"+data.id_game).append("<span class='mini_cat_game'> " + data.jogos[j] + "</span>");
									};
								$("#success_div_bundle").append("</div>");
							} else if (data.tipo == 'erro') { // If clicked buttons value is red, we post only red wines
								$('#success_div_bundle').html(''); // Clear #success_div_bundle div
								$('#success_div_bundle').css('display','initial');
								$("#message_bundle").html('<p class="error">ERROR: Falha no registo de dados</p>');	
								$("#success_div_bundle").append("<div class='titulo_game'> " + data.titulo + "</div>");
								$("#success_div_bundle").append("<img class='image_game' src=" + data.img + " alt=" + data.titulo + ">");
							}
						}
					});
      				return false;
				});
			});
			$(function() {
				$('#jogos_bundle').bind('keyup change', function () {
				    filtrar_jogo(this);
				});
				function filtrar_jogo(element) {
				   	var $trs = $('#games_search_bundle tr').hide();
				    var regexp = new RegExp($(element).val(), 'i');

				    var $valid = $trs.filter(function () {
				        return regexp.test($(this).find('td:last-child').text())
				    }).show();

				    $trs.not($valid).hide()
				}
				function tog(v){return v?'addClass':'removeClass';} 

				$(document).on('input', '.clearable', function(){
					$(this)[tog(this.value)]('x');
				}).on('mousemove', '.x', function( e ){
					$(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');   
				}).on('click', '.onX', function(){
					$(this).removeClass('x onX').val('');
					filtrar_jogo(this);
				});
			});
		</script>
		
	</head>
	<body>
		<div id="success_div_bundle"></div>
		<div class="lg-container">
			<form name="produto" id="form_bundle">
				<fieldset>
					<legend><h1>Registo de Bundles</h1></legend>
					<div>
						<label for="nome_bundle" id="nome_bundle">Nome do bundle</label><br>
						<input id="nome_bundle" name="nome_bundle" type="text" class="required">
					</div>
					<br>
					<div>
						<label for="capa_bundle" id="capa_bundle">Capa do Jogo</label><br>
						<input id="capa_bundle" name="capa_bundle" type="text" class="required">
					</div>
					<br>
					<div>
						<input class="clearable" id="jogos_bundle" name="jogos_bundle" style="width: 230px;" type="text" placeholder="Pesquisa do Jogo">
					</div>
					<div class="games_for_bundle">
						<table id="games_search_bundle">
						    <?php
								$query_cat= "select id_jogo, nome_jogo, img_jogo from jogos"; 
								$stmt_cat = $mydb->prepare($query_cat);
								$stmt_cat->execute(); 

								$stmt_cat->bind_result($id, $nome, $img); 
								while ($stmt_cat->fetch()) {
									echo "<tr>";
									echo "	<td><img src='$img' alt='capa' style='width:30px;height: 30px;'></td>";
									echo "	<td><input id='games_$id' class='games' type='checkbox' value='$id'></td>";
									echo "	<td><label for='games_$id' id='games'>$nome</label></td>";
									echo "</tr>";
								}
								$stmt_cat->close();
							?>
						</table>
					</div>
					<div>
						<label for="preco_bundle" id="preco_bundle">Preço</label><br>
						<input id="preco_bundle" name="preco_bundle" type="text" class="required">
					</div>
					<br>
					<div>
						<label for="data_inicio" id="data_inicio">Data de Inicio</label><br>
						<input id="data_inicio" name="data_inicio" type="date" class="required">
					</div>
					<div>
						<label for="data_fim" id="data_fim">Data de Fim</label><br>
						<input id="data_fim" name="data_fim" type="date" class="required">
					</div>
					<div class="row">
						<button id="confirm_bundle">Guardar</button>
					</div>
					<div id="message_bundle"></div>
				</fieldset>
			</form>
		</div>
	</body>
</html>
<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
		header("location:index.php");
	}
	require_once ("config/config.php");
?>
		 <script>
			$(function() {
				$("#confirm_plat").click(function(e) {
					e.preventDefault();
					var valor_form = $('#form_plat').serialize();
					$.ajax({
						type: "POST",
						url: "save_plat.php",
						data: valor_form,
						cache: false,
						dataType: 'json', // Choosing a JSON datatype
						success: function(data){ // Variable data contains the data we get from serverside
							$('#success_div_plat').html(''); // Clear #success_div div
							$('#success_div_plat').css('display','initial');
							$('#success_div_plat').css('background','rgba(0, 128, 0, 0.48)');
							if (data.tipo == 'success') { // If clicked buttons value is all, we post every wine
								$("#message_plat").fadeIn(400).html("<p class='success'>Registo efectuado com successo!</p>");
									//limpar formulario
								$('#form_plat').trigger("reset");
									//colocar resultado anterior numa div
								$("#list_plataform").fadeIn(400).append("<li><img class='plat_" + data.titulo + " src=" + data.image + " alt=" + data.titulo + ">");
								$("#list_plataform").fadeIn(400).append("<span class='plat_" + data.titulo + "'>" + data.titulo + "</span></li>");
							}
							else if (data.tipo == 'erro') { // If clicked buttons value is red, we post only red wines
								$('#success_div_plat').html(''); // Clear #success_div_plat div
								$('#success_div_plat').css('display','initial');
								$('#success_div_plat').css('background','rgba(223, 0, 0, 0.73)');
								$("#message_plat").fadeIn(400).html('<p class="error">ERROR: Falha no registo de dados</p>');	
								$("#success_div_plat").fadeIn(400).append("<div class='titulo_game'> " + data.titulo + "</div>");
								$("#success_div_plat").fadeIn(400).append("<img class='image_game' src=" + data.img + " alt=" + data.titulo + ">");
							}
						}
					});
      				return false;
				});
			});
		</script>
		
	</head>
	<body>
		<div class="lg-container">
			<form name="produto" id="form_plat">
				<fieldset>
					<div id="success_div_plat"></div>
					<legend><h1>Registo de Plataformas</h1></legend>
					<div>
						<label for="nome_plat" id="Nome_plat">Nome</label><br>
						<input id="nome_plat" name="nome_plat" type="text" class="required">
					</div>
					<br>
					<div>
						<label for="logo" id="logo">Logo da Plataforma</label><br>
						<input id="logo" size="100" name="logo" type="text" class="required" placeholder="http://exemplo.com/img.png">
					</div>
					<br>
					<div class="row">
						<button id="confirm_plat">Guardar</button>
					</div>
					<div id="message_plat"></div>
					<div>
						<label for="plataforma" id="plataforma_plat">Plataformas Existentes</label>
						<ul id="list_plataform">
							<?php
								$query_plat= "select id_plat, nome_plat, img_plat from plataforma"; 
								$stmt_plat = $mydb->prepare($query_plat);
								$stmt_plat->execute(); 

								$stmt_plat->bind_result($id, $nome, $img); 
								while ($stmt_plat->fetch()) { 
									echo "<li>";
									echo "	<img src='$img' alt='capa' class='plat_$nome'>";
									echo "	<span class='plat_$nome'>$nome</span>";
									echo "</li>";
								} 
								$stmt_plat->close();
								$mydb->close(); 
							?>
						</ul>
					</div>
				</fieldset>
			</form>
		</div>
	</body>
</html>
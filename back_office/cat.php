<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
		header("location:index.php");
	}
	require_once ("config/config.php");
?>
		 <script>
			$(function() {
				$("#confirm_cat").click(function(e) {
					e.preventDefault();
					var valor_form = $('#form_cat').serialize();
					$.ajax({
						type: "POST",
						url: "save_cat.php",
						data: valor_form,
						cache: false,
						dataType: 'json', // Choosing a JSON datatype
						success: function(data){ // Variable data contains the data we get from serverside
							$('#success_div_cat').html(''); // Clear #success_div div
							$('#success_div_cat').css('display','initial');
							if (data.tipo == 'success') { // If clicked buttons value is all, we post every wine
								$("#message_cat").fadeIn(400).html("<p class='success'>Registo efectuado com successo!</p>");
									//limpar formulario
								$('#form_cat').trigger("reset");
									//colocar resultado anterior numa div
								$("#list_categoria").fadeIn(400).append("<li class='new_category'>" + data.titulo + "</li>");
							}
							else if (data.tipo == 'erro') { // If clicked buttons value is red, we post only red wines
								$('#success_div_cat').html(''); // Clear #success_div_cat div
								$('#success_div_cat').css('display','initial');
								$("#messagecat").fadeIn(400).html('<p class="error">ERROR: Falha no registo de dados</p>');	
								$("#success_div_cat").fadeIn(400).append("<div class='titulo_game'> " + data.titulo + "</div>");
								$("#success_div_cat").fadeIn(400).append("<img class='image_game' src=" + data.img + " alt=" + data.titulo + ">");
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
			<form name="produto" id="form_cat">
				<fieldset>
					<div id="success_div_cat"></div>
					<legend><h1>Registo de Categorias</h1></legend>
					<div>
						<label for="nome_cat" id="Nome_cat">Nome</label><br>
						<input id="nome_cat" name="nome_cat" type="text" class="required">
					</div>
					<br>
					<div class="row">
						<button id="confirm_cat">Guardar</button>
					</div>
					<div id="message_cat"></div>
					<div>
						<label id="cat_categorias">Categorias Existentes</label><br>
						<ul id="list_categoria">
							<?php
								$query_cat= "select id_cat, nome_cat from categorias"; 
								$stmt_cat = $mydb->prepare($query_cat);
								$stmt_cat->execute(); 

								$stmt_cat->bind_result($id, $nome); 
								while ($stmt_cat->fetch()) { 
									echo "<li><span>$nome</span></li>";
								} 	

								$stmt_cat->close();
							?>
						</ul>
					</div>
				</fieldset>
			</form>
		</div>
	</body>
</html>

<?php 
	include("config/config.php");
	$id_get_bundle = $_GET['id'];
?>
<!doctype html>
<html lang="pt">
	<head>
		<meta charset="UTF-8">
		<title>Home - Bundles&Bundles.net</title>
		<?php 
			include("header.php"); 
		?>
		<script>
				$(function() {
					$(document).on('click', "#add_bundle_bookmarks", function() {
						var id = $(this).attr("data-id");
						var tipo = $(this).attr("data-tipo");
						var dataString = 'id='+ id ;
						$.ajax({
							type: "POST",
							url: "bookmarks/save_book.php",
							data: dataString,
							cache: false,
							success: function(html){
								if (tipo=="add") {
									$('#add_bundle_bookmarks').attr('data-tipo', 'remove');
									$('#label_fav').text('Remover dos Favoritos');
									$('#label_icon').removeClass().addClass('icon-heart-empty');
								}else{
									$('#add_bundle_bookmarks').attr('data-tipo', 'add');
									$('#label_fav').text('Adicionar aos Favoritos');
									$('#label_icon').removeClass().addClass('icon-heart');
								};
							} 
						});
						return false;
					});
				});
			</script>

	</head>
	<body>
		<div class="top_menu">
			<?php include("menu.php"); ?>
		</div>
		<div class="dead_space"></div>
		<div class="conteudo" style="width:950px;">
			<div class="bundle_pack effect7">
			<?php
			
				$query_bundle= "select id_bundle, nome_bundle, preco_bundle, capa_bundle, data_ini_bundle, data_fim_bundle from bundles where id_bundle = ?"; 
				$stmt_bundle = $mydb->prepare($query_bundle);
				$stmt_bundle->bind_param("i", $id_get_bundle); 
				$stmt_bundle->execute(); 

				$stmt_bundle->bind_result($id, $nome, $preco, $img, $data_ini, $data_fim); 
				while ($stmt_bundle->fetch()) { 
					$id_bundle = $id;
					$nome_bundle = $nome;
					$img = $img;
					$price_bundle = $preco;
					$data_ini = $data_ini;
					$data_fim = $data_fim;
				} 
				$stmt_bundle->close();
			?>
				<img class="bundle_capa" src="<?php echo "$img";?>" alt="<?php echo "$nome_bundle";?>">
				<div class="bundle_title offer-success effect8">	
					<div class="shape">
						<div class="shape-text">
							<?php echo round($preco, 2);?> €							
						</div>
					</div>
					<h1 class="title_bundle"><?php echo "$nome_bundle";?></h1>
					<br>
				</div>
				<div class="base_info_bundle info_bundle">
					<div class="time_bundle big-countdown">
						<span>Começou a <?php echo $data_ini;?> e acabou a <?php echo $data_fim;?></span>
					</div>
					<div class="buy_bundle">
					<?php 
						if ($user != "") { 
							$query_fav= "SELECT * FROM favoritos WHERE id_user=? AND id_bundle=?"; 
							$stmt_fav = $mydb->prepare($query_fav); 
							$stmt_fav->bind_param("ii", $user, $id_bundle); 
							$stmt_fav->execute();
							$stmt_fav->store_result();

							if ($stmt_fav->num_rows == 0) {
					?>
								<button type="button" class="button" data-tipo="add" data-id="<?php echo $id_bundle;?>" id="add_bundle_bookmarks">
									<span id="label_icon" class="icon-heart"></span><span id="label_fav">Adicionar aos Favoritos</span>
								</button>
					<?php 
							} else {
					?>
								<button type="button" class="button" data-tipo="remove" data-id="<?php echo $id_bundle;?>" id="add_bundle_bookmarks">
									<span id="label_icon" class="icon-heart-empty"></span><span id="label_fav">Remover dos favoritos</span>
								</button>
					<?php
							}
							$stmt_fav->close();
						}
						?>

					</div>
				</div>
			</div>
			<div class="game_pack  effect7">
				
				<div class="row">
 <?php
					$query_jogos= "SELECT j.*  FROM jogos AS j LEFT JOIN bundle_jogos AS b on b.id_jogo = j.id_jogo WHERE b.id_bundle = ? "; 
					$stmt_jogos = $mydb->prepare($query_jogos);
					$stmt_jogos->bind_param("i", $id_bundle); 
					$stmt_jogos->execute(); 

					$result_jogos = $stmt_jogos->get_result();
					while ($row_jogos = $result_jogos->fetch_assoc()) {

						 $id_jogo = $row_jogos['id_jogo'];
?>
						<div class="col-sm-6 col-md-4">
							<div class="thumbnail">
								<img <?php echo 'alt="'.$row_jogos["nome_jogo"].'" src="'.$row_jogos["img_jogo"].'"'; ?>style="max-width: 100%; max-height: 200px;">
								<div class="caption">
									<?php
										echo '<h3>'.$row_jogos["nome_jogo"].'</h3>';
										echo '<p>'.$row_jogos["lanc_jogo"].'</p>';
									?>
									<div style="float: right;font-size: 20px;">
										<?php echo getPlataformas($id_jogo);	?>
									</div>
									<button type="button" class="button expander_link" data-xid="expander_<?php echo $row_jogos['id_jogo']; ?>">
										<span class="icon-plus"></span>Ver Mais
									</button>
								</div>
							</div>
						</div>
<?php
					}
					$result_jogos->free();
					$stmt_jogos->close();
?>
					<div id="deadspace_expander" style="margin-top:40px;"></div>
<?php
					$query_jogos= "SELECT j.* FROM jogos AS j LEFT JOIN bundle_jogos AS b on b.id_jogo = j.id_jogo WHERE b.id_bundle = ?"; 
					$stmt_jogos = $mydb->prepare($query_jogos);
					$stmt_jogos->bind_param("i", $id_bundle); 
					$stmt_jogos->execute(); 

					$result_jogos = $stmt_jogos->get_result();
					while ($row_jogos = $result_jogos->fetch_assoc()) {
						 $id_jogo = $row_jogos['id_jogo'];
?>
						<div class="expander-information" data-tipo="none" id="expander_<?php echo $row_jogos['id_jogo']; ?>">
							<div class="expander-base">
								<div class="expander-image">
									<img <?php echo 'alt="'.$row_jogos["nome_jogo"].'" src="'.$row_jogos["img_jogo"].'"'; ?>>
								</div>
								<div class="expander-title">
									<?php
										echo '<h1>'.$row_jogos["nome_jogo"].'</h1>';
									?>
								</div>
								<div class="expander-computer">
									<div class="expander-platform">
										
									</div>
									<div class="expander-categorie">
										<p>
											Categorias: <?php echo getCategorias($id_jogo);	?>
										</p>
									</div>
									<div class="expander-lancamento">
										<p>
											Data de Lançamento: <?php echo $row_jogos['lanc_jogo']; ?>
										</p>
									</div>
								</div>
							</div>
							<div class="expander-more">
								<div class="expander-description">
									<p><h2>Descrição:</h2>
										<?php echo $row_jogos['informacao']; ?>
									</p>
								</div>
								<div class="expander-trailer">
									<iframe width="498" height="280" src="<?php echo $row_jogos['trailer']; ?>" frameborder="0" allowfullscreen></iframe>
								</div>
							</div>
							<div style="clear:both;"></div>
						</div>
<?php
					}
					$result_jogos->free();
					$stmt_jogos->close();
?>
				</div>
				<div id="before_buy_payment"></div>
			</div>
		<script>
			$(function() {
				$(".expander_link").click(function(){
					var exp = $(this).attr('data-xid');

					var scroller = $('#'+exp);
					var contents = scroller.wrapInner('<div>').children(); // wrap a div around the contents
					var height_div = contents.outerHeight() + 40; // read the inner divs height
					contents.replaceWith( contents.html() ); // unwrap the inner div

					// use the height variable now ..
					//alert( height );

					if ($('#'+exp).attr('data-tipo') =='show'){
						$('.thumbnail').removeClass('img-expander-active');
						$('.expander-information').animate({height: "0"}, 500 ).animate({
														 								padding: "0",
																						borderTopWidth: "0",
																						borderBottomWidth: "0",
													 								}, 0 );
						$('.expander-information').attr('data-tipo','none');
					} else {
						$('.thumbnail').removeClass('img-expander-active');
						$('.expander-information').animate({height: "0"}, 500 ).animate({
														 								padding: "0",
																						borderTopWidth: "0",
																						borderBottomWidth: "0",
													 								}, 0 );
						$('.expander-information').attr('data-tipo','none');
						$(this).parent().parent('.thumbnail').toggleClass('img-expander-active');
						//$('#'+exp).css('display','inline-block');
						$('#'+exp).animate({
											padding: "20px",
											borderTopWidth: "2px",
											borderBottomWidth: "2px"
										}, 0 ).animate({height: height_div}, 800);
						$('#'+exp).attr('data-tipo','show');
					}

					
				});
			});
		</script>
		</div>
		<div class="footer">
			<div class="footer_back"></div>
			<?php include("footer.php"); ?>
		</div>
			<?php include("modal_search.php"); ?>
			
	</body>
</html>
<?php 
	include("config/config.php");
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_COOKIE["id_user"])){
        $_SESSION["id_user"] = $_COOKIE["id_user"];
        $_SESSION["user"] = $_COOKIE["user"];
        $_SESSION["nome_user"] = $_COOKIE["nome_user"];
        $user = $_COOKIE["id_user"];
        $user_name = $_SESSION["user"];
        $nome_user = $_SESSION["nome_user"];
    }else{
        if (isset($_SESSION["id_user"])){
            $user = $_SESSION["id_user"];
            $user_name = $_SESSION["user"];
        	$nome_user = $_SESSION["nome_user"];
        } else {
        	$user = "";
        	$user_name ="";
        	$nome_user ="";
        }
    }
    include ('config/functions.php');
?> 
			<!-- Load custom js for countdown -->
			<script src="public/jquery/jquery.countdown.js"></script>
			<script>
				$(function() {
					$('[data-countdown]').each(function() {
						var $this = $(this), finalDate = $(this).data('countdown');
							$this.countdown(finalDate, function(event) {
								$this.html(event.strftime(''
									+ '<span>%d</span> D '
									+ '<span>%H</span> h '
									+ '<span>%M</span> m '
									+ '<span>%S</span>'));
								});
						$(this).on('finish.countdown', function(event) {
							$(this).parent()
							.addClass('disabled')
							.html('<strong>Este Bundle já acabou!!!</strong>');
							location.reload();
						});
					});
					
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
					$("#btn_pay_bundle").click(function () {
						$('html,body').animate({
							scrollTop: $("#before_buy_payment").offset().top
						}, "slow");
					});
				});
			</script>
			<div class="bundle_pack effect7">
			<?php
				$query= "SELECT id_bundle, nome_bundle, preco_bundle, capa_bundle, data_fim_bundle FROM bundles WHERE (data_ini_bundle <= CURDATE()) AND (data_fim_bundle >= CURDATE()) LIMIT 0,1"; 
				$stmt = $mydb->prepare($query); 
				$stmt->execute();
				$stmt->store_result();
				$valor_base_dados = $stmt->num_rows;
				if ($valor_base_dados == 0){
					echo "<div style='text-align:center;'>Sem Bundles para apresentar!!</div>";
				} else {
				$query_bundle= "SELECT id_bundle, nome_bundle, preco_bundle, capa_bundle, data_fim_bundle FROM bundles WHERE (data_ini_bundle <= CURDATE()) AND (data_fim_bundle >= CURDATE()) LIMIT 0,1"; 
				$stmt_bundle = $mydb->prepare($query_bundle);
				$stmt_bundle->execute(); 

				$stmt_bundle->bind_result($id, $nome, $preco, $img, $data); 
				while ($stmt_bundle->fetch()) { 
					$id_bundle = $id;
					$nome_bundle = $nome;
					$img = $img;
					$price_bundle = $preco;
					$valor_data = explode('-', $data);
					$valor_data[2] = intval($valor_data[2]) + 1;
					$data = $valor_data[0].'/'.$valor_data[1].'/'.$valor_data[2];

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
						<div data-countdown="<?php echo $data;?> "></div>
						<span>Para acabar este Bundle</span>
					</div>
					<div class="buy_bundle">
						
						<button type="button" id="btn_pay_bundle" class="button" style="margin-bottom: 10px;">
							<span class="icon-shopping-cart"></span>Comprar Bundle
						</button>
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

			<div class="payment  effect7" id="buy_payment">
            	<div id="paymentoptions">
					<div id="topPayment">
						<h2>Payment Options</h2>
					</div>
					<div id="slider">
						<div id="slider-range-min" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
							<div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min"></div>
							<a class="ui-slider-handle ui-state-default ui-corner-all" href="#"></a>
						</div>
						<span>ENTER YOUR OWN:</span>
						<input type="text" id="price" value="<?php echo round($preco, 2);?>" name="amount" style="font-weight: bold;">
					</div>

					<div id="wallet" class="payment_option">
						<input id="radio_wallet" type="radio" name="payment" value="Google Wallet">
						<label for="radio_wallet"><img src="public/img/wallet-logo.gif"></label>
					</div>

					<div id="paypal" class="payment_option">
						<input id="radio_paypal" type="radio" name="payment" value="Paypal">
						<label for="radio_paypal"><img src="public/img/paypal-logo.gif"></label>
					</div>
					<div class="emailbox">
						<input type="text" name="email" id="email_owner" value="" placeholder="E-Mail do comprador">
					</div>
					<div id="makeitgift">
						<input type="checkbox" name="gift" id="gift"> <label for="gift"><span>Enviar como presente</span></label>
					</div>
					<div class="emailbox giftbox">
						<input type="text" name="friend" id="email_gift" placeholder="E-Mail para receber o codigo">
					</div>
					<div id="buybundle">
						<div class="buybundlebtn">
							<button id="btn_buy_bundle">Comprar Bundle</button>
						</div>
					</div>
                </div>
			</div>
			<div id="modal-background"></div>
			<div id="loader_ticket"></div>
			<div id="modal-content">
			    <span class="icon-remove" id="modal-close"></span>
			    <div class="payment_info">
				    <div class="payment_receive">
				    	<label class="nome_ticket" id="ticket_name"><?php echo $nome_user; ?></label>
				    </div>
				    <div class="payment_receive">
				    	<label class="mail_owner" id="ticket_email"></label>
				    </div>
				    <div class="payment_receive">
				    	<label class="mail_owner" id="ticket_email_friend"></label>
				    </div>
				    <div class="payment_receive">
				    	<label class="type" id="ticket_type"></label>
				    </div>
				    <div class="payment_receive">
				    	<label class="bundle" id="ticket_bundle">Bundle</label>
				    	<label class="price_ticket">Preço</label>
				    </div>
				    <div class="payment_receive">
				    	<label class="bundle_name" id="ticket_bundle"><?php echo $nome_bundle; ?></label>
				    	<label class="price_ticket" id="ticket_price">d</label>
				    </div>
				    <div class="payment_footer">
				    	<label class="type" id="ticket_footer">Obrigado por comprar no Bundles&Bundles</label>
				    </div>
			    </div>
			    <?php } ?>
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
		<script>
  $(function() {
    $( "#slider-range-min" ).slider({
        range: "min",
        step: 0.10,
        value: <?php echo round($preco, 2);?>,
        min: 1,
        max: 50,
        slide: function( event, ui ) {
            
            var value = 0;

            if( ui.value <= 50 / 3 ) {
                value = parseFloat( 12/47 * ui.value + 35 / 47 ).toFixed(2);

            } else if( ui.value > (100/3) ) {
                value = parseFloat( ui.value * 2.4 - 70 ).toFixed(2);

            } else {
                value = parseFloat( ui.value * 0.3 ).toFixed(2);
            }

            $( "#price" ).val( '€ ' + value );
        }
    });
    $("#price").val( "€" + $( "#slider-range-min" ).slider( "value" ) );
    $("#gift").click(function(){
        if( $(this).is(':checked') ) {
            $(".giftbox").slideDown();
        } else {
            $(".giftbox").slideUp();
            $(".giftbox input").val('');
        }
    });
    $('#btn_pay').click(function() {   
        $('#buy_cart').animate({width:'toggle'},350);
    });
	$(" #modal-background, #modal-close").click(function () {
		$("#modal-background, #modal-content").toggleClass("active");
	});
	function validarEmail(email) { 
		// http://stackoverflow.com/a/46181/11236
		var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	};
	$("#price").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || 
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	$("#btn_buy_bundle").click(function () {
		var email_gift = "";
		if ((validarEmail($('#email_owner').val())) && ($('input[name="payment"]').is(':checked'))) {
			
			if ($('#email_gift').val().length > 1 ) {
				if (validarEmail($('#email_gift').val())) {
					$("#ticket_email_friend").text($('#email_gift').val());
					email_gift = $('#email_gift').val();
				}else{
					alert("Email de presente invalido!!\nSerá enviado para o email principal.");
				}
			}
			$("#modal-background").addClass("active");
			$("#loader_ticket").css('display', 'block');
			$("#loader_ticket").fadeIn(400).html("<img src='public/img/black_loader.gif'style='margin: 16% 17%;width: 70px;height: 70px;'>");
			var preco = $('#price').val();
			var email_owner = $('#email_owner').val();
			var id_bundle = $('#add_bundle_bookmarks').attr('data-id');

			var buying = "id=" + id_bundle +"&preco=" + preco + "&email=" + email_owner + "&gift=" + email_gift;

			$.ajax({
				type: "POST",
				url: "ajax/buy.php",
				data: buying,
				cache: false,
				success: function(){
					setInterval(function() {
						$("#loader_ticket").css('display', 'none');
						$("#loader_ticket").html();
					}, 2000);
					$("#ticket_price").text($('#price').val());
					$("#ticket_email").text($('#email_owner').val());
					
					$("#ticket_type").text('Tipo de Pagamento: '+$('input[name="payment"]:checked').val());

					$("#modal-content").delay(2000).queue(function(next){
					    $(this).addClass("active");
					    next();
					});
				}
			});

		} else {
			if ($('input[name="payment"]').not(':checked')){		
				alert("Tem de selecionar um metodo de pagamento");
			} else {
				alert("Tem de preencher o email!!");	

			}
		}
	});
});
  </script>
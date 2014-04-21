<?php
	//"ip.php" example- display user IP address on any page
	Header("content-type: application/x-javascript");
   	require("../config/functions.php");
    $caminho = caminholocal();
?>

// funcao para registar utilizador
		

      $(function() {
        $('#registar_password').bind('keyup', function() { 
          var value = $(this).val();
          if ( (value.length > 5) && (value != "123456") && (value != "qwerty")){
             $("#msg_password").fadeIn(400).html("<span class='pass_success'></span>");
             if ( $('#registar_pass').val() != value) {
             	$("#msg_password_2").fadeIn(400).html("<span class='pass_error'></span>");
             } else {
             	$("#msg_password_2").fadeIn(400).html("<span class='pass_success'></span>");
             }
          } else {
             $("#msg_password").fadeIn(400).html("<span class='pass_error'></span>");
             if ( $('#registar_pass').val() != value) {
             	$("#msg_password_2").fadeIn(400).html("<span class='pass_error'></span>");
             }
          }
        });
        $('#registar_pass').bind('keyup', function() { 
          var value_password = $(this).val();
          var value_pass = $('#registar_password').val();
          if ( (value_password == value_pass) && (value_password.length > 5) ){
             $("#msg_password_2").fadeIn(400).html("<span class='pass_success'></span>");
          } else {
             $("#msg_password_2").fadeIn(400).html("<span class='pass_error'></span>");

          }
        } );

//ver user name

        $('#registar_user').bind('keyup', function() { 
          	var value_user = 'user='+$(this).val();
	        $.ajax({
                type: "POST", 
				url: "<?php echo $caminho; ?>ajax/user.php",
				data: value_user,
				cache: false,
				dataType: 'json', // Choosing a JSON datatype
				success: function(data){ // Variable data contains the data we get from serverside
					$('#msg_username_text').html(''); // Clear #success_div div
					if (data.tipo == 'success') { // If clicked buttons value is all, we post every wine
						if ($("#registar_user").val() == "") {
							$("#msg_username").fadeIn(400).html("<span class='pass_error'></span>");
							$("#msg_username_text").fadeIn(400).html("<span class='info_register'>Tem de inserir um nome de utilzador!!</span>");
						} else{
							$("#msg_username").fadeIn(400).html("<span class='pass_success'></span>");
						}
					} else if (data.tipo == 'erro') { // If clicked buttons value is red, we post only red wines
						$("#msg_username").fadeIn(400).html("<span class='pass_error'></span>");
						$("#msg_username_text").fadeIn(400).html("<span class='info_register'>Nome de utilzador já existente!!</span>");
					}
				}
        	});
		});

//ver email
		function validateEmail(email) { 
		// http://stackoverflow.com/a/46181/11236

			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		}
        $('#registar_email').blur(function() { 
          	var value_mail = 'email='+$(this).val();
          	if (validateEmail(value_mail)) {
		        $.ajax({
	                type: "POST", 
					url: "<?php echo $caminho; ?>ajax/email.php",
					data: value_mail,
					cache: false,
					dataType: 'json', // Choosing a JSON datatype
					success: function(data){ // Variable data contains the data we get from serverside
						$('#msg_email_text').html(''); // Clear #success_div div
						if (data.tipo == 'success') { // If clicked buttons value is all, we post every wine
							if ($("#registar_email").val() == "") {
								$("#msg_email").fadeIn(400).html("<span class='pass_error'></span>");
								$("#msg_email_text").fadeIn(400).html("<span class='info_register'>Tem de inserir um email!!</span>");
							} else{
								$("#msg_email").fadeIn(400).html("<span class='pass_success'></span>");
							}
						} else if (data.tipo == 'erro') { // If clicked buttons value is red, we post only red wines
							$("#msg_email").fadeIn(400).html("<span class='pass_error'></span>");
							$("#msg_email_text").fadeIn(400).html("<span class='info_register'>Email já existente!!</span>");
						}
					}
	        	});
			} else {
				$("#msg_email").fadeIn(400).html("<span class='pass_error'></span>");
				$("#msg_email_text").fadeIn(400).html("<span class='info_register'>Email não é valido!!</span>");
			}
  
		});


     	var isChecked = $('#registar_agree').is(':checked');

        $("#bt_registar").click(function(e) {
        	e.preventDefault();
          	if (($('#registar_password').val() == $('#registar_pass').val()) && ($('#registar_pass').val().length > 5) && ($('#registar_nome').val().length > 3)){
	            
	            var valor_form = $('#form_registar').serialize();
	       		$.ajax({
	                type: "POST", 
					url: "<?php echo $caminho; ?>ajax/register.php",
					data: valor_form,
					cache: false,
					dataType: 'json', // Choosing a JSON datatype
					success: function(data){ // Variable data contains the data we get from serverside
	                $('#message_registar').html(''); // Clear #success_div div
					$('#message_registar').css('display','block');
					if (data.tipo == 'success') { // If clicked buttons value is all, we post every wine

						//$('#message_registar_button').css('display','block');
						$("#message_registar").fadeIn(400).html("<div class='alert-box success'><span>sucesso: </span>" + data.nome + data.msg + "</div>");
						$("#message_registar_icon").css('display','block');
						$("#message_registar_icon").fadeIn(400).html("<img src='public/img/black_loader.gif' width='24' height='24' style='vertical-align:middle; margin:20px 100px;'> A enviar email...");
						var valores_email = "nome=" + data.name_email + "&username=" + data.username + "&email=" + data.email + "&token="+data.token;
						$.ajax({
			                type: "GET", 
							url: "<?php echo $caminho; ?>config/email.php",
							data: valores_email,
							cache: false,
							dataType: 'json', // Choosing a JSON datatype
							success: function(email_data){ // Variable data contains the data we get from serverside
			                $('#message_registar_email').html(''); // Clear #success_div div
							$('#message_registar_email').css('display','block');
							if (email_data.tipo == 'success') { // If clicked buttons value is all, we post every wine
								$("#message_registar_email").fadeIn(400).html("<div class='alert-box success'><span>sucesso: </span>" + email_data.msg + "</div>");
								
									$("#message_registar_icon").css('display','block');
									$("#message_registar_icon").fadeIn(400).html("");
								setTimeout( function(){ 
									$('#close_register').trigger('click');
									$("#message_registar").fadeIn(400).html("");
									$("#message_registar_email").fadeIn(400).html("");
								}, 5000);
								if ($(location).attr('pathname') == '<?php echo $caminho; ?>account/account.php') {
									setInterval( function(){ window.location = "../"; }, 2000);
								} else {
									setInterval( function(){ 
										location.reload(); 
										$('#form_registar').find(':input:disabled').prop('disabled',false);
									}, 2000);
								}
							} else if (email_data.tipo == 'erro') { 
								$("#message_registar_email").fadeIn(400).html("<div class='alert-box error'><span>erro: </span>" + email_data.msg + "</div>");	
							}
			              }
			            });
									//limpar formulario
						$('#form_registar').find(':input:not(:disabled)').prop('disabled',true);
						$('#form_registar').trigger("reset");
						$("#msg_email").html("");
						$("#msg_email_text").html("");
						$("#msg_username").html("");
						$("#msg_username_text").html("");
						$("#msg_password").html("");
						$("#msg_password_2").html("");
						$("#msg_name").html("");
						$("#msg_agree").html("");
						$("#msg_password_text").html("");
						$("#msg_password_2_text").html("");
					}
					else if (data.tipo == 'erro') { // If clicked buttons value is red, we post only red wines
						$('#message_registar').html(''); // Clear #message_registar div
						$('#message_registar').css('display','block');
						$("#message_registar").fadeIn(400).html("<div class='alert-box error'><span>erro: </span>" + data.msg + "</div>");	
					}
	              }
	            });
          	} else {
	            if ($('#registar_nome').val().length < 3){
	              $("#msg_name").fadeIn(400).html("<span class='info_register'>Tem de Escrever o seu nome!!</span>");
	            } else {
	              $("#msg_name").html(''); 
	            }
		        if(isChecked)
	        		$("#msg_agree").fadeIn(400).html("<span class='info_register'>Tem de aceitar os termos e condições de compras!</span>");
	            else
	          		$("#msg_agree").html('');

	          	if ($('#registar_password').val().length < 5){
	          		$("#msg_password_text").html("<span class='info_register'>Passwords curta!!</span>");	
	          	}
	          	if ($('#registar_password').val() != $('#registar_pass').val()){
	          		$("#msg_password_2_text").html("<span class='info_register'>Passwords diferentes!!</span>");	
	          	}
          	}
        });

		var isChecked_log = $('#entrar_save').is(':checked');

        $("#bt_login").click(function(e) {
        	if (($('#entrar_password').val().length > 5) && ($('#entrar_user').val().length > 3)){
	            e.preventDefault();
	            var form_login = $('#form_login').serialize();
	       		$.ajax({
	                type: "POST", 
					url: "<?php echo $caminho; ?>ajax/login.php",
					data: form_login,
					cache: false,
					dataType: 'json', // Choosing a JSON datatype
					success: function(data){ // Variable data contains the data we get from serverside
	                $('#message_login').html(''); // Clear #success_div div
					$('#message_login').css('display','block');
					if (data.tipo == 'success') { // If clicked buttons value is all, we post every wine

						$("#message_login").fadeIn(400).html("<div class='alert-box success'><span>sucesso: </span>" + data.msg + data.nome + "</div>");
							//limpar formulario
						$('#form_login').trigger("reset");
						$('#form_login').find(':input:not(:disabled)').prop('disabled',true);
						if ($(location).attr('pathname') == "<?php echo $caminho; ?>account/account.php") {
							setInterval( function(){ window.location = "../"; }, 2000);
						} else {
							setInterval( function(){ location.reload(); }, 2000);
							$('#form_login').find(':input:disabled').prop('disabled',false);
						}
					}
					else if (data.tipo == 'erro') { // If clicked buttons value is red, we post only red wines
						$('#message_login').html(''); // Clear #message_login div
						$('#message_login').css('display','block');
						$("#message_login").fadeIn(400).html("<div class='alert-box error'><span>erro: </span>" + data.msg + "</div>");	
					}
          		}
	            });
	            return false;
			} else {
				if ($('#entrar_user').val().length < 3){
					$("#msg_user_log").fadeIn(400).html("<span class='info_register'>Tem de Escrever o seu nome!!</span>");
				} else {
					$("#msg_user_log").html(''); 
				}
				if ($('#entrar_password').val().length < 5){
					$("#msg_pass_log").fadeIn(400).html("<span class='info_register'>Tem de Escrever a sua password!!</span>");
				} else {
					$("#msg_pass_log").html(''); 
				}
			}
        });

        $("#bt_subscriver_footer").click(function(e) {
        	var value_mail = $("#email_subscriver_footer").val();
            e.preventDefault();
          	if (validateEmail(value_mail)) {
	            var form_subscriver = $('#form_subscriver').serialize();
	       		$.ajax({
	                type: "POST", 
					url: "<?php echo $caminho; ?>ajax/subscriver.php",
					data: form_subscriver,
					cache: false,
					dataType: 'json', // Choosing a JSON datatype
					success: function(data){ // Variable data contains the data we get from serverside
	                $('#message_subscritor').html(''); // Clear #success_div div
					if (data.tipo == 'success') { // If clicked buttons value is all, we post every wine

						$("#message_subscritor").fadeIn(400).html("<div class='alert-box_icon success_icon'></div>");
							//limpar formulario
						$('#message_subscritor').css('margin','-20px 0');
						$('#form_subscriver').trigger("reset");
					}
					else if (data.tipo == 'erro') { // If clicked buttons value is red, we post only red wines
						$('#message_subscritor').html(''); // Clear #message_subscritor div
						$('#message_subscritor').css('margin','0');
						$("#message_subscritor").fadeIn(400).html("<div class='alert-box error'><span>erro: </span>" + data.msg + "</div>");	
					}
					setInterval( function(){ $('#message_subscritor').html(''); }, 10000);
	              }
	            });
	            return false;
			} else {
				if ($('#email_subscriver_footer').val().length < 3){
					$('#message_subscritor').html(''); // Clear #message_subscritor div
					$('#message_subscritor').css('margin','0');
					$("#message_subscritor").fadeIn(400).html("<div class='alert-box error'><span>erro: </span>Email vazio!</div>");	
				} else {
					$('#message_subscritor').html(''); // Clear #message_subscritor div
					$('#message_subscritor').css('margin','0');
					$("#message_subscritor").fadeIn(400).html("<div class='alert-box error'><span>erro: </span>Email inválido!</div>");	
				}
				setInterval( function(){ $('#message_subscritor').html(''); }, 10000);
					
			}
        });
      });
	
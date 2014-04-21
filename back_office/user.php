<?php
	session_start();
	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
			header("location:index.php");
	}
	require_once ("config/config.php");
?>
		<script type="text/javascript">
			$(document).ready(function(){
				function loading_show(){
					$('#loading_page').html("<img src='public/img/loader.gif'/>").fadeIn('fast');
				}
				function loading_hide(){
					$('#loading_page').fadeOut('normal');
				}
				function loadData(page){
					loading_show();
					$.ajax({
						type: "POST",
						url: "ajax_admin/load_user.php",
						data: "page="+page,
						success: function(msg){
							$(document).ajaxComplete(function(event, request, settings){
								loading_hide();
								$("#user_table").fadeIn("fast",function(){
									$("#user_table").html(msg);
								});
							});
						}
					});
				}
				loadData(1);  // For first time page load default results
				$(document).on('click', '#pagination_user li a', function(){
					var page = $(this).attr('p');
					if ($('#page_total').attr('data-page')>'1'){
						loadData(page);
					};
				});
				$('.editable_user').load('user-editable.js',{},function(){
				    $('.editable_user').trigger('click');
				});
				$('.state_edit').load('user-editable.js',{},function(){
					$('.state_edit').trigger();
				});
				$('.tipo_edit').load('user-editable.js',{},function(){
					$('.tipo_edit').trigger();
				});
			});
		</script>


	<!-- jquery e css de editable -->
		<link rel="stylesheet" href="public/css/bootstrap-editable.css" />
		<script src="public/js/bootstrap-editable.js"></script>
		<script src="public/js/user-editable.js"></script>

		<div class="lg-container" style="width: 1000px;">
      		<div id="loading_page" style="position:absolute;text-align: center;width: 920px;"></div>
      		<div id="user_delete_msg" style="display:none;"><p>Utiliador apagado com sucesso!!</p></div>
			<div class="well">
			    <table class="table table-hover table-condensed" id="user_table">
			    </table>
			</div>

			<!-- Modal -->
			<div class="modal fade sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h3 id="myModalLabel">Confirmação de Eliminar do Utilizador Nº <span id="span_user_n"> </span>?</h3>
						</div>
						<div class="modal-body">
							<p class="error-text">Tem a certeza que quer apagar o Utilizador <span id="span_user_nome"> </span>?</p>
						</div>
						<div class="modal-footer">
							<button class="btn" data-dismiss="modal" aria-hidden="true">Cancelar</button>
							<button class="btn btn-danger" id="bt_confirm_user" data-pk="" data-dismiss="modal">Confirmar</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<span class="label label-success">Ativo</span>
			<span class="label label-danger">Banido</span>
			<span class="label label-default">Inativo</span>
			<span class="label label-warning">Pendente</span>
			<span class="label label-default" style="float: right;">Para confirmar alterações, basta clicar no 'enter' ou no 'escape' para cancelar</span>
		</div>
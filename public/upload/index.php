
<?php
	include('../../header.php');
?>
<link href="css/bootstrap.css" rel="stylesheet">
		<script src="../jquery/jquery-1.10.2.min.js"></script>
				<script src="js/bootstrap.js"></script>




      <!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:330px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Upload Avatar</h4>
      </div>
      <div class="modal-body" style="text-align: center;">
		<div class="fileinput fileinput-new" data-provides="fileinput"><input type="hidden" value="" name="">
			<div class="fileinput-new thumbnail" style="width: 180px; height: 180px;padding:0px;">
				<img data-src="phaceholder.it/100%x100%" alt="100%x100%" src="data:," style="border-radius:50%; height: 100%; width: 100%; display: block;">
			</div>
			<div class="fileinput-preview fileinput-exists thumbnail" style="padding:0px;max-width: 180px; max-height: 180px; line-height: 10px;"></div>
			<div>
				<span class="btn btn-default btn-file" style="margin-left:1px;"><span class="fileinput-new"  style="margin-left:1px;">Selecionar imagem</span><span class="fileinput-exists">Mudar</span><input type="file" name=""></span>
				<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
			</div>
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary">Guardar Alterações</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
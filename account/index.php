<?php
	session_start();
   if (isset($_COOKIE["id_user"])){
        $_SESSION["id_user"] = $_COOKIE["id_user"];
        $_SESSION["user"] = $_COOKIE["user"];
        $_SESSION["tipo"] = $_COOKIE["tipo"];
        $tipo =  $_SESSION["tipo"];
        $user = $_COOKIE["id_user"];
    }else{
        if (isset($_SESSION["id_user"])){
            $user = $_SESSION["id_user"];
            $tipo =  $_SESSION["tipo"];
        } else {
            $user = "";
            $tipo = "";
        }
    }
    include('../config/config.php');
    $query= "SELECT `id_user`, `nome_user`,  `username`, `email_user`, `avatar_user`, `type`, `verificado`, `data_user` FROM `user` WHERE id_user = ?"; 
        $stmt_user = $mydb->prepare($query);
        $stmt_user->bind_param("i", $user); 
        $stmt_user->execute(); 

        $stmt_user->bind_result($id, $nome, $username, $email, $avatar, $tipo, $verificado, $member_data); 
        while ($stmt_user->fetch()) {
            switch ($verificado) {
                case 'ativo':
                    $tipo_span = "success";
                    break;
                case 'pendente':
                    $tipo_span = "warning";
                    break;
                case 'inativo':
                    $tipo_span = "default";
                    break;
                case 'banido':
                    $tipo_span = "danger";
                    break;
            }
            $id_user = $id;
    		$nome_user = $nome;
    		$username_user = $username;
    		$email_user = $email;
    		$avatar_user = $avatar;
    		$member_since = $member_data;
            $tipo_user = $tipo;
            $verif_user = $verificado;
            $member_since_a = explode(" ", $member_since);
            $member_since = $member_since_a[0];
    	}
	$stmt_user->close();
?>
<!doctype html>
<html lang="pt">
	<head>
		<meta charset="UTF-8">
		<title>Home - Bundles&Bundles.net</title>
		<?php include("../header.php"); ?>
        <script src="../public/editable/bootstrap-editable.js"></script>
        <script src="../public/editable/editable.js"></script>
        <script src="../public/editable/bootstrap_avatar.js"></script>
        <link rel="stylesheet" href="../public/editable/bootstrap-editable.css">
        <link rel="stylesheet" href="../public/editable/bootstrap_avatar.css">
        <script>
            $(function(){
                    $("#bt_avatar_save").click(function(e){ 
                        e.preventDefault(); 
                        var file_data = $("#foto_avatar").prop("files")[0]; // Getting the properties of file from file field
                        var form_data = new FormData(); // Creating object of FormData class
                        form_data.append("file", file_data) // Appending parameter named file with properties of file_field to form_data

                        $.ajax({
                            url: "avatar_save.php",
                            dataType: 'script',
                            cache: false,
                            async: false,
                            contentType: false,
                            processData: false,
                            data: form_data, // Setting the data attribute of ajax with file_data
                            type: 'POST',
                            success: function(data) {
                                $('#message_avatar').html('Imagem alterada com successo'); 
                               setInterval(function() {
                                    window.location.reload();
                                }, 2000);
                            }
                        });
                    });
                });
        </script>
    <style>
        .edit_avatar{
            margin: -18px -3px;
            box-shadow: #000 0px 0px 100px 40px;
            position: absolute;
            display: none;
            border-radius: 50%;
            height: 36px;
        }
    </style>

	</head>
	<body>
		<div class="top_menu">
			<?php include("../menu.php"); ?>
		</div>
		<div class="dead_space"></div>
		<div class="account_frame">
            <div>
                <img class="account_avatar" id="img_src_base" src="<?php echo $avatar_user;?>" alt="">
                <button class="btn btn-warning edit_avatar" type="button" id="editable_avatar_user" data-toggle="modal" data-target="#Modal_avatar">
                    <span class="icon-pencil" style="margin-right:0"></span>
                </button>
            </div>
			<div class="account_info">
                <div class="row-fluid user-infos cyruxx">
                    <div class="span10 offset1">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title" style="padding-left:120px">Informação do Utilizador : <?php echo $nome_user; ?></h3>
                            </div>
                            <div class="panel-body" style="margin-left:100px">
                                <div class="row-fluid">
                                    <div class="span3"></div>
                                    <div class="span6">
                                        <table class="table table-striped table-bordered table-user-information"style="text-transform:capitalize">
                                            <tbody id="editable_info">
                                                <tr>
                                                    <th>Nome de Utilizador:</th>
                                                    <td style="text-transform:none"><a href="#" id="username_edit" class="editable editable-click editable-disabled" data-old="<?php echo $username_user;?>" data-pk="<?php echo $id_user; ?>"><?php echo $username_user;?></a></td>
                                                </tr> 
                                                <tr>
                                                    <th>Nome completo:</th>
                                                    <td><a href="#" id="nome_edit" class="editable editable-click editable-disabled" data-old="<?php echo $nome_user;?>" data-pk="<?php echo $id_user; ?>"><?php echo $nome_user;?></a></td>
                                                </tr> 
                                                <tr>
                                                    <th>Endereço de Email:</th>
                                                    <td style="text-transform:none"><a href="#" id="email_edit" class="editable editable-click editable-disabled" data-type="email" data-old="<?php echo $email_user;?>" data-pk="<?php echo $id_user; ?>"><?php echo $email_user; ?></a></td>
                                                </tr>
                                                <tr>
                                                    <th>Nível de Utilizador:</th>
                                                    <td><?php echo $tipo;?></td>
                                                </tr> 
                                                <tr>
                                                    <th>Verificado:</th>
                                                    <td><span class="label label-<?php echo $tipo_span;?>"><?php echo $verif_user;?></span></td>
                                                </tr>
                                                <tr>
                                                    <th>Registado desde:</th>
                                                    <td><?php echo $member_since?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div style="float: right;">
                                        
                                    <button class="btn btn-primary" id="btn_ok_edit" type="button" style="display:none">
                                        <span class="icon-ok" style="margin-right:0"></span>
                                    </button>
                                    <button class="btn btn-warning" type="button" id="editable_user">
                                            <span class="icon-pencil" style="margin-right:0"></span>
                                    </button>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        </div>
                    </div>
    			</div>
    		</div>
    	</div>
		<div class="footer">
			<div class="footer_back"></div>
			<?php include("../footer.php"); ?>
		</div>
			<?php include("../modal_search.php"); ?>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="Modal_avatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog" style="width:330px;">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="ModalLabel_avatar">Upload Avatar</h4>
                  </div>
                  <div class="modal-body" style="text-align: center;">
                    <div class="fileinput fileinput-new" data-provides="fileinput"><input type="hidden" value="" name="">
                        <div class="fileinput-new thumbnail" style="width: 180px; height: 180px;padding:0px;">
                            <img data-src="phaceholder.it/100%x100%" alt="100%x100%" src="data:," style="border-radius:50%; height: 100%; width: 100%; display: block;">
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail" style="padding:0px;max-width: 180px; max-height: 180px; line-height: 10px;"></div>
                        <div>
                            <span class="btn btn-default btn-file" style="margin-left:1px;">
                                <span class="fileinput-new"  style="margin-left:1px;">Selecionar imagem</span>
                                <span class="fileinput-exists">Mudar</span>
                                <input type="file" id="foto_avatar" name="">
                            </span>
                            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
                        </div>
                    </div>
                    <div id="message_avatar"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="bt_avatar_save">Guardar Alterações</button>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
	</body>
</html>
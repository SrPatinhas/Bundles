<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript" src="jquery-1.6.4.min.js"></script>
</head>

<body>
		<form id="formId">
			Name:<input type='text' name='name'>
			E-mail:<input type='text' name='email'>
			Gender:<select name='gender'>
			<option value='male'>male</option>
			<option value='female'>female</option>
			</select>
			Message:<textarea name='about'></textarea>
			<input type="button" value="Send" onclick="save()"/>
			<div id="message"></div>
		</form>
		<script type="javascript">
			function save(){
				var query = $('#formId').serialize();
				var url = 'save.php';
				$.ajax({
					type: "POST",
					cache: false,
					url: "save.php",
					data: query,
					success: function(response){
					if(response == "success"){
						$("#formId").slideUp('slow', function(){
							$("#message").html('<p class="success">Login efectuado!</p><p>Redirecionando....</p>');
							// to call, use:
							// or -> resetForm($('form[name=myName]')); // by name
							resetForm($('#myform')); // by id, recommended
						});
					} else
						$("#message").html('<p class="error">ERROR: Nome Utilizador e/ou password errada</p>');
				}	
				});
			}
			function resetForm($form) {
				$form.find('input:text, input:password, input:file, select, textarea').val('');
				$form.find('input:radio, input:checkbox')
					.removeAttr('checked').removeAttr('selected');
			}
		</script>
</body>
</html>

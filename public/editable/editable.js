$(function(){

	$.fn.editable.defaults.mode = 'inline';
	$.fn.editable.defaults.disabled = true;

	//enable / disable
	$(document).on('click', '#editable_user, #btn_ok_edit', function(e){
		e.preventDefault();
		$('#editable_info .editable').editable('toggleDisabled');
		if ($('#editable_info').hasClass('danger') == true) {
            $('#editable_info').removeClass('danger');
            $('#editable_user').css('display','block');
            $('#btn_ok_edit').css('display','none');
            $('#editable_avatar_user').css('display','none');
        }else{
            $('#editable_info').addClass('danger');
            $('#btn_ok_edit').css('display','block');
            $('#editable_user').css('display','none');
            $('#editable_avatar_user').css('display','block');
        }
	}); 
	//alterar nome completo
	$('#nome_edit').editable({
		url: '../account/save_user.php',
		type: 'text',
		name: 'name'
	}); 

	//alterar username
	$('#username_edit').editable({
		url: '../account/save_user.php',
		type: 'text',
		name: 'username',
		params: function(params) {
			//originally params contain pk, name and value
			params.old_value = $(this).attr('data-old');
			return params;
		},
		display: function(value, response) {
			//render response into element
			$(this).html(response);
		}
	});
	//alterar mail
	$('#email_edit').editable({
		url: '../account/save_user.php',
		type: 'text',
		name: 'email',
		params: function(params) {
			//originally params contain pk, name and value
			params.old_value = $(this).attr('data-old');
			return params;
		},
		display: function(value, response) {
	        //render response into element
	        $(this).html(response);
    	}
	});
	//alterar avatar
	$('#avatar_edit').editable({
		url: '../account/save_user.php',
		type: 'text',
		name: 'avatar'
	});
});
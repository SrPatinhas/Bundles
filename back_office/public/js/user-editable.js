$(function(){

	$.fn.editable.defaults.url = 'ajax_admin/save_user.php';
	$.fn.editable.defaults.mode = 'inline';
	$.fn.editable.defaults.disabled = true;

	//enable / disable
	$(document).on('click', '.editable_user', function(e){
		e.preventDefault();
		$('#user_details_'+ $(this).attr('data-pk')+' .editable').editable('toggleDisabled');
		if ($('#user_details_'+ $(this).attr('data-pk')).hasClass('danger') == true) {
            $('#user_details_'+ $(this).attr('data-pk')).removeClass('danger');
        }else{
            $('#user_details_'+ $(this).attr('data-pk')).addClass('danger');
        }
	}); 
	$(document).on('click', '.modal_show_up', function(e){
		$('#span_user_n').text();
		$('#span_user_n').text($(this).attr('data-ik'));
		$('#span_user_nome').text($(this).attr('data-nk'));
		$('#bt_confirm_user').attr('data-pk', $(this).attr('data-ik'));
	}); 

	$(document).on('click', '#bt_confirm_user', function(e){
		e.preventDefault();
		var line = '#user_details_' + $(this).attr('data-pk');

		$(line).animate({'backgroundColor':'#fb6c6c'},300).animate({ opacity: 0.35 }, "slow");
		$(line).slideUp( "normal",  function() {$(line).remove();});
	
		var valor_form = "name=delet&id=" + $(this).attr('data-pk');
		$.ajax({
			type: "POST",
			url: "ajax_admin/save_user.php",
			data: valor_form,
			cache: false,
			dataType: 'json', // Choosing a JSON datatype
			success: function(msg){
				if (msg.status == "success") {

					$("#user_delete_msg").fadeIn("fast");
					$(line).remove();
					setTimeout(function() {
						$("#user_delete_msg").fadeOut("slow");// Do something after 5 seconds
					}, 5000);
				};
			}
		});
	}); 
   //defaults
	$('#user_table .nome_edit').editable({
		//url: '/post',
		type: 'text',
		name: 'name',
		showbuttons: false,
		ajaxOptions: {
			dataType: 'json'
		},
		success: function(response, newValue) {
			if(!response) {
				alert('teste');
				return "Unknown error!";
			}
			if(response.status === 'success') {
				$(this).html(newValue);
			}
		}
	});

	$('#user_table .user_edit').editable({
		//url: '/post',
		type: 'text',
		name: 'user',
		showbuttons: false,
		ajaxOptions: {
			dataType: 'json'
		},
		success: function(response, newValue) {
			if(!response) {
				alert('teste');
				return "Unknown error!";
			}
			if(response.status === 'success') {
				$(this).html(newValue);
			}
		}
	});

	$('#user_table .email_edit').editable({
		//url: '/post',
		type: 'email',
		name: 'email',
		showbuttons: false,
		ajaxOptions: {
			dataType: 'json'
		},
		success: function(response, newValue) {
			if(!response) {
				alert('teste');
				return "Unknown error!";
			}
			if(response.status === 'success') {
				$(this).html(newValue);
			}
		}
	});

	$('#user_table .tipo_edit').editable({
        name: 'tipo',
		showbuttons: false,
		ajaxOptions: {
			dataType: 'json'
		},
		success: function(response, newValue) {
			if(!response) {
				alert('teste');
				return "Unknown error!";
			}
			if(response.status === 'success') {
				$(this).html(newValue);
			}
		}
		// source: [
		// 	{value: 0, text: 'utilizador'},
		// 	{value: 1, text: 'colaborador'},
		// 	{value: 2, text: 'administrador'},
		// 	{value: 3, text: 'developer'}
		// ]
	});

	//set value from ajax
	$.ajax({
		url: "ajax_admin/save_user.php?t=tipo",
		name: 'tipo',
		ajaxOptions: {
			dataType: 'json'
		},
		success: function(response, newValue) {
			if(!response) {
				alert('teste');
				return "Unknown error!";
			}
			if(response.status === 'success') {
				$(this).html(newValue);
			}
		}
	});

	$('#user_table .state_edit').editable({
		name: 'state',
		showbuttons: false,
		// source: [
		// 	{value: 0, text: 'ativo'},
		// 	{value: 1, text: 'pendente'},
		// 	{value: 2, text: 'inativo'},
		// 	{value: 3, text: 'banido'}
		// ],
		display: function(value, sourceData) {
			var obj = $(this);
			change_span(value, obj);
		}
	});
	function change_span (id_aviso, father_tag) {
		var lb_class = {
							0: "label label-success",
							1: "label label-warning",
							2: "label label-default",
							3: "label label-danger"
						};
		var lb_text = {
							0: "Ativo",
							1: "Pendente",
							2: "Inativo",
							3: "Banido"
						};

		var span_result = $(father_tag).children();

		$(span_result).text(lb_text[id_aviso]).removeClass("label-success label-warning label-default label-danger").addClass(lb_class[id_aviso]);	
	};
});
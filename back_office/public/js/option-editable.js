$(function(){

	$.fn.editable.defaults.url = 'ajax_admin/save_user.php';
	$.fn.editable.defaults.mode = 'inline';

	$('.tipo_edit').editable({
		prepend: "Não selecionado",
        name: 'tipo',
		source: [
			{value: 0, text: 'utilizador'},
			{value: 1, text: 'colaborador'},
			{value: 2, text: 'administrador'},
			{value: 3, text: 'developer'}
		],
		showbuttons: false 
	});
	$('.state_edit').editable({
		prepend: "Não selecionado",
		name: 'state',
		showbuttons: false ,
		source: [
			{value: 0, text: 'ativo'},
			{value: 1, text: 'pendente'},
			{value: 2, text: 'inativo'},
			{value: 3, text: 'banido'}
		],
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
			
	}
});
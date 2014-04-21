$(function() {
	function Categoria_update() {
		var allVals_cat = [];
		$('.check_paint[name*="categoria"]:checked').each(function() {
			var tag_span = "<span class='tm-tag tm-tag-small mini_cat' id='tag_" + $(this).attr('id') + "'>";
				tag_span = tag_span + "<span>" + $(this).val() + "</span>";
				tag_span = tag_span + "<a href='#' class='tm-tag-remove' rel-tipe='categoria' rel-link='" + $(this).attr('id') + "' rel-class='" + $(this).attr('rel-label') + "' id='taglink_" + $(this).attr('id') + "'>x</a>";
				tag_span = tag_span + "</span>";
			allVals_cat.push(tag_span);
		});
		$('#teste_cat').html(allVals_cat)
	}
	function Plataforma_update() {
		var allVals_plat = [];
		$('.check_paint[name*="plataforma"]:checked').each(function() {
			var tag_span ="<span class='tm-tag tm-tag-small mini_plat' id='tag_" + $(this).attr('id') + "'>";
				tag_span = tag_span + "<span>" + $(this).val() + "</span>";
				tag_span = tag_span + "<a href='#' class='tm-tag-remove' rel-link='" + $(this).attr('id') + "' rel-class='" + $(this).attr('rel-label') + "' id='taglink_" + $(this).attr('id') + "'>x</a>";
				tag_span = tag_span + "</span>";
			allVals_plat.push(tag_span);
		});
		$('#teste_plat').html(allVals_plat)
	}
	function GetNewSearch(){
		var Search_plat = [];
		var Search_cat  = [];

		$('.check_paint[name*="plataforma"]:checked').each(function() {
			var valor_plat = $(this).attr('data-id');
			Search_plat.push(valor_plat);
		});
		$('.check_paint[name*="categoria"]:checked').each(function() {
			var valor_cat = $(this).attr('data-id');
			Search_cat.push(valor_cat);
		});

		var search_bar = {'plat':{},'cat':{}};
			search_bar['plat'] = Search_plat;
			search_bar['cat'] = Search_cat;

		$.ajax({

			type: "POST",
			url: "ajax/search_bar.php",
			data: "Array_plat=" + search_bar['plat'] + "&Array_cat=" + search_bar['cat'],
			success: function(data) {
				$("#feed_container").html(data);        
			}	
		});
	}
	$('.check_paint[name*="categoria"]').change(function() {
		Categoria_update();
		GetNewSearch();
	});
	$('.check_paint[name*="plataforma"]').change(function() {
		Plataforma_update();
		GetNewSearch();
	});
	$('#menu_bar_p > ul > li > a').click(function() {
		$('#menu_bar_p li').removeClass('active');
		$(this).closest('li').addClass('active');	
		var checkElement = $(this).next();
		if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			$(this).closest('li').removeClass('active');
			checkElement.slideUp('normal');
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			$('#menu_bar_p ul ul:visible').slideUp('normal');
			checkElement.slideDown('normal');
		}
		if($(this).closest('li').find('ul').children().length == 0) {
			return true;
		} else {
			return false;	
		}		
	});
	$(document).on('click','.tm-tag-remove',function(e){
		e.preventDefault();
		var uncheck = $(this).attr('rel-link');
		$('#tag_' + uncheck).fadeOut('fast', function() {
			$(this).remove();
			$('#' + uncheck).removeAttr('checked');
			GetNewSearch();
		}); 
		return false;
	});

});
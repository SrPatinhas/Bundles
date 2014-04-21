<?php
	//"ip.php" example- display user IP address on any page
	Header("content-type: application/x-javascript");
   	require("../config/functions.php");
    $caminho = caminholocal();
?>
/* JS File */

// Start Ready
$(document).ready(function() {  

	// Icon Click Focus
	$('div.icon').click(function(){
		$('input#search_bundle').focus();
	});


	$('#sub_menu_option').hover(
		function() {
			$(this).find('ul').show();
		},
		function() {
			$(this).find('ul').hide();
		}
	);
	// Live Search
	// On Search Submit and Get Results
	function search() {
		var query_value = $('input#search_bundle').val();
		$('b#search-string').html(query_value);
		if(query_value !== ''){
			$.ajax({
				type: "POST",
				url: "<?php echo $caminho; ?>ajax/search.php",
				data: { query: query_value },
				cache: false,
				success: function(html){
					$("ul#results").html(html);
				}
			});
		}return false;    
	}

	$("input#search_bundle").on("keyup", function(e) {
		// Set Timeout
		clearTimeout($.data(this, 'timer'));

		// Set Search String
		var search_string = $(this).val();

		// Do Search
		if (search_string == '') {
			$("ul#results").fadeOut();
			$('h4#results-text').fadeOut();
		}else{
			$("ul#results").fadeIn();
			$('h4#results-text').fadeIn();
			$(this).data('timer', setTimeout(search, 100));
		};
	});
});
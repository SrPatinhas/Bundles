<?php
/************************************************
	The Search PHP File
************************************************/


/************************************************
	MySQL Connect
************************************************/
	include("../config/config.php");
   	require("../config/functions.php");
    $caminho = caminholocal();

/************************************************
	Search Functionality
************************************************/

// Define Output HTML Formating
$html = '';
$html .= '<li class="result">';
$html .= '<a target="_blank" href="urlString">';
$html .= '<img class="mini_search_img data_visivel" width="50px" height="34px" src="imgCapa" alt="nameString">';
$html .= '<div class="data_div data_visivel">';
$html .= '	<span class="data_search">Data Inicio: data_ini_String</span><br>';
$html .= '	<span class="data_search">Data Fim: data_fim_String</span>';
$html .= '</div>';
$html .= '<h3>nameString</h3>';
$html .= '<h4>precoString</h4>';
$html .= '</a>';
$html .= '</li>';

// Get Search
$search_string = preg_replace("/[^A-Za-z0-9]/", " ", $_POST['query']);
$search_string = $mydb->real_escape_string($search_string);

// Check Length More Than One Character
if (strlen($search_string) >= 1 && $search_string !== ' ') {
	// Build Query
	$query = 'SELECT * FROM bundles WHERE (nome_bundle LIKE ?) AND (data_fim_bundle <= CURDATE()+3) limit 0,15';
	//$query = 'select b.nome_bundle, b.id_jogo, b.preco_bundle, j.nome_jogo from bundles as b inner join jogos as j on j.id_jogo = b.cursoid');

	$string_query = '%'.$search_string.'%';

	$stmt = $mydb->prepare($query);
	$stmt->bind_param("s", $string_query); 
	$stmt->execute(); 
	$result = $stmt->get_result(); 
		$result_array = $result->fetch_all(MYSQL_ASSOC);
	$stmt->close(); 
	$mydb->close(); 
	// Check If We Have Results
	if (isset($result_array)) {
		$vazio = "";
		foreach ($result_array as $result) {

			// Format Output Strings And Hightlight Matches
			$display_img = $result['capa_bundle'];
			$display_preco = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", round($result['preco_bundle'],2)." €");
			$display_name = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['nome_bundle']);
			$display_data_ini = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['data_ini_bundle']);
			$display_data_fim = preg_replace("/".$search_string."/i", "<b class='highlight'>".$search_string."</b>", $result['data_fim_bundle']);
			$display_url = $caminho.'game.php?id='.urlencode($result['id_bundle']);

			// Insert Name
			$output = str_replace('nameString', $display_name, $html);

			// Insert Image
			$output = str_replace('imgCapa', $display_img, $output);

			// Insert Price
			$output = str_replace('precoString', $display_preco, $output);

			// Insert Date begin
			$output = str_replace('data_ini_String', $display_data_ini, $output);
			// Insert Date end
			$output = str_replace('data_fim_String', $display_data_fim, $output);

			// Insert URL
			$output = str_replace('urlString', $display_url, $output);

			// Output
			echo($output);

			$vazio = $result['id_bundle'];
		}
		if ($vazio =="") {
			// Format No Results Output
			$output = str_replace('urlString', 'javascript:void(0);', $html);
			$output = str_replace('nameString', '<b>No Results Found.</b>', $output);
			$output = str_replace('precoString', 'Sorry :(', $output);
			$output = str_replace('data_visivel', 'data_invisivel', $output);

			// Output
			echo($output);
		}
	}else{

		// Format No Results Output
		$output = str_replace('urlString', 'javascript:void(0);', $html);
		$output = str_replace('nameString', '<b>No Results Found.</b>', $output);
		$output = str_replace('precoString', 'Sorry :(', $output);
		$output = str_replace('data_visivel', 'data_invisivel', $output);

		// Output
		echo($output);
	}
}
?>
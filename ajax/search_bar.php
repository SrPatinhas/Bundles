 <?php
 	$myArray_cat  = array($_POST['Array_cat']); 
 	$myArray_plat = array($_POST['Array_plat']);

	$variavel = "Categorias: ";
	if (is_array($myArray_cat)) {
		foreach($myArray_cat as $cat){
			$variavel.= $cat." ";
			
		}
	} else {
		$variavel.= "<br>Sem Categorias. <br>";
	}

	$variavel.= "<br>Plataformas: ";

	if (is_array($myArray_plat)) {
		foreach($myArray_plat as $plat){
			$variavel.= $plat." ";
		}
	} else {
		$variavel.= "<br>Sem Categorias. <br>";
	}
 	echo $variavel;
 ?>
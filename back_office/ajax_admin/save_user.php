<?php
 	session_start();
 	if (($_SESSION["admin_log"]!="administrador") and  ($_SESSION["admin_log"]!="developer")){
 		header("location:index.php");
 	}
 	require_once("../config/config.php");
 	include("../config/functions.php");

// name:name
// value:Manel

// name:username
// value:migasa
// pk:2

// name:email
// value:migas_cerejo-1993@hotmail.co
// pk:2

// name:tipo
// value:1
// pk:2

// name:state
// value:0
// pk:2

// if ($_GET['t']=='state') {
// 			$groups = array(
// 				array('value' => 0, 'text' => 'ativo'),
// 				array('value' => 1, 'text' => 'pendente'),
// 				array('value' => 2, 'text' => 'inativo'),
// 				array('value' => 3, 'text' => 'banido')
// 			);
// 			echo json_encode($groups); 
// 		} else if ($_GET['t']=='tipo') {
// 			$groups = array(
// 				array('value' => 0, 'text' => 'utilizador'),
// 				array('value' => 1, 'text' => 'colaborador'),
// 				array('value' => 2, 'text' => 'administrador'),
// 				array('value' => 3, 'text' => 'developer')
// 			);
// 		}


/*
  Script outputs data in json format suitable for 'source' option in X-editable
*/

//	sleep(1); 
	if (isset($_GET['t'])) {
		if ($_GET['t']=='state') {
			$groups = array(
				'0' => 'ativo',
				'1' => 'pendente',
				'2' => 'inativo',
				'3' => 'banido'
			);
			echo json_encode($groups); 
		} else if ($_GET['t']=='tipo') {
			$groups = array(
				'0' => 'utilizador',
				'1' => 'colaborador',
				'2' => 'administrador',
				'3' => 'developer'
			);
		}
		$success = array(
			"status" => 'success',
			"valor" => $groups
		);
		
		// Finally depending on the button value, JSON encode our winetable and print it

		echo json_encode($groups);

	} else if (isset($_POST['name'])) {

		$nome = explode("_", $_POST['name']);
		$tipo = $nome[0];

		if ($tipo =='nome') {
			$id_pk = $_POST['pk'];
			$valor = $_POST['value'];
			$nome  = "nome_user";
			if (alterarUser($id_pk, $nome, $valor)==true){
				$valor_final = $valor;
			}

		} else if ($tipo =='user') {
			$id_pk = $_POST['pk'];
			$valor = $_POST['value'];
			$nome  = "username";
			if (alterarUser($id_pk, $nome, $valor)==true){
				$valor_final = $valor;
			}

		} else if ($tipo =='email') {
			$id_pk = $_POST['pk'];
			$valor = $_POST['value'];
			$nome  = "email_user";
			if (alterarUser($id_pk, $nome, $valor)==true){
				$valor_final = $valor;
			}

		} else if ($tipo =='tipo') {
			$id_pk = $_POST['pk'];
			$valor = $_POST['value'];
			$nome  = "type";
			if (alterarUser($id_pk, $nome, $valor)==true){
				$valor_final = $valor;
			}

		} else if ($tipo =='state') {
			$id_pk = $_POST['pk'];
			$valor = $_POST['value'];
			$nome  = "verificado";

			if (alterarUser($id_pk, $nome, $valor)==true){
				$valor_final = $valor;
			}

		}else if ($tipo =='avatar') {
			$id_pk = $_POST['pk'];
			$valor = $_POST['value'];
			$nome  = "avatar_user";
			if (alterarUser($id_pk, $nome, $valor)==true){
				$valor_final = $valor;
			}
		}else if ($tipo =='delet') {
			$id = $_POST['id'];
			if (apagarUser($id)==true){
				$valor_final = '';
			}
		} else {

		}
		$success = array(
			"status" => 'success',
			"valor" => $valor_final
		);

		// Finally depending on the button value, JSON encode our winetable and print it

		echo json_encode($success);
	} else {
		echo "error";
	}
?>
<?php
    /*
    Script for update record from X-editable.
    */

    //delay (for debug only)
    //sleep(1); 

    /*
    You will get 'pk', 'name' and 'value' in $_POST array.
    */
    //$pk = $_POST['pk'];
    //$name = $_POST['name'];
    //$value = $_POST['value'];

    /*
     Check submitted value
    */
    //if(!empty($value)) {
        /*
          If value is correct you process it (for example, save to db).
          In case of success your script should not return anything, standard HTTP response '200 OK' is enough.
          
          for example:
          $result = mysql_query('update users set '.mysql_escape_string($name).'="'.mysql_escape_string($value).'" where user_id = "'.mysql_escape_string($pk).'"');
        */
        
        //here, for debug reason we just return dump of $_POST, you will see result in browser console
     //   print_r($_POST);


    //} else {
        /* 
        In case of incorrect value or error you should return HTTP status != 200. 
        Response body will be shown as error message in editable form.
        */

    //    header('HTTP 400 Bad Request', true, 400);
  //      echo "This field is required!";
//    }

?>
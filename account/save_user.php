<?php
include('user_functions.php');
    /*
        Script for update record from X-editable.
        You will get 'pk', 'name' and 'value' in $_POST array.
    */

    $id = $_POST['pk'];
    $name = $_POST['name'];
    $value = $_POST['value'];
    if (isset($_POST['old_value'])) {
       $old_value = $_POST['old_value'];
    } else {
        $old_value = "";
    }

    /*
        Check submitted value
    */
    if(!empty($value)) {
       
       switch ($name) {
            case 'name':
                    $response = func_name($value, $id);
                break;
            
            case 'username':
                    $response = func_username($value, $old_value, $id);
                break;
            
            case 'email':
                    $response = func_email($value, $old_value, $id);
                break;
            
            case 'avatar':
                    $response = func_avatar($value, $id);
                break;
            
            default:
                return 'error';
                break;
        } 
        //here, for debug reason we just return dump of $_POST, you will see result in browser console
        //print_r($_POST);
        print_r($response);


    } else {
        /*
            In case of incorrect value or error you should return HTTP status != 200.
            Response body will be shown as error message in editable form.
        */

        header('HTTP 400 Bad Request', true, 400);
        echo "This field is required!";
    }

?>
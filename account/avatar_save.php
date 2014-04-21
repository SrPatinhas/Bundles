<?php 
  session_start();
   if (isset($_COOKIE["id_user"])){
        $_SESSION["id_user"] = $_COOKIE["id_user"];
        $user = $_COOKIE["id_user"];
    }else{
        if (isset($_SESSION["id_user"])){
            $user = $_SESSION["id_user"];
        }
      }
    include('../config/config.php');
 error_reporting(0);
$change="";
$abc="";

define ("MAX_SIZE","400");
function getExtension($str) {
  $i = strrpos($str,".");
  if (!$i) { 
    return ""; 
  }
  $l = strlen($str) - $i;
  $ext = substr($str,$i+1,$l);
  return $ext;
}

$errors=0;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $image =$_FILES["file"]["name"];
  $uploadedfile = $_FILES['file']['tmp_name'];

  if ($image) {
    $filename = stripslashes($_FILES['file']['name']);
    $extension = getExtension($filename);
    $extension = strtolower($extension);

    if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) {
      $change='<div class="msgdiv">Unknown Image extension </div> ';
      $errors=1;
    }
    else{
      $size=filesize($_FILES['file']['tmp_name']);

      if ($size > MAX_SIZE*5120){
        $change='<div class="msgdiv">You have exceeded the size limit!</div> ';
        $errors=1;
      }

      if($extension=="jpg" || $extension=="jpeg" ){
        $uploadedfile = $_FILES['file']['tmp_name'];
        $src = imagecreatefromjpeg($uploadedfile);

      }
      else if($extension=="png"){
        $uploadedfile = $_FILES['file']['tmp_name'];
        $src = imagecreatefrompng($uploadedfile);
      }
      else {
        $src = imagecreatefromgif($uploadedfile);
      }

      list($width,$height)=getimagesize($uploadedfile);

      $newwidth=180;
      $newheight=($height/$width)*$newwidth;
      $tmp=imagecreatetruecolor($newwidth,$newheight);

      imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
      
      $filename_base = uniqid(). $_FILES['file']['name'];
      $filename = "avatar/". $filename_base;
      $fileTmpLoc = $_FILES["file"]["tmp_name"];

      imagejpeg($tmp,$filename,100);

      imagedestroy($src);
      imagedestroy($tmp);

      $moveResult = move_uploaded_file($fileTmpLoc, $filename);
      // Evaluate the value returned from the function if needed
      
      $query= "UPDATE user SET avatar_user=? WHERE id_user = ? "; 
      $stmt = $mydb->prepare($query);
      $stmt->bind_param("si" , $filename, $user); 
      $stmt->execute(); 
      $teste = $stmt->affected_rows==1; // TRUE se alterou 1 linha 
      $stmt->close();

      if ($moveResult == true) {
        return $filename_base;
      }
    }
  }
}
?>
<?php
    require("functions.php");
    $caminho = caminholocal();

    require("phpmailer/class.phpmailer.php");
    $mail = new PHPMailer(); 
    $mail->IsSMTP(); // send via SMTP

        $mail->SMTPAuth = true; // turn on SMTP authentication
        $mail->Username = "*******@gmail.com"; // SMTP username
        $mail->Password = "**********"; // SMTP password

        $webmaster_email = "migascc69@gmail.com"; //Reply to this email ID


    $email= $_GET['email']; // Recipients email ID

    $name= $_GET['nome']; // Recipient's name

    $mail->From = $webmaster_email;
    $mail->FromName = "Bundles&Bundles.net";
    $mail->AddAddress($email,$name);
    $mail->AddReplyTo($webmaster_email,"Bundles&Bundles.net");
    $mail->WordWrap = 1000; // set word wrap

    //$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment
    //$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); // attachment

    $mail->IsHTML(true); // send as HTML

    $mail->Subject = "Confirmação de Registo";

            $message = '<html><body>';
            $message .= '<a href="http://localhost/$caminho">';
            $message .= '  <img style="width: 400px;border: 1px solid #000;box-shadow: 1px 1px 10px 4px;" src="https://lh5.googleusercontent.com/WBV0lwKByirAcHB3ZsMYISjRSTpGPL0OvfKP-8DJN6A=w609-h207-p-no" alt="Website Change Request" /></a>';
            $message .= '<table rules="all" style="border:1px solid #666;" cellpadding="10">';
            $message .= "<tr style='background: #eee;'><td><strong>Nome:</strong>               </td><td>" . strip_tags($_GET['nome']) . "</td></tr>";
            $message .= "<tr style='background: #eee;'><td><strong>Nome de Utilizador:</strong> </td><td>" . strip_tags($_GET['username']) . "</td></tr>";
            $message .= "<tr><td><strong>Email:</strong>                                        </td><td>" . strip_tags($_GET['email']) . "</td></tr>";
            $message .= "<tr><td><strong>Confirmação do email:</strong>                         </td><td><a href='http://localhost/".$caminho."account/account.php?type=confirm&email=" . strip_tags($_GET['email']) . "&token=" . $_GET['token'] . "'>Confirmar Email</a></td></tr>";
            $message .= "<tr><td><strong>Cancelar Registo:</strong>                         </td><td><a href='http://localhost/".$caminho."account/account.php?type=cancel&email=" . $_GET['email'] . "&token=" . $_GET['token'] . "'>Cancelar Registo</a></td></tr>";
            $message .= "</table>";
            $message .= "</body></html>";
            $message_plan = "Confirmação do email: http://localhost/".$caminho."account/account.php?type=confirm&email=" . strip_tags($_GET['email']) . "&token=token=" . $_GET['token'];

    $mail->Body = $message; //HTML Body
    $mail->AltBody = $message_plan; //Text Body
    if(!$mail->Send()){
        $response = 'erro';
        $erro = array(
            "tipo" => 'erro',
            "email" => $email,
            "msg" => "<ul style='display: inline-block;'>".$mail->ErrorInfo."</ul>",
        );
    } else {
        $response = "success";
        $success = array(
            "tipo" => 'success',
            "msg" => 'Email enviado, <b>'.$email.'</b> confirme o seu email de seguida.',
        ); 
    }
// Finally depending on the button value, JSON encode our winetable and print it
 if ($response == "success") {
      print json_encode($success);
    }
    else {
      print json_encode($erro);
    }
?>

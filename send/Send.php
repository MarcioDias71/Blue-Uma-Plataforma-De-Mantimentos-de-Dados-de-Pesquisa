<?php
if(!session_id()){
	session_start();
} else {
	session_regenerate_id(true);
}

require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function Send($codigo){

	$mail = new PHPMailer(true);

 try {
 	$mail->isSMTP();
 	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->SMTPDebug = false;
 	$mail->Username = "";
 	$mail->Password = '';
 	$mail->SMTPSecure = 'ssl';
 	$mail->CharSet = "UTF-8";
    $mail->Port = 465;

 	$mail->setFrom("","Equipe Blue - Autenticação de e-mail");
 	$mail->addAddress($_SESSION['email']);

 	$mail->isHTML(true);
 	$mail->Subject = 'Código de Verificação';
 	$mail->Body = "Seu código é: <strong>$codigo</strong>";
 	$mail->AltBody = "Seu código é: $codigo";


 	if($mail->send()) {
 		 /* echo 'Email enviado com sucesso'; */
 	} else {
 		 /* echo 'Email nao enviado'; */
 	}
 } catch (Exception $e) {
 	// echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
 }

}


if (!isset($_SESSION['email'])) {
	$_SESSION['msg'] = "Você deve fazer login primeiro";
	echo $_SESSION['msg'];
	header('location: ../login.php');
}
?>

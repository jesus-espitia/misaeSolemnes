<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Ajuste según su método de instalación

$mail = new PHPMailer(true); // Habilitar excepciones

// Configuración SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // Su servidor SMTP
$mail->SMTPAuth = true;
$mail->Username = 'santyvalethony03@gmail.com'; // Su usuario de Mailtrap
$mail->Password = 'uvaj tprj srkv qsev'; // Su contraseña de Mailtrap
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

//rsur afbi debv zdvf
//uvaj tprj srkv qsev

// Configuración de remitente y destinatario
$mail->setFrom('santyvalethony03@gmail.com', 'Santiago Ramirez');
$mail->addAddress('jcardona904@gmail.com', 'Cardona, el mejor profesor');

//jcardona904

// Enviando email de texto plano
$mail->isHTML(false); // Establecer formato de email a texto plano
$mail->Subject = 'Skymmusicradio';
$mail->Body    = 'https://Skymmusicradio.com';

// Enviar el email
if(!$mail->send()){
    echo 'El mensaje no pudo ser enviado. Error de Mailer: ' . $mail->ErrorInfo;
} else {
    echo 'El mensaje ha sido enviado';
}
<?php
require_once '../../phpmailer/vendor/autoload.php';// Ajuste según su método de instalación
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true); // Habilitar excepciones

// Configuración SMTP
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // Su servidor SMTP
$mail->SMTPAuth = true;
$mail->Username = 'missaesolemnes@gmail.com'; // Su dirección de correo electrónico
$mail->Password = 'wyzj yvln lmmp rswd'; 
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->CharSet = 'UTF-8'; // Establecer la codificación de caracteres a UTF-8
$mail->setFrom('missaesolemnes@gmail.com', 'Missae Solemnes');
<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'path/to/composer/vendor/autoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'live.smtp.mailtrap.io';
$mail->SMTPAuth = true;
$mail->Username = '1a2b3c4d5e6f7g'; //generado por Mailtrap
$mail->Password = '1a2b3c4d5e6f7g'; //generado por Mailtrap
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->SMTPKeepAlive = true; // agrégalo para mantener la conexión SMTP abierta después de cada email enviado
$mail->setFrom('lista@ejemplo.com', 'Gestor de lista');
$mail->Subject = "Nueva lista de email de Mailtrap";
$users = [
  ['email' => 'max@gmail.com', 'name' => 'Max'],
  ['email' => 'box@ejemplo.com', 'name' => 'Bob']
];
foreach ($users as $user) {
  $mail->addAddress($user['email'], $user['name']);
  $mail->Body = "<h2>¡Hola, {$user['name']}!</h2> <p>¿Cómo está?</p>";
  $mail->AltBody = "¡Hola, {$user['name']}! \n ¿Cómo está?";
  try {
      $mail->send();
      echo "Mensaje enviado a: ({$user['email']}) {$mail->ErrorInfo}\n";
  } catch (Exception $e) {
      echo "Error de Mailer ({$user['email']}) {$mail->ErrorInfo}\n";
  }
  $mail->clearAddresses();
}
$mail->smtpClose();
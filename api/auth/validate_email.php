<?php
require 'C:\xampp\htdocs\php\verificar2\verificar\vendor\autoload.php';
use SMTPValidateEmail\Validator as SmtpEmailValidator;

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $validator = new SmtpEmailValidator($email, 'sender@example.com');
    $results = $validator->validate();
    if ($results[$email]) {
        session_start();
        $_SESSION['email_real'] = true; // Guardar el email en la sesión
        echo "1"; // El email existe
    } else {
        echo "0"; // El email no existe
    }
}else{
    echo "-1"; // No se ha enviado el email

}
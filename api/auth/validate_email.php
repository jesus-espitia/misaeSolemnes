<?php
require_once __DIR__ . '/../config/database.php';

require_once '../../verificar/vendor/autoload.php';
use SMTPValidateEmail\Validator as SmtpEmailValidator;

if (isset($_POST['email'])) {
    $nameInput = $_POST['nameInput'];
    $password = $_POST['password'];
    $countryUser = $_POST['countryUser'];
    $email = $_POST['email'];

    $conn = conectarBD();
    $stmt = $conn->prepare("SELECT * FROM USUARIOS WHERE correo_usuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "2"; //el correo ya esta registrado
    }else{
        $validator = new SmtpEmailValidator($email, 'sender@example.com');
        $results = $validator->validate();
        if ($results[$email]) {
            session_start();
            $_SESSION['nameInput'] = $nameInput; // Guardar el nombre de usuario en la sesión
            $_SESSION['email'] = $email; // Guardar el email en la sesión
            $_SESSION['password'] = $password; // Guardar la contraseña en la sesión
            $_SESSION['countryUser'] = $countryUser; // Guardar el país en la sesión

            echo "1"; // El email existe
        } else {
            echo "0"; // El email no existe
        }
    }
}else{
    echo "-1"; // No se ha enviado el email

}
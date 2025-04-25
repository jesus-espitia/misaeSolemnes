<?php
session_start();

if(!isset($_SESSION['email_real'])) {
    session_unset();
    die("Acceso directo no autorizado.");
}

if (!isset($_GET['email']) || !isset($_GET['username'])) {
    session_unset();
    die("Por alguna razón no se ha enviado el email o el usuario. Vuelva a intentarlo");
}
$email = $_GET['email'];
$username = $_GET['username'];

include_once 'C:\xampp\htdocs\php\verificar2\missae_solemnes\includes\conexionSMTP.php';

$mail->setFrom('missaesolemnes@gmail.com', 'Missae Solemnes');
$mail->addAddress($email, $username);

$codigo = bin2hex(random_bytes(3)); // Generar un código único
$_SESSION['codigo'] = $codigo; // Guardar el código en la sesión para su verificación posterior

//jcardona904

// Enviando email de texto plano
$mail->isHTML(false); // Establecer formato de email a texto plano
$mail->Subject = 'Código de verificación de correo Missae Solemnes';
$mail->Body    = $codigo;

// Enviar el email
if(!$mail->send()){
    die("El mensaje no pudo ser enviado. Error de Mailer: " . $mail->ErrorInfo. "<br>Por favor, vuelva a intentarlo.");
} else { ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form action="" method="">
            <label for="verification_code">Ingrese el código de verificación(puede que tengas que ver en spam): </label>
            <input type="text" id="verification_code" name="verification_code" required>
            <button id="btnSubmit" type="submit">Verificar</button>
        </form>

        <form action="verify_email.php" method="get"></form>
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <button type="submit">Enviar de nuevo el código</button>
        </form>
    </body>
    </html>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/php/verificar2/missae_solemnes/assets/js/verify_email.js"></script>

<?php }



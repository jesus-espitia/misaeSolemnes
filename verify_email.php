<?php
session_start();

if(!isset($_SESSION['email']) || !isset($_SESSION['nameInput'])) {
    session_unset();
    die("Acceso directo no autorizado.");
}

$email = $_SESSION['email'];
$nameInput = $_SESSION['nameInput'];

require_once 'api/utils/conexionSMTP.php';

$mail->setFrom('missaesolemnes@gmail.com', 'Missae Solemnes');
$mail->addAddress($email, $nameInput);

$codigo = bin2hex(random_bytes(3)); // Generar un código único
$_SESSION['codigo'] = $codigo; // Guardar el código en la sesión para su verificación posterior

//jcardona904

// Enviando email de texto plano
$mail->isHTML(true); // Establecer formato de email a texto plano
$mail->Subject = 'Código de verificación de correo Missae Solemnes';
// Contenido del correo
$mail->Body = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Verificación de correo</title>
</head>
<body style="margin:0;padding:0;background-color:white;background-image:linear-gradient(45deg, #ccc 25%, transparent 25%, transparent 75%, #ccc 75%, #ccc),linear-gradient(45deg, #ccc 25%, white 25%, white 75%, #ccc 75%, #ccc);background-size:30px 30px;background-position:0 0,15px 15px;font-family: Arial, sans-serif; color: #5C4033;">

    <div style="max-width:600px;margin:30px auto;padding:20px;background-color:#fff;border-radius:8px;box-shadow:0px 0px 10px rgba(0,0,0,0.1);">
        <h1 style="text-align:center;color:#8B4513;">MISSAE SOLEMNES ✝️</h1>
        <p style="font-size:18px;color:#5C4033;">Hola <strong>' . htmlspecialchars($nameInput) . '</strong>,</p>
        <p style="font-size:16px;color:#5C4033;">Gracias por registrarte. Tu código de verificación es:</p>
        
        <div style="text-align:center;margin:30px 0;">
            <span style="display:inline-block;padding:15px 30px;font-size:24px;font-weight:bold;color:white;background-color:#A0522D;border-radius:8px;">' . htmlspecialchars($codigo) . '</span>
        </div>
        
        <p style="font-size:14px;color:#5C4033;">Por favor, ingresa este código en la página para completar tu verificación.</p>
        
        <p style="font-size:12px;color:#5C4033;">Si no solicitaste este correo, puedes ignorarlo.</p>

        <hr style="margin:30px 0;border:0;border-top:1px solid #D2B48C;">
        <footer style="text-align:center;font-size:12px;color:#A0522D;">
            © 2025 MISSAE SOLEMNES - Todos los derechos reservados.
        </footer>
    </div>

</body>
</html>
';

// Enviar el email
if(!$mail->send()){
    die("El mensaje no pudo ser enviado. Error de Mailer: " . $mail->ErrorInfo. "<br>Por favor, vuelva a intentarlo.");
} else { ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Misae Solemnes | VERIFICAR</title>
        <link rel="icon" href="assets/icon/cruzar (1).png">
        <link rel="stylesheet" href="css/verify_code.css">
    </head>

    <header>
        <h1>MISAE SOLEMNES ✝️</h1>
        <div class="menu-container">
            <a id="toggle" href="#"><span></span></a>
            <div id="menu">
                <ul>
                    <li><a href="index.html">INICIO</a></li>
                    <li><a href="acercaDe.html">ACERCA DE</a></li>
                    <li><a href="login.html">LOGIN</a></li>
                    <li><a href="registro.html">REGISTRO</a></li>
                </ul>
            </div>
        </div>
        <nav class="menu">
            <a href="index.html">INICIO</a>
            <a href="acercaDe.html">ACERCA DE</a>
            <a href="login.html">LOGIN</a>
            <a href="registro.html">REGISTRO</a>
        </nav>
    </header>

    <body>
    <div id="page-loader" style="display: none;">
        <div class="spinner"></div>
    </div>
        <main>
            <h2>Verificación de correo electrónico</h2>
            <p>Hemos enviado un código de verificación a su correo electrónico (Spam). Por favor, ingréselo a continuación para verificar su cuenta.</p>
            <p>Si no ha recibido el correo, revise su carpeta de spam o haga clic en "Enviar de nuevo el código".</p>

            <form action="" method="">
                <label for="verification_code">Ingrese el código de verificación: </label>
                <input type="text" id="verification_code" name="verification_code" required>
                <button id="btnSubmit" type="submit">Verificar</button>
            </form>

            <p id="resend_code">¿No ha recibido el código? <a href="verify_email.php" id="resend">Enviar de nuevo el código</a></p>
        </main>

        <footer>
            © 2025 MISAE SOLEMNES - Todos los derechos reservados.
        </footer>

    <script src="js/verify_email.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/loader.js"></script>
    </body>
    </html>

<?php }



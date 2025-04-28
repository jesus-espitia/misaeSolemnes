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
$mail->isHTML(false); // Establecer formato de email a texto plano
$mail->Subject = 'Código de verificación de correo Missae Solemnes';
$mail->Body    = $codigo;

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
            <p>Hemos enviado un código de verificación a su correo electrónico. Por favor, ingréselo a continuación para verificar su cuenta.</p>
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



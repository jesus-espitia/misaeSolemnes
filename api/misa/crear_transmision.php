<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_exception_handler(function ($e) {
    echo "EXCEPTION: " . $e->getMessage() . "<br>";
    echo "En archivo: " . $e->getFile() . "<br>";
    echo "En línea: " . $e->getLine() . "<br>";
    echo "<pre>";
    print_r($e);
    echo "</pre>";
});

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    echo "ERROR [$errno]: $errstr in $errfile on line $errline";
});

session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para crear una transmisión.";
    exit;
}

require_once __DIR__ . '/../config/database.php';
require_once '../utils/conexionSMTP.php';
$conn = conectarBD();

// Recibir datos del formulario
$enlace = $_POST['enlaceVideo_transmision'] ?? '';
$estado = $_POST['estado_transmision'] ?? '';
$misa_id = $_POST['misa_id'] ?? null;
$plataforma = $_POST['plataforma_transmision'] ?? '';
$usuario_id = $_SESSION['usuario_id'];

if (empty($enlace) || empty($estado) || empty($misa_id) || empty($plataforma)) {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Todos+los+campos+son+obligatorios&redirect=../../perfil.php");
    exit;
}

// Insertar transmisión
$query = "INSERT INTO TRANSMISIONES (enlaceVideo_transmision, estado_transmision, plataforma_transmision, misa_id)
            VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssi", $enlace, $estado, $plataforma, $misa_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $stmt = $conn->prepare("SELECT MISAS.tipo_misa, SACERDOTES.nombre_sacerdote FROM MISAS JOIN SACERDOTES ON MISAS.sacerdote_id = SACERDOTES.id_sacerdote WHERE MISAS.id_misa = ? ");
    $stmt->bind_param("i", $misa_id);
    $stmt->execute();
    $resultTipo = $stmt->get_result();
    $fila = $resultTipo->fetch_row();
    $tipoMisa = $fila[0];
    $sacerdote = $fila[1];

    $result = $conn->query("SELECT nombre_usuario, correo_usuario FROM USUARIOS WHERE quiere_correos = 'si'");
    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }


    foreach ($rows as $key => $row) {
        file_put_contents(
            '/tmp/debug_row.log',
            "[$key] nombre_usuario: {$row['nombre_usuario']} | correo_usuario: {$row['correo_usuario']}\n",
            FILE_APPEND
        );

        $mail->addAddress($row['correo_usuario'], $row['nombre_usuario']);
        $mail->isHTML(true); // Establecer formato de email a HTML
        $mail->Subject = 'Enlace a la transmisión de la Misa - Missae Solemnes';
        // Contenido del correo
        $mail->Body = '
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <title>Transmisión de la Misa</title>
            </head>
            <body style="margin:0;padding:0;background-color:white;background-image:linear-gradient(45deg, #ccc 25%, transparent 25%, transparent 75%, #ccc 75%, #ccc),linear-gradient(45deg, #ccc 25%, white 25%, white 75%, #ccc 75%, #ccc);background-size:30px 30px;background-position:0 0,15px 15px;font-family: Arial, sans-serif; color: #5C4033;">

                <div style="max-width:600px;margin:30px auto;padding:20px;background-color:#fff;border-radius:8px;box-shadow:0px 0px 10px rgba(0,0,0,0.1);">
                    <h1 style="text-align:center;color:#8B4513;">MISSAE SOLEMNES ✝️</h1>
                    <p style="font-size:18px;color:#5C4033;">Hola <strong>' . htmlspecialchars($row['nombre_usuario']) . '</strong>,</p>
                    <p style="font-size:16px;color:#5C4033;">Te compartimos el enlace para la transmisión en vivo de la misa <strong>' . htmlspecialchars($tipoMisa) . '</strong>, que será oficiada por el padre <strong>' . htmlspecialchars($sacerdote) . '</strong>:</p>
                    
                    <div style="text-align:center;margin:30px 0;">
                        <a href="' . htmlspecialchars('http://localhost/misaeSolemnes/pos/transmisiones.php') . '" style="display:inline-block;padding:15px 30px;font-size:18px;font-weight:bold;color:white;background-color:#A0522D;border-radius:8px;text-decoration:none;">
                            Ver Transmisión
                        </a>
                    </div>

                    <hr style="margin:30px 0;border:0;border-top:1px solid #D2B48C;">
                    <footer style="text-align:center;font-size:12px;color:#A0522D;">
                        © 2025 MISSAE SOLEMNES - Todos los derechos reservados.
                    </footer>
                </div>

            </body>
            </html>
        ';
        $mail->send();
    }
    header("Location: ../utils/alerta.php?tipo=success&titulo=¡LISTO!&mensaje=Se+ha+creado+correctamete&redirect=../../perfil.php");
} else {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Error+al+crear+la+transmisión.+Vuelva+a+intentarlo.&redirect=../../perfil.php");
}

$conn->close();
?>

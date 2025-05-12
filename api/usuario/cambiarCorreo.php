<?php
file_put_contents("debug.txt", print_r($_POST, true), FILE_APPEND);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_exception_handler(function ($e) {
    echo "EXCEPTION: " . $e->getMessage();
});

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    echo "ERROR [$errno]: $errstr in $errfile on line $errline";
});

require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();
session_start();

$email = $_SESSION['email'];
$quiereCorreos = isset($_POST['quiereCorreos']) ? "si" : "no"; // 1 si está marcado, 0 si no

$stmt = $conn->prepare("UPDATE USUARIOS SET quiere_correos = ? WHERE correo_usuario = ?");
$stmt->bind_param("ss", $quiereCorreos, $email);
$stmt->execute();
if ($stmt->affected_rows > 0) {
    file_put_contents("debug.txt", "Actualización exitosa\n", FILE_APPEND);
} else {
    file_put_contents("debug.txt", "No se actualizó ninguna fila\n", FILE_APPEND);
}
file_put_contents("debug.txt", "Email usado: $email\n", FILE_APPEND);


header('Location: ../../perfil.php');
exit;

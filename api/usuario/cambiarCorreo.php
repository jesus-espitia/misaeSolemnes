<?php
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();
session_start();

$email = $_SESSION['email'];
$quiereCorreos = isset($_POST['quiereCorreos']) ? "si" : "no"; // 1 si está marcado, 0 si no

$stmt = $conn->prepare("UPDATE USUARIOS SET quiere_correos = ? WHERE correo_usuario = ?");
$stmt->bind_param("ss", $quiereCorreos, $email);
$stmt->execute();
header('Location: ../../perfil.php');
exit;

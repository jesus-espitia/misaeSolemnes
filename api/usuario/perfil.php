<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "No autenticado"]);
    exit();
}

require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

$id = $_SESSION['usuario_id'];

$stmt = $conn->prepare("SELECT id_usuario, nombre_usuario, correo_usuario, pais_usuario, fechaRegistro_usuario FROM USUARIOS WHERE id_usuario = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($usuario = $result->fetch_assoc()) {
    echo json_encode($usuario);
} else {
    http_response_code(404);
    echo json_encode(["error" => "Usuario no encontrado"]);
}

$stmt->close();
$conn->close();

<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para crear una transmisión.";
    exit;
}

require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

// Recibir datos del formulario
$enlace = $_POST['enlaceVideo_transmision'] ?? '';
$estado = $_POST['estado_transmision'] ?? '';
$misa_id = $_POST['misa_id'] ?? null;
$plataforma = $_POST['plataforma_transmision'] ?? '';
$usuario_id = $_SESSION['usuario_id'];

if (empty($enlace) || empty($estado) || empty($misa_id) || empty($plataforma)) {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Faltan+campos&redirect=../../perfil.php");
    exit;
}

// Insertar transmisión
$query = "INSERT INTO TRANSMISIONES (enlaceVideo_transmision, estado_transmision, plataforma_transmision, misa_id, id_usuario)
            VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssii", $enlace, $estado, $plataforma, $misa_id, $usuario_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: ../utils/alerta.php?tipo=success&titulo=¡LISTO!&mensaje=Se+ha+creado+correctamete&redirect=../../perfil.php");
} else {
    echo "Error al crear la transmisión.";
}

$stmt->close();
$conn->close();
?>

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

// Validaciones básicas
if (empty($estado) || empty($misa_id) || empty($plataforma)) {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Todos+los+campos+son+obligatorios&redirect=../../perfil.php");
    exit;
}

// Si es programada, el enlace es opcional
if ($estado !== 'programada' && empty($enlace)) {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=El+enlace+es+obligatorio+para+este+estado&redirect=../../perfil.php");
    exit;
}

// Si es programada y no tiene enlace, usar valor especial
if ($estado === 'programada' && empty($enlace)) {
    $enlace = 'PROGRAMADA_SIN_ENLACE';
}

// Insertar transmisión
$query = "INSERT INTO TRANSMISIONES (enlaceVideo_transmision, estado_transmision, plataforma_transmision, misa_id)
            VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("sssi", $enlace, $estado, $plataforma, $misa_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: ../utils/alerta.php?tipo=success&titulo=¡LISTO!&mensaje=Se+ha+creado+correctamete&redirect=../../perfil.php");
} else {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Error+al+crear+la+transmisión&redirect=../../perfil.php");
}

$stmt->close();
$conn->close();
?>

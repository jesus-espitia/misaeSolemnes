<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "Debes iniciar sesión para crear una misa.";
    exit;
}

require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

// Validar los campos del formulario
$titulo = $_POST['titulo_misa'] ?? '';
$fecha = $_POST['fecha_misa'] ?? '';
$hora = $_POST['hora_misa'] ?? '';
$tipo = $_POST['tipo_misa'] ?? '';
$sacerdote_id = $_POST['sacerdote_id'] ?? null;

if (empty($titulo) || empty($fecha) || empty($hora) || empty($tipo) ) {
    echo "Todos los campos son obligatorios.";
    exit;
}

// Insertar la misa
$query = "INSERT INTO MISAS (titulo_misa, fecha_misa, hora_misa, tipo_misa, sacerdote_id)
            VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $titulo, $fecha, $hora, $tipo, $sacerdote_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Misa creada exitosamente.";
} else {
    echo "Hubo un error al crear la misa.";
}

$stmt->close();
$conn->close();
?>

<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Debes+iniciar+sesión+para+crear+una+misa&redirect=../../perfil.php");
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
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Todos+los+campos+son+obligatorios&redirect=../../perfil.php");
    exit;
}

// Insertar la misa
$query = "INSERT INTO MISAS (titulo_misa, fecha_misa, hora_misa, tipo_misa, sacerdote_id)
            VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $titulo, $fecha, $hora, $tipo, $sacerdote_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    header("Location: ../utils/alerta.php?tipo=success&titulo=¡LISTO!&mensaje=Misa+creada+exitosamente&redirect=../../perfil.php");
} else {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Hubo+un+error+al+crear+la+misa&redirect=../../perfil.php");
}

$stmt->close();
$conn->close();
?>

<?php
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

// Verificar si se pasó un ID de misa
if (!isset($_GET['id_misa'])) {
    echo "ID de misa no proporcionado.";
    exit;
}

$id = intval($_GET['id_misa']);
$query = "SELECT * FROM MISAS WHERE id_misa = $id";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    echo "Misa no encontrada.";
    exit;
}

$misa = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo_misa'];
    $fecha = $_POST['fecha_misa'];
    $hora = $_POST['hora_misa'];
    $tipo = $_POST['tipo_misa'];

    $update = $conn->prepare("UPDATE MISAS SET titulo_misa=?, fecha_misa=?, hora_misa=?, tipo_misa=? WHERE id_misa=?");
    $update->bind_param("ssssi", $titulo, $fecha, $hora, $tipo, $id);
    
    if ($update->execute()) {
        echo "Misa actualizada correctamente.";
    } else {
        echo "Error al actualizar la misa.";
    }
}
?>

<h2>Editar Misa</h2>
<form method="post">
    <label>Título:</label><br>
    <input type="text" name="titulo_misa" value="<?= htmlspecialchars($misa['titulo_misa']) ?>"><br>

    <label>Fecha:</label><br>
    <input type="date" name="fecha_misa" value="<?= $misa['fecha_misa'] ?>"><br>

    <label>Hora:</label><br>
    <input type="time" name="hora_misa" value="<?= $misa['hora_misa'] ?>"><br>

    <label>Tipo:</label><br>
    <select name="tipo_misa">
        <option value="dominical" <?= $misa['tipo_misa'] == 'dominical' ? 'selected' : '' ?>>Dominical</option>
        <option value="funeral" <?= $misa['tipo_misa'] == 'funeral' ? 'selected' : '' ?>>Funeral</option>
        <option value="boda" <?= $misa['tipo_misa'] == 'boda' ? 'selected' : '' ?>>Boda</option>
        <option value="otra" <?= $misa['tipo_misa'] == 'otra' ? 'selected' : '' ?>>Otra</option>
    </select><br><br>

    <button type="submit">Actualizar</button>
</form>

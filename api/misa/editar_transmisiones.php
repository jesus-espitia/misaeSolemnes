<?php
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();


if (!isset($_GET['id_transmision'])) {
    echo "ID de Transmision no proporcionado.";
    exit;
}

$id = intval($_GET['id_transmision']);
$query = "SELECT * FROM TRANSMISIONES WHERE id_transmision = $id";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    echo "Transmision no encontrada.";
    exit;
}

$transmision = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enlaceT = $_POST['enlaceVideo_transmision'];
    $plataformaT = $_POST['plataforma_transmision'];
    $estadoT = $_POST['estado_transmision'];

    $update = $conn->prepare("UPDATE TRANSMISIONES SET enlaceVideo_transmision=?, plataforma_transmision=?, estado_transmision=? WHERE id_transmision=?");
    $update->bind_param("sssi", $enlaceT, $plataformaT, $estadoT, $id);
    
    if ($update->execute()) {
        echo "Transmision actualizada correctamente.";
    } else {
        echo "Error al actualizar la Transmision.";
    }
}
?>

<h2>Editar Transmision</h2>
<form method="post">
    <label>Enlace:</label><br>
    <input type="url" name="enlaceVideo_transmision" value="<?= htmlspecialchars($transmision['enlaceVideo_transmision']) ?>"><br>

    <label>Plataforma:</label><br>
    <select name="plataforma_transmision">
        <option value="YouTube" <?= $transmision['plataforma_transmision'] == 'YouTube' ? 'selected' : '' ?>>YouTube</option>
        <option value="Facebook" <?= $transmision['plataforma_transmision'] == 'Facebook' ? 'selected' : '' ?>>Facebook</option>
        <option value="otra" <?= $transmision['plataforma_transmision'] == 'otra' ? 'selected' : '' ?>>Otra</option>
    </select><br><br>

    <label>Estado Transmision:</label><br>
    <select name="estado_transmision">
        <option value="en vivo" <?= $transmision['estado_transmision'] == 'en vivo' ? 'selected' : '' ?>>en vivo</option>
        <option value="finalizada" <?= $transmision['estado_transmision'] == 'finalizada' ? 'selected' : '' ?>>finalizada</option>
        <option value="otra" <?= $transmision['estado_transmision'] == 'otra' ? 'selected' : '' ?>>Otra</option>
    </select><br><br>

    <button type="submit">Actualizar</button>
</form>

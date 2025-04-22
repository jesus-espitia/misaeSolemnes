<?php
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();


if (!isset($_GET['id_transmision'])) {
    header("Location: ../utils/alerta.php?tipo=warning&titulo=¡ADVERTENCIA!&mensaje=ID+de+transmision+no+proporcionado&redirect=../misa/admin_transmisiones.php");
    exit;
}

$id = intval($_GET['id_transmision']);
$query = "SELECT * FROM TRANSMISIONES WHERE id_transmision = $id";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    header("Location: ../utils/alerta.php?tipo=warning&titulo=¡ADVERTENCIA!&mensaje=Transmision+no+encontrada&redirect=../misa/admin_transmisiones.php");
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
        header("Location: ../utils/alerta.php?tipo=success&titulo=¡BIEN HECHO!&mensaje=transmision+actualizada+correctamente&redirect=../misa/admin_transmisiones.php");
    } else {
        header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Error+al+actualizar+la+transmision&redirect=../misa/admin_transmisiones.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misae Solemnes | EDITAR TRANSMISION</title>
    <link rel="stylesheet" href="../../css/editarMisaTransmision.css">
    <link rel="icon" href="../../assets/icon/cruzar (1).png">
</head>
<body>
    <header>
        <h1>MISAE SOLEMNES ✝️</h1>
        <nav>
            <a href="/api/misa/admin_transmisiones.php">ATRAS</a>
        </nav>
    </header>
    <center>
    <div class="form_editar_misas">
        <div class="editar_misas">
            <h3>Editar Transmision</h3>
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
        </div>    
        <div class="hero-text">
            <p><strong>📡 Advertencia para la edición de transmisiones:</strong> ⚠️ La información editada aquí afecta la transmisión en vivo vinculada. Verifica los datos antes de confirmar los cambios.</p>
        </div>
    </div>
    </center>
    <footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>
</body>
</html>



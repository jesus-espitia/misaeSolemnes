<?php
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

// Verificar si se pasó un ID de misa
if (!isset($_GET['id_misa'])) {
    header("Location: ../utils/alerta.php?tipo=warning&titulo=¡ADVERTENCIA!&mensaje=ID+de+misa+no+proporcionado&redirect=../misa/admin_transmisiones.php");
    exit;
}

$id = intval($_GET['id_misa']);
$query = "SELECT * FROM MISAS WHERE id_misa = $id";
$result = $conn->query($query);

if (!$result || $result->num_rows === 0) {
    header("Location: ../utils/alerta.php?tipo=warning&titulo=¡ADVERTENCIA!&mensaje=Misa+no+encontrada&redirect=../misa/admin_transmisiones.php");
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
        header("Location: ../utils/alerta.php?tipo=success&titulo=¡BIEN HECHO!&mensaje=Misa+actualizada+correctamente&redirect=../misa/admin_transmisiones.php");
    } else {
        header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Error+al+actualizar+la+misa&redirect=../misa/admin_transmisiones.php");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misae Solemnes | EDITAR MISA</title>
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
            <h3>Editar Misa</h3>
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
        </div>    
        <div class="hero-text">
            <p><strong>🔧 Advertencia para la edición de misas:</strong> ⚠️ Los cambios realizados en esta sección modificarán directamente los datos de la misa en la base de datos. Asegúrate de revisar bien antes de guardar.</p>
        </div>
    </div>
    </center>
    <footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>
</body>
</html>


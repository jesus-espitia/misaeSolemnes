<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

// Verifica si el usuario es un sacerdote
if (!isset($_SESSION['usuario_id'])) {
    echo "<p>No tienes permiso para ver esta página.</p>";
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Verificar si este usuario es sacerdote
$sqlSacerdote = "SELECT id_sacerdote FROM SACERDOTES WHERE usuario_id = ?";
$stmt = $conn->prepare($sqlSacerdote);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p>Acceso restringido. Solo para sacerdotes.</p>";
    exit;
}

$id_sacerdote = $result->fetch_assoc()['id_sacerdote'];

// Traer misas y transmisiones asociadas a este sacerdote
$query = "
    SELECT M.id_misa, M.titulo_misa, M.fecha_misa, M.hora_misa, M.tipo_misa,
            T.id_transmision, T.enlaceVideo_transmision, T.estado_transmision, T.plataforma_transmision
    FROM MISAS M
    LEFT JOIN TRANSMISIONES T ON M.id_misa = T.misa_id
    WHERE M.sacerdote_id = ?
    ORDER BY M.fecha_misa DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_sacerdote);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Misae Solemnes | ADMINISTRADOR</title>
    <link rel="stylesheet" href="../../css/admin.css">
    <link rel="icon" href="../../assets/icon/cruzar (1).png">
</head>
<body>
    <header>
        <h1>MISAE SOLEMNES ✝️</h1>
        <nav>
            <a href="/pos/inicio.html">INICIO</a>
            <a href="#">ACERCA DE</a>
            <a href="/pos/transmisiones.php">TRASMICIONES</a>
            <a href="/perfil.php">PERFIL</a>
            <a href="/pos/logout.html">CERRAR SESIÓN</a>
        </nav>
    </header>
    <h2 style="text-align:center;">Panel de Administración de Transmisiones</h2>
    <table>
        <thead>
            <tr>
                <th>Título de Misa</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Tipo</th>
                <th>Enlace Video</th>
                <th>Plataforma</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['titulo_misa']) ?></td>
                    <td><?= htmlspecialchars($row['fecha_misa']) ?></td>
                    <td><?= htmlspecialchars($row['hora_misa']) ?></td>
                    <td><?= htmlspecialchars($row['tipo_misa']) ?></td>
                    <td><?= htmlspecialchars($row['enlaceVideo_transmision'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['plataforma_transmision'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['estado_transmision'] ?? '-') ?></td>
                    <td class="acciones">
                        <?php if ($row['id_misa']): ?>
                            <form action="editar_misa.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id_misa" value="<?= $row['id_misa'] ?>">
                                <button class="editar">Editar Misa</button>
                            </form>
                        <?php endif; ?>

                        <?php if ($row['id_transmision']): ?>
                            <form action="editar_transmisiones.php" method="GET" style="display:inline;">
                                <input type="hidden" name="id_transmision" value="<?= $row['id_transmision'] ?>">
                                <button class="editar">Editar Transmisión</button>
                            </form>
                            <form action="eliminar_misa_y_transmision.php" method="POST" style="display:inline;">
                                <input type="hidden" name="id_misa" value="<?= $row['id_misa'] ?>">
                                <input type="hidden" name="id_transmision" value="<?= $row['id_transmision'] ?>">
                                <button class="eliminar" onclick="return confirm('¿Eliminar misa y transmisión asociada?');">Eliminar Todo</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>
</body>
</html>

<?php $conn->close(); ?>

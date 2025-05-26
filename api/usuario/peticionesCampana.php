<?php 
session_start();
// include '../api/config/database.php';
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

$stmt = $conn -> prepare('SELECT parroquia_id FROM SACERDOTES WHERE usuario_id = ?');
$stmt->bind_param('i', $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $parroquia_id = $row['parroquia_id'];

    $stmt = $conn->prepare('SELECT p.contenido, p.tipo, p.fecha_envio, u.nombre_usuario FROM PETICIONES p JOIN USUARIOS u ON p.usuario_id = u.id_usuario WHERE p.parroquia_id = ?');
    $stmt->bind_param('i', $parroquia_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $peticiones = [];
    while ($row = $result->fetch_assoc()) {
        $peticiones[] = $row;
    }
    if (empty($peticiones)) {
        echo "<p>No hay peticiones.</p>";
    } else {
        foreach ($peticiones as $peticion) {
            echo '<div class="peticion">';
            echo '<div class="tipo">' . htmlspecialchars($peticion['tipo']) . '</div>';
            echo '<div class="usuario">' . htmlspecialchars($peticion['nombre_usuario']) . '</div>';
            echo '<div class="contenido">' . nl2br(htmlspecialchars($peticion['contenido'])) . '</div>';
            echo '<div class="fecha"><small>' . htmlspecialchars($peticion['fecha_envio']) . '</small></div>';
            echo '</div>';
        }
    }
} else {
    echo "No se encontró la parroquia del sacerdote.";
    exit();
}
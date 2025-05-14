<?php
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

// Obtener el estado del filtro (por defecto 'en vivo')
$estado = isset($_GET['estado']) ? $_GET['estado'] : 'en vivo';

// Construir la consulta SQL según el filtro
$query = "SELECT T.enlaceVideo_transmision, T.estado_transmision, 
                 M.titulo_misa, M.tipo_misa, M.fecha_misa, M.hora_misa
          FROM TRANSMISIONES T
          INNER JOIN MISAS M ON T.misa_id = M.id_misa";

// Aplicar filtro según selección
if ($estado !== 'todas') {
    if ($estado === 'en vivo') {
        $query .= " WHERE T.estado_transmision = 'en vivo'";
    } elseif ($estado === 'programada') {
        $query .= " WHERE T.estado_transmision = 'programada' AND 
                    (M.fecha_misa > CURDATE() OR (M.fecha_misa = CURDATE() AND M.hora_misa > CURTIME()))";
    } elseif ($estado === 'finalizada') {
        $query .= " WHERE T.estado_transmision = 'finalizada' OR 
                    (T.estado_transmision = 'programada' AND 
                    (M.fecha_misa < CURDATE() OR (M.fecha_misa = CURDATE() AND M.hora_misa < CURTIME())))";
    }
}

// Ordenar según estado
if ($estado === 'programada') {
    $query .= " ORDER BY M.fecha_misa ASC, M.hora_misa ASC";
} elseif ($estado === 'finalizada') {
    $query .= " ORDER BY M.fecha_misa DESC, M.hora_misa DESC";
} else {
    $query .= " ORDER BY M.fecha_misa DESC, M.hora_misa DESC";
}

$result = $conn->query($query);

// Comienza HTML de las transmisiones
if ($result && $result->num_rows > 0) {
    echo '<div class="grid-transmisiones">';
    
    while ($row = $result->fetch_assoc()) {
        $url = $row['enlaceVideo_transmision'];
        $titulo = $row['titulo_misa'];
        $tipo = $row['tipo_misa'];

        // Extraer ID del video de YouTube
        preg_match("/(?:v=|be\/)([a-zA-Z0-9_-]{11})/", $url, $matches);
        $videoId = $matches[1] ?? null;

        // Si hay ID válido, se muestra el iframe
        if ($videoId) {
            echo '<div class="card-transmision">';
            echo '<h3>' . htmlspecialchars($titulo) . '</h3>';
            echo '<p class="tipo-misa">' . htmlspecialchars($tipo) . '</p>';
            echo '<iframe src="https://www.youtube.com/embed/' . htmlspecialchars($videoId) . '?autoplay=1" frameborder="0" allowfullscreen></iframe>';
            echo '</div>';
        } else {
            echo '<div class="card-transmision">';
            echo '<h3>' . htmlspecialchars($titulo) . '</h3>';
            echo '<p class="tipo-misa">' . htmlspecialchars($tipo) . '</p>';
            echo '<p style="color:red;">⚠️ Enlace inválido</p>';
            echo '</div>';
        }
    }

    echo '</div>';
} else {
    echo "<p style='text-align:center;'>No hay transmisiones en vivo actualmente.</p>";
}

$conn->close();
?>


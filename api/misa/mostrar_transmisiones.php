<?php
require_once __DIR__ . '/../config/database.php'; 
$conn = conectarBD(); 

$query = "SELECT T.enlaceVideo_transmision, M.titulo_misa, M.tipo_misa 
            FROM TRANSMISIONES T 
            INNER JOIN MISAS M ON T.misa_id = M.id_misa
            WHERE T.estado_transmision = 'en vivo'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    echo '<div class="grid-transmisiones">';
    while ($row = $result->fetch_assoc()) {
        $url = $row['enlaceVideo_transmision'];
        $titulo = $row['titulo_misa'];
        $tipo = $row['tipo_misa'];

        preg_match("/(?:v=|be\/)([a-zA-Z0-9_-]{11})/", $url, $matches);
        $videoId = $matches[1] ?? '';

        if ($videoId) {
            echo '<div class="card-transmision">';
            echo '<h3>' . htmlspecialchars($titulo) . '</h3>';
            echo '<p class="tipo-misa">' . htmlspecialchars($tipo) . '</p>';
            echo '<iframe src="https://www.youtube.com/embed/' . $videoId . '?autoplay=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
            echo '</div>';
        }
    }
    echo '</div>';
} else {
    echo "<p>No hay transmisiones en vivo actualmente.</p>"; 
}

$conn->close(); 
?>

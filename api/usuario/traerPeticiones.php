<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_exception_handler(function ($e) {
    echo "EXCEPTION: " . $e->getMessage();
});

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    echo "ERROR [$errno]: $errstr in $errfile on line $errline";
});

require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

$stmt = $conn->prepare('SELECT p.contenido, p.tipo, p.fecha_envio, par.nombre_parroquia FROM PETICIONES p JOIN PARROQUIAS par ON p.parroquia_id = par.id_parroquia WHERE usuario_id = ?;');
$stmt->bind_param('i', $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();
$peticiones = [];
while ($row = $result->fetch_assoc()) {
    $peticiones[] = $row;
}

if (empty($peticiones)) {
    echo "<p>No hay peticiones.</p>";
}else{
foreach ($peticiones as $peticion): ?>
    <div class="peticion">
        <div class="tipo"><?= htmlspecialchars($peticion['tipo']) ?></div>
        <div class="parroquia"><?= htmlspecialchars($peticion['nombre_parroquia']) ?></div>
        <div class="contenido"><?= nl2br(htmlspecialchars($peticion['contenido'])) ?></div>
        <div class="fecha"><small><?= htmlspecialchars($peticion['fecha_envio']) ?></small></div>
    </div>
<?php endforeach; }?>
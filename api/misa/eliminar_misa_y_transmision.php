<?php
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transmision = intval($_POST['id_transmision']);
    $id_misa = intval($_POST['id_misa']);

    // Eliminar la transmisión primero (por FK)
    $stmt1 = $conn->prepare("DELETE FROM TRANSMISIONES WHERE id_transmision = ?");
    $stmt1->bind_param("i", $id_transmision);
    $stmt1->execute();

    // Luego eliminar la misa
    $stmt2 = $conn->prepare("DELETE FROM MISAS WHERE id_misa = ?");
    $stmt2->bind_param("i", $id_misa);
    $stmt2->execute();

    echo "Misa y transmisión eliminadas correctamente.";
} else {
    echo "Solicitud inválida.";
}
?>

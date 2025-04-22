<?php
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_transmision = intval($_POST['id_transmision']);
    $id_misa = intval($_POST['id_misa']);

    // Eliminar la transmisión 
    $stmt1 = $conn->prepare("DELETE FROM TRANSMISIONES WHERE id_transmision = ?");
    $stmt1->bind_param("i", $id_transmision);
    $stmt1->execute();

    // Luego eliminar la misa
    $stmt2 = $conn->prepare("DELETE FROM MISAS WHERE id_misa = ?");
    $stmt2->bind_param("i", $id_misa);
    $stmt2->execute();
    
    header("Location: ../utils/alerta.php?tipo=success&titulo=¡BIEN HECHO!&mensaje=Misa+y+transmisión+eliminadas+correctamente&redirect=../misa/admin_transmisiones.php");
} else {
    
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=Solicitud+inválida&redirect=../misa/admin_transmisiones.php");
}
?>

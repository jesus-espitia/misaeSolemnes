<?php 

if (isset($_POST['peticion']) && isset($_POST['tipo']) && isset($_POST['parroquia_id'])){
    session_start();
    $contenido = $_POST['peticion'];
    $tipo = $_POST['tipo'];
    $parroquia_id = $_POST['parroquia_id'];
    
    require_once __DIR__ . '/../config/database.php';
    $conn = conectarBD();
    
    // Prepare the SQL statement
    $stmt = $conn->prepare('INSERT INTO PETICIONES (contenido, tipo, fecha_envio, usuario_id, parroquia_id) VALUES (?, ?, NOW(), ?, ?)');
    
    // Bind parameters
    $stmt->bind_param('ssii', $contenido, $tipo, $_SESSION['usuario_id'], $parroquia_id);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "1"; // Petición enviada correctamente
    } else {
        echo "0"; // Error al enviar la petición
    }
    
    // Close the statement and connection
    $stmt->close();
    $conn->close();
}else{
    echo "-1";
    exit();
}
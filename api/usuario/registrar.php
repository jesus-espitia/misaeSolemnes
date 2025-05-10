<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config/database.php';

$conn = conectarBD();

if(!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
session_start();


// Hashear contraseña
$hash = password_hash($_SESSION['password'], PASSWORD_BCRYPT);

// Insertar en BD
try {
    $stmt = $conn->prepare("INSERT INTO USUARIOS (nombre_usuario, correo_usuario, contraseña_usuario, pais_usuario) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $_SESSION['nameInput'], $_SESSION['email'], $hash, $_SESSION['countryUser']);
    $stmt->execute();

    header("Location: ../utils/alerta.php?tipo=success&titulo=¡BIEN+HECHO!&mensaje=Ya+puedes+ingresar&redirect=../../login.html");
} catch (mysqli_sql_exception $e) {
    header("Location: ../utils/alerta.php?tipo=error&titulo=¡Error,+no+se+pudo+registrar!&mensaje=Tranquilo(a),+fue+un+error+de+nuestro+servidor.+Vuelve+a+intentarlo&redirect=../../registro.html");
}

$stmt->close();
$conn->close();

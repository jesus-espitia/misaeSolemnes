<?php
function conectarBD() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "misae_solemnes";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    return $conn;
}

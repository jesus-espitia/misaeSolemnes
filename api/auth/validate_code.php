<?php

if (isset($_POST['verification_code'])) {
    session_start();
    $codigo = $_POST['verification_code'];
    if ($codigo === $_SESSION['codigo']) {
        echo "1"; // Código correcto
    } else {
        echo "0"; // Código incorrecto
    }
} else {
    echo "-1"; // No se ha enviado el código de verificación
}
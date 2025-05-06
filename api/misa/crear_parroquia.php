<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $ciudad = $_POST['ciudad'] ?? '';

    if ($nombre && $direccion && $telefono && $ciudad) {
        $stmt = $conn->prepare("INSERT INTO PARROQUIAS (nombre_parroquia, direccion_parroquia, telefono_parroquia, ciudad_parroquia) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$nombre, $direccion, $telefono, $ciudad])) {
            header("Location: ../utils/alerta.php?tipo=success&titulo=¡BIEN HECHO!&mensaje=✅+Parroquia+creada+correctamente&redirect=../misa/crear_parroquia.php");
            
        } else {
            header("Location: ../utils/alerta.php?tipo=error&titulo=¡ERROR!&mensaje=❌+Error+al+guardar+la+parroquia&redirect=../misa/crear_parroquia.php");
        }
    } else {
        header("Location: ../utils/alerta.php?tipo=info&titulo=¡ERROR!&mensaje=⚠️+Por+favor,+completa+todos+los+campos&redirect=../misa/crear_parroquia.php");
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Misae Solemnes | CREAR PARROQUIA</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/crearSacerdote.css">
    <link rel="icon" href="../../assets/icon/cruzar (1).png">
</head>
<body>
    <div id="page-loader" style="display: none;">
        <div class="spinner"></div>
    </div>
    <header>
        <h1>MISAE SOLEMNES ✝️</h1>
        <div class="menu-container">
            <a id="toggle" href="#"><span></span></a>
            <div id="menu">
                <ul>
                    <li><a href="/pos/inicio.html">INICIO</a></li>
                    <li><a href="/pos/acercaDe.html">ACERCA DE</a></li>
                    <li><a href="/pos/transmisiones.php">TRASMICIONES</a></li>
                    <li><a href="/perfil.php">PERFIL</a></li>
                    <li><a href="/pos/logout.html">CERRAR SESIÓN</a></li>
                </ul>
            </div>
        </div>
        <nav class="menu">
            <a href="/pos/inicio.html">INICIO</a>
            <a href="/pos/acercaDe.html">ACERCA DE</a>
            <a href="/pos/transmisiones.php">TRASMICIONES</a>
            <a href="/perfil.php">PERFIL</a>
            <a href="/pos/logout.html">CERRAR SESIÓN</a>
        </nav>
    </header>


<main>
    <div class="formulario">
        <h2 style="margin-bottom: 1rem;">Registrar Parroquia</h2>
        <form method="post">
            <label>Nombre de la parroquia:</label>
            <input type="text" name="nombre" >

            <label>Dirección:</label>
            <input type="text" name="direccion" >

            <label>Teléfono:</label>
            <input type="text" name="telefono" >

            <label>Ciudad o País:</label>
            <input type="text" name="ciudad" >
            <button type="submit">Guardar Parroquia</button>
                <br><br>
                <p style="margin-top:-15px;">¿Ya creaste tu parroquia? <a href="crear_sacerdote.php" style="color: #E6C16E; font-weight:bold;">Regresar</a></p>
        </form>
    </div>
</main>

<footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>
    <script src="../../js/loader.js"></script>
    <script src="../../js/menu.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Misae Solemnes | TRANSMISIONES</title>
    <link rel="stylesheet" href="css/transmisiones.css">
    <link rel="icon" href="assets/icon/cruzar (1).png">
</head>

<body>
    <header>
        <h1>MISAE SOLEMNES ✝️</h1>
        <nav>
            <a href="index.html">INICIO</a>
            <a href="login.html">LOGIN</a>
        </nav>
    </header>
    <main>
        <div id="contenedor-transmisiones">
            <?php include 'api/misa/mostrar_transmisiones.php'; ?>
        </div>
    </main>
    <footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>
</body>
</html>

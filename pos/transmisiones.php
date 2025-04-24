<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Misae Solemnes | TRANSMISIONES</title>
    <link rel="stylesheet" href="../css/transmisiones.css">
    <link rel="icon" href="../assets/icon/cruzar (1).png">
</head>

<body>
    <header>
        <h1>MISAE SOLEMNES ✝️</h1>
        <nav>
            <a href="inicio.html">INICIO</a>
            <a href="acercaDe.html">ACERCA DE</a>
            <a href="../perfil.php">PERFIL</a>
            <a href="logout.html">CERRAR SESIÓN</a>
        </nav>
    </header>
    <main>
        <div class="grid-transmisiones">
            <div id="contenedor-transmisiones">
                <?php include '../api/misa/mostrar_transmisiones.php'; ?>
            </div>
        </div>

    </main>
    <footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>
</body>
</html>

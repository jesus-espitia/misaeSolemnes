<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Misae Solemnes | TRANSMISIONES</title>
    <link rel="stylesheet" href="../css/transmisiones.css">
    <link rel="icon" href="../assets/icon/cruzar (1).png">
    <script src="../js/menu.js" defer></script>
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
                    <li><a href="inicio.html">INICIO</a></li>
                    <li><a href="acercaDe.html">ACERCA DE</a></li>
                    <li><a href="../perfil.php">PERFIL</a></li>
                    <li><a href="logout.html">CERRAR SESIÓN</a></li>
                </ul>
            </div>
        </div>
        <nav class="menu">
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
    
    <script src="../js/loader.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Misae Solemnes | TRANSMISIONES</title>
    <link rel="stylesheet" href="../css/transmisiones.css">
    <link rel="icon" href="../assets/icon/cruzar (1).png">
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
            <div class="campana" style="display: inline;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 icon-hover" style="width: 28px;">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
        <nav class="menu">
            <a href="inicio.html">INICIO</a>
            <a href="acercaDe.html">ACERCA DE</a>
            <a href="../perfil.php">PERFIL</a>
            <a href="logout.html">CERRAR SESIÓN</a>
            <div class="campana" style="display: inline;">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 icon-hover" style="width: 28px;">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                </svg>
            </div>
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
    <script src="../js/menu.js" defer></script>
    <script src="../js/loader.js"></script>
</body>
</html>

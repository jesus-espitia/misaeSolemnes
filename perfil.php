<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.html');
    exit;
}

require_once __DIR__ . '/api/config/database.php';
$conn = conectarBD();

// Obtener datos del usuario
$usuario_id = $_SESSION['usuario_id'];
$sqlUsuario = "SELECT * FROM USUARIOS WHERE id_usuario = ?";
$stmtUsuario = $conn->prepare($sqlUsuario);
$stmtUsuario->bind_param("i", $usuario_id);
$stmtUsuario->execute();
$resultUsuario = $stmtUsuario->get_result();
$usuario = $resultUsuario->fetch_assoc();

// Verificar si el usuario también es sacerdote (usando usuario_id, no el correo)
$sqlSacerdote = "SELECT * FROM SACERDOTES WHERE usuario_id = ?";
$stmtSacerdote = $conn->prepare($sqlSacerdote);
$stmtSacerdote->bind_param("i", $usuario_id);
$stmtSacerdote->execute();
$resultSacerdote = $stmtSacerdote->get_result();
$esSacerdote = $resultSacerdote->num_rows > 0;
$sacerdote = $esSacerdote ? $resultSacerdote->fetch_assoc() : null;

// Obtener parroquias para el dropdown
$sqlParroquias = "SELECT id_parroquia, nombre_parroquia FROM PARROQUIAS";
$resultParroquias = $conn->query($sqlParroquias);
$parroquias = $resultParroquias->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil - Misae Solemnes</title>
    <link rel="stylesheet" href="css/perfil.css">
    <link rel="icon" href="assets/icon/cruzar (1).png">
    <script src="js/menu.js" defer></script>
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
                <li><a href="pos/inicio.html">INICIO</a></li>
                <li><a href="pos/acercaDe.html">ACERCA DE</a></li>
                <li><a href="pos/transmisiones.php">TRANSMISIONES</a></li>
                <li><a href="/pos/logout.html">CERRAR SESIÓN</a></li>
              </ul>
            </div>
        </div>
        <nav class="menu">
            <a href="pos/inicio.html">INICIO</a>
            <a href="pos/acercaDe.html">ACERCA DE</a>
            <a href="pos/transmisiones.php">TRANSMISIONES</a>
            <a href="/pos/logout.html">CERRAR SESIÓN</a>
        </nav>
    </header>

    <main>
        <section class="form-container">
            <h2>Bienvenido, <?= htmlspecialchars($usuario['nombre_usuario']) ?></h2>
            <p><strong>Correo:</strong> <?= htmlspecialchars($usuario['correo_usuario']) ?></p>
            <p><strong>País:</strong> <?= htmlspecialchars($usuario['pais_usuario']) ?></p>
            <p><strong>Miembro desde:</strong> <?= htmlspecialchars($usuario['fechaRegistro_usuario']) ?></p>
        </section>

        <?php if ($esSacerdote): ?>
            <section class="form-container">
                <h3>Crear Nueva Misa</h3>
                <form action="api/misa/crear_misa.php" method="POST">
                    <label for="titulo">Título:</label>
                    <input type="text" name="titulo_misa" autocomplete="off">

                    <label for="fecha">Fecha:</label>
                    <input type="date" name="fecha_misa">

                    <label for="hora">Hora:</label>
                    <input type="time" name="hora_misa">

                    <label for="tipo">Tipo de Misa:</label>
                    <select name="tipo_misa">
                        <option value="dominical">Dominical</option>
                        <option value="funeral">Funeral</option>
                        <option value="boda">Boda</option>
                        <option value="otra">Otra</option>
                    </select>

                    <input type="hidden" name="sacerdote_id" value="<?= $sacerdote['id_sacerdote'] ?>">
                    <button type="submit">Crear Misa</button>
                </form>
            </section>
        <?php endif; ?>

        <?php if ($esSacerdote): ?>
        <section class="form-container">
            <h3>Crear Nueva Transmisión</h3>
            <form action="api/misa/crear_transmision.php" method="POST">
                <label for="enlace">Enlace del video (YouTube):</label>
                <input type="url" name="enlaceVideo_transmision" autocomplete="off">

                <label for="estado">Estado de la Transmisión:</label>
                <select name="estado_transmision">
                    <option value="en vivo">En Vivo</option>
                    <option value="programada">Programada</option>
                    <option value="finalizada">Finalizada</option>
                </select>

                <label for="misa_id">Misa relacionada (ID):</label>
                <input type="number" name="misa_id">

                <label for="plataforma">Plataforma:</label>
                <select name="plataforma_transmision">
                    <option value="YouTube">YouTube</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Otra">Otra</option>
                </select>

                <button type="submit">Crear Transmisión</button>
        </section>
        
        <?php endif; ?>

        <?php if ($esSacerdote): ?>
            <section class="form-container">
                <h3>Acceder a Administrador</h3>
                <center>
                <a href="./api/misa/admin_transmisiones.php" title="ADMINISTRADOR"><img style="align-items: center;" src="assets/icon/cruzar.png" width="50"></a>
                </center>
            </section>
        <?php endif; ?>
    </main>

    <footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>
    
    <script src="js/loader.js"></script>
</body>
</html>

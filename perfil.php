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

//Guaradar el estado actual de la columna "quiere_correos"
$quiere_correos = $usuario["quiere_correos"] == "si" ? true : false;

// Verificar si el usuario también es sacerdote (usando usuario_id, no el correo)
$sqlSacerdote = "SELECT * FROM SACERDOTES WHERE usuario_id = ?";
$stmtSacerdote = $conn->prepare($sqlSacerdote);
$stmtSacerdote->bind_param("i", $usuario_id);
$stmtSacerdote->execute();
$resultSacerdote = $stmtSacerdote->get_result();
$esSacerdote = $resultSacerdote->num_rows > 0;
$sacerdote = $esSacerdote ? $resultSacerdote->fetch_assoc() : null;
$_SESSION['es_sacerdote'] = $esSacerdote;


// Obtener parroquias para el dropdown
$sqlParroquias = "SELECT id_parroquia, nombre_parroquia FROM PARROQUIAS";
$resultParroquias = $conn->query($sqlParroquias);
$parroquias = $resultParroquias->fetch_all(MYSQLI_ASSOC);



// Obtener misas solo del sacerdote actual con nombre de parroquia
if ($esSacerdote) {
    $sqlMis = "SELECT id_misa, titulo_misa FROM MISAS WHERE sacerdote_id = ?";
    $stmtMis = $conn->prepare($sqlMis);
    $stmtMis->bind_param("i", $sacerdote['id_sacerdote']);
    $stmtMis->execute();
    $resultMis = $stmtMis->get_result();
    $misas = $resultMis->fetch_all(MYSQLI_ASSOC);
}


$conn->close();


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Misae Solemnes | PERFIL</title>
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
                    <li><a href="pos/logout.html">CERRAR SESIÓN</a></li>
                </ul>
            </div>
        </div>
        <nav class="menu">
            <a href="pos/inicio.html">INICIO</a>
            <a href="pos/acercaDe.html">ACERCA DE</a>
            <a href="pos/transmisiones.php">TRANSMISIONES</a>
            <a href="pos/logout.html">CERRAR SESIÓN</a>
        </nav>
    </header>

    <main>
        <section class="form-container">
            <h2>Bienvenido, <?= htmlspecialchars($usuario['nombre_usuario']) ?></h2>
            <p><strong>Correo:</strong> <?= htmlspecialchars($usuario['correo_usuario']) ?></p>
            <p><strong>País:</strong> <?= htmlspecialchars($usuario['pais_usuario']) ?></p>
            <p><strong>Miembro desde:</strong> <?= htmlspecialchars($usuario['fechaRegistro_usuario']) ?></p>
            <br>
            <form action="api/usuario/cambiarCorreo.php" method="post" id="formQuiere">
                <label style="display:inline;">
                    <?php if ($quiere_correos){ ?>
                        ¿Deseas que te enviemos correos cada que se inicie una transmisión? (activado)
                        <input type="checkbox" name="quiereCorreos" class="quiereCorreos" value="1" checked onchange="setTimeout(() => document.getElementById('formQuiere').submit(), 100);">
                    <?php } else { ?>
                        ¿Deseas que te enviemos correos cada que se inicie una transmisión? (desactivado)
                        <input type="checkbox" name="quiereCorreos" class="quiereCorreos" value="1" onchange="setTimeout(() => document.getElementById('formQuiere').submit(), 100);">
                    <?php } ?>
                </label>
            </form>
            <?php if ($esSacerdote): ?>
                <section class="form-container">
                    <h3>Administración de Transmisiones</h3>
                  
                    <a href="./api/misa/admin_transmisiones.php" title="ADMINISTRADOR"><img style="align-items: center;" src="assets/icon/cruzar.png" width="50"></a>
                    </center>
                </section>
                <section class="form-container">
                    <h3>Nuevo Sacerdote</h3>
                    <a href="api/misa/crear_sacerdote.php" style="text-decoration: none; color: black;" onmouseover="this.style.color='red'; this.style.textDecoration='underline';" onmouseout="this.style.color='black'; this.style.textDecoration='none';" ">➕ Crear Sacerdote</a>
                </section>
            <?php endif; ?>
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
                
                <label>Misa relacionada:</label>
                <select name="misa_id" class="select2" required>
                    <option value="">Seleccione una misa</option>
                    <?php foreach ($misas as $m): ?>
                        <option value="<?= $m['id_misa'] ?>">
                            <?= htmlspecialchars($m['titulo_misa']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="plataforma">Plataforma:</label>
                <select name="plataforma_transmision">
                    <option value="YouTube">YouTube</option>
                    <option value="Facebook">Facebook</option>
                    <option value="Otra">Otra</option>
                </select>

                <button type="submit">Crear Transmisión</button>
        </section>
        
        <?php endif; ?>


    </main>

    <footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>
    <script src="js/loader.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Activar Select2 -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('.select2').select2();
        });
    </script>

</body>
</html>

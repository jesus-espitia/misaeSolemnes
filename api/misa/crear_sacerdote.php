<?php
session_start();
require_once __DIR__ . '/../config/database.php';
$conn = conectarBD();

// Cargar la clave secreta desde archivo
$clave_correcta = require 'clave_secreta.php';

// Verificar si el usuario es sacerdote
$esSacerdote = $_SESSION['es_sacerdote'] ?? false;
if (!$esSacerdote) {
    echo "Acceso denegado.";
    exit;
}

// Verificar si ya se autenticó con clave
$claveValida = $_SESSION['acceso_crear_sacerdote'] ?? false;
$mensaje = '';

// Cargar parroquias y usuarios
$parroquias = $conn->query("SELECT id_parroquia, nombre_parroquia FROM PARROQUIAS")->fetch_all(MYSQLI_ASSOC);
$usuarios = $conn->query("SELECT id_usuario, nombre_usuario, correo_usuario FROM USUARIOS")->fetch_all(MYSQLI_ASSOC);

// POST: verificar clave o guardar sacerdote
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['clave'])) {
        if ($_POST['clave'] === $clave_correcta) {
            $_SESSION['acceso_crear_sacerdote'] = true;
            $claveValida = true;
        } else {
            $mensaje = "⚠️ Clave incorrecta.";
        }
    } elseif ($claveValida && isset($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $parroquia = $_POST['parroquia_id'];
        $usuario_id = !empty($_POST['usuario_id']) ? $_POST['usuario_id'] : null;

        $sql = "INSERT INTO SACERDOTES (nombre_sacerdote, correoElectronico_sacerdote, telefono_sacerdote, parroquia_id, usuario_id)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $nombre, $correo, $telefono, $parroquia, $usuario_id);

        if ($stmt->execute()) {
            $mensaje = "✅ Sacerdote creado correctamente.";
            $_SESSION['acceso_crear_sacerdote'] = false;
        } else {
            $mensaje = "❌ Error al guardar: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Misae Solemnes | CREAR SACERDOTES</title>
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
            <h2 style="margin-bottom: 1rem;">Registrar Sacerdote</h2>
            <?php if ($mensaje): ?>
                <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
            <?php endif; ?>

            <?php if (!$claveValida): ?>
                <form method="post">
                    <label>Contraseña:</label>
                    <input type="password" name="clave" required placeholder="Inserte clave de administrador">
                    <button type="submit">Verificar</button>
                </form>
            <?php else: ?>
                <form method="post">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" required>

                    <label>Correo electrónico:</label>
                    <input type="email" name="correo" required>

                    <label>Teléfono:</label>
                    <input type="text" name="telefono" required>

                    <label>Parroquia:</label>
                    <select name="parroquia_id" class="select2" required>
                        <option value="">Seleccione una parroquia</option>
                        <?php foreach ($parroquias as $p): ?>
                            <option value="<?= $p['id_parroquia'] ?>"><?= htmlspecialchars($p['nombre_parroquia']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label>Usuario (opcional):</label>
                    <select name="usuario_id" class="select2">
                        <option value="">Sin asignar</option>
                        <?php foreach ($usuarios as $u): ?>
                            <option value="<?= $u['id_usuario'] ?>">
                                <?= htmlspecialchars($u['nombre_usuario']) ?> (<?= htmlspecialchars($u['correo_usuario']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <br><br>
                    <button type="submit">Guardar Sacerdote</button>
                </form>
                <br>
                <p style="margin-top:-15px;">¿No encuentras la parroquia? <a href="crear_parroquia.php" style="color: #E6C16E; font-weight:bold;">Crear nueva</a></p>
            <?php endif; ?>

            
        </div>
        
    </main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Buscar...",
            allowClear: true
        });
    });
</script>
    <footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>
    <script src="../../js/loader.js"></script>
    <script src="../../js/menu.js"></script>
</body>
</html>

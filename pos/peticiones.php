<?php session_start(); 
include '../api/config/database.php';
$conn = conectarBD();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../index.html');
    exit();
}
$result = $conn->query("SELECT id_parroquia, nombre_parroquia FROM PARROQUIAS");
$parroquias = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Misae Solemnes | HOME</title>
    <link rel="stylesheet" href="../css/peticiones.css">
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
                    <li><a href="transmisiones.php">TRASMICIONES</a></li>
                    <li><a href="../perfil.php">PERFIL</a></li>
                    <li><a href="logout.html">CERRAR SESIÓN</a></li>
                </ul>
            </div>
            <div class="campana" onclick="togglePopup()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 icon-hover" style="width: 28px;">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                </svg>

            </div>
        </div>
        <nav class="menu">
            <a href="inicio.html">INICIO</a>
            <a href="acercaDe.html">ACERCA DE</a>
            <a href="transmisiones.php">TRASMICIONES</a>
            <a href="../perfil.php">PERFIL</a>
            <a href="logout.html">CERRAR SESIÓN</a>
            <div class="campana" style="display: inline;" onclick="togglePopup()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 icon-hover" style="width: 28px;">
                    <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0 1 13.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 0 1-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 1 1-7.48 0 24.585 24.585 0 0 1-4.831-1.244.75.75 0 0 1-.298-1.205A8.217 8.217 0 0 0 5.25 9.75V9Zm4.502 8.9a2.25 2.25 0 1 0 4.496 0 25.057 25.057 0 0 1-4.496 0Z" clip-rule="evenodd" />
                </svg>
                <div id="notificaciones-popup">
                    <div class="contenido-notificaciones">
                        <div>🔔 Notificación 1</div>
                        <div>🔔 Notificación 2</div>
                        <div>🔔 Notificación 3</div>
                        <div>🔔 Notificación 1</div>
                        <div>🔔 Notificación 2</div>
                        <div>🔔 Notificación 3</div>
                        <div>🔔 Notificación 1</div>
                        <div>🔔 Notificación 2</div>
                        <div>🔔 Notificación 3</div>
                        <div>🔔 Notificación 1</div>
                        <div>🔔 Notificación 2</div>
                        <div>🔔 Notificación 3</div>
                        <!-- ... más notificaciones -->
                    </div>
                </div>

            </div>
        </nav>
    </header>

    <main>
        <aside>
            <div id="div-aside">
                <h1 class="titulos">secciones</h1>
                <ul>
                    <li class="aside-elements"><a href="#peticiones" class="aside-links">Ir a tus peticiones</a></li>
                    <li class="aside-elements"><a href="#enviar-peticion" class="aside-links">Formulario para enviar una petición</a></li>
                </ul>
            </div>
        </aside>
        <section id="sec-peticiones">
            <div id="contenedor-peticiones">
                <div id="peticiones">
                    <h1 class="titulos">Tus peticiones</h1>
                    <div class="lista-peticones"><?php include '../api/usuario/traerPeticiones.php'; ?></div>
                </div>
                <div id="enviar-peticion">
                    <h1 class="titulos">Envia una petición</h1>
                    <form class="form-peticion" action="procesar_peticion.php" method="POST">
                        <input type="hidden" name="user_email" value="rsany13x0@gmail.com">
        
                        <div class="form-group">
                            <label>Tu petición:</label>
                            <textarea id="peticion"name="contenido" required></textarea>
                            <p><small>máximo 300 caracteres</small></p>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label>Tipo de petición:</label>
                            <div class="radio-group">
                                <label><input type="radio" name="tipo" value="pública" checked> Pública (visible para otros)</label>
                                <label><input type="radio" name="tipo" value="privada"> Privada (solo visible para ti)</label>
                            </div>
                        </div>
                        <br><br>
                        <div class="form-group">
                            <label>A que parroquias deseas enviar la peticion:</label>
                            <select name="parroquia_id" id="parroquia_id" required>
                                <option value="0">Selecciona una parroquia</option>
                                <?php foreach ($parroquias as $p): ?>
                                    <option style="font-weight: bold;" value="<?= $p['id_parroquia'] ?>">
                                        <?= htmlspecialchars($p['nombre_parroquia']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                        <br><br>
                        <div class="form-actions">
                            <label class="action-btn">
                                <input type="reset">
                            </label>
                            <label class="action-btn">
                                <input type="submit" id="btn-enviar" value="enviar">
                            </label>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>

        <footer>
        © 2025 MISAE SOLEMNES - Todos los derechos reservados.
    </footer>

    <script>
        textarea = document.querySelector("#peticion");
        textarea.addEventListener('input', autoResize, false);

        function autoResize() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        }
    </script>
    <script src="../js/form_peticiones.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
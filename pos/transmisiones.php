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
        </div>
        <nav class="menu">
            <a href="inicio.html">INICIO</a>
            <a href="acercaDe.html">ACERCA DE</a>
            <a href="../perfil.php">PERFIL</a>
            <a href="logout.html">CERRAR SESIÓN</a>
        </nav>
    </header>
    <main>
        <div class="filtros-transmisiones">
            <select id="filtro-estado" class="selector-filtro">
                <option value="en vivo">En vivo</option>
                <option value="programada">Programadas</option>
                <option value="finalizada">Finalizadas</option>
            </select>
        </div>
        
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filtroEstado = document.getElementById('filtro-estado');
            const contenedorTransmisiones = document.getElementById('contenedor-transmisiones');
            
            // Manejar cambio de filtro
            filtroEstado.addEventListener('change', function() {
                const estado = this.value;
                
                // Mostrar loader
                document.getElementById('page-loader').style.display = 'flex';
                
                // Hacer petición AJAX para actualizar las transmisiones
                fetch(`../api/misa/mostrar_transmisiones.php?estado=${estado}`)
                    .then(response => response.text())
                    .then(html => {
                        contenedorTransmisiones.innerHTML = html;
                        document.getElementById('page-loader').style.display = 'none';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('page-loader').style.display = 'none';
                    });
            });
        });
    </script>
</body>
</html>

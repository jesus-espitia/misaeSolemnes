<!-- public/alerta.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alerta</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<script>
    // Datos pasados desde PHP por la URL
    const tipo = "<?php echo $_GET['tipo'] ?? 'info'; ?>";
    const titulo = "<?php echo $_GET['titulo'] ?? 'Alerta'; ?>";
    const mensaje = "<?php echo $_GET['mensaje'] ?? ''; ?>";
    const redirect = "<?php echo $_GET['redirect'] ?? 'registro.html'; ?>";

    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensaje,
        confirmButtonText: 'Aceptar'
    }).then(() => {
        window.location.href = redirect;
    });
</script>

</body>
</html>

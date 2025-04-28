<?php
$autoloadPath = realpath(__DIR__ . '/../../verificar/vendor/autoload.php');
if ($autoloadPath && file_exists($autoloadPath)) {
    require_once $autoloadPath;
    echo "Autoload cargado correctamente desde: $autoloadPath";
} else {
    die("Error: Ruta no válida.");
}
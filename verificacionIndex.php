<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db/connect.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Missae solemnes</title>
    <link rel="stylesheet" href="/php/verificar2/missae_solemnes/assets/css/style.css">
    <style>
        /*invalid/valid field form*/
        .is_valid {
            border: 2px solid #19e31c;
            background-color: #f0f4fc;
        }
        .is_invalid {
            border: 2px solid #e31919;
            background-color:rgb(243, 132, 132);
        }
    </style>
</head>
<body>
    <h1>Formulario de Registro</h1>
    <form action="" method="">

        <label for="username">Usuario:</label>
        <input type="text" id="username" name="username" required>
        <div class="popup" onclick="togglePopup('myPopup')">Formato
            <span class="popuptext" id="myPopup">De 5 a 18 caracteres. Minimo tres letras; mayuscula, numeros y especiales (- _ * + ! $ # ? ¡ ¿ @ %) son opcionales</span>
        </div>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <div class="popup" onclick="togglePopup('myPopup2')">Formato
            <span class="popuptext" id="myPopup2">Formato tipico de email</span>
        </div>
        <br><br>

        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <div class="popup" onclick="togglePopup('myPopup3')">Formato
            <span class="popuptext" id="myPopup3">De 8 a 30 caracteres. Minimo una mayuscula, minimo un numero y minimo un especiales (- _ * + ! $ # ? ¡ ¿ @ %).</span>
        </div>
        <br><br>

        <label for="passwordConfirm">Confirma tu contraseña: </label>
        <input type="password" id="passwordConfirm" name="password2" required>
        <div class="popup" onclick="togglePopup('myPopup4')">Formato
            <span class="popuptext" id="myPopup4">Igual a la contraseña anterior.</span>
        </div>
        <br><br>
        <button id="btnSubmit" type="submit">Enviar</button>
    </form>
    <br><br>
    <p>Sr1020114133*</p>

    <script>
        // When the user clicks on div, open the popup

        function togglePopup(id) {
            var popup = document.getElementById(id);
            let popupWindow;
            popup.classList.toggle("show");
            if (popup.classList.contains("show")) {
                popupWindow = setTimeout(function() {
                    popup.classList.remove("show");
                }, 2500);
            } else {
                clearTimeout(popupWindow);
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/php/verificar2/missae_solemnes/assets/js/validate_form.js" defer></script>

</body>
</html>
const nameInput = document.getElementById("nameInput");
const email = document.getElementById("email");
const password = document.getElementById("password");
const passwordConfirm = document.getElementById("passwordConfirm");
const country = document.getElementById("countryUser");
const btnSubmit = document.getElementById("btnSubmit");

function callbackRegex(regex, input) {
    if (regex.test(input.value)) {
        input.classList.remove("is_invalid");
        input.classList.add("is_valid");
        return true;
    } else {
        input.classList.remove("is_valid");
        input.classList.add("is_invalid");
        return false;
    }
}

regexnameInput = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ'-]{1,20}\s([a-zA-ZáéíóúÁÉÍÓÚüÜñÑ'-]{1,20})?\s?[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ'-]{1,20}\s?([a-zA-ZáéíóúÁÉÍÓÚüÜñÑ'-]{1,20})?$/;
regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
regexPassword = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[-_*+!$#?¡¿@%]).{8,30}$/;
regexCountry = /^[A-Za-záéíóúñÁÉÍÓÚÑüÜ\s'-]+$/

btnSubmit.addEventListener("click", (e) => {
    e.preventDefault();

    let validnameInput = callbackRegex(regexnameInput, nameInput);
    let validEmail = callbackRegex(regexEmail, email);   
    let validPassword = callbackRegex(regexPassword, password);
    let validCountry = callbackRegex(regexCountry, country);
    let validConfirmPassword = false;

    if (password.value !== passwordConfirm.value || passwordConfirm.value === "") {
        passwordConfirm.classList.remove("is_valid");
        passwordConfirm.classList.add("is_invalid");
    } else {
        passwordConfirm.classList.remove("is_invalid");
        passwordConfirm.classList.add("is_valid");
        validConfirmPassword = true;
    }
    if (validnameInput && validEmail && validPassword && validCountry && validConfirmPassword) {
        let data = new FormData();
        data.append("nameInput", nameInput.value);
        data.append("email", email.value);
        data.append("password", password.value);
        data.append("countryUser", country.value);
        const options = {
            method: "POST",
            body: data
        };

        fetch("./api/auth/validate_email.php", options)
        .then((response) => response.text())
        .then((response) => {
            console.log(response);
            switch (response){
                case "-1":
                    Swal.fire({
                        icon: "error",
                        title: "Error interno. Disculpe",
                        text: "Por alguna razon no se pudo verificar el correo electronico. Vuelva a intentarlo."
                    });
                    break;
                case "0":
                    Swal.fire({
                        icon: "error",
                        title: "Error, el correo no es real",
                        text: "El correo electronico que ingresaste no es real. Verificalo y vuelve a intentarlo."
                    });
                    break;
                case "1":
                    window.location.href = "verify_email.php";
                    break;
                case "2":
                    Swal.fire({
                        icon: "info",
                        title: "No se pudo ingresar el usuario",
                        text: "El correo electrónico que ingresaso ya esta en uso. Prueba con otro y vuelve a intentarlo",
                    });
                    break;
            }
        })
        .catch(() => {
            Swal.fire({
                icon: "error",
                title: "Ha ocurrido un error interno",
                text: "No te preocupes no es culpa tuya. Vuelve a intentarlo.",
            });
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "Por favor rellene el formulario correctamente...",
            text: "Verifique el formato de los campos y vuelva a intentarlo.",
            });
    }

});
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
    console.log("Estoy funcionando");
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
            try{
                if (response !== "-1") {
                    console.log(response.is_real);
                    if (response === "1") {
                        window.location.href = "verify_email.php";
                    } else {
                        console.log("El correo electrónico no es real");
                        Swal.fire({
                            icon: "error",
                            title: "Email no existente",
                            text: "El correo electrónico que ingresaste no es real",
                        });
                    }
                }else{
                    throw new Error("Por alguna razón no se pudo verificar el correo electrónico. Vuelva a intentarlo");
                }
            } catch (error) {
                console.error("Error:", error);
                
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
    } else {
        Swal.fire({
            icon: "error",
            title: "Please fill the form correctly...",
            text: "Check the format of the fields and try again.",
          });
    }

});
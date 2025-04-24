const username = document.getElementById("username");
const email = document.getElementById("email");
const password = document.getElementById("password");
const passwordConfirm = document.getElementById("passwordConfirm");
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

regexUsername = /^(?=.*?[a-zA-Z]{3})[a-zA-Z0-9!@#$%*_+?¡¿\-]{8,21}$/;
regexEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
regexPassword = /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[-_*+!$#?¡¿@%]).{8,30}$/;

btnSubmit.addEventListener("click", (e) => {
    e.preventDefault();

    let validUsername = callbackRegex(regexUsername, username);
    let validEmail = callbackRegex(regexEmail, email);   
    let validPassword = callbackRegex(regexPassword, password);
    let validConfirmPassword = false;

    if (password.value !== passwordConfirm.value || passwordConfirm.value === "") {
        passwordConfirm.classList.remove("is_valid");
        passwordConfirm.classList.add("is_invalid");
    } else {
        passwordConfirm.classList.remove("is_invalid");
        passwordConfirm.classList.add("is_valid");
        validConfirmPassword = true;
    }
    if (validUsername && validEmail && validPassword && validConfirmPassword) {
        let data = new FormData();
        data.append("email", email.value);
        const options = {
            method: "POST",
            body: data
        };

        fetch("/php/verificar2/missae_solemnes/includes/auth/validate_email.php", options)
        .then((response) => response.text())
        .then((response) => {
            try{
                if (response !== "-1") {
                    console.log(response.is_real);
                    if (response === "1") {
                        window.location.href = "/php/verificar2/missae_solemnes/public/verify_email.php?email=" + email.value + "&username=" + username.value;
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

        /*fetch("/php/verificar2/missae_solemnes/includes/auth/get_user_into_db", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                username: username.value,
                email: email.value,
                password: password.value,
            }),
        }) */
    } else {
        Swal.fire({
            icon: "error",
            title: "Please fill the form correctly...",
            text: "Check the format of the fields and try again.",
          });
    }

});
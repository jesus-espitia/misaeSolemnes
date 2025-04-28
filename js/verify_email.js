const btnSubmit = document.getElementById('btnSubmit');
const verificationCode = document.getElementById('verification_code');

btnSubmit.addEventListener('click', function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    if(verificationCode.value.length !== 6){
        Swal.fire({
            icon: 'error',
            title: 'Errorrrr',
            text: 'El código de verificación no puede estar vacío ni ser diferente de seis digitos.',
        });
    }else{
        let code = new FormData();
        code.append('verification_code', verificationCode.value);
        console.log(code.get('verification_code'));
        const options = {
            method: 'POST',
            body: code
        };
        fetch("./api/auth/validate_code.php", options) 
        .then(response => response.text())
        .then((response) => {
            try{
                if (response !== "-1") {
                    console.log(response.is_real);
                    if (response === "1") {
                        console.log("El código de verificación es correcto");
                        window.location.replace("./api/usuario/registrar.php");
                    } else {
                    Swal.fire({
                        icon: "error",
                        title: "Código incorrectoooa",
                        text: "El código de verificación que ingresó es incorrectoooo",
                    });
                    }
                }else {
                    throw new Error("Por alguna razón no se pudo verificar el código de verificación. Vuelva a intentarlo");
                }
            }catch (error) {
                console.error("Error:", error);                
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
});
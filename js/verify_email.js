const btnSubmit = document.getElementById('btnSubmit');
const verificationCode = document.getElementById('verification_code');

btnSubmit.addEventListener('click', function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    
    if(verificationCode.value.length !== 6){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El código de verificación no puede estar vacío ni ser diferente de seis digitos.',
        });
    }else{
        let data = new FormData();
        data.append('verification_code', verificationCode.value);
        const options = {
            method: 'POST',
            body: data
        };
        fetch("/php/verificar2/missae_solemnes/includes/auth/validate_code.php", options) 
        .then(response => response.text())
        .then((response) => {
            try{
                if (response !== "-1") {
                    console.log(response.is_real);
                    if (response === "1") {
                    Swal.fire({
                        icon: "success",
                        title:"Código correcto",
                        text: "El código de verificación que ingresó es correcto",
                    });
                    } else {
                    Swal.fire({
                        icon: "error",
                        title: "Código incorrecto",
                        text: "El código de verificación que ingresó es incorrecto",
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
const button = document.getElementById("btn-enviar");
const textArea = document.getElementById("peticion");
const parroquia = document.getElementById("parroquia_id");
const radioButton = document.querySelector('input[name="tipo"]:checked');

function sanitizarTexto(texto){
    return texto.replace(/[^a-zA-Z0-9 áéíóúÁÉÍÓÚñÑ,.;:¡!¿?()@\-_=+]/g, '');
}

button.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent the default form submission
    const peticion = textArea.value;
    const sanitizaPeticion = sanitizarTexto(peticion);
    textArea.value = sanitizaPeticion; // Update the textarea with the sanitized value
    const parroquiaId = parroquia.value;
    const tipo = radioButton.value;

    if (parroquiaId === "0") {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Debes seleccionar una parroquia.",
        });
        return;
    }
    if (sanitizaPeticion === "" || peticion.length < 10 || peticion.length > 300) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "La petición debe tener entre 10 y 300 caracteres.",
        });
        return;
    }
    if (tipo === undefined) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Debes seleccionar un tipo de petición.",
        });
        return;
    }

    let formData = new FormData();
    formData.append("peticion", sanitizaPeticion);
    formData.append("parroquia_id", parroquiaId);
    formData.append("tipo", tipo);
    const options = {
        method: "POST",
        body: formData,
    };
    fetch("../api/usuario/peticionDB.php", options)
    .then((response) => response.text())
    .then((response)=>{
        if(response === "-1"){
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Por alguna razón no se pudo enviar la petición. Vuelva a intentarlo",
            });
            return;
        }
        if (response === "1") {
            Swal.fire({
                icon: "success",
                title: "Éxito",
                text: "La petición se ha enviado correctamente.",
            });
            textArea.value = "";
            parroquia.value = "0";
            radioButton.checked = false;
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "Por alguna razón no se pudo enviar la petición al servidor. Vuelva a intentarlo",
            });
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No te preocupes, el error no es tuyo. Por favor, vuelve a intentarlo más tarde.",
        });
    });
});
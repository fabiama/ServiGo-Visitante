const form   = document.getElementById("formulario");
const nombre = document.getElementById("nombre");
const email  = document.getElementById("email");
const pass   = document.getElementById("password");
const tipo   = document.getElementById("tipo");

document.addEventListener("DOMContentLoaded", function() {
    nombre.addEventListener("input", validar);
    email.addEventListener("input", validar);
    pass.addEventListener("input", validar);
    tipo.addEventListener("change", validar);

    form.addEventListener("submit", e => {
        e.preventDefault();
        if (validar()) {
            console.log("Formulario listo para enviar");
            registrar();

        }
    });
});

function validar() {
    const divNombre = document.getElementById("DivNombre");
    const divEmail  = document.getElementById("DivEmail");
    const divPass   = document.getElementById("Divpass");
     const divTipo   = document.getElementById("DivTipo");

    const vNom = nombre.value.trim();
    const vEml = email.value.trim();
    const vPas = pass.value.trim();
     const vTipo = tipo.value.trim();

    let ok = true; 

    if (vNom === "") {
        MostrarError(nombre, divNombre, "El nombre no debe estar vacío");
        ok = false;
    } else if (vNom.length < 4) {
        MostrarError(nombre, divNombre, "Mínimo 4 caracteres");
        ok = false;
    } else if (!/^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{4,40}$/.test(vNom)) {
        MostrarError(nombre, divNombre, "Solo letras y espacios");
        ok = false;
    } else {
        OcultarError(nombre, divNombre);
    }

    if (vEml === "") {
        MostrarError(email, divEmail, "El email no debe estar vacío");
        ok = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(vEml)) {
        MostrarError(email, divEmail, "Email no válido");
        ok = false;
    } else {
        OcultarError(email, divEmail);
    }

    const regexPass = /^(?=.*[°|!"#$%&/()=?'¡¿´¨+{}\[\]_\-:.,;><]).{6,}$/;
    if (vPas === "") {
        MostrarError(pass, divPass, "Debe ingresar una contraseña");
        ok = false;
    } else if (!regexPass.test(vPas)) {
        MostrarError(pass, divPass, "Mínimo 6 caracteres y al menos un símbolo");
        ok = false;
    } else {
        OcultarError(pass, divPass);
    }

        if (vTipo === "") {
        MostrarError(tipo, divTipo, "Selecciona un tipo de usuario");
        ok = false;
    } else {
        OcultarError(tipo, divTipo, "Seleccione un rol.");
    }

    return ok;
}

function MostrarError(input, div, msg) {
    input.classList.add("is-invalid");
    div.textContent   = msg;
}
function OcultarError(input, div) {
    input.classList.remove("is-invalid");
    div.textContent   = "";
}

async function registrar(){

     let url = "/ServiGo-Visitante/backend/api/usuarios/visitante/regis.php";

        const params = new URLSearchParams({
            nombre: nombre.value,
            email: email.value,                
            pass: pass.value,
            tipo: tipo.value,
        });

        const respuesta = await fetch(url, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: params,
        });

        //const data = await respuesta.json();
          const texto = await respuesta.text();
        console.log("RAW response:", texto); 
          const data = JSON.parse(texto);

        if (respuesta.ok && data.status !== "error") {
            console.log("respuesta del servidor", data);
            await Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Contraseña cambiada",
            showConfirmButton: false,
            timer: 1500,
            });
            window.location.href = "/ServiGo-Visitante/views/login.php";
        } else {
            Swal.fire({
            icon: "error",
            title: "Oops...",
            text: data.message, // <- aquí aparece tu error de PHP
            });
        }

}
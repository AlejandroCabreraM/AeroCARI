let nombreR = document.getElementById('userR');
let passR = document.getElementById('passR');
let formR = document.getElementById('formR');
let parrafo = document.getElementById('warnings');

function enviarRegistro() {
    console.log('Enviando formulario');

    var entrar = false;
    var warnings = [];

    let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    parrafo.innerHTML = "";
    
    if (nombreR.value.trim() === '') {
        warnings.push('El campo de email no puede estar vacío <br>');
        entrar = true;
    } else if (!regexEmail.test(nombreR.value)) {
        warnings.push('El email no es válido <br>');
        entrar = true;
    }

    if (passR.value.trim() === '') {
        warnings.push('El campo de contraseña no puede estar vacío <br>');
        entrar = true;
    }else if (passR.value.length < 8) {
        warnings.push('La contraseña no es válida, <br> deben ser 8 caracteres mínimo <br>');
        entrar = true;
    }
    
    if (entrar) {
        parrafo.innerHTML = warnings.join(''); // Convierte el array de mensajes a una cadena
        return false; // Detiene el envío del formulario
    }

    // Resto de la lógica para enviar el formulario si todo está bien
    console.log('Formulario válido, enviando...');

    return true; // Continúa con el envío del formulario
}


let email = document.getElementById('email');
let name1 = document.getElementById('name1');
let apP = document.getElementById('apP');
let apM = document.getElementById('apM');
let tele = document.getElementById('tel');

let formA = document.getElementById('formA');
let label = document.getElementById('warnings');

function enviarFormAvion() {
    console.log('Enviando formulario');

    var entrar = false;
    var warnings = [];

    let regexEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    parrafo.innerHTML = "";
    
    if (email.value.trim() === '') {
        warnings.push('El campo de email no puede estar vacío <br>');
        entrar = true;
    } else if (!regexEmail.test(email.value)) {
        warnings.push('El email no es válido <br>');
        entrar = true;
    }

    if (name1.value.trim() === '') {
        warnings.push('El campo nombre esta vacío <br>');
        entrar = true;
    }

    if (apP.value.trim() === '') {
        warnings.push('El campo apellidoP esta vacío <br>');
        entrar = true;
    }

    if (apM.value.trim() === '') {
        warnings.push('El campo apellidoM esta vacío  <br>');
        entrar = true;
    }

    if (tele.value.trim() === '') {
        warnings.push('El campo de telefono esta vacío <br>');
        entrar = true;
    }
    
    if (entrar) {
        parrafo.innerHTML = warnings.join(''); // Convierte el array de mensajes a una cadena
        return false; // Detiene el envío del formulario
    }

    // Resto de la lógica para enviar el formulario si todo está bien
    console.log('Formulario válido, enviando...');

    return true; // Continúa con el envío del formulario
}

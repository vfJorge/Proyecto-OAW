const listadoCRUD_RSS = document.getElementsByClassName("listaRSS");
let globalVal = '';
window.onload = verCrudRSS();

const btnEliminar = document.getElementById('btnEliminar');

btnEliminar.addEventListener("click", eliminarURL);
function peticion(data){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
        globalVal = this.responseText;
        }
    };
    xhttp.open("GET", data, false);
    xhttp.send();
}

function agregarURL(){
    let url = document.getElementById('agregarURL').value;
    peticion("agregarRSS.php?q="+url);
}

function eliminarURL(){
    let url = document.getElementById('btnEliminar').getAttribute("text");
    peticion("eliminarRSS.php?q="+url);
}

function mostrarNoticias(){
    
}

function verCrudRSS(){
    peticion("verCrudRSS.php");
    let mensaje = globalVal;
    if (mensaje) {
        mensaje = JSON.parse(globalVal);
        console.log(mensaje.enlace);
        listadoCRUD_RSS[0].innerHTML = mensaje.enlace;
    } else {
        console.log("Sin noticias");
  }
}
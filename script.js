const listadoCRUD_RSS = document.getElementsByClassName("listaRSS");
const listadoNoticias = document.getElementById("listadoNoticias");
const siteName = document.getElementById("titulo");

let globalVal = '';
var ultimaNoticiaVista;
window.onload = verCrudRSS();

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

function noticiasIniciales(){
    if(btnEnlace.length != 0){
        peticion("mostrarNoticias.php?q=" + btnEnlace[0].textContent);
        let content = JSON.parse(globalVal);
        siteName.innerHTML = btnEnlace[0].textContent;
        listadoNoticias.innerHTML = content.noticias;
        ultimaNoticiaVista =  btnEnlace[0].textContent;
      }else{
        listadoNoticias.innerHTML = "<h1>Nada nuevo...<h1>";
      }
}

function actualizarNoticias(){
    peticion("actualizarRSS.php?q="+siteName.textContent);
    peticion("mostrarNoticias.php?q=" + siteName.textContent);
    let content = JSON.parse(globalVal);
    listadoNoticias.innerHTML = content.noticias;
    ultimaNoticiaVista =  siteName.textContent;
}

function agregarURL(){
    let url = document.getElementById('agregarURL').value;
    peticion("agregarRSS.php?q="+url);
}

function agregarEventoEliminar(){  
    const btnEliminar = document.getElementsByClassName("btnEliminar");
    for(let i=0; i<btnEliminar.length; i++){
      btnEliminar[i].addEventListener("click", eliminarURL);
    }
}

function agregarEventoMostrar() {
    const btnEnlace = document.getElementsByClassName("btnEnlace");
    for (let i = 0; i < btnEnlace.length; i++) {
      btnEnlace[i].addEventListener("click", mostrarNoticias);
    }
}

function eliminarURL(){
    let nombreEnlace = this.parentNode.childNodes;
    peticion("eliminarRSS.php?q=" + nombreEnlace[1].textContent);
}


function mostrarNoticias(){
    peticion("mostrarNoticias.php?q=" + this.textContent);
    let content = JSON.parse(globalVal);
    siteName.innerHTML = this.textContent;
    listadoNoticias.innerHTML = content.noticias;
    ultimaNoticiaVista =  this.textContent;
}

function verCrudRSS(){
    peticion("verCrudRSS.php");
    let mensaje = globalVal;
    if (mensaje) {
        mensaje = JSON.parse(globalVal);
        listadoCRUD_RSS[0].innerHTML = mensaje.enlace;
        agregarEventoMostrar();
        agregarEventoEliminar();
        noticiasIniciales();
    } else {
        console.log("Sin noticias");
  }
}
const listadoCRUD_RSS = document.getElementsByClassName("listaRSS");
const listadoNoticias = document.getElementById("listadoNoticias");
const siteName = document.getElementById("actualizar");

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
    const btnEnlace = document.getElementsByClassName("btnEnlace");
    if(btnEnlace.length != 0){
        
        peticion("mostrarNoticias.php" );
        let content = JSON.parse(globalVal);
        siteName.innerHTML = "Actualizar noticias";
        listadoNoticias.innerHTML = content.noticias;
    }else{
        listadoNoticias.innerHTML = "<h1>Nada nuevo...<h1>";
    }
}

function actualizarNoticias(){
    peticion("actualizarRSS.php?q="+siteName.textContent);
    peticion("mostrarNoticias.php");
    let content = JSON.parse(globalVal);
    listadoNoticias.innerHTML = content.noticias;
}

function addURL(){
    let url = document.getElementById('agregarURL').value;
    peticion("agregarRSS.php?q="+url);
    location.reload();
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
    peticion("eliminarRSS.php?q=" + nombreEnlace[3].textContent);
    location.reload();
}


function mostrarNoticias(){
    peticion("mostrarNoticias.php");
    let content = JSON.parse(globalVal);
    siteName.innerHTML = "Resultados";
    listadoNoticias.innerHTML = content.noticias;
}

function buscar(){
    let cadenaBusqueda = document.getElementById("buscador").value;
    peticion("mostrarNoticias.php?p="+cadenaBusqueda);
    let content = globalVal;
    if(content != null){
        content = JSON.parse(globalVal);
        siteName.innerHTML = "Resultados";
        listadoNoticias.innerHTML = content.noticias;
        
    }else{
        alert("No existe ninguna noticia que coincida");
    }
}

function ordenar(){
    let selectOpc = document.getElementById("agruparPor");
    let tipoOrdenamiento = selectOpc.value;
    peticion("mostrarNoticias.php?q=" + tipoOrdenamiento);
    let content = JSON.parse(globalVal);
    listadoNoticias.innerHTML = content.noticias;
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

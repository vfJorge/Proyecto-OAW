const listadoCRUD_RSS = document.getElementsByClassName("listaRSS");
let globalVal = '';
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

function eliminarURL(){
    let nombreEnlace = this.parentNode.childNodes;
    peticion("eliminarRSS.php?q=" + nombreEnlace[1].textContent);
}


function mostrarNoticias(){
    
}

function verCrudRSS(){
    peticion("verCrudRSS.php");
    let mensaje = globalVal;
    if (mensaje) {
        mensaje = JSON.parse(globalVal);
        listadoCRUD_RSS[0].innerHTML = mensaje.enlace;
        agregarEventoEliminar();
    } else {
        console.log("Sin noticias");
  }
}
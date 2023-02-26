let globalVal = '';

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
    let url = document.getElementById('agregarURL');
    peticion("agregarRSS?q="+url);
}

function mostrarNoticias(){
    makeRequest("mostrarRSS.php?q=mostrar");
    let content = global;
    if (content) {
        content = JSON.parse(global);
        lista_url[0].innerHTML = content.enlace;
        asignarEventoBoton();
    } else {
        console.log("Sin noticias");
  }
}
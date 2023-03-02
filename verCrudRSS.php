<?php
require("dbconfig.php");

//  Obtener enlaces desde la base de datos y mostrarlos
$sql = "SELECT name,id FROM rssfeed";
$result = mysqli_query($connection, $sql);

if ($result) { // Agrega una verificación de $result
    $enlace = "";
    while ($row = $result->fetch_array()) {
      $enlace .= mostrarEnlaces($row['name'],$row['id']);
    }

    $arr = ["enlace" => $enlace];
} else {
    $arr = ["error" => "No se pudo obtener los enlaces"];
}

mysqli_close($connection);
echo json_encode($arr);

function mostrarEnlaces($nombre,$id) {
    $enlace = <<<_END
    <article class="enlaces ">
        <input type="radio" class="btn btn-check" name="btnradio" id="btnEnlace$id" autocomplete="off">
        <label class="btnEnlace btn btn-outline-dark btn-lg" type="button" for="btnEnlace$id">$nombre</label>
            <svg xmlns="http://www.w3.org/2000/svg"  class="btnEliminar  btn-outline-danger" width="20" height="20" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3
            .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/> <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1
            0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/> </svg>
    </article>
    _END;
    return $enlace;
}
?> 
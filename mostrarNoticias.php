<?php

require("dbconfig.php");

$siteName = $_GET['q'];

$sql = "SELECT * FROM rssfeed where name = '".$siteName."'";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($result);
$id_url = $row['id'];

$sql = "SELECT * FROM noticias WHERE id= '".$id_url."'";
$result = mysqli_query($connection, $sql);  
$noticias = "";

while ($row = $result->fetch_array()) {
  $noticias .= mostrar($row['date'], $row['title'], $row["url"], $row['descrip'], $row['category']);
}


function mostrar($fecha, $titulo, $link, $descripcion, $categoria) { 
  $news = <<<_END
  <div class="card">
  <div class="card-header">
    $fecha
  </div>
  <div class="card-body">
    <h5 class="card-title">$titulo</h5>
    <div class="card-text">$descripcion</div>
    <a href="$link" class="btn btn-primary link">Enlace al sitio web</a>
  </div>
  </div>
  _END;


  

  return $news;
}
  
$arr = ["noticias" => $noticias];
echo json_encode($arr);
?>
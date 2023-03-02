<?php

function search()
{
  require("dbconfig.php"); 
  $cadenaBusq = $_GET['q'];

  $cadenaDividida= explode(" ",$cadenaBusq);;
  $query = "SELECT * FROM noticias WHERE title LIKE '%$cadenaDividida[0]%' ";

  for($i = 1; $i < count($cadenaDividida); $i++) {
    if(!empty($cadenaDividida[$i])) {
        $query .= "and titulo LIKE '% $cadenaDividida[$i] %'";
        
    }    
  }
  $query .= "LIMIT 10";

  $res = $connection->query($query);
  $noticias="";
  while ($row = $res->fetch_array(MYSQLI_ASSOC)) {
    $noticias .= mostrar($row['date'], $row['title'], $row["url"], $row['descrip'], $row['category']);
  }
  $arr = ["noticias" => $noticias];
  echo json_encode($arr);

}

function mostrar($fecha, $titulo, $link, $descripcion, $categoria) { 
  $noticias = <<<_END
  <div class="card">
  <div class="card-header">
    $fecha
  </div>
  <div class="card-body">
    <h3 class="card-title">$titulo</h3>
    <div class="card-text">$descripcion</div>
    <a href="$link" class="btn btn-primary link">Enlace al sitio web</a>
  </div>
  </div>
_END;

  return $noticias;
}

search();

?>
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
  <div class="card-list" style="--rating:90">
    <div class="icon">🫠</div>
    <div class="title">$titulo</div>
    <p class="description">$descripcion</p>
    <div class="rating"></div>
    <a href="$link" class="link">See the recipe</a>
  </div>
_END;

  return $noticias;
}

search();

?>
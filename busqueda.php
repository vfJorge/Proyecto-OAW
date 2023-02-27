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
    <article class="card">
    Publicado el
    <time datetime="2013-11-12T11:00"
      >$fecha</time>
    <div class="info">
      <h3>
        $titulo
      </h3>
      <button id="btnVisitar"><a href=$link>Enlace al sitio web</a></button>
      <p>
        $descripcion
      </p>
      <p>
        $categoria
      </p>
    </div>
  </article>
_END;

return $noticias;
}

search();

?>
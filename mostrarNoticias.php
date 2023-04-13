<?php

require("dbconfig.php");

//$siteName = $_GET['q'];
$sql = "SELECT * FROM noticias JOIN rssfeed ON noticias.id=rssfeed.id";
if (isset($_GET['p'])) {
  $cadenaBusq = $_GET['p'];

  $cadenaDividida= explode(" ",$cadenaBusq);
  $sql.= " WHERE title LIKE '%$cadenaDividida[0]%' ";

  for($i = 1; $i < count($cadenaDividida); $i++) {
    if(!empty($cadenaDividida[$i])) {
        $sql .= "and title LIKE '% $cadenaDividida[$i] %'";
        
    }    
  }
  
}

if (isset($_GET['q'])) {
  $ordenamiento = $_GET['q'];
  switch ($ordenamiento) {
    case 'date':
        $sql.= " ORDER BY date";
        break;
    case 'title':
      $sql.= " ORDER BY title";
        break;
    case 'descrip':
      $sql.= " ORDER BY descrip";
        break;
    case 'url':
        $sql.= " ORDER BY noticias.url";
        break;
    default:
      break;
  }
}
$sql .= " LIMIT 10";


$result = mysqli_query($connection, $sql);  
$noticias = "";

while ($row = $result->fetch_array()) {
  $noticias .= mostrar($row['date'], $row['title'], $row["url"], $row['descrip'], $row['name']);
}


function mostrar($fecha, $titulo, $link, $descripcion, $fuente) { 
  $news = <<<_END
  <div class="card">
  <div class="card-header">
    $fuente
  </div>
  <div class="card-body">
    <h5 class="card-title">$titulo</h5>
    <div class="card-text">$descripcion</div>
    <a href="$link" class="btn btn-primary link">Enlace al sitio web</a>
  </div>
  <div class="card-footer text-muted">
    $fecha
  </div>
  </div>
  _END;

  return $news;
}
  
$arr = ["noticias" => $noticias];
echo json_encode($arr);
?>
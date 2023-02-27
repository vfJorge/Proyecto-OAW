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


  $arr = ["noticias" => $noticias];
echo json_encode($arr);
?>
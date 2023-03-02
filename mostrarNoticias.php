<?php
function show()
{
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
    $noticias = mostrar($row['date'], $row['title'], $row["url"], $row['descrip'], $row['category']);
  }
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
  


  $arr = ["noticias" => $noticias];
echo json_encode($arr);
show();
?>
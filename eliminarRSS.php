<?php
require("dbconfig.php");

$nombre = $_GET['q'];


$sql = "DELETE FROM rssfeed WHERE name = '".$nombre."'";
$resultado = mysqli_query($connection, $sql);

mysqli_free_result($resultado);
mysqli_close($connection);
?>
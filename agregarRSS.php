<?php
require('dbconfig.php');
include "simplepie-1.5/autoloader.php";
$url = $_GET['q'];

$feed = new SimplePie();
$feed->set_feed_url($url);

if(@$feed->init()){
	$nombreSitio = $feed->get_title();
	$sql = "INSERT INTO rssfeed (name, url) VALUES ('".$nombreSitio."','". $url."')";
	if (mysqli_query($connection, $sql)) {
		//echo "Nuevo registro creado con éxito";
  } else {
		//echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
}

$sql = "SELECT * FROM rssfeed WHERE name = '".$nombreSitio."'";
$resultado = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($resultado);
$id_url = $row['id'];

for($i=0;$i<10;$i++){
	$item  = $feed->get_item($i);

	$date = $item->get_date("Y-m-d h:m:s");
	$title = $item->get_title();
	$link = $item->get_link();
	$descrip = $item->get_description();
	$category = $item->get_category();

	
	$title = mysqli_real_escape_string( $connection, $title);
	$link = mysqli_real_escape_string( $connection, $link);
	$descrip = mysqli_real_escape_string($connection, $descrip);
	$date = mysqli_real_escape_string($connection, $date);
	$category = mysqli_real_escape_string($connection, $category);

	$sql = "INSERT INTO noticias (date, title, url, descrip, category, id) VALUES ('".$date."', '".$title."', '".$link."','".$descrip."','".$category."','".$id_url."')";
    $resultado = mysqli_query($connection, $sql);
}
mysqli_close($connection);
?>
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

echo "<h1>".$feed->get_title()."</h1>";
echo "<h4>".$feed->get_description()."</h4>";

for($i=0;$i<10;$i++){
	$item  = $feed->get_item($i);
	echo "<a href='".$item->get_link()."'>".$item->get_title()."</a>";
	echo "<p>".$item->get_description()."</p>";
//	echo $item->get_content();
	echo "<p><i>Fecha y hora: ".$item->get_date()."</i></p>";
	echo "<br>";
}
?>
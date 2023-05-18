<?php
require("dbconfig.php");
include "simplepie-1.5/autoloader.php";



$id_url = "";

$url = "";
$sql = "SELECT * FROM rssfeed";
$id = mysqli_query($connection, $sql);
//Por cada Feed en RSSFeed
while ($row = $id->fetch_array()) {
    //echo $row['id'];

    //Borra las noticias anteriores
    $sql1 = "DELETE FROM noticias WHERE id ='".$row['id']."'";
    $result = mysqli_query($connection, $sql1);

    $url = $row['url'];
    $id_url = $row['id'];
    $name= $row['name'];

    //Conecta al feed
    $feed = new SimplePie();
    $feed->set_feed_url($url);

    if(@$feed->init()){
        $nombreSitio = $feed->get_title();
    


        for($i=0;$i<10;$i++){
            $item  = $feed->get_item($i);

            $date = $item->get_date("Y-m-d h:i:s");
            $title = $item->get_title();
            $link = $item->get_link();
            $descrip = $item->get_description();
            $category = $item->get_category();

            
            $title = mysqli_real_escape_string( $connection, $title);
            $link = mysqli_real_escape_string( $connection, $link);
            $descrip = mysqli_real_escape_string($connection, $descrip);
            $date = mysqli_real_escape_string($connection, $date);
            $category = mysqli_real_escape_string($connection, $category);

            $sql4 = "INSERT INTO noticias (date, title, url, descrip, category, id) VALUES ('".$date."', '".$title."', '".$link."','".$descrip."','".$category."','".$id_url."')";
            $resultado = mysqli_query($connection, $sql4);
        }
    }
}
mysqli_close($connection);
?>
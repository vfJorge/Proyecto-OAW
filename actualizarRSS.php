<?php
require("dbconfig.php");
include "simplepie-1.5/autoloader.php";

$nombreSite = $_GET['q'];

$id_url = "";

$url = "";
$sql = "SELECT id, url FROM rssfeed WHERE name = '".$nombreSite."'";
$id = mysqli_query($connection, $sql);

while ($row = $id->fetch_assoc()) {
    echo $row['id'];

    $sql1 = "DELETE FROM noticias WHERE id ='".$row['id']."'";
    $result = mysqli_query($connection, $sql1);
    $url = $row['url'];
    $id_url = $row['id'];

}

    $feed = new SimplePie();
    $feed->set_feed_url($url);

    if(@$feed->init()){
        $nombreSitio = $feed->get_title();
    

        $sql3 = "SELECT * FROM rssfeed WHERE name = '".$nombreSitio."'";
        $resultado = mysqli_query($connection, $sql3);
        $row1 = mysqli_fetch_assoc($resultado);
        $id_url = $row1['id'];

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
        mysqli_close($connection);
    }

mysqli_close($connection);
?>
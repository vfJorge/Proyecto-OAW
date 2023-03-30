<?php
session_start();

$connection = mysqli_connect(
  '127.0.0.1',
  'root',
  '',
  'elbuenrssdb'
) or die(mysqli_error($connection));
?>

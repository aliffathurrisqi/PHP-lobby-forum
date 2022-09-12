<?php
include "../config.php";
$id = $_GET['id'];
$url = $_GET['url'];
mysqli_query($conn, "UPDATE account SET akses = 'blokir', blokir = NOW() WHERE username = '$id'");
echo '<script> location.replace("' . $url . '"); </script>';

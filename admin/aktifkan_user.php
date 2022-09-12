<?php
include "../config.php";
$id = $_GET['id'];
mysqli_query($conn, "UPDATE account SET akses = 'user', blokir = NULL WHERE username = '$id'");
echo '<script> location.replace("datauser.php"); </script>';

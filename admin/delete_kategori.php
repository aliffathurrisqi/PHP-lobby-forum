<?php
include "../config.php";
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM kategori WHERE id = '$id'");
echo '<script> location.replace("datakategori.php"); </script>';
?>
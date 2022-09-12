<?php
include "../config.php";
$id = $_GET['id'];
$laporan = $_GET['laporan'];
mysqli_query($conn, "UPDATE account SET akses = 'blokir', blokir = NOW() WHERE username = '$id'");
mysqli_query($conn, "UPDATE laporan SET konfirmasi = 'Ya' WHERE id = '$laporan'");

echo '<script> location.replace("laporan.php"); </script>';

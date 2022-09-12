<?php
$servername = "localhost";
$database   = "db_lobby";
$username   = "root";
$password   = "";

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
mysqli_query($conn, "SET time_zone = '+07:00'");
mysqli_query($conn, "SET lc_time_names = 'id_ID';");

<?php
include "../../config.php";

$id = $_GET['username'];

$query = mysqli_query($conn, "SELECT * FROM account WHERE username = '$id' OR email = '$id'");
$count = mysqli_num_rows($query);

if ($count > 0) {
    $posts = array();
    if (mysqli_num_rows($query)) {
        while ($get = mysqli_fetch_assoc($query)) {
            $posts[] = $get;
        }
    }
    $data = json_encode($posts, JSON_PRETTY_PRINT);
    header('Content-Type: application/json');
    echo $data;
} else {
    $posts = array(
        "username" => NULL,
        "email" => NULL,
        "password" => NULL, "nama" => NULL,
        "gender" => NULL, "bio" => NULL,
        "photo" => NULL, "dibuat" => NULL,
        "blokir" => NULL, "akses" => NULL
    );
    $data = json_encode($posts, JSON_PRETTY_PRINT);
    header('Content-Type: application/json');
    echo $data;
}

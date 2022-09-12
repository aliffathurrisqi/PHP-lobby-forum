<?php
include "../../config.php";

$id = $_GET['id'];
$token = hash('sha256', md5(date('Y-m-d-H-i-s')));

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
    // echo $data;

    $query2 = mysqli_query($conn, "SELECT * FROM account WHERE username = '$id' OR email = '$id'");
    $row = mysqli_fetch_array($query2);

    $dataUser = $row['username'];
    $email = $row['email'];

    mysqli_query($conn, "UPDATE account SET token = '$token' WHERE username = '$dataUser'");

    include "mail_forget.php";
    header("Location: ../../login.php");
    exit();
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

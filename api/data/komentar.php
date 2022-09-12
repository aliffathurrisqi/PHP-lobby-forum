<?php
include "../../config.php";

$query = mysqli_query(
    $conn,
    "SELECT id,id_post,komentar.username,komentar,
    DATE_FORMAT(waktu, '%d %M %Y') AS tgl,
                DATE_FORMAT(waktu, '%H:%i WIB') AS jam,account.photo AS picture
    FROM komentar INNER JOIN account ON komentar.username = account.username"
);
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
        "id" => NULL
        // "username" => NULL,
        // "password" => NULL, "nama" => NULL,
        // "gender" => NULL, "bio" => NULL,
        // "photo" => NULL, "dibuat" => NULL,
        // "blokir" => NULL, "akses" => NULL
    );
    $data = json_encode($posts, JSON_PRETTY_PRINT);
    header('Content-Type: application/json');
    echo $data;
}

<?php
include "../../config.php";

$query = mysqli_query(
    $conn,
    "SELECT * FROM kategori ORDER BY nama_kategori DESC"
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
    );
    $data = json_encode($posts, JSON_PRETTY_PRINT);
    header('Content-Type: application/json');
    echo $data;
}

<?php
include "../../config.php";

$username = $_GET['username'];
$password = $_GET['password'];
$konfirmasi = $_GET['konfirmasi'];
$email = $_GET['email'];
$token = hash('sha256', md5(date('Y-m-d-H-i-s')));

if ($password == $konfirmasi) {
    $cekEmail = mysqli_query($conn, "SELECT username,email FROM account WHERE email = '$email' OR username = '$username'");
    $emailCek = mysqli_num_rows($cekEmail);
    if ($emailCek < 1) {
        $posts = array(
            "username" => $username,
            "password" => $password,
            "konfirmasi" => $konfirmasi,
            "email" => $email,
            "token" => $token,
            "response" => "200",
            "result" => "Data Berhasil Ditambah"
        );
        $data = json_encode($posts);
        header('Content-Type: application/json');
        echo $data;

        include "mail.php";

        $regist = mysqli_query($conn, "INSERT INTO account VALUES('$username',md5($password),'$email','$username','Laki-Laki','','',NOW(),NULL,'$token','user','Belum')");
    } else {
        $posts = array(
            "username" => $username,
            "password" => $password,
            "konfirmasi" => $konfirmasi,
            "email" => $email,
            "response" => "Username atau Password sudah terdaftar",
            "result" => "Proses Registrasi Gagal"
        );
        $data = json_encode($posts);
        header('Content-Type: application/json');
        echo $data;
    }
} else {
    $posts = array(
        "username" => $username,
        "password" => $password,
        "konfirmasi" => $konfirmasi,
        "email" => $email,
        "response" => "400",
        "result" => "Proses Registrasi Gagal"
    );
    $data = json_encode($posts);
    header('Content-Type: application/json');
    echo $data;
}

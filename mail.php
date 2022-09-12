<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";
$mail = new PHPMailer(true);
$mail->SMTPDebug = 0;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
//ganti dengan email dan password yang akan di gunakan sebagai email pengirim
$mail->Username = "alfaristudio@gmail.com";
$mail->Password = "opzopqvzczpvaoyo";
$mail->SMTPSecure = "ssl";
$mail->Port = 465;
//ganti dengan email yg akan di gunakan sebagai email pengirim
$mail->setFrom("alfaristudio@gmail.com", "Alfari Studio");
$mail->addAddress($reg_email, $reg_email);
$mail->isHTML(true);
$style = "background-color: #f44336;
color: white;
padding: 14px 25px;
text-align: center;
text-decoration: none;
display: inline-block;";
$mail->Subject = "Aktivasi Akun";
$mail->Body = "Selamat, anda berhasil membuat akun di Forum Lobby. Untuk mengaktifkan akun anda silahkan klik link dibawah ini.
<br><br>
<a href='http://localhost:8080/lobby/activation.php?t=" . $token . "' 
style='background-color: #f44336;
color: white;
padding: 14px 25px;
text-align: center;
width : 100%;
text-decoration: none;
display: inline-block;'>Aktivasi Akun</a>";
$mail->send();
// echo 'Message has been sent';

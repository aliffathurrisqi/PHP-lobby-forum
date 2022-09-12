<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../../vendor/autoload.php";
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
$mail->addAddress($email, $email);
$mail->isHTML(true);
$style = "background-color: #f44336;
color: white;
padding: 14px 25px;
text-align: center;
text-decoration: none;
display: inline-block;";
$mail->Subject = "Permintaan Perubahan Password";
$mail->Body = "Pengajuan perubahan password dari akun " . $dataUser . ". Untuk mengubah password akun anda silahkan klik link dibawah ini. 
Jika bukan anda yang melakukan aksi ini maka abaikan pesan ini.
<br><br>
<a href='http://localhost:8080/lobby/forgotpassword.php?t=" . $token . "' 
style='background-color: #f44336;
color: white;
padding: 14px 25px;
text-align: center;
width : 100%;
text-decoration: none;
display: inline-block;'>Ubah Password</a>";
$mail->send();
// echo 'Message has been sent';

<?php

include "config.php";

$pindah = $_GET['url'];
$id = $_GET['id'];
$target = $_GET['target'];
$username_log = $_GET['username'];

$id_like = "L" . $id . $username_log;

$new_url = ".." . $pindah;

mysqli_query($conn, "INSERT INTO like_unlike VALUES (NULL,'$username_log','$id',NOW())");


$cek = mysqli_query($conn, "SELECT judul FROM post WHERE id = '$id'");
$data = mysqli_fetch_array($cek);
$judul = $data['judul'];
mysqli_query($conn, "INSERT INTO notifikasi VALUES ('$id_like','$target','suka','baru saja menyukai diskusi Anda tentang <strong>$judul</strong>','$username_log','$id',NOW(),'tidak')");


?>
<script>
    location.replace("<?php echo $new_url; ?>")
</script>
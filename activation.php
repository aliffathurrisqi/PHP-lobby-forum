<!DOCTYPE html>
<html lang="en">
<?php
include "config.php";
include "php/head.php";
?>

<body>
  <div class="container" align="center">
    <br>
    <?php
    $token = $_GET['t'];
    $sql_cek = mysqli_query($conn, "SELECT * FROM account WHERE token = '$token' AND verifikasi = 'belum'");
    $jml_data = mysqli_num_rows($sql_cek);
    if ($jml_data > 0) {
      //update data users aktif
      $data = mysqli_fetch_array($sql_cek);
      mysqli_query($conn, "UPDATE account SET verifikasi = 'Sudah' WHERE token = '$token' AND verifikasi = 'Belum'");
      echo '<div class="alert alert-success">
                        Akun anda ' . $data['username'] . ' sudah aktif, silahkan Login
                        </div>';
    } else {
      //data tidak di temukan
      echo '<div class="alert alert-warning">
                        Invalid Token!
                        </div>';
    }
    ?>
  </div>
</body>

</html>
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
    $sql_cek = mysqli_query($conn, "SELECT * FROM account WHERE token = '$token' AND verifikasi = 'Sudah'");
    $jml_data = mysqli_num_rows($sql_cek);
    if ($jml_data > 0) {
      //update data users aktif
      $data = mysqli_fetch_array($sql_cek);
      $dataUsername = $data['username'];
    ?>

      <body>
        <main class="d-flex w-100">
          <div class="container d-flex flex-column">
            <div class="row vh-100">
              <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">
                  <div class="card">
                    <div class="card-body">
                      <div class="m-sm-4">
                        <div class="text-center">
                          <h1 class="h2">Lupa Password</h1>
                          <p class="lead">
                            <?php echo $dataUsername; ?>, Silahkan masukkan password baru anda
                          </p>
                        </div>
                        <form method="POST">
                          <div class="mb-3">
                            <!-- <label class="form-label">Password</label> -->
                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Masukkan password baru" />
                          </div>
                          <div class="mb-3">
                            <!-- <label class="form-label">Ulangi Password</label> -->
                            <input class="form-control form-control-lg" type="password" name="konfirmasi" placeholder="masukkan kembali password baru" />
                          </div>
                          <hr>
                          <div class="text-center mt-3">
                            <button class="btn btn-lg btn-primary w-100 mb-2" name="btnUbah">Ubah Password</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main>
        <script src="js/app.js"></script>
      </body>
    <?php
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
<?php
if (isset($_POST["btnUbah"])) {
  $password = $_POST['password'];
  $konfirmasi = $_POST['konfirmasi'];

  if ($password == $konfirmasi) {
    $ubah = mysqli_query($conn, "UPDATE account SET password = md5('$password') WHERE username = '$dataUsername'");
    echo "<script>alert('Password berhasil diubah')</script>";
  } else {
    echo "<script>alert('Konfirmasi Password Salah')</script>";
  }
}
?>
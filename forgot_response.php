<?php
session_start();
include "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<?php
include "php/head.php";
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
                                        <h1 class="h2">Selamat Datang</h1>
                                        <p class="lead">
                                            Silahkan login terlebih dahulu
                                        </p>

                                    </div>
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Username atau Email</label>
                                            <input class="form-control form-control-lg" type="text" name="username" placeholder="Masukkan username atau Email" />
                                        </div>
                                        <hr>
                                        <div class="text-center mt-3">
                                            <button class="btn btn-lg btn-primary w-100 mb-2" name="btnSend">Kirim Permintaan</button>
                                            <a class="btn btn-lg btn-danger w-100" href="login.php">Kembali</a>
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

</html>

<?php

if (isset($_POST["btnSend"])) {
    echo '<script type="text/javascript"> alert("Permintaan perubahan password telah dikirim ke email")</script>';
    echo '<script> location.replace("api/auth/forget.php?id=' . $_POST['username'] . '"); </script>';
}
?>
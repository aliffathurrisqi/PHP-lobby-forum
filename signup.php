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
                                            Silahkan membuat akun baru anda
                                        </p>
                                        <?php

                                        if (isset($_POST["btnDaftar"])) {
                                            $reg_username = $_POST['username'];
                                            $reg_password = $_POST['password'];
                                            $reg_confirm = $_POST['konfirmasi'];
                                            $reg_email = $_POST['email'];
                                            $token = hash('sha256', md5(date('Y-m-d-H-i-s')));

                                            if ($reg_password == $reg_confirm) {
                                                $cekEmail = mysqli_query($conn, "SELECT email FROM account WHERE email = '$reg_email'");
                                                $emailCek = mysqli_num_rows($cekEmail);
                                                if ($emailCek < 1) {
                                                    $regist = mysqli_query($conn, "INSERT INTO account VALUES('$reg_username',md5($reg_password),'$reg_email','$reg_username','Laki-Laki','','',NOW(),NULL,'$token','user','Belum')");

                                                    if ($regist) {
                                                        include "mail.php";
                                                        echo '<script> location.replace("login.php"); </script>';
                                                    } else {
                                        ?>
                                                        <div class="alert alert-danger align-items-center" role="alert">
                                                            <i class="bi bi-exclamation-triangle-fill me-2"></i> Username sudah terdaftar
                                                        </div>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="alert alert-danger align-items-center" role="alert">
                                                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Email sudah terdaftar
                                                    </div>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="alert alert-danger align-items-center" role="alert">
                                                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Konfirmasi password salah
                                                </div>
                                        <?php

                                            }
                                        }
                                        ?>
                                    </div>
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input class="form-control form-control-lg" type="text" name="username" placeholder="Masukkan username" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control form-control-lg" type="email" pattern="[a-z0-9._%+-=]+@[a-z0-9.-]+\.[a-z]{2,}$" name="email" placeholder="Masukkan email" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Masukkan password" />
                                            <!-- <small>
												<a href="index.html">Forgot password?</a>
											</small> -->
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ulangi Password</label>
                                            <input class="form-control form-control-lg" type="password" name="konfirmasi" placeholder="Masukkan ulang password" />
                                            <!-- <small>
												<a href="index.html">Forgot password?</a>
											</small> -->
                                        </div>
                                        <div class="text-center">

                                            sudah memiliki akun ?<a href="login.php"> Login</a>

                                        </div>
                                        <hr>
                                        <div class="text-center mt-3">
                                            <button class="btn btn-lg btn-primary w-100 mb-2" name="btnDaftar">Daftar</button>
                                            <!-- <button type="submit" class="btn btn-lg btn-primary">Sign in</button> -->
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
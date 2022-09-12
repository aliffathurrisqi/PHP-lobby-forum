<?php
session_start();
$_SESSION['user_log'] = $_SESSION['user_log'];
include "config.php";
$username = $_SESSION['user_log'];
$profile = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<?php
include "php/head.php";
?>

<body>
    <div class="wrapper">
        <?php

        $url = $_SERVER["REQUEST_URI"];
        if ($_SESSION['user_log'] != NULL) {
            $username = $_SESSION['user_log'];
            $akses = mysqli_query($conn, "SELECT akses FROM account WHERE username = '$username'");
            $data = mysqli_fetch_array($akses);
            if ($data['akses'] == 'admin') {
                include "php/sidebar.php";
            }
            if ($data['akses'] == 'blokir') {
                echo '<script> location.replace("login.php"); </script>';
            }
        }
        ?>

        <div class="main">
            <?php

            $url = $_SERVER["REQUEST_URI"];

            if ($_SESSION['user_log'] != NULL) {
                $username = $_SESSION['user_log'];
                $akses = mysqli_query($conn, "SELECT akses FROM account WHERE username = '$username'");
                $data = mysqli_fetch_array($akses);
                if ($data['akses'] == 'admin') {
                    include "admin/php/navbar.php";
                }
                if ($data['akses'] == 'user') {
                    include "php/navbar.php";
                }
            } else {
                include "php/navbar.php";
            }

            ?>

            <main class="content mt-4">
                <div class="container-fluid p-0 mb-7">
                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            <?php
                            $profile_data = mysqli_query($conn, "SELECT username,nama,gender,bio,photo,akses,
                            DATE_FORMAT(dibuat, '%d') AS tglgabung, DATE_FORMAT(dibuat,'%M') AS blngabung,DATE_FORMAT(dibuat,'%Y') AS thngabung
                            FROM account WHERE username = '$profile'");
                            while ($row = mysqli_fetch_array($profile_data)) {

                                $data_photo = $row['photo'];

                                if ($data_photo == NULL) {
                                    $data_photo = "default_image.png";
                                }

                                $profile_bio = $row['bio'];
                                if ($profile_bio == null) {
                                    $profile_bio = "Pengguna ini belum menulis biografi";
                                }

                                $jumlahpost = mysqli_query($conn, "SELECT COUNT(username) AS jumlah FROM post WHERE username = '$profile' AND kategori !=1");
                                while ($jml = mysqli_fetch_array($jumlahpost)) {
                                    $post_count = $jml['jumlah'];
                                }

                                $jumlahcomment = mysqli_query($conn, "SELECT COUNT(username) AS jumlah FROM komentar WHERE username = '$profile'");
                                while ($jml = mysqli_fetch_array($jumlahcomment)) {
                                    $comment_count = $jml['jumlah'];
                                }

                                $profile_tglgabung = $row['tglgabung'];
                                $profile_blngabung = $row['blngabung'];
                                if ($profile_blngabung == "Pebruari") {
                                    $profile_blngabung = "Februari";
                                }
                                $profile_thngabung = $row['thngabung'];

                            ?>
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <div class="d-flex align-items-start">
                                            <h5 class="card-title mb-0">Detail Profile</h5>
                                            <div class="flex-grow-1">
                                                <?php
                                                if ($username != NULL) {
                                                ?>
                                                    <small style="font-size:smaller;" class="btn float-end p-1" data-bs-toggle="modal" data-bs-target="#reportModal<?php echo $row['username']; ?>"><i class="bi bi-exclamation-circle"></i></small>
                                                <?php
                                                }
                                                ?>

                                                <!-- Modal Report -->
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="modal fade" id="reportModal<?php echo $row['username']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h5 class="modal-title text-white" id="exampleModalLabel">Memberikan Laporan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body text-center">

                                                                    <img src="img/user/<?php echo $data_photo; ?>" class="rounded-circle mb-2" height="75" />
                                                                    <h5 class="card-title mb-0 text-dark"><?php echo $row['username']; ?></h5>

                                                                    <div class="input-group">
                                                                        <textarea class="form-control" name="reportAlasan" aria-label="With textarea" style="resize: none; height:300px;" placeholder="Berikan alasan...."></textarea>
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                                    <button class="btn btn-primary" name="btnReport<?php echo $row['username']; ?>">Buat Laporan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- Modal Report End -->

                                                <?php
                                                $idReport = $row['username'];
                                                if (isset($_POST["btnReport$idReport"])) {
                                                    include "makeReport.php";
                                                    $alasan = $_POST['reportAlasan'];
                                                    makeReport($username, 'user', $idReport, $alasan);
                                                }

                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body text-center">
                                        <img src="img/user/<?php echo $data_photo; ?>" class="rounded-circle mb-2" height="128" />
                                        <h5 class="card-title mb-0 text-dark"><?php echo $row['username']; ?></h5>
                                        <div class="text-muted"><?php echo $row['nama']; ?></div>
                                        <div class="text-muted mb-2"><?php echo $row['gender']; ?></div>
                                        <div class="text-muted">"<?php echo $profile_bio; ?>"</div>
                                        <?php
                                        if ($row['akses'] == 'blokir') {
                                        ?>
                                            <div class="alert-secondary align-items-center mt-2 mb-2 p-2" role="alert">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i> Akun diblokir
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                    <hr class="my-0" />
                                    <div class="card-body">
                                        <h5 class="h6 card-title">Statistik</h5>
                                        <ul class="list-unstyled mb-0">
                                            <li class="mb-1"><i class="bi bi-star"></i> Bergabung <?php echo $profile_tglgabung . " " . $profile_blngabung . " " . $profile_thngabung; ?></li>
                                            <li class="mb-1"><i class="bi bi-chat"></i></i> <?php echo $post_count; ?> Diskusi</li>
                                            <li class="mb-1"><i class="bi bi-chat-dots"></i> <?php echo $comment_count; ?> Komentar</li>
                                        </ul>
                                    </div>
                                    <?php
                                    if ($username == $profile) {
                                        $userdata = mysqli_query($conn, "SELECT * FROM account where username = '$username'");
                                        $data = mysqli_fetch_array($userdata);
                                        if ($data['bio'] != NULL) {
                                            $databio = $data['bio'];
                                        } else {
                                            $databio = "";
                                        }

                                        if ($data['photo'] != NULL) {
                                            $dataimg = $data['photo'];
                                        } else {
                                            $dataimg = "default_image.png";
                                        }
                                    ?>
                                        <hr class="my-0" />
                                        <div class="card-body">
                                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editModal">Ubah Profile</button><br>
                                            </ul>
                                        </div>
                                        <!-- Modal -->
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="input-group mb-3" id="changeimg">

                                                                <div class="w-100">
                                                                    <center>
                                                                        <img src="img/user/<?php echo $data_photo; ?>" class="mb-2" height="100" />
                                                                    </center>
                                                                    <a class="btn btn-primary w-100" name="gantiAvatar" id="gantiAvatar">Ganti Avatar</a>
                                                                </div>

                                                            </div>
                                                            <div class="input-group mb-3" id="selectimg" style="display: none;">
                                                                <center>
                                                                    <div class="form-check form-check-inline">
                                                                        <label class="mb-1">
                                                                            <input type="radio" name="radio" value="default_image.png">
                                                                            <img src="img/user/default_image.png" width="75px">
                                                                        </label>
                                                                        <label class="mb-1">
                                                                            <input type="radio" name="radio" value="miya.jpg">
                                                                            <img src="img/user/miya.jpg" width="75px">
                                                                        </label>
                                                                        <label class="mb-1">
                                                                            <input type="radio" name="radio" value="balmond.jpg">
                                                                            <img src="img/user/balmond.jpg" width="75px">
                                                                        </label>
                                                                        <label class="mb-1">
                                                                            <input type="radio" name="radio" value="kagura.jpg">
                                                                            <img src="img/user/kagura.jpg" width="75px">
                                                                        </label>
                                                                        <label class="mb-1">
                                                                            <input type="radio" name="radio" value="saber.jpg">
                                                                            <img src="img/user/saber.jpg" width="75px">
                                                                        </label>
                                                                        <label class="mb-1">
                                                                            <input type="radio" name="radio" value="nana.jpg">
                                                                            <img src="img/user/nana.jpg" width="75px">
                                                                        </label>
                                                                    </div>

                                                                    <a class="btn btn-danger w-100" id="batalAvatar">Batal</a>
                                                                </center>
                                                                <!-- <input type="file" class="form-control" id="photo" name="photo" aria-describedby="basic-addon1" accept="image/png, image/gif, image/jpeg, image/jpg" onchange="previewImage()"> -->

                                                            </div>


                                                            <script type="text/javascript">
                                                                document.getElementById("gantiAvatar").onclick = function() {
                                                                    selectIMG()
                                                                };

                                                                document.getElementById("batalAvatar").onclick = function() {
                                                                    cancelIMG()
                                                                };

                                                                function selectIMG() {
                                                                    document.getElementById("changeimg").style.display = 'none';
                                                                    document.getElementById("selectimg").style.display = 'block';
                                                                }

                                                                function cancelIMG() {
                                                                    document.getElementById("changeimg").style.display = 'block';
                                                                    document.getElementById("selectimg").style.display = 'none';
                                                                }
                                                            </script>


                                                            <hr>
                                                            <div class="input-group mb-3">
                                                                <input type="text" class="form-control" name="nama" id="form-nama" onkeyup="validate();" aria-describedby="basic-addon1" placeholder="Tuliskan nama anda" value="<?php echo $data['nama']; ?>">
                                                            </div>
                                                            <script>
                                                                function validate() {
                                                                    var element = document.getElementById('form-nama');
                                                                    element.value = element.value.replace(/[^a-zA-Z ]+/, '');
                                                                };
                                                            </script>
                                                            <div class="input-group mb-3">
                                                                <select class="form-select" id="inputGroupSelect01" name="gender">
                                                                    <option value="Laki-Laki">Laki-Laki</option>
                                                                    <option value="Perempuan">Perempuan</option>
                                                                </select>
                                                            </div>
                                                            <div class="input-group">
                                                                <textarea class="form-control" name="bio" aria-label="With textarea" style="resize: none; height:100px;" placeholder="Tulis biografi disini...."><?php echo $databio; ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                            <button class="btn btn-primary" name="btnEdit">Simpan Perupahan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <!-- Modal End -->
                                        <script>
                                            function previewImage() {
                                                document.getElementById("image-preview").style.display = "block";
                                                var onFReader = new FileReader();
                                                onFReader.readAsDataURL(document.getElementById("photo").files[0]);

                                                onFReader.onload = function(oFREvent) {
                                                    document.getElementById("image-preview").src = oFREvent.target.result;
                                                };
                                            }
                                        </script>
                                    <?php
                                    }
                                    ?>
                                </div>
                            <?php
                            }
                            ?>
                        </div>

                        <div class="col-md-8 col-xl-9">

                            <?php
                            if ($username == $profile) {
                            ?>
                                <button class="btn btn-primary w-100 d-none d-sm-inline-block mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Tulis Diskusi</button><br>
                            <?php
                            }
                            ?>
                            <!-- Modal -->
                            <form method="POST" enctype="multipart/form-data">
                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Tulis Diskusi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="input-group mb-3">
                                                    <input type="text" class="form-control" name="p_judul" aria-describedby="basic-addon1" placeholder="Tuliskan judul....">
                                                </div>
                                                <div class="input-group mb-3">
                                                    <select class="form-select" id="inputGroupSelect01" name="p_kategori">
                                                        <?php
                                                        $akses = mysqli_query($conn, "SELECT akses FROM account WHERE username = '$username'");
                                                        while ($row = mysqli_fetch_array($akses)) {
                                                            $hak_akses = $row['akses'];
                                                        }
                                                        if ($hak_akses == "admin") {
                                                            $kategori = mysqli_query($conn, "SELECT * FROM kategori");
                                                            while ($row = mysqli_fetch_array($kategori)) {
                                                        ?>
                                                                <option style="color:<?php echo $row['warna']; ?>;" value="<?php echo $row['id']; ?>"><?php echo $row['nama_kategori']; ?></option>
                                                            <?php
                                                            }
                                                        } else {
                                                            $kategori = mysqli_query($conn, "SELECT * FROM kategori WHERE id != 1");
                                                            while ($row = mysqli_fetch_array($kategori)) {
                                                            ?>
                                                                <option style="color:<?php echo $row['warna']; ?>;" value="<?php echo $row['id']; ?>"><?php echo $row['nama_kategori']; ?></option>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="input-group">
                                                    <textarea class="form-control" name="p_konten" aria-label="With textarea" style="resize: none; height:300px;" placeholder="Tulis diskusi disini...."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                <button class="btn btn-primary" name="btnPost">Publikasikan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- Modal End -->

                            </script>
                            <?php
                            if (isset($_POST["btnPost"])) {

                                $p_judul = $_POST["p_judul"];
                                $p_konten = $_POST["p_konten"];
                                $p_kategori = $_POST["p_kategori"];

                                $post = mysqli_query(
                                    $conn,
                                    "INSERT INTO post VALUES(NULL,'$username',NOW(),'$p_konten','$p_kategori','$p_judul','Ya')"
                                );
                                echo '<script> location.replace("profile.php?id=' . $username . '"); </script>';
                            }

                            ?>
                            <!-- Awal Diskusi -->
                            <?php
                            $sql_query = "SELECT post.id,post.judul,post.konten,post.username,post.kategori,
              DATE_FORMAT(waktu, '%d') AS tgl,DATE_FORMAT(waktu, '%M') AS bln,DATE_FORMAT(waktu, '%Y') AS thn,
              DATE_FORMAT(waktu, '%H:%i WIB') AS jam, post.konfirmasi
              FROM post INNER JOIN kategori ON post.kategori = kategori.id
              WHERE post.kategori !='1' AND post.username = '$profile' ORDER BY post.id DESC";

                            $post = mysqli_query($conn, $sql_query);

                            $results_per_page = 5;
                            $number_of_result = mysqli_num_rows($post);
                            $number_of_page = ceil($number_of_result / $results_per_page);
                            if (!isset($_GET['page'])) {
                                $page = 1;
                            } else {
                                $page = $_GET['page'];
                            }

                            $page_first_result = ($page - 1) * $results_per_page;

                            $post = mysqli_query($conn, $sql_query);
                            $count = mysqli_num_rows($post);
                            while ($row = mysqli_fetch_array($post)) {
                                $pBln = $row['bln'];
                                if ($pBln == "Pebruari") {
                                    $pBln = "Februari";
                                }
                                $id_post = $row["id"];
                                $tampil_konten = substr($row["konten"], 0, 100);
                                $tampil_user = substr($row["username"], 0, 15);
                                $tampil_user2 = substr($row["username"], 15, 30);
                                $jumlahkomen = mysqli_query($conn, "SELECT COUNT(id_post) AS jumlah_komentar FROM komentar WHERE id_post = '$id_post';");
                                $data = mysqli_fetch_array($jumlahkomen);
                                $data_komentar = $data["jumlah_komentar"];

                                $jumlahLike = mysqli_query($conn, "SELECT COUNT(id) AS jmlLike FROM like_unlike WHERE id_post = '$id_post'");
                                $data2 = mysqli_fetch_array($jumlahLike);
                                $data_like = $data2["jmlLike"];

                                $liker = mysqli_query($conn, "SELECT * FROM like_unlike WHERE id_post = '$id_post' AND username = '$username'");
                                $dataliker = mysqli_num_rows($liker);
                                $liker2 = mysqli_fetch_array($liker);
                                if ($dataliker > 0) {
                                    $like_id = $liker2['id'];
                                }

                                $jumlahLihat = mysqli_query($conn, "SELECT COUNT(id) AS jmlLihat FROM dilihat WHERE id_post = '$id_post'");
                                $data3 = mysqli_fetch_array($jumlahLihat);
                                $data_lihat = $data3["jmlLihat"];


                                $user_post = $row["username"];
                                $foto = mysqli_query($conn, "SELECT photo FROM account WHERE username = '$user_post'");
                                while ($photo = mysqli_fetch_array($foto)) {
                                    $data_photo = $photo["photo"];

                                    if ($data_photo == NULL) {
                                        $data_photo = "default_image.png";
                                    }
                                }

                                $kat = $row["kategori"];
                                $kategori = mysqli_query($conn, "SELECT nama_kategori,warna FROM kategori WHERE id= '$kat'");
                                while ($kat_info = mysqli_fetch_array($kategori)) {
                                    $data_kategori = $kat_info["nama_kategori"];
                                    $data_warna = $kat_info["warna"];
                                }

                            ?>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <img src="img/user/<?php echo $data_photo; ?>" width="36" height="36" class="rounded-circle me-2">
                                            <div class="flex-grow-1">


                                                <?php
                                                if ($username != NULL) {
                                                ?>
                                                    <small style="font-size:smaller;" class="btn float-end p-1" data-bs-toggle="modal" data-bs-target="#reportModal<?php echo $id_post; ?>"><i class="bi bi-exclamation-circle"></i></small>
                                                <?php
                                                }
                                                ?>
                                                <!-- Modal Report -->
                                                <form method="POST" enctype="multipart/form-data">
                                                    <div class="modal fade" id="reportModal<?php echo $id_post; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-danger">
                                                                    <h5 class="modal-title text-white" id="exampleModalLabel">Memberikan Laporan</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="reportId" value="<?php echo $id_post; ?>">
                                                                    <strong><a class="text-dark" href="discussion.php?id=<?php echo $row["id"]; ?>">
                                                                            <?php echo $row["judul"]; ?>
                                                                        </a></strong><br />
                                                                    <small class="text-muted"><?php echo $row["tgl"] . " " . $pBln . " " . $row["thn"] . " " . $row["jam"]; ?>
                                                                        oleh
                                                                        <a href="profile.php?id=<?php echo $row["username"]; ?>">
                                                                            <strong><?php echo $row["username"]; ?></strong>
                                                                        </a>
                                                                        - <a href="index.php?search=<?php echo $data_kategori; ?>" style="color:<?php echo $data_warna; ?>;"><?php echo $data_kategori; ?></a>
                                                                    </small>
                                                                    <div class="input-group">
                                                                        <textarea class="form-control" name="reportAlasan" aria-label="With textarea" style="resize: none; height:300px;" placeholder="Berikan alasan...."></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                                    <button class="btn btn-primary" name="btnReport<?php echo $id_post; ?>">Buat Laporan</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                                <!-- Modal Report End -->

                                                <?php

                                                if (isset($_POST["btnReport$id_post"])) {
                                                    include "makeReport.php";
                                                    $alasan = $_POST['reportAlasan'];
                                                    makeReport($username, 'post', $id_post, $alasan);
                                                }

                                                ?>

                                                <strong><a class="text-dark" href="discussion.php?id=<?php echo $row["id"]; ?>">
                                                        <?php echo $row["judul"]; ?>
                                                    </a></strong><br />
                                                <small class="text-muted"><?php echo $row["tgl"] . " " . $pBln . " " . $row["thn"] . " " . $row["jam"]; ?>
                                                    oleh
                                                    <a href="profile.php?id=<?php echo $row["username"]; ?>">
                                                        <strong><?php echo $row["username"]; ?></strong>
                                                    </a>
                                                    - <a href="#" style="color:<?php echo $data_warna; ?>;"><?php echo $data_kategori; ?></a>
                                                </small>

                                                <?php
                                                if ($row['konfirmasi'] == "Ya") {
                                                ?>
                                                    <div class="text-sm dark mt-1" align="justify">
                                                        <?php echo  $row["konten"]; ?>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="alert alert-secondary align-items-center p-3 text-center" role="alert">
                                                        <i class="bi bi-exclamation-triangle-fill ms-2 me-2"></i>Postingan ditangguhkan
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <center>
                                            <hr>
                                            <span class="informasi mt-1">
                                                <?php
                                                if ($username != NULL) {

                                                    if ($dataliker == 0) {
                                                ?>
                                                        <a class="btn btn-outline-danger" href="like.php?id=<?php echo $row["id"]; ?>&&url=<?php echo $url ?>&&target=<?php echo $row["username"]; ?>&&username=<?php echo $username; ?>"><i class="bi bi-heart-fill"></i> <?php echo $data_like; ?> Suka</a>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <a class="btn btn-danger" href="unlike.php?id=<?php echo $like_id; ?>&&url=<?php echo $url ?>"><i class="bi bi-heart-fill"></i> <?php echo $data_like; ?> Suka</a>
                                                    <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <a class="btn btn-danger" href="login.php"><i class="bi bi-heart"></i> <?php echo $data_like; ?> Suka</a>
                                                <?php
                                                }
                                                ?>

                                                <a class="btn btn-primary" href="discussion.php?id=<?php echo $row["id"]; ?>"><i class="bi bi-chat-dots-fill"></i> <?php echo $data_komentar; ?> Komentar</a>
                                                <a class="btn btn-success" href="discussion.php?id=<?php echo $row["id"]; ?>"><i class="bi bi-eye-fill"> </i><?php echo $data_lihat; ?> Kali Dilihat</a>
                                            </span>

                                        </center>
                                    </div>
                                </div>
                                <!-- Akhir Diskusi -->
                            <?php
                            }
                            if ($count <= 0) {
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-start">
                                            <div class="border text-sm dark mt-1 w-100 fs-4 p-2" align="center">
                                                Pengguna ini belum menulis apapun...
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>

                        </div>
                    </div>

                </div>
            </main>

            <!-- <footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> &copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer> -->
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>

<?php
if (isset($_POST["btnEdit"])) {

    $search = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username'");
    $data = mysqli_fetch_array($search);

    $nama = $_POST['nama'];
    $gender = $_POST['gender'];
    $bio = $_POST['bio'];

    if (!empty($_POST['radio'])) {
        // if ($data['photo'] != NULL) {
        //     $files    = glob('img/user/' . $data['photo']);
        //     foreach ($files as $file) {
        //         if (is_file($file))
        //             unlink($file);
        //     }
        // }

        // $dir = "img/user/";
        // $edit_foto = $username . date('Ymdhis') . '.jpg';
        // move_uploaded_file($_FILES["photo"]["tmp_name"], $dir . $edit_foto);

        $fotobaru = $_POST['radio'];

        $edit_profile = mysqli_query(
            $conn,
            "UPDATE account SET 
            photo = '$fotobaru', nama = '$nama', gender = '$gender', bio = '$bio' 
            WHERE username = '$username'"
        );
    } else {
        $edit_profile = mysqli_query(
            $conn,
            "UPDATE account SET 
            nama = '$nama', gender = '$gender', bio = '$bio' 
            WHERE username = '$username'"
        );
    }

    echo '<script> location.replace("profile.php?id=' . $username . '"); </script>';
}
?>
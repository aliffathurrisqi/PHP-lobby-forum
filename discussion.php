<?php
session_start();
$_SESSION['user_log'] = $_SESSION['user_log'];
include "config.php";
$username = $_SESSION['user_log'];
?>
<!DOCTYPE html>
<html lang="en">
<?php
$url = $_SERVER["REQUEST_URI"];

include "php/head.php";
?>

<body>
    <div class="wrapper">
        <?php
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
            include "php/navbar.php";
            ?>

            <main class="content mt-4">
                <div class="container-fluid p-0 mb-7">
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card">
                                <div class="card-body h-100">

                                    <!-- Awal Diskusi -->
                                    <?php
                                    $id = $_GET['id'];

                                    $sql_query = "SELECT post.id,post.judul,post.konten,post.username,post.kategori,
              DATE_FORMAT(waktu, '%d') AS tgl,DATE_FORMAT(waktu, '%M') AS bln,DATE_FORMAT(waktu, '%Y') AS thn,
              DATE_FORMAT(waktu, '%H:%i WIB') AS jam,post.konfirmasi
              FROM post INNER JOIN kategori ON post.kategori = kategori.id
              WHERE post.id = '$id'";

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

                                    $post = mysqli_query($conn, $sql_query . " LIMIT " . $page_first_result . ',' . $results_per_page);
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
                                        while ($data = mysqli_fetch_array($jumlahkomen)) {
                                            $data_komentar = $data["jumlah_komentar"];
                                        }

                                        $jumlahLike = mysqli_query($conn, "SELECT COUNT(id) AS jmlLike FROM like_unlike WHERE id_post = '$id_post'");
                                        $data2 = mysqli_fetch_array($jumlahLike);
                                        $data_like = $data2["jmlLike"];

                                        $liker = mysqli_query($conn, "SELECT * FROM like_unlike WHERE id_post = '$id_post' AND username = '$username'");
                                        $dataliker = mysqli_num_rows($liker);
                                        $liker2 = mysqli_fetch_array($liker);
                                        if ($dataliker > 0) {
                                            $like_id = $liker2['id'];
                                        }

                                        if ($_SESSION['user_log'] != NULL) {
                                            $idsee = $id_post . $username;
                                            mysqli_query($conn, "INSERT INTO dilihat VALUES ('$idsee','$id_post','$username',NOW())");
                                        }

                                        $jumlahLihat = mysqli_query($conn, "SELECT COUNT(id) AS jmlLihat FROM dilihat WHERE id_post = '$id_post'");
                                        $data3 = mysqli_fetch_array($jumlahLihat);
                                        $data_lihat = $data3["jmlLihat"];

                                        $user_post = $row["username"];
                                        $judul_post = $row["judul"];
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

                                        <div class="d-flex align-items-start">
                                            <img src="img/user/<?php echo $data_photo; ?>" width="36" height="36" class="rounded-circle me-2" alt="Charles Hall">
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
                                                        <a class="btn btn-success mt-2" href="discussion.php?id=<?php echo $row["id"]; ?>"><i class="bi bi-eye-fill"> </i><?php echo $data_lihat; ?> Kali Dilihat</a>
                                                    </span>

                                                </center>



                                                <!-- komentar -->
                                                <?php
                                                $comment = mysqli_query(
                                                    $conn,
                                                    "SELECT id,id_post,komentar.username,komentar,
  DATE_FORMAT(waktu, '%d') AS tgl,DATE_FORMAT(waktu, '%M') AS bln,DATE_FORMAT(waktu, '%Y') AS thn,
              DATE_FORMAT(waktu, '%H:%i WIB') AS jam,account.photo AS picture, konfirmasi
  FROM komentar INNER JOIN account ON komentar.username = account.username 
  WHERE id_post = $id ORDER BY id"
                                                );
                                                while ($co = mysqli_fetch_array($comment)) {
                                                    $comm_user = $co["username"];
                                                    $comm_komentar = $co["komentar"];

                                                    $comm_pic = $co["picture"];

                                                    if ($comm_pic == null) {
                                                        $comm_pic = "default_image.png";
                                                    }

                                                    $pBln = $co['bln'];
                                                    if ($pBln == "Pebruari") {
                                                        $pBln = "Februari";
                                                    }
                                                ?>
                                                    <div class="d-flex align-items-start mt-3">
                                                        <a class="pe-3" href="#">
                                                            <img src="img/user/<?php echo $comm_pic; ?>" width="36" height="36" class="rounded-circle">
                                                        </a>

                                                        <div class="flex-grow-1">
                                                            <a href="profile.php?id=<?php echo $comm_user; ?>">
                                                                <small><strong><?php echo $comm_user; ?></strong></a>
                                                            <span class="text-muted">
                                                                - <?php echo $co["tgl"] . " " . $pBln . " " . $co["thn"] . " " . $co["jam"]; ?>
                                                            </span>
                                                            </small>
                                                            <?php
                                                            if ($username != NULL) {
                                                            ?>
                                                                <small style="font-size:smaller;" class="btn float-end p-1" data-bs-toggle="modal" data-bs-target="#reportModal<?php echo $co["id"]; ?>"><i class="bi bi-exclamation-circle"></i></small>
                                                            <?php
                                                            }
                                                            ?>

                                                            <!-- Modal Report -->
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="modal fade" id="reportModal<?php echo $co["id"]; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header bg-danger">
                                                                                <h5 class="modal-title text-white" id="exampleModalLabel">Memberikan Laporan</h5>
                                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <input type="hidden" name="reportId" value="<?php echo $co["id"]; ?>">

                                                                                <div class="d-flex align-items-start">
                                                                                    <a class="pe-3" href="#">
                                                                                        <img src="img/user/<?php echo $comm_pic; ?>" width="36" height="36" class="rounded-circle">
                                                                                    </a>

                                                                                    <div class="flex-grow-1">
                                                                                        <a href="profile.php?id=<?php echo $comm_user; ?>">
                                                                                            <small><strong><?php echo $comm_user; ?></strong></a>
                                                                                        <span class="text-muted">
                                                                                            - <?php echo $co["tgl"] . " " . $pBln . " " . $co["thn"] . " " . $co["jam"]; ?>
                                                                                        </span>
                                                                                        </small>
                                                                                        <div class="border text-sm text-dark p-2 mt-1 mb-2" align="justify">
                                                                                            <?php echo $comm_komentar; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="input-group">
                                                                                    <textarea class="form-control" name="reportAlasan" aria-label="With textarea" style="resize: none; height:300px;" placeholder="Berikan alasan...."></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                                                <button class="btn btn-primary" name="btnReport<?php echo $co["id"]; ?>">Buat Laporan</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <!-- Modal Report End -->

                                                            <?php
                                                            $idreport = $co["id"];
                                                            if (isset($_POST["btnReport$idreport"])) {
                                                                include "makeReport.php";
                                                                $alasan = $_POST['reportAlasan'];
                                                                makeReport($username, 'komentar', $idreport, $alasan);
                                                            }

                                                            ?>

                                                            <?php
                                                            if ($co['konfirmasi'] == 'Ya') {
                                                            ?>
                                                                <div class="border text-sm text-dark p-2 mt-1" align="justify">
                                                                    <?php echo $comm_komentar; ?>
                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <div class="alert alert-secondary align-items-center p-1" role="alert">
                                                                    <i class="bi bi-exclamation-triangle-fill ms-2 me-2"></i>Komentar dinonaktifkan
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>

                                                    </div>
                                                <?php
                                                }
                                                ?>
                                                <!-- Komentar END -->

                                                <div class="d-flex align-items-start mt-3">
                                                    <?php
                                                    if ($username == NULL) {
                                                    ?>
                                                        <div class="flex-grow-1">
                                                            <form method="POST">
                                                                <div class="pe-3" href="#">
                                                                </div>
                                                                <div class="border text-sm text-dark p-2 mt-1 text-center">
                                                                    <a href="login.php">Login</a> dahulu untuk memberikan tanggapan
                                                                </div>
                                                            </form>
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    $login = mysqli_query(
                                                        $conn,
                                                        "SELECT * FROM account WHERE username = '$username'"
                                                    );
                                                    while ($row = mysqli_fetch_array($login)) {
                                                        $user_img = $row["photo"];
                                                        if ($user_img == null) {
                                                            $user_img = "default_image.png";
                                                        }
                                                    ?>
                                                        <a class="pe-3" href="#">
                                                            <img src="img/user/<?php echo $user_img ?>" width="36" height="36" class="rounded-circle">
                                                        </a>

                                                        <div class="flex-grow-1">
                                                            <form method="POST">
                                                                <div class="input-group p-0">
                                                                    <input type="text" class="form-control text-sm text-dark p-2 mt-1" name="komentar" aria-describedby="basic-addon1" placeholder="Tulis komentar....">
                                                                    <button class="btn btn-primary ms-2" name="btnKomentar">Kirim</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                </div>
                                            <?php
                                                    }
                                            ?>

                                            </div>
                                        </div>

                                        <hr />
                                        <!-- Akhir Diskusi -->
                                    <?php
                                    }
                                    ?>


                                    <?php

                                    if ($count <= 0) {
                                    ?>
                                        <div class="d-flex align-items-start">
                                            <div class="border text-sm dark mt-1 w-100 fs-4 p-2" align="center">
                                                Data tidak ditemukan
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <!--  -->
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
if (isset($_POST['btnKomentar'])) {

    if ($username == null) {
        echo '<script> location.replace("login.php"); </script>';
    } else {
        $p_comment = $_POST["komentar"];
        $postcomm = mysqli_query($conn, "INSERT INTO komentar VALUES
        (NULL,'$id','$username','$p_comment',NOW(),'Ya')");



        $id_comm = "K" . $id . $username;
        mysqli_query($conn, "INSERT INTO notifikasi VALUES ('$id_comm','$user_post','komentar','baru saja mengomentari diskusi Anda tentang <strong>$judul_post</strong>','$username','$id',NOW(),'tidak')");



        $url = $_SERVER["REQUEST_URI"];
?>
        <script>
            location.replace("refresh.php?url=<?php echo $url; ?>");
        </script>
<?php
    }
}
?>
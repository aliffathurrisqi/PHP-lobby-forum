<?php
session_start();
if ($_SESSION['user_log'] == NULL) {
    echo '<script> location.replace("../login.php"); </script>';
}
$_SESSION['user_log'] = $_SESSION['user_log'];
include "../config.php";
$username = $_SESSION['user_log'];

$akses = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username'");
$datauser = mysqli_fetch_array($akses);
if ($datauser['akses'] != 'admin') {
    echo '<script> location.replace("../index.php"); </script>';
}

?>
<!DOCTYPE html>
<html lang="en">
<?php
include "php/head.php";
?>

<body>
    <div class="wrapper">
        <?php
        include "php/sidebar.php";
        ?>

        <div class="main">
            <?php
            include "php/navbar.php";
            ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>Data</strong> Laporan</h1>
                    <div class="row">
                        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                            <div class="card flex-fill">

                                <table class="table table-hover my-0 table-admin">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="d-none d-xl-table-cell">Tipe</th>
                                            <th class="d-none d-xl-table-cell">Suspect</th>
                                            <th class="d-none d-md-table-cell text-center">Laporan</th>
                                            <th class="d-none d-md-table-cell text-center">Waktu</th>
                                            <th class="d-none d-md-table-cell text-center">Report By</th>
                                            <th class="d-none d-md-table-cell text-center">Diterima</th>
                                            <th class="d-none d-md-table-cell text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $datalaporan = mysqli_query(
                                            $conn,
                                            "SELECT id,tipe_laporan,pelapor,suspect,alasan,
                                            DATE_FORMAT(waktu, '%d') AS tgl,
                                            DATE_FORMAT(waktu, '%M') AS bln,
                                            DATE_FORMAT(waktu, '%Y') AS thn,
                                            DATE_FORMAT(waktu, '%d') AS btgl,
                                            DATE_FORMAT(waktu, '%M') AS bbln,
                                            DATE_FORMAT(waktu, '%Y') AS bthn,
                                            konfirmasi
                                            FROM laporan ORDER BY waktu DESC"
                                        );
                                        while ($data = mysqli_fetch_array($datalaporan)) {
                                            $pBln = $data['bln'];
                                            $bBln = $data['bbln'];
                                            if ($pBln == "Pebruari") {
                                                $pBln = "Februari";
                                            }
                                            if ($bBln == "Pebruari") {
                                                $bpBln = "Februari";
                                            }
                                            $i++;
                                        ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td class="d-none d-xl-table-cell">
                                                    <?php echo $data['tipe_laporan']; ?>
                                                </td>
                                                <td class="text-justify">
                                                    <?php
                                                    if ($data['tipe_laporan'] == "user") {
                                                    ?>
                                                        <a href="../profile.php?id=<?php echo $data['suspect']; ?>"><?php echo $data['suspect']; ?></a>
                                                    <?php
                                                    }
                                                    if ($data['tipe_laporan'] == "post") {
                                                        $judul = $data['suspect'];
                                                        $judul_post = mysqli_query($conn, "SELECT judul FROM post WHERE id = '$judul'");
                                                        $jpost = mysqli_fetch_array($judul_post);
                                                    ?>
                                                        <a href="../discussion.php?id=<?php echo $data['suspect']; ?>"><?php echo $jpost['judul']; ?></a>
                                                    <?php
                                                    }
                                                    if ($data['tipe_laporan'] == "komentar") {
                                                        $id_kom = $data['suspect'];
                                                        $judul_post = mysqli_query($conn, "SELECT komentar.id,komentar.komentar,post.id AS post FROM komentar
                                                        INNER JOIN post ON komentar.id_post = post.id
                                                        WHERE komentar.id = '$id_kom'");
                                                        $jpost = mysqli_fetch_array($judul_post);
                                                    ?>
                                                        <a href="../discussion.php?id=<?php echo $jpost['post']; ?>"><?php echo $jpost['komentar']; ?></a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td class=" text-justify">
                                                    <?php echo $data['alasan']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $data['tgl'] . " " . $pBln . " " . $data['thn']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <a href="../profile.php?id=<?php echo $data['pelapor']; ?>"><?php echo $data['pelapor']; ?></a>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $data['konfirmasi']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <form method="POST">
                                                        <?php
                                                        if ($data['tipe_laporan'] == "user") {
                                                            if ($data['konfirmasi'] == "Tidak") {
                                                        ?>
                                                                <a class="btn btn-danger" href="laporan_pengguna.php?id=<?php echo $data['suspect']; ?>&laporan=<?php echo $data['id']; ?>">
                                                                    Blokir</a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-success" href="kembalikan_laporan_pengguna.php?id=<?php echo $data['suspect']; ?>&laporan=<?php echo $data['id']; ?>">
                                                                    Kembalikan</a>
                                                            <?php
                                                            }
                                                        }
                                                        if ($data['tipe_laporan'] == "post") {
                                                            if ($data['konfirmasi'] == "Tidak") {
                                                            ?>
                                                                <a class="btn btn-danger" href="laporan_post.php?id=<?php echo $data['suspect']; ?>&laporan=<?php echo $data['id']; ?>">
                                                                    Blokir</a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-success" href="kembali_post.php?id=<?php echo $data['suspect']; ?>&laporan=<?php echo $data['id']; ?>">
                                                                    Kembalikan</a>
                                                            <?php
                                                            }
                                                        }
                                                        if ($data['tipe_laporan'] == "komentar") {
                                                            if ($data['konfirmasi'] == "Tidak") {
                                                            ?>
                                                                <a class="btn btn-danger" href="laporan_komentar.php?id=<?php echo $data['suspect']; ?>&laporan=<?php echo $data['id']; ?>">
                                                                    Blokir</a>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <a class="btn btn-success" href="kembalikan_laporan_komentar.php?id=<?php echo $data['suspect']; ?>&laporan=<?php echo $data['id']; ?>">
                                                                    Kembalikan</a>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


                </div>
            </main>

        </div>
    </div>

    <script src="js/app.js"></script>

</body>
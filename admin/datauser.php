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
            $url = $_SERVER["REQUEST_URI"];
            ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <h1 class="h3 mb-3"><strong>Data</strong> User</h1>
                    <div class="row">
                        <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Kategori</a>
                        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                            <div class="card flex-fill">

                                <table class="table table-hover my-0 table-admin">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="d-none d-xl-table-cell">Username</th>
                                            <th class="d-none d-md-table-cell text-center">Diskusi</th>
                                            <th class="d-none d-md-table-cell text-center">Komentar</th>
                                            <th class="d-none d-md-table-cell text-center">Bergabung</th>
                                            <th class="d-none d-md-table-cell text-center">Status</th>
                                            <th class="d-none d-md-table-cell text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $datauser = mysqli_query(
                                            $conn,
                                            "SELECT 
                                            username,dibuat,blokir,akses,
                                            DATE_FORMAT(dibuat, '%d') AS tgl,
                                            DATE_FORMAT(dibuat, '%M') AS bln,
                                            DATE_FORMAT(dibuat, '%Y') AS thn,
                                            DATE_FORMAT(blokir, '%d') AS btgl,
                                            DATE_FORMAT(blokir, '%M') AS bbln,
                                            DATE_FORMAT(blokir, '%Y') AS bthn
                                            FROM account WHERE akses != 'admin' ORDER BY username"
                                        );
                                        while ($data = mysqli_fetch_array($datauser)) {
                                            $pBln = $data['bln'];
                                            $bBln = $data['bbln'];
                                            if ($pBln == "Pebruari") {
                                                $pBln = "Februari";
                                            }
                                            if ($bBln == "Pebruari") {
                                                $bpBln = "Februari";
                                            }
                                            $i++;
                                            $id = $data['username'];
                                            $jmldata = mysqli_query(
                                                $conn,
                                                "SELECT(SELECT COUNT(id) FROM post WHERE username = '$id') AS jmlPost,(SELECT COUNT(id) FROM komentar WHERE username = '$id') AS jmlComm"
                                            );
                                            $dataAll = mysqli_fetch_array($jmldata);
                                        ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td class="d-none d-xl-table-cell">
                                                    <a href="../profile.php?id=<?php echo $data["username"]; ?>">
                                                        <?php echo $data['username'] ?>
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $dataAll['jmlPost']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $dataAll['jmlComm']; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php echo $data['tgl'] . " " . $pBln . " " . $data['thn']; ?>
                                                </td>
                                                <?php
                                                if ($data['akses'] == 'user') {
                                                ?>
                                                    <td class="text-center text-success">
                                                        Aktif
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-danger" href="blokir_user.php?id=<?php echo $data['username']; ?>&url=<?php $url; ?>">Blokir Pengguna</a>
                                                    </td>
                                                <?php
                                                }

                                                if ($data['akses'] == 'blokir') {
                                                ?>
                                                    <td class="text-center text-danger">
                                                        Diblokir<br>
                                                        <?php echo $data['btgl'] . " " . $bBln . " " . $data['bthn']; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a class="btn btn-success" href="aktifkan_user.php?id=<?php echo $data['username']; ?>">Aktifkan Pengguna</a>
                                                    </td>
                                                <?php
                                                }
                                                ?>
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
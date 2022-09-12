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
                    <h1 class="h3 mb-3"><strong>Data</strong> Kategori</h1>
                    <div class="row">
                        <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Kategori</a>
                        <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                            <div class="card flex-fill">
                                <!-- Modal -->
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" name="nama_kategori" aria-describedby="basic-addon1" placeholder="Tuliskan nama kategori">
                                                    </div>
                                                    <div class="input-group mb-3">
                                                        <input name="warna" class="w-100" type="color">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                    <button class="btn btn-primary" name="btnTambah">Simpan Perupahan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- Modal End -->

                                <?php
                                if (isset($_POST["btnTambah"])) {
                                    $nama = $_POST["nama_kategori"];
                                    $warna = $_POST["warna"];
                                    $add = mysqli_query($conn, "INSERT INTO kategori VALUES(NULL,'$nama','$warna')");
                                    echo '<script> location.replace("datakategori.php"); </script>';
                                }
                                ?>

                                <table class="table table-hover my-0 table-admin">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="d-none d-xl-table-cell">Nama Kategori</th>
                                            <th class="d-none d-xl-table-cell text-center">Jumlah Diskusi</th>
                                            <th class="d-none d-md-table-cell text-center">Warna</th>
                                            <th class="d-none d-md-table-cell text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $kategori = mysqli_query(
                                            $conn,
                                            "SELECT * FROM kategori ORDER BY nama_kategori"
                                        );
                                        while ($data = mysqli_fetch_array($kategori)) {
                                            $i++;
                                            $id_kat = $data['id'];
                                            $jmlkategori = mysqli_query(
                                                $conn,
                                                "SELECT COUNT(kategori) AS jmlPost FROM post WHERE kategori = '$id_kat'"
                                            );
                                            $datakat = mysqli_fetch_array($jmlkategori);
                                        ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td class="d-none d-xl-table-cell"><?php echo $data['nama_kategori'] ?></td>
                                                <td class="d-none d-md-table-cell text-center">
                                                    <?php echo $datakat['jmlPost']; ?>
                                                </td>
                                                <td>
                                                    <div class="text-center" style="background-color: <?php echo $data['warna']; ?>;width:100%;height:20px;">

                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $data['id']; ?>">Edit</a>
                                                    <a class="btn btn-danger" href="delete_kategori.php?id=<?php echo $data['id']; ?>">Hapus</a>
                                                </td>
                                            </tr>

                                            <!-- Modal -->
                                            <form method="POST" enctype="multipart/form-data">
                                                <div class="modal fade" id="editModal<?php echo $data['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="input-group mb-3">
                                                                    <input type="hidden" name="id_kategori" value="<?php echo $data['id']; ?>">
                                                                    <input type="text" class="form-control" name="nama_kategori" aria-describedby="basic-addon1" placeholder="Tuliskan nama kategori" value="<?php echo $data['nama_kategori']; ?>">
                                                                </div>
                                                                <div class="input-group mb-3">
                                                                    <input name="warna" class="w-100" type="color" value="<?php echo $data['warna']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                                <button class="btn btn-primary" name="btnEdit<?php echo $data['id']; ?>">Simpan Perupahan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- Modal End -->
                                            <?php
                                            if (isset($_POST["btnEdit" . $data['id']])) {
                                                $id = $_POST["id_kategori"];
                                                $nama = $_POST["nama_kategori"];
                                                $warna = $_POST["warna"];

                                                $edit = mysqli_query($conn, "UPDATE kategori SET nama_kategori = '$nama',warna = '$warna' WHERE id = '$id'");
                                                echo '<script> location.replace("datakategori.php"); </script>';
                                            }
                                            ?>
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
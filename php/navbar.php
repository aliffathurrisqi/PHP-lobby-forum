<nav class="navbar navbar-expand navbar-light navbar-bg">
    <?php
    if ($_SESSION['user_log'] != NULL) {
        $username = $_SESSION['user_log'];
        $akses = mysqli_query($conn, "SELECT akses FROM account WHERE username = '$username'");
        $data = mysqli_fetch_array($akses);
        if ($data['akses'] != 'admin') {
    ?>
            <a class="sidebar-toggle  d-none d-sm-inline-block" href="index.php?search=">
                <div class="align-middle">
                    <img src="img/website/lobby_logos.png" width="100px">
                </div>
            </a>
        <?php
        }
    }
    if ($_SESSION['user_log'] == NULL) {
        ?>
        <a class="sidebar-toggle  d-none d-sm-inline-block" href="index.php?search=">
            <div class="align-middle">
                <img src="img/website/lobby_logos.png" width="100px">
            </div>
        </a>
    <?php
    }
    ?>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <?php
            if ($_SESSION['user_log'] != NULL) {
                $login = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username'");
                //var_dump($login);
                while ($row = mysqli_fetch_array($login)) {
                    $userimg = $row["photo"];

                    if ($userimg == NULL) {
                        $userimg = "default_image.png";
                    }


                    $notifikasi = mysqli_query($conn, "SELECT id,username,sumber,notif,tipe,id_post,
                    DATE_FORMAT(waktu, '%d') AS tgl,DATE_FORMAT(waktu, '%M') AS bln,DATE_FORMAT(waktu, '%Y') AS thn,
              DATE_FORMAT(waktu, '%H:%i WIB') AS jam 
                    FROM notifikasi WHERE username = '$username' AND dibaca = 'Tidak' ORDER BY waktu DESC");
                    $notif = mysqli_num_rows($notifikasi);


            ?>

                    <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                            <div class="position-relative">
                                <i class="align-middle" data-feather="bell"></i>
                                <span class="indicator"><?php echo $notif; ?></span>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                            <div class="dropdown-menu-header">
                                <?php echo $notif; ?> Notifikasi Baru
                            </div>
                            <div class="list-group">
                                <?php
                                while ($notifdata = mysqli_fetch_array($notifikasi)) {
                                    $pBln = $notifdata['bln'];
                                    if ($pBln == "Pebruari") {
                                        $pBln = "Februari";
                                    }
                                ?>
                                    <a href="notifikasi.php?id=<?php echo $notifdata["id"]; ?>&&post=<?php echo $notifdata["id_post"]; ?>" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-2">
                                                <?php
                                                if ($notifdata['tipe'] == 'suka') {
                                                    $jNotif = "Diskusi disukai";
                                                    echo '<i class="bi bi-heart text-danger"></i>';
                                                }
                                                if ($notifdata['tipe'] == 'komentar') {
                                                    echo '<i class="bi bi-chat text-primary"></i>';
                                                    $jNotif = "Komentar Baru";
                                                }
                                                ?>


                                            </div>
                                            <div class="col-10">
                                                <div class="text-dark"><?php echo $jNotif; ?></div>
                                                <div class="text-muted small mt-1"> <?php echo $notifdata['sumber'] . " " . $notifdata['notif']; ?></div>
                                                <div class="text-muted small mt-1"><?php echo $notifdata["tgl"] . " " . $pBln . " " . $notifdata["thn"] . " " . $notifdata["jam"]; ?></div>
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="dropdown-menu-footer">
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <!-- <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" data-bs-toggle="dropdown" style="text-decoration: none;">
                            <img src="img/user/<?php echo $userimg; ?>" class="avatar img-fluid rounded-circle me-1 align-middle" alt="<?php echo $row["username"]; ?>" />
                            <small class="d-inline-block d-sm-none fs-5"><?php echo $row["username"]; ?></small>
                        </a> -->

                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" data-bs-toggle="dropdown">
                            <img src="img/user/<?php echo $userimg; ?>" class="avatar img-fluid rounded-circle  me-1" alt="<?php echo $row["username"]; ?>" /> <span class="text-dark"><?php echo $row["username"]; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="profile.php?id=<?php echo $username; ?>"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST">
                                <button class="dropdown-item" name="btnLogout">Logout</button>
                                <?php
                                if (isset($_POST["btnLogout"])) {
                                    session_destroy();
                                    session_start();
                                    $_SESSION['user_log'] = NULL;
                                    echo '<script> location.replace("index.php?search="); </script>';
                                }
                                ?>
                            </form>
                        </div>
                    </li>
                <?php
                }
            } else {
                ?>
                <li class="nav-item dropdown">
                    <!-- <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="login.php" style="text-decoration: none;">
                        <i class="bi bi-person align-middle fs-4"></i>
                        <small class="d-inline-block d-sm-none fs-6">Login</small>
                    </a> -->

                    <a class=" nav-link d-none d-sm-inline-block" href="login.php">
                        <i class="bi bi-person align-middle fs-4"></i> Login
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>

<!-- Navbar Mobile -->

<nav class="navbar navbar-light bg-white border-top navbar-expand d-md-none d-lg-none d-xl-none fixed-top mb-0" style="background-color: white;">
    <a class="sidebar-toggle  d-md-none d-lg-none d-xl-none" href="index.php?search=">
        <div class="align-middle">
            <img src="img/website/lobby_logos.png" width="100px">
        </div>
    </a>

    <div class="navbar-mobile navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <?php
            if ($_SESSION['user_log'] != NULL) {
                $username = $_SESSION['user_log'];
                $akses = mysqli_query($conn, "SELECT akses FROM account WHERE username = '$username'");
                $data = mysqli_fetch_array($akses);

                $login = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username'");
                //var_dump($login);
                while ($row = mysqli_fetch_array($login)) {
                    $userimg = $row["photo"];

                    if ($userimg == NULL) {
                        $userimg = "default_image.png";
                    }

                    $notifikasi = mysqli_query($conn, "SELECT id,username,sumber,notif,tipe,id_post,
                    DATE_FORMAT(waktu, '%d') AS tgl,DATE_FORMAT(waktu, '%M') AS bln,DATE_FORMAT(waktu, '%Y') AS thn,
              DATE_FORMAT(waktu, '%H:%i WIB') AS jam 
                    FROM notifikasi WHERE username = '$username' AND dibaca = 'Tidak' ORDER BY waktu DESC");
                    $notif = mysqli_num_rows($notifikasi);
            ?>

                    <li class="nav-item dropdown me-1">
                        <a class="nav-icon" href="index.php">
                            <div class="position-relative">
                                <i class="bi bi-house-door-fill"></i>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item dropdown me-2">
                        <a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
                            <div class="position-relative">
                                <i class="align-middle" data-feather="bell"></i>
                                <small><span class="indicator"><?php echo $notif; ?></span></small>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="alertsDropdown">
                            <div class="dropdown-menu-header p-0">
                                <small> <?php echo $notif; ?> Notifikasi Baru</small>
                            </div>
                            <div class="list-group">
                                <?php
                                while ($notifdata = mysqli_fetch_array($notifikasi)) {
                                    $pBln = $notifdata['bln'];
                                    if ($pBln == "Pebruari") {
                                        $pBln = "Februari";
                                    }
                                ?>
                                    <a href="notifikasi.php?id=<?php echo $notifdata["id"]; ?>&&post=<?php echo $notifdata["id_post"]; ?>" class="list-group-item">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-1">
                                                <?php
                                                if ($notifdata['tipe'] == 'suka') {
                                                    $jNotif = "Diskusi disukai";
                                                    echo '<small><i class="bi bi-heart text-danger"></i></small>';
                                                }
                                                if ($notifdata['tipe'] == 'komentar') {
                                                    echo '<small><i class="bi bi-chat text-primary"></i></small>';
                                                    $jNotif = "Komentar Baru";
                                                }
                                                ?>


                                            </div>
                                            <div class="col-11">
                                                <div class="text-dark"><small><?php echo $jNotif; ?></small></div>
                                                <div class="text-muted small mt-1"><small> <?php echo $notifdata['sumber'] . " " . $notifdata['notif']; ?></small></div>
                                                <div class="text-muted small mt-1"><small><?php echo $notifdata["tgl"] . " " . $pBln . " " . $notifdata["thn"] . " " . $notifdata["jam"]; ?></small></div>
                                            </div>
                                        </div>
                                    </a>
                                <?php
                                }
                                ?>

                            </div>
                            <div class="dropdown-menu-footer">
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" data-bs-toggle="dropdown" style="text-decoration: none;">
                            <img src="img/user/<?php echo $userimg; ?>" class="avatar img-fluid rounded-circle me-1 align-middle" alt="<?php echo $row["username"]; ?>" />
                            <small class="d-inline-block d-sm-none fs-5"></small>
                        </a>

                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" data-bs-toggle="dropdown">
                            <img src="img/user/<?php echo $userimg; ?>" class="avatar img-fluid rounded-circle me-1" alt="<?php echo $row["username"]; ?>" /> <span class="text-dark"><?php echo $row["username"]; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="profile.php?id=<?php echo $username; ?>"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST">
                                <button class="dropdown-item" name="btnLogout">Logout</button>
                                <?php
                                if (isset($_POST["btnLogout"])) {
                                    session_destroy();
                                    session_start();
                                    $_SESSION['user_log'] = NULL;
                                    echo '<script> location.replace("index.php?search="); </script>';
                                }
                                ?>
                            </form>
                        </div>
                    </li>
                <?php
                }
            } else {
                ?>
                <li class="nav-item dropdown me-1">
                    <a class="nav-icon" href="login.php">
                        <div class="position-relative">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                    </a>
                </li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>

<!--  -->
<!--  -->
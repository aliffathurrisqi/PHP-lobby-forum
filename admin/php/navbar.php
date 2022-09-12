<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle  d-md-none d-lg-none d-xl-none" href="index.php?search=">
        <div class="align-middle">
            <img src="img/website/lobby_logos.png" width="100px">
        </div>
    </a>

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
            ?>
                    <li class="nav-item dropdown">
                        <!-- <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" data-bs-toggle="dropdown" style="text-decoration: none;">
                            <img src="img/user/<?php echo $userimg; ?>" class="avatar img-fluid rounded-circle me-1 align-middle" alt="<?php echo $row["username"]; ?>" />
                            <small class="d-inline-block d-sm-none fs-5"><?php echo $row["username"]; ?></small>
                        </a> -->

                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" data-bs-toggle="dropdown">
                            <img src="img/user/<?php echo $userimg; ?>" class="avatar img-fluid rounded-circle  me-1" alt="<?php echo $row["username"]; ?>" /> <span class="text-dark"><?php echo $row["username"]; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="../profile.php?id=<?php echo $username; ?>"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST">
                                <button class="dropdown-item" name="btnLogout">Logout</button>
                                <?php
                                if (isset($_POST["btnLogout"])) {
                                    session_destroy();
                                    session_start();
                                    $_SESSION['user_log'] = NULL;
                                    echo '<script> location.replace("../login.php"); </script>';
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

                    <a class=" nav-link d-none d-sm-inline-block" href="../login.php">
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
            ?>
                    <li class="nav-item dropdown">
                        <!-- <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" data-bs-toggle="dropdown" style="text-decoration: none;">
                            <img src="img/user/<?php echo $userimg; ?>" class="avatar img-fluid rounded-circle me-1 align-middle" alt="<?php echo $row["username"]; ?>" />
                            <small class="d-inline-block d-sm-none fs-5"><?php echo $row["username"]; ?></small>
                        </a> -->

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

<!--  -->

<!-- Bottom Navbar -->
<nav class="navbar navbar-light bg-white border-top navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom mb-0" style="background-color: white;">
    <ul class="navbar-nav nav-justified w-100">
        <li class="nav-item">
            <div class="btn-group dropup align-middle">
                <a class="nav-link " data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration:none;">
                    <i class="bi bi bi-grid text-dark fs-1"></i><br>
                    <small>Menu</small>
                </a>
                <ul class="dropdown-menu w-100 align-end">
                    <li>
                        <a class="dropdown-item" href="index.php?search=">
                            <i class="bi bi-bar-chart-line align-middle fs-4"></i><span class="align-middle ms-1">Statistik</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="datauser.php">
                            <i class="bi bi-person align-middle fs-4"></i><span class="align-middle ms-1">User</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="datakategori.php">
                            <i class="bi bi-tag align-middle fs-4"></i><span class="align-middle ms-1">Kategori</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="laporan.php">
                            <i class="bi bi-exclamation-circle align-middle fs-4"></i><span class="align-middle ms-1">Laporan</span>
                        </a>
                    </li>
                    <div class="dropdown-divider"></div>
                    <li>
                        <a class="dropdown-item" href="../index.php?search=">
                            <i class="bi bi-globe align-middle fs-4"></i><span class="align-middle ms-1">Lihat Website</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <?php
            if ($username != NULL) {
            ?>
                <a class="nav-link" style="text-decoration:none;" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-chat-dots text-dark fs-1"></i>
                    <br>
                    <small>Tulis Diskusi</small>
                </a>
            <?php
            } else {
            ?>
                <a class="nav-link" style="text-decoration:none;" href="login.php">
                    <i class="bi bi-chat-dots text-dark fs-1"></i>
                    <br>
                    <small>Tulis Diskusi</small>
                </a>
            <?php
            }
            ?>
        </li>
        <li class="nav-item">
            <?php
            if ($_SESSION['user_log'] != NULL) {
                $login = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username'");
                //var_dump($login);
                while ($row = mysqli_fetch_array($login)) {
                    $userimg = $row["photo"];

                    if ($userimg == NULL) {
                        $userimg = "default_image.png";
                    }
            ?>
                    <div class="btn-group dropup align-middle">
                        <a class="nav-link " data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration:none;">
                            <img height="34px" src="img/user/<?php echo $userimg; ?>" class="rounded-circle mb-1 mt-1" alt="<?php echo $row["username"]; ?>" />
                            <br>
                            <small><?php echo $row["username"]; ?></small>
                        </a>
                        <ul class="dropdown-menu w-100 align-end">
                            <li>
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
                            </li>
                        </ul>
                    </div>
                <?php
                }
            } else {
                ?>
                <a href="login.php" class="nav-link" style="text-decoration:none;">
                    <i class="bi bi-person-circle text-dark fs-1"></i>
                    <br>
                    <small>login</small>
                </a>
            <?php
            }
            ?>
        </li>
    </ul>
</nav>
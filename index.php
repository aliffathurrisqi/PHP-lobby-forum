<?php
session_start();
$_SESSION['user_log'] = $_SESSION['user_log'];

include "config.php";
$username = NULL;
if (isset($_GET['username'])) {
	$userLog = $_GET["username"];
	$loginStatus = mysqli_query($conn, "SELECT username,email FROM account 
	WHERE username = '$userLog' OR email = '$userLog'");
	$data = mysqli_fetch_array($loginStatus);
	$_SESSION['user_log'] = $data['username'];
	$username = $_SESSION['user_log'];
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
		$url = $_SERVER["REQUEST_URI"];

		if ($_SESSION['user_log'] != NULL) {
			$username = $_SESSION['user_log'];
			$akses = mysqli_query($conn, "SELECT akses FROM account WHERE username = '$username'");
			$data = mysqli_fetch_array($akses);
			if ($data['akses'] == 'admin') {
				include "php/sidebar.php";
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
				if ($data['akses'] == 'blokir') {
					echo '<script> location.replace("login.php"); </script>';
				}
			} else {
				include "php/navbar.php";
			}

			?>

			<main class="content">
				<div class="container-fluid p-0 mb-7">
					<div class="row">
						<div class="col-md-8 col-xl-9">

							<?php
							if ($username != NULL) {

								$login = mysqli_query($conn, "SELECT * FROM account WHERE username = '$username'");
								//var_dump($login);
								while ($row = mysqli_fetch_array($login)) {
									$userimg = $row["photo"];

									if ($userimg == NULL) {
										$userimg = "default_image.png";
									}
								}
							?>

								<form method="POST">

									<div class="card">
										<div class="card-body">
											<div class="d-flex align-items-start mb-3">
												<img src="img/user/<?php echo $userimg; ?>" width="36" height="36" class="rounded-circle me-2" alt="<?php echo $row['username']; ?>">
												<div class="flex-grow-1">
													<div class="input-group mb-3">
														<input type="text" class="form-control" name="p_judul" aria-describedby="basic-addon1" placeholder="Judul Diskusi">
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
													<div class="text-sm dark mb-3" align="justify">

														<div class="input-group">
															<textarea class="form-control" name="p_konten" aria-label="With textarea" style="resize: none; height:100px;" placeholder="Tulis diskusi disini...."></textarea>
														</div>

													</div>
													<button class="btn btn-primary w-100" name="btnPost">Publikasikan</button>
												</div>
											</div>
										</div>
									</div>

								</form>
								<?php

								if (isset($_POST["btnPost"])) {

									$p_judul = $_POST["p_judul"];
									$p_konten = $_POST["p_konten"];
									$p_kategori = $_POST["p_kategori"];

									$post = mysqli_query(
										$conn,
										"INSERT INTO post VALUES(NULL,'$username',NOW(),'$p_konten','$p_kategori','$p_judul')"
									);
									echo '<script> location.replace("index.php"); </script>';
								}
							} else {
								?>
								<a href="login.php" class="btn btn-primary w-100 d-none d-sm-inline-block mb-3">Tulis Diskusi</a><br>
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
							<?php
							if (isset($_POST["btnPost"])) {

								$p_judul = $_POST["p_judul"];
								$p_konten = $_POST["p_konten"];
								$p_kategori = $_POST["p_kategori"];

								$post = mysqli_query(
									$conn,
									"INSERT INTO post VALUES(NULL,'$username',NOW(),'$p_konten','$p_kategori','$p_judul','Ya')"
								);
								echo '<script> location.replace("index.php"); </script>';
							}

							?>
							<!-- Awal Diskusi -->
							<?php

							if (isset($_GET['search'])) {
								$search = $_GET['search'];
							} else {
								$search = "";
							}

							$sql_query = "SELECT post.id,post.judul,post.konten,post.username,post.kategori,
              DATE_FORMAT(waktu, '%d') AS tgl,DATE_FORMAT(waktu, '%M') AS bln,DATE_FORMAT(waktu, '%Y') AS thn,
              DATE_FORMAT(waktu, '%H:%i WIB') AS jam, post.konfirmasi
              FROM post INNER JOIN kategori ON post.kategori = kategori.id
              WHERE post.kategori !='1' AND post.judul LIKE '%" . $search . "%' OR kategori.nama_kategori LIKE '%" . $search . "%'
              ORDER BY post.id DESC";

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
								$jumlahkomen = mysqli_query($conn, "SELECT COUNT(id_post) AS jumlah_komentar FROM komentar WHERE id_post = '$id_post'");
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
											<img src="img/user/<?php echo $data_photo; ?>" width="36" height="36" class="rounded-circle me-2" alt="<?php echo $row['username']; ?>">
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
													- <a href="index.php?search=<?php echo $data_kategori; ?>" style="color:<?php echo $data_warna; ?>;"><?php echo $data_kategori; ?></a>
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
								<div class="card mb-2">
									<div class="card-body">
										<div class="d-flex align-items-start">
											<div class="border text-sm dark mt-1 w-100 fs-4 p-2" align="center">
												Data tidak ditemukan
											</div>
										</div>
									</div>
								</div>
							<?php
							}
							?>
							<center>
								<?php
								for ($page = 1; $page <= $number_of_page; $page++) {
									echo '<a class="btn btn-primary me-2 mb-3 mt-0" href = "index.php?search=' . $search . '&&page=' . $page . '">' . $page . ' </a>';
								}
								?>
							</center>
							<!-- </div>
							</div> -->
						</div>

						<!--  -->
						<?php
						$statistik = mysqli_query(
							$conn,
							"SELECT (SELECT COUNT(username) FROM account) AS jmlUser,(SELECT COUNT(id) FROM post WHERE kategori !=1) AS jmlPost,(SELECT COUNT(id) FROM komentar) AS jmlKomentar"
						);
						while ($stat = mysqli_fetch_array($statistik)) {
							$dat_post = $stat["jmlPost"];
							$dat_comm = $stat["jmlKomentar"];
							$dat_user = $stat["jmlUser"];
						}

						?>

						<div class="col-md-4 col-xl-3">
							<div class="card mb-3">
								<div class="card-body">
									<h5 class="h6 card-title">Kategori</h5>
									<ul class="list-unstyled mb-0">

										<a class="btn mb-1 p-1 text-light" href="index.php?search=" style="background-color:black;">
											Semua
										</a>

										<?php
										$s_kategori = mysqli_query($conn, "SELECT * FROM kategori WHERE id !=1");
										while ($row = mysqli_fetch_array($s_kategori)) {
											$search = $row['nama_kategori'];
										?>

											<a class="btn mb-1 p-1 text-light" href="index.php?search=<?php echo $search; ?>" style="background-color:<?php echo $row['warna']; ?>;">
												<?php echo $row['nama_kategori']; ?>
											</a>

										<?php
										}
										?>
									</ul>
								</div>
							</div>
							<div class="card mb-3">
								<div class="card-body">
									<h5 class="h6 card-title">Statistik Forum</h5>
									<ul class="list-unstyled mb-0">
										<li class="mb-1"><i class="bi bi-person"></i> <?php echo $dat_user ?> User</li>
										<li class="mb-1"><i class="bi bi-chat"></i> <?php echo $dat_post; ?> Diskusi</li>
										<li class="mb-1"><i class="bi bi-chat-dots"></i></i> <?php echo $dat_comm ?> Komentar</li>
									</ul>
								</div>
							</div>
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
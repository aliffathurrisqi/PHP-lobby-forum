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
										<?php

										if (isset($_POST["btnMasuk"])) {
											$login_username = $_POST['username'];
											$login_password = $_POST['password'];

											$login = mysqli_query($conn, "SELECT * FROM account WHERE username = '$login_username' OR email = '$login_username'");
											$count = mysqli_num_rows($login);
											if ($count == 1) {
												while ($row = mysqli_fetch_array($login)) {
													if (($login_username == $row['username'] || $login_username == $row['email']) && md5($login_password) == $row['password']) {
														if ($row['verifikasi'] == "Belum") {
										?>
															<div class="alert alert-secondary align-items-center" role="alert">
																<i class="bi bi-exclamation-triangle-fill me-2"></i> Maaf akun anda belum diverifikasi melalui email
															</div>

															<?php
														} else {
															if ($row['akses'] == "user") {
																$_SESSION['user_log'] = $row['username'];
																echo '<script> location.replace("index.php?search="); </script>';
															}
															if ($row['akses'] == "admin") {
																$_SESSION['user_log'] = $row['username'];
																echo '<script> location.replace("admin/"); </script>';
															}
															if ($row['akses'] == "blokir") {
															?>

																<div class="alert alert-secondary align-items-center" role="alert">
																	<i class="bi bi-exclamation-triangle-fill me-2"></i> Maaf akun anda telah dinonaktifkan
																</div>

														<?php
															}
														}
													} else {
														?>
														<div class="alert alert-danger align-items-center" role="alert">
															<i class="bi bi-exclamation-triangle-fill me-2"></i> Username dan Password tidak cocok
														</div>
												<?php
													}
												}
											} else {
												?>
												<div class="alert alert-danger align-items-center" role="alert">
													<i class="bi bi-exclamation-triangle-fill me-2"></i> Username tidak ditemukan
												</div>
										<?php
											}
										}
										?>
									</div>
									<form method="POST">
										<div class="mb-3">
											<label class="form-label">Username atau Email</label>
											<input class="form-control form-control-lg" type="text" name="username" placeholder="Masukkan username atau email" />
										</div>
										<div class="mb-3">
											<label class="form-label">Password</label>
											<input class="form-control form-control-lg" type="password" name="password" placeholder="Masukkan password" />
										</div>
										<div class="text-center">

											lupa password ?<a href="forgot_response.php"> ubah disini</a>

										</div>
										<hr>
										<div class="text-center mt-3">
											<button class="btn btn-lg btn-primary w-100 mb-2" name="btnMasuk">Masuk</button>
											<a class="btn btn-lg btn-danger w-100" href="signup.php">Daftar</a>
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
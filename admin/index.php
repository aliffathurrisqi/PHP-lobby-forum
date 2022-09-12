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

			$statistik = mysqli_query(
				$conn,
				"SELECT (SELECT COUNT(username) FROM account) AS jmlUser,
				(SELECT COUNT(id) FROM post WHERE kategori !=1) AS jmlPost,
				(SELECT COUNT(id) FROM komentar) AS jmlKomentar,
				(SELECT COUNT(username) FROM account WHERE DATE(dibuat) > (NOW() - INTERVAL 1 MONTH)) AS userBaru,
				(SELECT COUNT(username) FROM account WHERE akses = 'blokir') AS userBlokTotal,
				(SELECT COUNT(username) FROM account WHERE akses = 'blokir' AND DATE(blokir) > (NOW() - INTERVAL 1 MONTH)) AS userBlokir,
				(SELECT COUNT(id) FROM post WHERE DATE(waktu) > (NOW() - INTERVAL 1 MONTH)) AS postBaru,
				(SELECT COUNT(id) FROM komentar WHERE DATE(waktu) > (NOW() - INTERVAL 1 MONTH)) AS commBaru"
			);
			$stat = mysqli_fetch_array($statistik);
			$dat_post = $stat["jmlPost"];
			$dat_postBaru = $stat["postBaru"];
			$dat_comm = $stat["jmlKomentar"];
			$dat_commBaru = $stat["commBaru"];
			$dat_user = $stat["jmlUser"];
			$dat_userBaru = $stat["userBaru"];
			$dat_userBlokTotal = $stat["userBlokTotal"];
			$dat_userBlok = $stat["userBlokir"];

			?>
			<main class="content">
				<div class="container-fluid p-0 mb-5">
					<h1 class="h3 mb-3"><strong>Statistik</strong> Forum</h1>
					<div class="row mb-5">
						<div class="col-xl-12 col-xxl-5 d-flex">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Jumlah Pengguna</h5>
													</div>
													<div class="col-auto">
														<div class="stat text-primary">
															<i class="bi bi-people fs-3"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?php echo $dat_user; ?></h1>
												<div class="mb-0">
													<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i><strong><?php echo $dat_userBaru; ?> Pengguna Baru</strong></span>
													<span class="text-muted"> bulan ini</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Pengguna Diblokir</h5>
													</div>

													<div class="col-auto">
														<div class="stat text-primary">
															<i class="bi bi-person-x fs-3"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?php echo $dat_userBlokTotal; ?></h1>
												<div class="mb-0">
													<span class="text-danger"> <i class="mdi mdi-arrow-bottom-right"></i> <strong><?php echo $dat_userBlok; ?> Pengguna Diblokir</strong></span>
													<span class="text-muted">bulan ini</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Jumlah Diskusi</h5>
													</div>
													<div class="col-auto">
														<div class="stat text-primary">
															<i class="bi bi-chat fs-3"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?php echo $dat_post; ?></h1>
												<div class="mb-0">
													<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i><strong><?php echo $dat_postBaru; ?> Diskusi</strong></span>
													<span class="text-muted">bulan ini</span>
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h5 class="card-title">Jumlah Komentar</h5>
													</div>
													<div class="col-auto">
														<div class="stat text-primary">
															<i class="bi bi-chat-dots fs-3"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3"><?php echo $dat_comm; ?></h1>
												<div class="mb-0">
													<span class="text-success"> <i class="mdi mdi-arrow-bottom-right"></i><strong><?php echo $dat_commBaru; ?> Komentar</strong></span>
													<span class="text-muted">bulan ini</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>


				</div>
			</main>


		</div>
	</div>

	<script src="js/app.js"></script>

</body>
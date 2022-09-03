<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Model Pembelajaran | Entrepreneurship</title>

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('assets/dist') ?>/css/adminlte.min.css">

	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/select2/css/select2.min.css">

	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/select2-bootstrap4-theme/select2-bootstrap4.min.css">

	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
</head>

<body class="hold-transition layout-top-nav">
	<div class="wrapper">

		<!-- Navbar -->
		<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
			<div class="container">
				<a href="<?= base_url('/') ?>" class="navbar-brand">
					<img src="<?= base_url('assets') ?>/dist/img/kemdikbud.jpg" alt="AdminLTE Logo" class="brand-image" style="opacity: .8; width:100px; height:60px">
					<span class="brand-text font-weight-light">Model Pembelajaran Entrepreneurship</span>
				</a>

				<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<!-- Right navbar links -->
				<ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
					<li class="nav-item mr-2">
						<button class="btn btn-sm btn-primary" id="btn_login">Login</button>
					</li>
					<li class="nav-item">
						<div class="dropdown open">
							<button class="btn btn-sm btn-primary dropdown-toggle " type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								Registrasi
							</button>
							<div class="dropdown-menu" aria-labelledby="triggerId">
								<button class="dropdown-item" id="perti">Perguruan Tinggi</button>
								<button class="dropdown-item" id="mahasiswa">Mahasiswa</button>
								<button class="dropdown-item" id="masyarakat">Masyarakat</button>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</nav>
		<!-- /.navbar -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container">
					<div class="row mb-2">
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->

			<!-- Main content -->
			<div class="content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="card card-outline card-primary">
								<div class="card-body">
									<h3 class="display-6 text-center">Cari Perguruan Tinggi</h3>
									<div class="row">
										<div class="col-md-8 offset-md-2">
											<form action="#">
												<div class="input-group">
													<input type="search" class="form-control form-control-lg" placeholder="Type your keywords here">
													<div class="input-group-append">
														<button type="submit" class="btn btn-lg btn-default">
															<i class="fa fa-search"></i>
														</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-outline card-primary">
								<div class="card-header">
									Narasi pengenalan model pembelajaran Entrepreneurship yang diinput oleh super admin model
									pembelajaran entrepreneurship
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
										<button type="button" class="btn btn-tool" data-card-widget="remove">
											<i class="fas fa-times"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<h4 class="card-title">Title</h4>
									<p class="card-text">Card Text</p>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-outline card-primary">
								<div class="card-header">
									<h3 class="card-title">Dokumentasi kegiatan wirausaha mahasiswa di luar kampus</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
										<button type="button" class="btn btn-tool" data-card-widget="remove">
											<i class="fas fa-times"></i>
										</button>
									</div>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-sm-4">
											<div class="position-relative bg-gray p-3" style="height: 180px">
												<div class="ribbon-wrapper">
													<div class="ribbon bg-primary">
														Ribbon
													</div>
												</div>
												Ribbon Default <br />
												<small>.ribbon-wrapper.ribbon-lg .ribbon</small>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="position-relative bg-gray p-3" style="height: 180px">
												<div class="ribbon-wrapper ribbon-lg">
													<div class="ribbon bg-info">
														Ribbon Large
													</div>
												</div>
												Ribbon Large <br />
												<small>.ribbon-wrapper.ribbon-lg .ribbon</small>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="position-relative bg-gray p-3" style="height: 180px">
												<div class="ribbon-wrapper ribbon-xl">
													<div class="ribbon bg-secondary">
														Ribbon Extra Large
													</div>
												</div>
												Ribbon Extra Large <br />
												<small>.ribbon-wrapper.ribbon-xl .ribbon</small>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card card-outline card-primary">
								<div class="card-header">
									<h3 class="card-title">Area Chart</h3>
									<div class="card-tools">
										<button type="button" class="btn btn-tool" data-card-widget="collapse">
											<i class="fas fa-minus"></i>
										</button>
										<button type="button" class="btn btn-tool" data-card-widget="remove">
											<i class="fas fa-times"></i>
										</button>
									</div>
								</div>
								<div class="card-body">
									<div class="chart">
										<canvas class="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>

			<!-- Modal -->
			<!-- <div class="modal fade myModal" id="modal_sm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
				<div class="modal-dialog modal_sm" role="document">
				</div>
			</div>

			<div class="modal fade myModal" id="modal_lg" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
				</div>
			</div> -->

			<div id="myModal" class="modal myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content card-outline card-primary"></div>
				</div>
			</div>
		</div>
	</div>
	</div>
	<!-- /.content -->
	</div>

	<!-- Main Footer -->
	<footer class="main-footer">
		<!-- To the right -->
		<div class="float-right d-none d-sm-inline">
			@Makrani 2022.
		</div>
		<!-- Default to the left -->
		<strong>Model Pembelajaran Entrepreneurship.</strong>
	</footer>
	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->

	<script src="<?= base_url('assets/plugins') ?>/jquery/jquery.min.js"></script>

	<script src="<?= base_url('assets/plugins') ?>/sweetalert2/sweetalert2.all.min.js"></script>

	<script src="<?= base_url('assets/plugins') ?>/select2/js/select2.full.min.js"></script>

	<!-- Bootstrap 4 -->
	<script src="<?= base_url('assets/plugins') ?>/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url('assets/dist') ?>/js/adminlte.min.js"></script>

	<script>
		function regionSelect2(params) {
			$('.provinsi').select2({
				theme: "bootstrap4",
				dropdownParent: $(".myModal"),
				placeholder: 'Pilih Provinsi',
				ajax: {
					type: "POST",
					url: '<?= site_url('RegionController/provinsi') ?>',
					dataType: 'json',
					delay: 250,
					data: function(params) {
						return {
							search: params.term
						}
					},
					processResults: function(response) {
						return {
							results: response
						};
					},
					cache: true
				}
			}).on('select2:select', function(evt) {
				var provID = $(".provinsi option:selected").val();
				$('.kabupaten').removeAttr('disabled')

				$('.kabupaten').select2({
					theme: "bootstrap4",
					dropdownParent: $(".myModal"),
					placeholder: 'Pilih Kabupaten',
					ajax: {
						type: "POST",
						url: '<?= site_url('RegionController/kabupaten') ?>',
						dataType: 'json',
						delay: 250,
						data: function(params) {
							return {
								provID: provID,
								search: params.term
							}
						},
						processResults: function(response) {
							return {
								results: response
							};
						},
						cache: true
					}
				}).on('select2:select', function(evt) {
					var kabID = $(".kabupaten option:selected").val();
					$('.kecamatan').removeAttr('disabled')

					$('.kecamatan').select2({
						theme: "bootstrap4",
						dropdownParent: $(".myModal"),
						placeholder: 'Pilih Kecamatan',
						ajax: {
							type: "POST",
							url: '<?= site_url('RegionController/kecamatan') ?>',
							dataType: 'json',
							delay: 250,
							data: function(params) {
								return {
									kabID: kabID,
									search: params.term
								}
							},
							processResults: function(response) {
								return {
									results: response
								};
							},
							cache: true
						}
					})
				});
			});
		}

		$(document).ready(function() {
			$('#btn_login').on('click', function(e) {
				e.preventDefault()
				$('.modal-dialog').removeClass('modal-xl');
				$('.modal-dialog').addClass('modal-xxl');
				$('.modal-content').load('<?= site_url('AuthController/login') ?>');
				$('#myModal').modal({
					backdrop: 'static',
					keyboard: false
				});
			});

			$('#perti').on('click', function(e) {
				e.preventDefault()
				$('.modal-dialog').removeClass('modal-xxl');
				$('.modal-dialog').addClass('modal-xl');
				$('.modal-content').load('<?= site_url('AuthController/register_perti') ?>');
				$('#myModal').modal({
					backdrop: 'static',
					keyboard: false
				});
			});

			$('#mahasiswa').on('click', function(e) {
				e.preventDefault()
				$('.modal-dialog').removeClass('modal-xxl');
				$('.modal-dialog').addClass('modal-xl');
				$('.modal-content').load('<?= site_url('AuthController/register_mhs') ?>');
				$('#myModal').modal({
					backdrop: 'static',
					keyboard: false
				});
			});

			$('#masyarakat').on('click', function(e) {
				e.preventDefault()
				$('.modal-dialog').removeClass('modal-xxl');
				$('.modal-dialog').addClass('modal-xl');
				$('.modal-content').load('<?= site_url('AuthController/register_msyr') ?>');
				$('#myModal').modal({
					backdrop: 'static',
					keyboard: false
				});
			});
		});
	</script>
</body>

</html>
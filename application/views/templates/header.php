<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Model Pembelajaran Entrepreneurship</title>

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/fontawesome-free/css/all.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?= base_url('assets/dist') ?>/css/adminlte.min.css">

	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/select2/css/select2.min.css">

	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/select2-bootstrap4-theme/select2-bootstrap4.min.css">

	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/datatables-select/css/select.bootstrap4.css">

	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/datatables-bs4/css/dataTables.bootstrap4.min.css">

	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/select2-bootstrap4-theme/select2-bootstrap4.min.css">

	<link rel="stylesheet" href="<?= base_url('assets/plugins') ?>/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

</head>

<body class="hold-transition sidebar-mini sidebar-collapse">
	<div class="wrapper">

		<!-- Navbar -->
		<?php if ($_SESSION['id_role'] != 'Superadmin') { ?>
			<nav class="main-header navbar navbar-expand navbar-light elevation-1">
				<ul class="navbar-nav">
					<div class="elevation-1 p-2">
						<img class="image" style="width: 120px; height:100px" src="<?= base_url('assets') ?>/dist/img/kemdikbud.jpg">
					</div>
				</ul>

				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<h2 class="nav-link">Model Pembelajaran Entrepreneurship</h2>
					</li>
				</ul>

				<ul class="navbar-nav ml-auto">
					<?php if ($_SESSION['id_role'] != 'Dosen' and $_SESSION['id_role'] != 'Masyarakat') { ?>
						<li class="nav-item dropdown mr-3">
							<a class="nav-link" data-toggle="dropdown" href="#">
								<i class="far fa-comments"></i>
								<span class="badge badge-danger navbar-badge count_notif"></span>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-left" style="margin-top: -120px; margin-right: 50px;">
								<div class="nontifikasi"></div>
								<div class="dropdown-divider"></div>
								<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
							</div>
						</li>
					<?php } ?>

					<div class="elevation-1 p-2">
						<img class="image" style="width: 120px; height:100px" src="<?= base_url('uploads/') . $_SESSION['userfile'] ?>">
					</div>
				</ul>
			</nav>
		<?php } else { ?>
			<nav class="main-header navbar navbar-expand navbar-light elevation-1">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>

					<?php if ($_SESSION['id_role'] != 'Dosen' and $_SESSION['id_role'] != 'Masyarakat') { ?>
						<li class="nav-item dropdown">
							<a class="nav-link" data-toggle="dropdown" href="#">
								<i class="far fa-comments"></i>
								<span class="badge badge-danger navbar-badge count_notif"></span>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-left">
								<div class="nontifikasi"></div>
								<div class="dropdown-divider"></div>
								<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
							</div>
						</li>
					<?php } ?>

					<li class="nav-item">
						<h5 class="nav-link">Model Pembelajaran Entrepreneurship</h5>
					</li>
				</ul>

				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">
						<a href="<?= site_url('AuthController/logout') ?>" class="btn btn-sm btn-primary" id="logout"><i class="fa fa-power-off"></i> Logout</a>
					</li>
				</ul>
			</nav>
		<?php } ?>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<aside class="main-sidebar sidebar-light-primary elevation-2">
			<div class="sidebar mt-4">
				<div class="user-panel d-flex pb-3">
					<div class="image">
						<img src="<?= base_url('uploads/') . $_SESSION['userfile'] ?>" class="img-circle elevation-2" style="height:30px">
					</div>
					<div class="info">
						<a href="<?= site_url('ProfileController/index/' . $_SESSION['id_user']) ?>" class="d-block"><b><?= $_SESSION['username'] ?></b></a></a>
					</div>
				</div>

				<nav class="mt-2">
					<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

						<?php if ($_SESSION['id_role'] == 'Superadmin') { ?>
							<li class="nav-item">
								<a href="<?= site_url('DashController') ?>" class="nav-link <?= $this->uri->segment(1) == 'DashController' ? 'active' : ''; ?>">
									<i class="nav-icon fas fa-tachometer-alt"></i>
									<p>Dashboard</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('AkademikController') ?>" class="nav-link <?= $this->uri->segment(1) == 'AkademikController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-calendar"></i>
									<p>Data Akademik</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('PertiController') ?>" class="nav-link <?= $this->uri->segment(1) == 'PertiController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-university"></i>
									<p>Data Perguruan Tinggi</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('MahasiswaController') ?>" class="nav-link <?= $this->uri->segment(1) == 'MahasiswaController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-graduation-cap"></i>
									<p>Data Mahasiswa</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('MasyarakatController') ?>" class="nav-link <?= $this->uri->segment(1) == 'MasyarakatController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-archive"></i>
									<p>Data Keg.Masyarakat</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('DosenController') ?>" class="nav-link <?= $this->uri->segment(1) == 'DosenController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-book" aria-hidden="true"></i>
									<p>Berita Acara Perkuliahan</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('UserController') ?>" class="nav-link <?= $this->uri->segment(1) == 'UserController' ? 'active' : ''; ?>">
									<i class="nav-icon fas fa-users"></i>
									<p>Data User</p>
								</a>
							</li>
						<?php } ?>

						<?php if ($_SESSION['id_role'] == 'Admin') { ?>
							<li class="nav-item">
								<a href="<?= site_url('DashController') ?>" class="nav-link <?= $this->uri->segment(1) == 'DashController' ? 'active' : ''; ?>">
									<i class="nav-icon fas fa-tachometer-alt"></i>
									<p>Dashboard</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('FakultasController') ?>" class="nav-link <?= $this->uri->segment(1) == 'FakultasController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-industry"></i>
									<p>Data Fakultas</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('NilaiController') ?>" class="nav-link <?= $this->uri->segment(1) == 'NilaiController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-calculator" aria-hidden="true"></i>
									<p>Data Bobot Nilai</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('AbsenController') ?>" class="nav-link <?= $this->uri->segment(1) == 'AbsenController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-address-book" aria-hidden="true"></i>
									<p>Data Absensi</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('KelasController') ?>" class="nav-link <?= $this->uri->segment(1) == 'KelasController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-object-group" aria-hidden="true"></i>
									<p>Data Kelas</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('UserController') ?>" class="nav-link <?= $this->uri->segment(1) == 'UserController' ? 'active' : ''; ?>">
									<i class="nav-icon fas fa-users"></i>
									<p>Data User</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('MahasiswaController') ?>" class="nav-link <?= $this->uri->segment(1) == 'MahasiswaController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-graduation-cap"></i>
									<p>Data Mahasiswa</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('MasyarakatController') ?>" class="nav-link <?= $this->uri->segment(1) == 'MasyarakatController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-archive"></i>
									<p>Data Keg.Masyarakat</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('DosenController') ?>" class="nav-link <?= $this->uri->segment(1) == 'DosenController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-book" aria-hidden="true"></i>
									<p>Berita Acara Perkuliahan</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('PengajarController') ?>" class="nav-link <?= $this->uri->segment(1) == 'PengajarController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-clipboard" aria-hidden="true"></i>
									<p>Data Pengajar</p>
								</a>
							</li>
						<?php } ?>

						<?php if ($_SESSION['id_role'] == 'Dosen') { ?>
							<li class="nav-item">
								<a href="<?= site_url('DashController') ?>" class="nav-link <?= $this->uri->segment(1) == 'DashController' ? 'active' : ''; ?>">
									<i class="nav-icon fas fa-tachometer-alt"></i>
									<p>Dashboard</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('PengajarController') ?>" class="nav-link <?= $this->uri->segment(1) == 'PengajarController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-clipboard" aria-hidden="true"></i>
									<p>Data Pengajar</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('PenilaianController') ?>" class="nav-link <?= $this->uri->segment(1) == 'PenilaianController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-briefcase" aria-hidden="true"></i>
									<p>Data Nilai</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('KelompokController') ?>" class="nav-link <?= $this->uri->segment(1) == 'KelompokController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-street-view" aria-hidden="true"></i>
									<p>Kegiatan Mahasiswa</p>
								</a>
							</li>

							<li class="nav-item">
								<a href="<?= site_url('MonitoringController') ?>" class="nav-link <?= $this->uri->segment(1) == 'MonitoringController' ? 'active' : ''; ?>">
									<i class="nav-icon fa fa-tablet" aria-hidden="true"></i>
									<p>Monitoring Kegiatan</p>
								</a>
							</li>
						<?php } ?>
						<?php if ($_SESSION['id_role'] != 'Superadmin') { ?>
							<li class="nav-item">
								<a href="<?= site_url('AuthController/logout') ?>" class="nav-link" id="logout"><i class="nav-icon fa fa-power-off" aria-hidden="true"></i>
									<p>Logout</p>
								</a>
							</li>
						<?php } ?>
					</ul>
				</nav>
			</div>
		</aside>

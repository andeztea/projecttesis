<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Detail Peserta Matakuliah</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url('DashController') ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Dosen</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-outline card-primary">
						<div class="card-header">
							Detail Peserta Matakuliah
							<div class="card-tools">
								<a href="<?= site_url('DosenController') ?>" type="button" class="btn btn-danger btn-sm">Kembali</a>
							</div>
						</div>
						<div class="card-body">

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="text-muted d-flex justify-content-center m-0">Nama Dosen *<small class="text-danger nama"></small></label>
										<input type="text" class="form-control" name="nama" id="nama" value="<?= $dosen->nama ?>" disabled>
									</div>

									<div class="form-group">
										<label class="text-muted d-flex justify-content-center m-0">Tahun Akademik *<small class="text-danger id_akd"></small></label>
										<select class="form-control select2bs4" name="id_akd" id="id_akd" disabled>
											<option value=""><?= $dosen->thn_akademik ?> / <?= $dosen->periode ?></option>
										</select>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label class="text-muted d-flex justify-content-center m-0">Mata Kuliah *</label>
										<input type="text" class="form-control" value="<?= $dosen->mata_kuliah ?>" disabled>
									</div>

									<div class="form-group">
										<label class="text-muted d-flex justify-content-center m-0">Kelas *<small class="text-danger id_kelas"></small></label>
										<input type="text" class="form-control" name="id_kelas" id="id_kelas" value="<?= $dosen->nama_kelas ?>" disabled>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="message text-danger d-flex justify-content-center"></div>
									<table class="table-bordered table-hover table" id="mhsTableAdd">
										<thead>
											<tr>
												<th>No</th>
												<th>NIM</th>
												<th>Nama</th>
												<th>Kontak</th>
												<th>Fakultas / Jurusan / Prodi</th>
												<th>Tahun Ak. / Periode</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- Main content -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/script'); ?>

<script>
	$(document).ready(function() {
		$('#mhsTableAdd').DataTable({
			processing: true,
			serverSide: true,
			order: [],
			dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
			ajax: {
				url: "<?= site_url('DataTableController/datatables_set_kelas/' . $dosen->id_kelas . '/' . $dosen->id_user) ?>",
				type: "POST",
			},
			columnDefs: [{
				targets: [0], //first column / numbering column
				orderable: false, //set not orderable
			}, ],
		});
	});
</script>
</body>

</html>

<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Edit Peserta Matakuliah</h1>
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
					<form action="<?= site_url('DosenController/update/' . $dosen->id) ?>" method="post" id="form_update_dosen">
						<div class="card card-outline card-primary">
							<div class="card-header">
								Edit Peserta Matakuliah
								<div class="card-tools">
									<button type="submit" class="btn btn-sm btn-primary" id="submit_form_store_dosen">Simpan</button>
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
											<input type="text" class="form-control" name="id_akd" id="id_akd" value="<?= $dosen->thn_akademik ?> / <?= $dosen->periode ?>" disabled>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="text-muted d-flex justify-content-center m-0">Fakultas/Jurusan/Prodi *</label>
											<input type="text" class="form-control" value="<?= $dosen->fakultas ?> / <?= $dosen->jurusan ?> / <?= $dosen->program_studi ?>" disabled>
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
					</form>
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
		$('.select2bs4').select2({
			theme: "bootstrap4",
			placeholder: "--Pilih--",
		})

		let tablemahasiswa = $('#mhsTableAdd').DataTable({
			processing: true,
			serverSide: true,
			order: [],
			select: {
				style: 'multi',
			},
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

		$('#buttons').html("<div class='text-center'>" +
			" <a href='<?= site_url('DosenController/tambah_mhs/' . $dosen->id) ?>' class='btn btn-sm btn-info modal_xl'>Tambah Mahasiswa</a>" +
			" <a href='<?= site_url('DosenController/set_hapus') ?>' id='set_hapuss' class='btn btn-sm btn-danger'>Hapus Mahasiswa</a>" +
			"</div>");

		$(document).on('click', '#set_hapuss', function(e) {
			e.preventDefault();
			var datamhs = [];
			var datakelas = [];
			var searchIDs = tablemahasiswa.rows('.selected').data();

			$.each(searchIDs, function(index, value) {
				datamhs += '/' + value[6];
				datakelas += '/' + value[7];
			});

			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete!'
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: "POST",
						url: $(this).attr('href'),
						data: {
							datamhs: datamhs,
							datakelas: datakelas,
						},
						dataType: "JSON",
						success: function(res) {
							$('#mhsTableAdd').DataTable().ajax.reload(null, false);
							toasts_success(res.icon, res.title)
						}
					});
				}
			})
		})

		$(document).on('submit', '#form_update_dosen', function(e) {
			e.preventDefault();
			var form = this;
			$.ajax({
				type: $(form).attr('method'),
				url: $(form).attr('action'),
				data: new FormData(form),
				dataType: "json",
				processData: false,
				contentType: false,
				beforeSend: function() {
					$(form).find('small.text-danger').html();
				},
				success: function(res) {
					if (res.error) {
						$.each(res.error, function(prefix, val) {
							$(form).find('small.' + prefix).html(val)
						})
					} else {
						window.location.reload()
						toasts_success(res.icon, res.title)
					}
				}
			});
		})
	});
</script>
</body>

</html>

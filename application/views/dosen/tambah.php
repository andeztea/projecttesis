<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Form Peserta Matakuliah</h1>
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
					<form action="<?= site_url('DosenController/store') ?>" method="post" id="form_store_dosen">
						<div class="card card-outline card-primary">
							<div class="card-header">
								Tambah Peserta Matakuliah
								<div class="card-tools">
									<a href="<?= site_url('AuthController/tambah_dosen') ?>" type="button" class="btn btn-sm btn-primary modal_xl" id="tambah_dosen">Tambah Dosen</a>
									<button type="submit" class="btn btn-sm btn-primary" disabled id="submit_form_store_dosen">Simpan</button>
									<a href="<?= site_url('DosenController') ?>" type="button" class="btn btn-danger btn-sm">Kembali</a>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="text-muted d-flex justify-content-center m-0">Nama Dosen *<small class="text-danger nama"></small></label>
											<select class="form-control select2bs4" id="id_user" name="id_user">
												<option value="">--Pilih--</option>
												<?php foreach ($users as $user) { ?>
													<option value="<?= $user->id ?>"><?= $user->nama ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="form-group">
											<label class="text-muted d-flex justify-content-center m-0">Tahun Akademik *<small class="text-danger id_akd"></small></label>
											<select class="form-control select2bs4" name="id_akd" id="id_akd">
												<option value="">--Pilih--</option>
												<?php foreach ($akademikk as $akademik) { ?>
													<option value="<?= $akademik->id ?>"><?= $akademik->thn_akademik ?> / <?= $akademik->periode ?></option>
												<?php } ?>
											</select>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="text-muted d-flex justify-content-center m-0">Fakultas/Jurusan/Prodi *<small class="text-danger id_fakultas"></small></label>
											<select class="form-control select2bs4" name="id_fakultas" id="id_fakultas">
												<option value="">--Pilih--</option>
												<?php foreach ($fakultass as $fakultas) { ?>
													<option value="<?= $fakultas->id ?>"><?= $fakultas->fakultas ?> / <?= $fakultas->jurusan ?> / <?= $fakultas->program_studi ?></option>
												<?php } ?>
											</select>
										</div>

										<div class="form-group">
											<label class="text-muted d-flex justify-content-center m-0">Kelas *<small class="text-danger id_kelas"></small></label>
											<select class="form-control select2bs4" name="id_kelas" id="id_kelas">
												<option value="">--Pilih--</option>
												<?php foreach ($kelass as $kelas) { ?>
													<option value="<?= $kelas->id ?>"><?= $kelas->nama_kelas ?> / <?= $kelas->mata_kuliah ?> / <?= $kelas->sks ?></option>
												<?php } ?>
											</select>
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

		$('#id_fakultas').select2({
			theme: "bootstrap4",
			placeholder: '--Pilih--',
		}).on('select2:select', function(evt) {

			$("#submit_form_store_dosen").removeAttr('disabled')
			var fakultas = $("#id_fakultas option:selected").val();
			var tablemahasiswa = $('#mhsTableAdd').DataTable({
				processing: true,
				serverSide: true,
				bDestroy: true,
				order: [],
				select: {
					style: 'multi',
				},
				dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
				ajax: {
					url: "<?= site_url('DataTableController/datatables_mhs_by_fakultas/') ?>" + fakultas,
					type: "POST",
				},
				columnDefs: [{
					targets: [0], //first column / numbering column
					orderable: false, //set not orderable
				}, ],
			});


			$(document).on('submit', '#form_store_dosen', function(e) {
				e.preventDefault();
				var nama_dosen = $("#id_user option:selected").text();
				var form = this;
				var id_mhs = [];
				var id_user = $('#id_user').val();
				var nidn = $('#nidn').val();
				var id_fakultas = $('#id_fakultas').val();
				var id_kelas = $('#id_kelas').val();
				var id_akd = $('#id_akd').val();
				var searchIDs = tablemahasiswa.rows('.selected').data();

				if (searchIDs.length <= 0) {
					return $('.message').text('Setidaknya pilih salah satu mahasiswa.')
				}

				$.each(searchIDs, function(index, value) {
					id_mhs += '/' + value[6];
				});

				$.ajax({
					type: $(this).attr('method'),
					url: $(this).attr('action'),
					dataType: "json",
					data: {
						id_user: id_user,
						nidn: nidn,
						id_fakultas: id_fakultas,
						id_mhs: id_mhs,
						id_kelas: id_kelas,
						id_mhs: id_mhs,
						id_akd: id_akd,
						nama_dosen: nama_dosen
					},
					beforeSend: function() {
						$(form).find('small.text-danger').html();
					},
					success: function(res) {
						if (res.error) {
							$.each(res.error, function(prefix, val) {
								$(form).find('small.' + prefix).html(val)
							})
						} else {
							$(form)[0].reset();
							window.location.assign('<?= site_url('DosenController') ?>')
							toasts_success(res.icon, res.title)
						}
					}
				});
			})
		});
	});
</script>
</body>

</html>

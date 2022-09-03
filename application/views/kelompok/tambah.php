<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Form Kelompok Kegiatan Mahasiwa :</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url('DashController') ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Kelompok Mahasiwa</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="card card-outline card-primary">
						<form action="<?= site_url('KelompokController/store') ?>" method="post" id="form_store_kelompok" enctype="multipart/form-data">
							<div class="card-header">
								Tambah Kelompok Kegiatan Mahasiwa :
								<div class="card-tools">
									<div class="card-tools">
										<button type="submit" class="btn btn-sm btn-primary">Simpan</button>
										<a href="<?= site_url('KelompokController') ?>" type="button" class="btn btn-danger btn-sm">Kembali</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<strong for="fakultas">Fakultas/Jurusan/Prodi</strong>
											<select name="fakultas" id="fakultas" class="form-control select2bs4">
												<option value="">-- Pilihan --</option>
												<?php foreach ($fakultass as $fakultas) { ?>
													<option value="<?= $fakultas->id ?>"><?= $fakultas->fakultas ?> / <?= $fakultas->jurusan ?> / <?= $fakultas->program_studi ?></option>
												<?php } ?>
											</select>
											<small class="text-danger fakultas_error"></small>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<strong for="thn_akademik">Tahun Akademik</strong>
											<select name="thn_akademik" id="thn_akademik" class="form-control select2bs4">
												<option value="">-- Pilihan --</option>
												<?php foreach ($akademikk as $akademik) { ?>
													<option value="<?= $akademik->id ?>"><?= $akademik->thn_akademik ?> / <?= $akademik->periode ?></option>
												<?php } ?>
											</select>
											<small class="text-danger thn_akademik_error"></small>
										</div>
									</div>

									<div class="col-sm-4">
										<div class="form-group">
											<strong for="id_kelas">Kelas </strong>
											<select class="form-control" name="id_kelas" id="id_kelas">
												<option value="">--Pilihan--</option>
											</select>
											<small class="text-danger id_kelas_error"></small>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="text-muted d-flex justify-content-center m-0">Pendampingan Masyarakat</label>
											<select class="form-control select2bs4" name="id_msyr" id="id_msyr">
												<?php foreach ($masyarakat as $msyr) { ?>
													<option value=""></option>
													<option value="<?= $msyr->id ?>"><?= $msyr->nama_kel ?></option>
												<?php } ?>
											</select>
											<small class="text-danger id_msyr_error"></small>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="text-muted d-flex justify-content-center m-0">Kegiatan Usaha Mandiri</label>
											<select class="form-control" name="id_msyr" id="id_msyr">
												<option value="">--Pilih--</option>
											</select>
											<small class="text-danger id_msyr_error"></small>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="card card-outline card-primary">
						<div class="card-header">
							Data Mahasiswa :
							<div class="card-tools">
								<div class="card-tools">
									<button type="button" class="btn btn-tool" data-card-widget="collapse">
										<i class="fas fa-minus"></i>
									</button>
									<button type="button" class="btn btn-tool" data-card-widget="remove">
										<i class="fas fa-times"></i>
									</button>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">
									<table class="table-bordered table-hover table" id="mhsTableKegiatan">
										<thead>
											<tr>
												<th>No</th>
												<th>NIM</th>
												<th>Nama</th>
												<th>Kategori Kegiatan</th>
												<th>Jenis Kegiatan Usaha</th>
											</tr>
										</thead>
									</table>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- REQUIRED SCRIPTS -->
<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/script'); ?>

<script>
	$(document).ready(function() {
		$('.select2bs4').select2({
			theme: "bootstrap4",
			placeholder: "--Pilih--",
		})

		var dosenID = '<?= $users->dosen_id ?>';

		$('#id_kelas').select2({
			theme: "bootstrap4",
			placeholder: "--Pilih--",
			ajax: {
				type: "POST",
				url: '<?= site_url('SelectController/kelas_json/') ?>' + dosenID,
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
			var kelasID = $("#id_kelas option:selected").val();

			$('#mhsTableKegiatan').DataTable({
				processing: true,
				serverSide: true,
				bDestroy: true,
				order: [],
				dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
				ajax: {
					url: "<?= site_url('DataTableController/datatables_mhs_kegiatan_add/') ?>" + kelasID + '/' + dosenID,
					type: "POST",
				},
				columnDefs: [{
					targets: [0], //first column / numbering column
					orderable: false, //set not orderable
				}, ],
			});
		})

		// $(document).on('submit', '#form_store_pengajar', function(e) {
		// 	e.preventDefault();

		// 	var form = this;
		// 	var status = []
		// 	var formData = new FormData(form);

		// 	$(".status").each(function(index, element) {
		// 		status += '/' + $(this).data('id') + ',' + $(this).val()
		// 	});

		// 	formData.append('status', status);

		// 	$.ajax({
		// 		type: $(form).attr('method'),
		// 		url: $(form).attr('action'),
		// 		data: formData,
		// 		dataType: "json",
		// 		processData: false,
		// 		contentType: false,
		// 		beforeSend: function() {
		// 			$(form).find('small.text-danger').html();
		// 		},
		// 		success: function(res) {
		// 			if (res.error) {
		// 				$.each(res.error, function(prefix, val) {
		// 					$(form).find('small.' + prefix).html(val)
		// 				})
		// 			} else {
		// 				window.location.reload()
		// 				toasts_success(res.icon, res.title)
		// 			}
		// 		}
		// 	});
		// })
	});
</script>

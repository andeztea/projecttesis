<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Form Penilaian</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url('DashController') ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Penilaian</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<div class="content">
		<div class="container-fluid">
			<form action="<?= site_url('PenilaianController/store') ?>" method="post" id="form_store_penilaian">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-outline card-primary">
							<input type="hidden" name="id_dosen" value="<?= $users->dosen_id ?>">
							<input type="hidden" name="id_kelas" value="<?= $users->id_kelas ?>">
							<input type="hidden" name="id_pt" value="<?= $users->id_pt ?>">
							<div class="card-header">
								Tambah Penilaian :
								<div class="card-tools">
									<div class="card-tools">
										<button type="submit" class="btn btn-sm btn-primary">Simpan</button>
										<a href="<?= site_url('PenilaianController') ?>" type="button" class="btn btn-danger btn-sm">Kembali</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="fakultas">Fakultas/Jurusan/Prodi</label>
											<select name="fakultas" id="fakultas" class="form-control select2bs4">
												<option value="">-- Pilihan --</option>
												<?php foreach ($fakultass as $fakultas) { ?>
													<option value="<?= $fakultas->id ?>"><?= $fakultas->fakultas ?> / <?= $fakultas->jurusan ?> / <?= $fakultas->program_studi ?></option>
												<?php } ?>
											</select>
											<small class="text-danger fakultas_error"></small>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label for="thn_akademik">Tahun Akademik</label>
											<select name="thn_akademik" id="thn_akademik" class="form-control select2bs4">
												<option value="">-- Pilihan --</option>
												<?php foreach ($akademikk as $akademik) { ?>
													<option value="<?= $akademik->id ?>"><?= $akademik->thn_akademik ?> / <?= $akademik->periode ?></option>
												<?php } ?>
											</select>
											<small class="text-danger thn_akademik_error"></small>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label class="text-muted">Kelas </label>
											<select class="form-control" name="kelas" id="kelas">
												<option value="">--Pilihan--</option>
											</select>
											<small class="text-danger kelas_error"></small>
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
										<table class="table-bordered table-hover table" id="table_penilai" style="width: 100%;">
											<thead>
												<tr>
													<th rowspan="2">No</th>
													<th rowspan="2">NIM</th>
													<th rowspan="2">Nama</th>
													<th colspan="4">Nilai</th>
													<th rowspan="2">Rata-Rata</th>
													<th rowspan="2">N.Huruf</th>
													<th rowspan="2"></th>
												</tr>
												<tr>
													<th>Kehadiran</th>
													<th>Aktivitas</th>
													<th>Medium Test</th>
													<th>Final Test</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
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

		$('#kelas').select2({
			theme: "bootstrap4",
			ajax: {
				type: "POST",
				url: '<?= site_url('SelectController/kelas_penilaian_json/' . $_SESSION['id_user']) ?>',
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
			var kelasID = $("#kelas option:selected").val();

			var table_penilai = $('#table_penilai').DataTable({
				processing: true,
				serverSide: true,
				bDestroy: true,
				scrollY: "480px",
				scrollX: "200px",
				scrollCollapse: true,
				ordering: false,
				searching: false,
				paging: false,
				order: [],
				dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
				ajax: {
					url: "<?= site_url('DataTableController/datatables_nilai_akhir_add/' . $users->dosen_id . '/') ?>" + kelasID,
					type: "POST",
				},
				columnDefs: [{
						targets: [0], //first column / numbering column
						orderable: false, //set not orderable
					},
					{
						'width': '0%',
						'targets': [9]
					},
				],
			});

			$(document).on('submit', '#form_store_penilaian', function(e) {
				e.preventDefault();

				var form = this;
				var formData = $(this).serializeArray();

				$.ajax({
					type: $(form).attr('method'),
					url: $(form).attr('action'),
					data: formData,
					dataType: "json",
					success: function(res) {
						toasts_success(res.icon, res.title)
					}
				});
			})
		})
	});
</script>

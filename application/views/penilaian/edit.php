<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Form Penilaian :</h1>
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
		<form action="<?= site_url('PenilaianController/update/' . $penilai->id) ?>" method="post" id="form_update_nilai_akhir">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<div class="card card-outline card-primary">
							<div class="card-header">
								Edit Penilaian :
								<div class="card-tools">
									<div class="card-tools">
										<button type="submit" class="btn btn-sm btn-primary">Simpan</button>
										<a href="<?= site_url('PenilaianController') ?>" type="button" class="btn btn-danger btn-sm">Kembali</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm">
										<div class="form-group">
											<strong for="fakultas">Fakultas/Jurusan/Prodi</strong>
											<select name="fakultas" id="fakultas" class="form-control select2bs4" disabled>
												<option selected value="<?= $penilai->id_fakultas ?>"><?= $penilai->fakultas ?> / <?= $penilai->jurusan ?> / <?= $penilai->program_studi ?></option>
											</select>
											<small class="text-danger fakultas_error"></small>
										</div>
									</div>

									<div class="col-sm">
										<div class="form-group">
											<strong for="thn_akademik">Tahun Akademik</strong>
											<select name="thn_akademik" id="thn_akademik" class="form-control select2bs4" disabled>
												<option selected value="<?= $penilai->id_akd ?>"><?= $penilai->thn_akademik ?> / <?= $penilai->periode ?></option>
											</select>
											<small class="text-danger thn_akademik_error"></small>
										</div>
									</div>

									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted d-flex justify-content-center m-0">Kelas </label>
											<select class="form-control select2bs4" name="kelas" id="kelas" disabled>
												<option selected value="<?= $penilai->id_kelas ?>"><?= $penilai->nama_kelas ?> / <?= $penilai->mata_kuliah ?> / <?= $penilai->sks ?></option>
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
										<table class="table-bordered table-hover table" id="table_nilai_akhir2" style="width: 100%;">
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
			</div>
		</form>
	</div>
</div>

<!-- REQUIRED SCRIPTS -->
<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/script'); ?>

<script>
	$(document).ready(function() {
		let tableakademik = $('#table_nilai_akhir2').DataTable({
			processing: true,
			serverSide: true,
			scrollY: "480px",
			scrollX: "200px",
			scrollCollapse: true,
			ordering: false,
			searching: false,
			paging: false,
			order: [],
			dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
			ajax: {
				url: "<?= site_url('DataTableController/datatables_nilai_akhir_edit/' . $penilai->id) ?>",
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

		$(document).on('submit', '#form_update_nilai_akhir', function(e) {
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
	});
</script>

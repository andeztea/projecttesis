<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Detail Pengajaran</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url('DashController') ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Pengajaran Dosen</li>
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
						<div class="card-header">
							Detail Data Pengajaran :
							<div class="card-tools">
								<div class="card-tools">
									<a href="<?= site_url('PengajarController') ?>" type="button" class="btn btn-danger btn-sm">Kembali</a>
								</div>
							</div>
						</div>
						<div class="card-body">
							<div class="row">
								<div class="col-sm">
									<div class="form-group">
										<label class="text-muted m-0">Nama Dosen</label>
										<select class="form-control" name="id_dosen" id="id_dosen" disabled>
											<option selected value="<?= $pengajar->id_user ?>"><?= $pengajar->nama ?></option>
										</select>
										<small class="text-danger error-text jml_pekan"></small>
									</div>
								</div>

								<div class="col-sm">
									<div class="form-group">
										<label class="text-muted m-0">Kelas</label>
										<select class="form-control" name="id_kelas" id="id_kelas" disabled>
											<option selected value="<?= $pengajar->id_kelas ?>"><?= $pengajar->nama_kelas ?></option>
										</select>
										<small class="text-danger error-text id_kelas"></small>
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
							Realisasi Pertemuan :
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
									<table class="table-bordered table-hover table" id="realisasi">
										<thead>
											<tr>
												<th>Pert.Ke</th>
												<th>Pelaksanaan</th>
												<th>Materi</th>
												<th>Bukti Perkuliahan</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1 ?>
											<?php foreach ($realisasi as $real) { ?>
												<tr>
													<td><?= $real->pertemuan_ke ?></td>
													<td><?= $real->pelaksanaan ?></td>
													<td>Materi Pokok : <?= $real->materi_pokok ?> <br>Materi Sub Pokok :<?= $real->bahasan ?></td>
													<td><?= $real->bukti ?></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
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
							Rekapitulasi Pertemuan :
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
									<table id="rekapitulasi" class="table-bordered table-hover table">
										<thead>
											<tr>
												<th rowspan="2">No.</th>
												<th rowspan="2">NIM</th>
												<th rowspan="2">Nama</th>
												<th colspan="32">Pertemuan Ke</th>
												<th colspan="4">Status</th>
												<th rowspan="2">Total</th>
											</tr>
											<tr>

												<?php for ($i = 1; $i < 33; $i++) { ?>
													<th><?= $i ?></th>
												<?php } ?>

												<th>H</th>
												<th>I</th>
												<th>S</th>
												<th>A</th>
											</tr>
										</thead>
										<tbody>
											<?php $no = 1;
											$sum = 0; ?>
											<?php foreach ($kehadiran as $khr) { ?>
												<tr>
													<td><?= $no++ ?></td>
													<td><?= $khr['nim'] ?></td>
													<td><?= $khr['nama'] ?></td>

													<?php for ($i = 1; $i < 33; $i++) { ?>
														<td><?= $khr['p' . $i] ?></td>
													<?php } ?>

													<td>23</td>
													<td>23</td>
													<td>23</td>
													<td>23</td>
													<td>23</td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- /.row -->
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

		$('#rekapitulasi').DataTable({
			scrollY: "480px",
			scrollX: "200px",
			bDestroy: true,
			scrollCollapse: true,
			ordering: false,
			searching: false,
			paging: false,
		});

		$(document).on('submit', '#form_update_pengajar', function(e) {
			e.preventDefault();
			var form = this;
			var status = []
			var formData = new FormData(form);

			$(".status").each(function(index, element) {
				status += '/' + $(this).data('id') + ',' + $(this).val()
			});

			formData.append('status', status);

			$.ajax({
				type: $(form).attr('method'),
				url: $(form).attr('action'),
				data: formData,
				dataType: "json",
				processData: false,
				contentType: false,
				beforeSend: function() {
					$(form).find('small.text-danger').html();
				},
				success: function(res) {
					console.log(res);
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

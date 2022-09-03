<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Form Pengajaran Dosen</h1>
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
						<form action="<?= site_url('PengajarController/store') ?>" method="post" id="form_store_pengajar" enctype="multipart/form-data">
							<input type="hidden" name="id_dosen" value="<?= $_SESSION['id_user'] ?>">
							<div class="card-header">
								Tambah Data Pengajaran Dosen :
								<div class="card-tools">
									<div class="card-tools">
										<button type="submit" class="btn btn-sm btn-primary" id="submit_form_store_dosen">Simpan</button>
										<a href="<?= site_url('PengajarController') ?>" type="button" class="btn btn-danger btn-sm">Kembali</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="row">
									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0" for="thn_akademik">Tahun Akademik</label>
											<select name="id_akd" id="id_akd" class="form-control select2bs4">
												<option value="">-- Pilihan --</option>
												<?php foreach ($akademikk as $akademik) { ?>
													<option value="<?= $akademik->id ?>"><?= $akademik->thn_akademik ?> / <?= $akademik->periode ?></option>
												<?php } ?>
											</select>
											<small class="text-danger error-text id_akd"></small>
										</div>
									</div>

									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0">Kelas</label>
											<select class="form-control" name="id_kelas" id="id_kelas">
												<option value="">--Pilihan--</option>
											</select>
											<small class="text-danger error-text id_kelas"></small>
										</div>
									</div>

									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0">Pertemuan Ke</label>
											<select class="form-control select2bs4" name="pertemuan_ke">
												<option value="">--Pilihan--</option>
												<?php for ($i = 1; $i < 33; $i++) { ?>
													<option value="<?= $i ?>">Pertemuan Ke <?= $i ?></option>
												<?php } ?>
											</select>
											<small class="text-danger error-text pertemuan_ke"></small>
										</div>
									</div>

									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0">Jumlah Pekan</label>
											<input type="number" class="form-control" id="jml_pekan" name="jml_pekan">
											<small class="text-danger error-text jml_pekan"></small>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0">Sub Pokok Bahasan</label>
											<textarea type="text" class="form-control" name="bahasan" rows="2"></textarea>
											<small class="text-danger error-text bahasan"></small>
										</div>
									</div>

									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0">Materi Pokok</label>
											<textarea type="text" class="form-control" name="materi_pokok" rows="2"></textarea>
											<small class="text-danger error-text materi_pokok"></small>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0">RPS</label>
											<div class="custom-file">
												<input type="file" class="form-control" id="rps" name="rps">
												<small class="text-danger error-text rps"></small>
												<label class="text-muted m-0" for="rps"></label>
											</div>
										</div>
									</div>

									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0">Bukti Pertemuan</label>
											<div class="custom-file">
												<input type="file" class="form-control" id="bukti" name="bukti">
												<small class="text-danger error-text bukti"></small>
												<label class="text-muted m-0" for="bukti"></label>
											</div>
										</div>
									</div>

									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0">Materi Pertemuan</label>
											<div class="custom-file">
												<input type="file" class="form-control" id="materi_temu" name="materi_temu">
												<small class="text-danger error-text materi_temu"></small>
												<label class="text-muted m-0" for="materi_temu"></label>
											</div>
										</div>
									</div>

									<div class="col-sm">
										<div class="form-group">
											<label class="text-muted m-0">Modul/Buku Ajar</label>
											<div class="custom-file">
												<input type="file" class="form-control" id="modul" name="modul">
												<small class="text-danger error-text modul"></small>
												<label class="text-muted m-0" for="modul"></label>
											</div>
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
							Absensi Mahasiswa :
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
									<table class="table-bordered table-hover table" id="mhsTableAddd">
										<thead>
											<tr>
												<th>No</th>
												<th>NIM</th>
												<th>Nama</th>
												<th>Status Kehadiran</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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

		var dosenID = '<?= $_SESSION['id_user'] ?>';

		$('#id_kelas').select2({
			theme: "bootstrap4",
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

			$('#mhsTableAddd').DataTable({
				processing: true,
				serverSide: true,
				bDestroy: true,
				order: [],
				dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
				ajax: {
					url: "<?= site_url('DataTableController/datatables_mhs_absensi/') ?>" + kelasID + '/' + dosenID,
					type: "POST",
				},
				columnDefs: [{
					targets: [0], //first column / numbering column
					orderable: false, //set not orderable
				}, ],
			});
		})

		$(document).on('submit', '#form_store_pengajar', function(e) {
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

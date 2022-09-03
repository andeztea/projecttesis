<div class="modal-header d-flex justify-content-center">
	<h2>Registrasi Mahasiswa</h2>
</div>
<div class="modal-body">
	<form action="<?= site_url('AuthController/register_mhs') ?>" method="post" enctype="multipart/form-data" id="mhs_form">
		<div class="row">
			<div class="col-sm">
				<div class="form-group">
					<strong for="nama_pt">Perguruan Tinggi</strong>
					<select name="nama_pt" id="nama_pt" class="form-control">
						<option value="">-- Pilihan --</option>
					</select>
					<small class="text-danger nama_pt_error"></small>
				</div>
			</div>

			<div class="col-sm">
				<div class="form-group">
					<strong for="nama_dosen">Dosen</strong>
					<select name="nama_dosen" id="nama_dosen" class="form-control" disabled>
						<option value="">-- Pilihan --</option>
					</select>
					<small class="text-danger nama_dosen_error"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm">
				<div class="form-group">
					<strong for="nim">NIM</strong>
					<input type="text" name="nim" id="nim" class="form-control" placeholder="Nomor Induk Mahasiswa" aria-describedby="nama">
					<small class="text-danger nim_error"></small>
				</div>
			</div>

			<div class="col-sm">
				<div class="form-group">
					<strong for="nama">Nama</strong>
					<input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" aria-describedby="nama">
					<small class="text-danger nama_error"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm">
				<div class="form-group">
					<strong for="kontak">Kontak</strong>
					<input type="text" name="kontak" id="kontak" class="form-control" placeholder="Kontak" aria-describedby="kontak">
					<small class="text-danger kontak_error"></small>
				</div>
			</div>

			<div class="col-sm">
				<div class="form-group">
					<strong for="email">Email</strong>
					<input type="email" name="email" id="email" class="form-control" placeholder="Email" aria-describedby="email">
					<small class="text-danger email_error"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm">
				<div class="form-group">
					<strong for="fakultas">Fakultas/Jurusan/Prodi</strong>
					<select name="fakultas" id="fakultas" class="form-control" disabled>
						<option value="">-- Pilihan --</option>
					</select>
					<small class="text-danger fakultas_error"></small>
				</div>
			</div>
		</div>

		<!-- <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
          <strong for="email">Fakultas</strong>
          <input type="text" name="fakultas" id="fakultas" class="form-control" placeholder="Fakultas" aria-describedby="fakultas">
          <small class="text-danger fakultas_error"></small>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="form-group">
         <strong for="email">Jurusan</strong>
          <input type="text" name="jusrusan" id="jusrusan" class="form-control" placeholder="Jusrusan" aria-describedby="jusrusan">
          <small class="text-danger jusrusan_error"></small>
        </div>
      </div>

      <div class="col-sm-4">
        <div class="form-group">
         <strong for="program_studi">Program Studi</strong>
          <input type="text" name="program_studi" id="program_studi" class="form-control" placeholder="program_studi" aria-describedby="program_studi">
          <small class="text-danger program_studi_error"></small>
        </div>
      </div>
    </div> -->

		<div class="row">
			<div class="col-sm">
				<div class="form-group">
					<strong for="thn_akademik">Tahun Akademik</strong>
					<select name="thn_akademik" id="thn_akademik" class="form-control select2Mhs">
						<option value="">-- Pilihan --</option>
						<?php foreach ($akademikk as $akademik) { ?>
							<option value="<?= $akademik->id ?>"><?= $akademik->thn_akademik ?> / <?= $akademik->periode ?></option>
						<?php } ?>
					</select>
					<small class="text-danger thn_akademik_error"></small>
				</div>
			</div>

			<div class="col-sm">
				<div class="form-group">
					<strong for="semester">Semester</strong>
					<select name="semester" id="semester" class="form-control select2Mhs">
						<option value="">-- Pilihan --</option>
						<option value="1">Semester I</option>
						<option value="2">Semester II</option>
						<option value="3">Semester III</option>
						<option value="4">Semester IV</option>
						<option value="5">Semester V</option>
						<option value="6">Semester VI</option>
						<option value="7">Semester VII</option>
					</select>
					<small class="text-danger semester_error"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm">
				<div class="form-group">
					<strong for="alamat">Alamat</strong>
					<input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat" aria-describedby="alamat">
					<small class="text-danger alamat_error"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<strong for="provinsi">Provinsi</strong>
					<select name="provinsi" id="provinsi" class="form-control provinsi">
					</select>
					<small class="text-danger kabupaten_error"></small>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group">
					<strong for="kabupaten">Kabupaten</strong>
					<select name="kabupaten" id="kabupaten" class="form-control kabupaten" disabled>
					</select>
					<small class="text-danger kabupaten_error"></small>
				</div>
			</div>

			<div class="col-sm-4">
				<div class="form-group">
					<strong for="kecamatan">Kecamatan</strong>
					<select name="kecamatan" id="kecamatan" class="form-control kecamatan" disabled>
					</select>
					<small class="text-danger kecamatan_error"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm">
				<strong>Jenis Kegiatan Kewirausahaan Diluar Kampus <small class="text-danger jns_kwdk_error"></small></strong>
				<div class="form-group">
					<div class="form-check form-check-inline">
						<input class="form-check-input inlineRadio" type="radio" name="jns_kwdk" id="inlineRadio1" value="Pendampingan Masyarakat">
						<label class="form-check-label" for="inlineRadio1">Pendampingan Masyarakat</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input inlineRadio" type="radio" name="jns_kwdk" id="inlineRadio2" value="Kegiatan Usaha Mandiri">
						<label class="form-check-label" for="inlineRadio2">Kegiatan Usaha Mandiri</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="jns_kwdk" id="inlineRadio3" value="jns_kwdk_lainnya">
						<label class="form-check-label" for="inlineRadio3">Lainnya..</label>
					</div>
					<input type="text" class="form-control form-control-sm mt-1 jns_kwdk_lainnya" name="jns_kwdk_lainnya" id="jns_kwdk_lainnya" placeholder="Lainnya.." disabled>
				</div>
			</div>
		</div>

		<div class=" row">
			<div class="col-sm">
				<div class="form-group">
					<strong for="userfile">Foto Kartu Mahasiswa</strong>
					<input type="file" name="userfile" id="userfile" class="form-control">
					<small class="text-danger userfile_error"></small>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-6">
				<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
			</div>
			<!-- /.col -->
			<div class="col-6">
				<button type="submit" class="btn btn-primary btn-block">Registrasi</button>
			</div>
			<!-- /.col -->
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {
		regionSelect2();

		$('.select2Mhs').select2({
			theme: "bootstrap4",
			dropdownParent: $(".myModal"),
			placeholder: "--Pilihan--",
		})

		$('#nama_pt').select2({
			theme: "bootstrap4",
			dropdownParent: $(".myModal"),
			placeholder: 'Pilihan',
			ajax: {
				type: "POST",
				url: '<?= site_url('SelectController/perguruan_tinggi') ?>',
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
			var pertiID = $("#nama_pt option:selected").val();
			$('#nama_dosen').removeAttr('disabled')
			$('#nama_kelas').removeAttr('disabled')
			$('#fakultas').removeAttr('disabled')

			$('#nama_dosen').select2({
				theme: "bootstrap4",
				dropdownParent: $(".myModal"),
				placeholder: 'Pilih Dosen',
				ajax: {
					type: "POST",
					url: '<?= site_url('SelectController/dosen_by_perti/') ?>' + pertiID,
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
			})

			$('#nama_kelas').select2({
				theme: "bootstrap4",
				dropdownParent: $(".myModal"),
				placeholder: 'Pilih Kelas',
				ajax: {
					type: "POST",
					url: '<?= site_url('SelectController/kelas_by_perti/') ?>' + pertiID,
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
			})

			$('#fakultas').select2({
				theme: "bootstrap4",
				dropdownParent: $(".myModal"),
				placeholder: 'Pilih Fakultas',
				ajax: {
					type: "POST",
					url: '<?= site_url('SelectController/fakultas_by_perti/') ?>' + pertiID,
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
			})
		});

		$(document).on('submit', '#mhs_form', function(e) {
			e.preventDefault();
			var form = this;
			$.ajax({
				type: $(form).attr('method'),
				url: $(form).attr('action'),
				data: new FormData(form),
				processData: false,
				contentType: false,
				cache: false,
				beforeSend: function() {
					$(form).find('small.text-danger').html();
				},
				success: function(res) {
					$.each(res.error, function(prefix, val) {
						$(form).find('small.' + prefix + '_error').html(val)
					})

					if (res.userfile) {
						$(form).find('small.' + userfile + '_error').html(userfile)
					}

					if (res.pesan) {
						$('.myModal').modal('hide')
						$('.alert-success').removeAttr('style')
						$('strong#pesan').text(res.pesan)
					}
				}
			});
		})

		$(document).on('mousedown', '#kwhn_lainnya', function() {
			$("input:radio").prop("checked", false)
		})

		$(document).on('click', 'input:radio', function() {
			$("#kwhn_lainnya").val('')
		})

		$(document).on('click', '#inlineRadio3', function() {
			$(".jns_kwdk_lainnya").removeAttr('disabled');
		})

		$(document).on('click', '.inlineRadio', function() {
			$(".jns_kwdk_lainnya").attr('disabled', 'disabled');
		})

	});
</script>

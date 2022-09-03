<form action="<?= site_url('AbsenController/update/' . $absen->id) ?>" method="post" id="form_update_absen">
	<div class="modal-header elevation-1 d-flex justify-content-center py-2">
		<h4><strong>Edit Nilai Kehadiran</strong></h4>
	</div>

	<div class="modal-body elevation-1">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label class="text-muted d-flex justify-content-center m-0">Tahun Akademik</label>
					<select class="form-control select2bs4" name="id_akd">
						<option value="">--Pilih--</option>
						<?php foreach ($akademiks as $akademik) { ?>
							<option <?= $akademik->id == $absen->id_akd ? 'selected' : '' ?> value="<?= $akademik->id ?>"><?= $akademik->thn_akademik ?> / <?= $akademik->periode ?></option>
						<?php } ?>
					</select>
					<small class="text-danger d-flex justify-content-center id_akd"></small>
				</div>

				<div class="form-group">
					<label class="text-muted m-0">Kategori</label>
					<select class="form-control select2bs4" name="kategori">
						<option value="<?= $absen->kategori ?>"><?= $absen->kategori ?></option>
						<option value="1">Hadir</option>
						<option value="2">Izin</option>
						<option value="3">Sakit</option>
						<option value="4">Alpa</option>
					</select>
					<small class="text-danger error-text kategori"></small>
				</div>

				<div class="form-group">
					<label class="text-muted m-0">Skor Nilai</label>
					<input type="text" step="any" class="form-control" name="skor_nilai" value="<?= $absen->skor_nilai ?>">
					<small class="text-danger error-text skor_nilai"></small>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary btn-block">Simpan</button>
		<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
	</div>
</form>

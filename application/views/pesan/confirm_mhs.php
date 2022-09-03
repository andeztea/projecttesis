<form action="<?= site_url('PesanController/confirm_data_mhs/' . $pesan->id) ?>" method="post" enctype="multipart/form-data" id="confirm_data_mhs">
  <div class="modal-header elevation-1 d-flex justify-content-center">
    <h3>KONFIRMASI PENDAFTARAN MAHASISWA</h3>
  </div>

  <div class="modal-body elevation-1">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label class="text-muted d-flex justify-content-center m-0">Pilih Perguruan Tinggi *<small class="text-danger error-text kode_pt_error"></small></label>
          <select class="form-control select2bs4" name="kode_pt" disabled>
            <option value=""><?= $pesan->nama_pt ?></option>
          </select>
        </div>

        <div class="form-group">
          <label class="text-muted m-0">Nomor Induk Mahasiswa *<small class="text-danger error-text nim_error"></small></label>
          <input type="text" class="form-control" name="nim" value="<?= $pesan->nim ?>" disabled>
        </div>

        <div class="form-group">
          <label class="text-muted m-0">Nama Mahasiswa *<small class="text-danger error-text nama_error"></small></label>
          <input type="text" class="form-control" name="nama" value="<?= $pesan->nama ?>" disabled>
        </div>

        <div class="form-group">
          <label class="text-muted m-0">Fakultas/Jurusan/Prodi *<small class="text-danger error-text fakultas_error"></small></label>
          <select class="form-control select2bs4" name="fakultas" disabled>
            <option value=""><?= $pesan->fakultas ?> / <?= $pesan->jurusan ?> / <?= $pesan->program_studi ?></option>
          </select>
        </div>

        <div class="form-group">
          <label class="text-muted m-0">Semester *<small class="text-danger error-text jurusan_error"></small></label>
          <select class="form-control select2bs4" name="jurusan" disabled>
            <option value=""><?= $pesan->id_semester ?></option>
          </select>
        </div>

        <div class="form-group">
          <label class="text-muted m-0">Tahun Akademik *<small class="text-danger error-text id_akd_error"></small></label>
          <select class="form-control select2bs4" name="id_akd" disabled>
            <option value=""><?= $pesan->thn_akademik ?> / <?= $pesan->periode ?></option>
          </select>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label class="text-muted m-0">Kontak/No. Handphone *<small class="text-danger error-text kontak_error"></small></label>
          <input type="text" class="form-control" name="kontak" value="<?= $pesan->kontak ?>" disabled>
        </div>

        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="text-muted m-0">Provinsi *<small class="text-danger error-text id_prov_error"></small></label>
              <select class="form-control select2bs4" name="id_prov" disabled>
                <option value=""><?= $pesan->nama_prov ?></option>
              </select>
            </div>

            <div class="form-group">
              <label class="text-muted m-0">Kabupaten *<small class="text-danger error-text id_kab_error"></small></label>
              <select class="form-control select2bs4" name="id_kab" disabled>
                <option value=""><?= $pesan->nama_kab ?></option>
              </select>
            </div>

            <div class="form-group">
              <label class="text-muted m-0">Kecamatan *<small class="text-danger error-text id_desa_error"></small></label>
              <select class="form-control select2bs4" name="id_desa" disabled>
                <option value=""><?= $pesan->nama_kec ?></option>
              </select>
            </div>
          </div>

          <div class="col-md-6">
            <label class="text-muted m-0 d-flex justify-content-center">Kartu Mahasiswa</label>
            <div class="text-center mt-2">
              <img class="profile-user-img img-fluid img-square" src="<?= base_url('uploads/' . $pesan->userfile) ?>" alt="User profile picture" style="height: 180px ;width: 244px">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="text-muted m-0">Alamat *<small class="text-danger error-text alamat_pt_error"></small></label>
          <textarea class="form-control" name="alamat" rows="1" disabled><?= $pesan->alamat ?></textarea>
        </div>

        <div class="form-group">
          <label class="text-muted m-0">Jenis Kegiatan Kewirausahaan Diluar Kampus *<small class="text-danger error-text jns_kwhn_error"></small></label>
          <input type="text" class="form-control" name="kontak" value="<?= $pesan->jns_kwdk ?>" disabled>
        </div>

      </div>
    </div>

    <div class="modal-footer">
      <button type="submit" class="btn btn-primary btn-block">Terima</button>
      <button type="button" class="btn btn-warning btn-block">Tolak</button>
      <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
    </div>
</form>

<script>
  $(document).on('submit', '#confirm_data_mhs', function(e) {
    e.preventDefault();
    var form = this;
    $.ajax({
      type: $(form).attr('method'),
      url: $(form).attr('action'),
      data: new FormData(form),
      processData: false,
      contentType: false,
      cache: false,
      success: function(res) {
        window.location.reload()
        toasts_success(res.icon, res.title)
      }
    });
  })
</script>
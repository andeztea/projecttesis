
  <div class="modal-header d-flex justify-content-center">
    <h2>Registrasi Masyarakat</h2>
  </div>
  <div class="modal-body">
    <form action="<?= site_url('AuthController/register_msyr') ?>" method="post" enctype="multipart/form-data" id="msyr_form">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <strong for="nama_pt">Perguruan Tinggi</strong>
            <select name="nama_pt" id="nama_pt" class="form-control select2Msyr">
              <option value="">-- Pilihan --</option>
              <?php foreach ($pertig as $perti) { ?>
                <option value="<?= $perti->id ?>"><?= $perti->nama ?></option>
              <?php } ?>
            </select>
            <small class="text-danger nama_pt_error"></small>
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group">
            <strong for="nama_kel">Nama Kelompok Kewirausahaan</strong>
            <input type="text" name="nama_kel" id="nama_kel" class="form-control" placeholder="Nama Kelompok" aria-describedby="nama_kel">
            <small class="text-danger nama_kel_error"></small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <strong for="nama_ket">Ketua Kelompok</strong>
            <input type="text" name="nama_ket" id="nama_ket" class="form-control" placeholder="Nama Ketua Kelompok" aria-describedby="nama_ket">
            <small class="text-danger nama_ket_error"></small>
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group">
            <strong for="kontak">Kontak</strong>
            <input type="text" name="kontak" id="kontak" class="form-control" placeholder="Kontak Perguruan Tinggi" aria-describedby="kontak">
            <small class="text-danger kontak_error"></small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <strong for="email">Email</strong>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email Perguruan Tinggi" aria-describedby="email">
            <small class="text-danger email_error"></small>
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group">
            <strong for="jml_anggota">Jumlah Anggota Kelompok</strong>
            <input type="number" name="jml_anggota" id="jml_anggota" class="form-control" placeholder="" aria-describedby="jml_anggota">
            <small class="text-danger jml_anggota_error"></small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <strong for="alamat">Alamat</strong>
            <input type="text" name="alamat" id="alamat" class="form-control" placeholder="Alamat Perguruan Tinggi" aria-describedby="alamat">
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
          <strong>Jenis Produk/Jasa Usaha Untuk Kegiatan Pendampingan <small class="text-danger jns_produk_error"></small></strong>
          <select class="form-control jns_produks" name="jns_produk">
            <optgroup label="Pengolahan Kegiatan Usaha Hasil Pertanian">
              <option value="Sagu">Sagu</option>
              <option value="Ubi Jalar">Ubi Jalar</option>
              <option value="Ubi Talas">Ubi Talas</option>
              <option value="Kacang Tanah">Kacang Tanah</option>
              <option value="Bawang Merah">Bawang Merah</option>
              <option value="Jagung">Jagung</option>
              <option value="Pisang">Pisang</option>
            <optgroup label="Pembuatan Aplikasi Penjualan">
              <option value="Pembuatan Aplikasi Penjualan (E-Commerce)">E-Commerce</option>
          </select>
          <input type="text" class="form-control form-control-sm mt-2 clear_val" name="jns_produk_lainnya" id="jns_produk_lainnya" placeholder="Lainnya">
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <strong for="userfile">Foto KTP</strong>
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

    $('.select2Msyr').select2({
      theme: "bootstrap4",
      dropdownParent: $(".myModal"),
      placeholder: "--Pilih--",
    })

    var select2Msyr = $('.jns_produks').select2({
      theme: "bootstrap4",
      dropdownParent: $(".myModal"),
      placeholder: "--Pilih--",
    })

    $(document).on('click', '#jns_produk_lainnya', function() {
      select2Msyr.val(null).trigger("change");
    })

    $(document).on('change', '.jns_produks', function() {
      $('.clear_val').val(null)
    })

    $(document).on('submit', '#msyr_form', function(e) {
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
  });
</script>
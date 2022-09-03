
  <div class="modal-header d-flex justify-content-center">
    <h2>Registrasi Perguruan Tinggi</h2>
  </div>
  <div class="modal-body">
    <form action="<?= site_url('AuthController/register_perti') ?>" method="post" enctype="multipart/form-data" id="perti_form">
      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <strong for="kode">Kode</strong>
            <input type="text" name="kode" id="kode" class="form-control" placeholder="Kode Perguruan Tinggi" aria-describedby="kode">
            <small class="text-danger kode_error"></small>
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group">
            <strong for="nama">Nama Perguruan Tinggi</strong>
            <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Perguruan Tinggi" aria-describedby="nama">
            <small class="text-danger nama_error"></small>
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group">
            <strong for="rektor">Nama Rektor</strong>
            <input type="text" name="rektor" id="rektor" class="form-control" placeholder="Nama Rektor" aria-describedby="rektor">
            <small class="text-danger rektor_error"></small>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm">
          <div class="form-group">
            <strong for="kontak">Kontak</strong>
            <input type="text" name="kontak" id="kontak" class="form-control" placeholder="Kontak Perguruan Tinggi" aria-describedby="kontak">
            <small class="text-danger kontak_error"></small>
          </div>
        </div>

        <div class="col-sm">
          <div class="form-group">
            <strong for="email">Email</strong>
            <input type="email" name="email" id="email" class="form-control" placeholder="Email Perguruan Tinggi" aria-describedby="email">
            <small class="text-danger email_error"></small>
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
          <div class="form-group">
            <strong for="userfile">Logo</strong>
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

    $('.select2Perti').select2({
      theme: "bootstrap4",
      dropdownParent: $(".myModal"),
      placeholder: "--Pilih--",
    })

    $(document).on('submit', '#perti_form', function(e) {
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
<div class="modal-content">
    <div class="modal-header d-flex justify-content-center">
        <h2>Tambah Dosen</h2>
    </div>
    <div class="modal-body">
        <form action="<?= site_url('AuthController/store_dosen') ?>" method="post" id="store_dosen">
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <strong for="nama">Nama Dosen</strong>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Dosen" aria-describedby="nama">
                        <small class="text-danger nama"></small>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-group">
                        <strong for="email">Email</strong>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email@gmail.com" aria-describedby="email">
                        <small class="text-danger email"></small>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-group">
                        <strong for="kontak">Kontak</strong>
                        <input type="text" name="kontak" id="kontak" class="form-control" placeholder="Kontak" aria-describedby="kontak">
                        <small class="text-danger kontak"></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <strong for="username">Username</strong>
                        <input type="text" name="username" id="username" class="form-control" placeholder="username" aria-describedby="username">
                        <small class="text-danger username"></small>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-group">
                        <strong for="password">Password</strong>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" aria-describedby="password">
                        <small class="text-danger password"></small>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-group">
                        <strong for="cpassword">Confirmasi Password</strong>
                        <input type="password" name="cpassword" id="cpassword" class="form-control" placeholder="Confirmasi Password" aria-describedby="cpassword">
                        <small class="text-danger cpassword"></small>
                    </div>
                </div>
            </div>
            <!-- 
            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <strong for="alamat">Alamat</strong>
                        <input type="textarea" name="alamat" class="form-control">
                        <small class="text-danger alamat"></small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm">
                    <div class="form-group">
                        <strong for="provinsi">Provinsi</strong>
                        <select name="provinsi" id="provinsi" class="form-control provinsi">
                        </select>
                        <small class="text-danger kabupaten"></small>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-group">
                        <strong for="kabupaten">Kabupaten</strong>
                        <select name="kabupaten" id="kabupaten" class="form-control kabupaten" disabled>
                        </select>
                        <small class="text-danger kabupaten"></small>
                    </div>
                </div>

                <div class="col-sm">
                    <div class="form-group">
                        <strong for="kecamatan">Kecamatan</strong>
                        <select name="kecamatan" id="kecamatan" class="form-control kecamatan" disabled>
                        </select>
                        <small class="text-danger kecamatan"></small>
                    </div>
                </div>
            </div> -->

            <div class="row">
                <div class="col-6">
                    <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Close</button>
                </div>
                <!-- /.col -->
                <div class="col-6">
                    <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
</div>

<script>
    $(document).on('submit', '#store_dosen', function(e) {
        e.preventDefault();
        var form = this;
        $.ajax({
            type: $(form).attr('method'),
            url: $(form).attr('action'),
            data: new FormData(form),
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
                    $(form)[0].reset();
                    window.location.reload()
                    toasts_success(res.icon, res.title)
                }
            }
        });
    })
</script>
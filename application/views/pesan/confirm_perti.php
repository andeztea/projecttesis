<form action="<?php echo site_url('PesanController/confirm_data_perti/' . $pesan->id) ?>" method="post" enctype="multipart/form-data" id="confirm_data_perti">
    <div class="modal-header elevation-1 d-flex justify-content-center">
        <h3>KONFIRMASI PENDAFTARAN PERGURUAN TINGGI</h3>
    </div>

    <div class="modal-body elevation-1">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-muted m-0">Nama Perguruan Tinggi</label>
                    <input type="text" class="form-control" name="nama" value="<?= $pesan->nama ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Nama Perguruan Tinggi</label>
                    <input type="text" class="form-control" name="nama" value="<?= $pesan->rektor ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Kontak Perguruan Tinggi</label>
                    <input type="text" class="form-control" name="kontak" value="<?= $pesan->kontak ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Email</label>
                    <input type="email" class="form-control" name="email" value="<?= $pesan->email ?>" disabled>
                </div>
            </div>

            <div class="col-md-6">
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
                        <label class="text-muted m-0 d-flex justify-content-center">Logo</label>
                        <div class="text-center mt-2">
                            <img class="profile-user-img img-fluid img-square" src="<?= base_url('uploads/' . $pesan->userfile) ?>" alt="User profile picture" style="height: 180px ;width: 244px">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Alamat</label>
                    <textarea class="form-control" name="alamat" rows="1" disabled><?= $pesan->alamat ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <div class="row">
            <div class="col-sm"><button type="submit" class="btn btn-primary btn-block">Terima</button></div>
            <div class="col-sm"> <button type="button" class="btn btn-warning btn-block">Tolak</button></div>
            <div class="col-sm"><button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button></div>
        </div>
    </div>
</form>

<script>
    $(document).on('submit', '#confirm_data_perti', function(e) {
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
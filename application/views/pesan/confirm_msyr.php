<form action="<?= site_url('PesanController/confirm_data_msyr/' . $pesan->id) ?>" method="post" enctype="multipart/form-data" id="confirm_data_msyr">
    <div class="modal-header elevation-1 d-flex justify-content-center">
        <h3>KONFIRMASI PENDAFTARAN MASYARAKAT</h3>
    </div>

    <div class="modal-body elevation-1">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Pilih Perguruan Tinggi *<small class="text-danger error-text nama_pt_error"></small></label>
                    <select class="form-control select2bs4" name="kode_pt" disabled>
                        <option value=""><?= $pesan->nama_pt ?></option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Nama Kelompok Kewirausahaan *<small class="text-danger error-text nama_kel_error"></small></label>
                    <input type="text" class="form-control" name="nama_kel" value="<?= $pesan->nama_kel ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Ketua Kelompok*<small class="text-danger error-text ket_kel_error"></small> </label>
                    <input type="text" class="form-control" name="ket_kel" value="<?= $pesan->nama_ket ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Jumlah Anggota Kelompok *<small class="text-danger error-text jml_kel_error"></small></label>
                    <input type="number" class="form-control" name="jml_kel" value="<?= $pesan->jml_anggota ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Kontak/No. Handphone *<small class="text-danger error-text kontak_kel_error"></small></label>
                    <input type="text" class="form-control" name="kontak_kel" value="<?= $pesan->kontak ?>" disabled>
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
                        <label class="text-muted m-0 d-flex justify-content-center">Foto KTP</label>
                        <div class="text-center mt-2">
                            <img class="profile-user-img img-fluid img-square" src="<?= base_url('uploads/' . $pesan->userfile) ?>" alt="User profile picture" style="height: 180px ;width: 244px">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Alamat *<small class="text-danger error-text alamat_error"></small></label>
                    <textarea class="form-control" name="alamat" rows="1" disabled><?= $pesan->alamat ?></textarea>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Jenis Produk/Jasa Usaha Untuk Kegiatan Pendampingan *<small class="text-danger error-text jns_produk_error"></small></label>
                    <input type="text" class="form-control" name="produk_lainnya" id="jns_produk" value="<?= $pesan->jns_produk ?>" disabled>
                </div>
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
    $(document).on('submit', '#confirm_data_msyr', function(e) {
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
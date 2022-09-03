<form action="<?= site_url('MasyarakatController/update/' . $masyarakat->id) ?>" method="post" enctype="multipart/form-data" id="form_update_msyr">

    <div class="modal-header elevation-1 d-flex justify-content-center">
        <h3><?= $masyarakat->nama_kel ?></h3>
    </div>

    <div class="modal-body elevation-1">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Pilih Perguruan Tinggi *<small class="text-danger id_pt"></small></label>
                    <select class="form-control select2bs4" name="id_pt" disabled>
                        <?php foreach ($pertis as $perti) { ?>
                            <option <?= $masyarakat->id_pt == $perti->id ? 'selected' : '' ?> value="<?= $perti->id ?>"><?= $perti->nama ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Nama Kelompok Kewirausahaan *<small class="text-danger nama_kel"></small></label>
                    <input type="text" class="form-control" name="nama_kel" value="<?= $masyarakat->nama_kel ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Ketua Kelompok*<small class="text-danger nama_ket"></small> </label>
                    <input type="text" class="form-control" name="nama_ket" value="<?= $masyarakat->nama_ket ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Jumlah Anggota Kelompok *<small class="text-danger jml_anggota"></small></label>
                    <input type="number" class="form-control" name="jml_anggota" value="<?= $masyarakat->jml_anggota ?>" disabled>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Kontak/No. Handphone *<small class="text-danger kontak"></small></label>
                    <input type="text" class="form-control" name="kontak" value="<?= $masyarakat->kontak ?>" disabled>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="text-muted m-0" for="provinsi">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control provinsi" disabled>
                                <option selected value="<?= $masyarakat->provinsi ?>"><?= $masyarakat->nama_prov ?></option>
                            </select>
                            <small class="text-danger provinsi_error"></small>
                        </div>

                        <div class="form-group">
                            <label class="text-muted m-0" for="kabupaten">Kabupaten</label>
                            <select name="kabupaten" id="kabupaten" class="form-control kabupaten" disabled>
                                <option selected value="<?= $masyarakat->kabupaten ?>"><?= $masyarakat->nama_kab ?></option>
                            </select>
                            <small class="text-danger kabupaten_error"></small>
                        </div>

                        <div class="form-group">
                            <label class="text-muted m-0" for="kecamatan">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control kecamatan" disabled>
                                <option selected value="<?= $masyarakat->kecamatan ?>"><?= $masyarakat->nama_kec ?></option>
                            </select>
                            <small class="text-danger kecamatan_error"></small>
                        </div>
                    </div>

                    <?php
                    if ($masyarakat->userfile == NULL) {
                        $userfile = base_url('assets/dist/img/kemdikbud.jpg');
                    } else {
                        $userfile = base_url('uploads/' . $masyarakat->userfile);
                    }
                    ?>

                    <div class="col-md-6">
                        <label class="text-muted m-0 d-flex justify-content-center">Foto KTP</label>
                        <div class="text-center mt-2">
                            <img class="profile-user-img img-fluid img-square" src="<?= $userfile ?>" alt="User profile picture" style="height: 150px ;width: 244px">
                        </div>
                        <input type="file" class="form-control-sm" name="userfile" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Alamat *<small class="text-danger alamat"></small></label>
                    <textarea class="form-control" disabled name="alamat" rows="1"><?= $masyarakat->alamat ?></textarea>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Jenis Produk/Jasa Usaha Untuk Kegiatan Pendampingan *<small class="text-danger alamat"></small></label>
                    <textarea class="form-control" disabled name="alamat" rows="1"><?= $masyarakat->jns_produk ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
    </div>
</form>

<script>
    regionSelect2();
    $('.select2bs4').select2({
        theme: "bootstrap4",
        dropdownParent: $("#myModal"),
        placeholder: "--Pilih--",
    })

    var select2bs4 = $('.jns_produks').select2({
        theme: "bootstrap4",
        dropdownParent: $(".myModal"),
        placeholder: "--Pilih--",
    })

    $(document).on('click', '#jns_produk_lainnya', function() {
        select2bs4.val(null).trigger("change");
    })

    $(document).on('change', '.jns_produks', function() {
        $('.clear_val').val(null)
    })
</script>
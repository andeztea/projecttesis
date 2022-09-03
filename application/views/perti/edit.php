<form action="<?= site_url('PertiController/update/' . $perti->id) ?>" method="post" enctype="multipart/form-data" id="form_update_perti">
    <div class="modal-header elevation-1 d-flex justify-content-center">
        <h3><?= $perti->nama ?></h3>
    </div>

    <div class="modal-body elevation-1">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="text-muted m-0">Nama Perguruan Tinggi *<small class="text-danger nama"></small></label>
                    <input type="text" class="form-control" name="nama" value="<?= $perti->nama ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-muted m-0">Kode Perguruan Tinggi *<small class="text-danger  kode"></small></label>
                    <input type="text" class="form-control" name="kode" value="<?= $perti->kode ?>">
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Nama Rektor *<small class="text-danger  rektor"></small></label>
                    <input type="text" class="form-control" name="rektor" value="<?= $perti->rektor ?>">
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Kontak Perguruan Tinggi *<small class="text-danger  kontak"></small></label>
                    <input type="text" class="form-control" name="kontak" value="<?= $perti->kontak ?>">
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Email *<small class="text-danger  email"></small></label>
                    <input type="email" class="form-control" name="email" value="<?= $perti->email ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <strong for="provinsi">Provinsi</strong>
                            <select name="provinsi" id="provinsi" class="form-control provinsi">
                                <option value="">-- Pilihan --</option>
                                <option selected value="<?= $perti->provinsi ?>"><?= $perti->nama_prov ?></option>
                            </select>
                            <small class="text-danger provinsi_error"></small>
                        </div>

                        <div class="form-group">
                            <strong for="kabupaten">Kabupaten</strong>
                            <select name="kabupaten" id="kabupaten" class="form-control kabupaten">
                                <option value="">-- Pilihan --</option>
                                <option selected value="<?= $perti->kabupaten ?>"><?= $perti->nama_kab ?></option>
                            </select>
                            <small class="text-danger kabupaten_error"></small>
                        </div>

                        <div class="form-group">
                            <strong for="kecamatan">Kecamatan</strong>
                            <select name="kecamatan" id="kecamatan" class="form-control kecamatan">
                                <option value="">-- Pilihan --</option>
                                <option selected value="<?= $perti->kecamatan ?>"><?= $perti->nama_kec ?></option>
                            </select>
                            <small class="text-danger kecamatan_error"></small>
                        </div>
                    </div>

                    <?php
                    if ($perti->userfile == NULL) {
                        $userfile = base_url('assets/dist/img/kemdikbud.jpg');
                    } else {
                        $userfile = base_url('uploads/' . $perti->userfile);
                    }
                    ?>

                    <div class="col-md-6">
                        <label class="text-muted m-0 d-flex justify-content-center">Logo *<small class="text-danger userfile"></small></label>
                        <div class="text-center mt-2">
                            <img class="profile-user-img img-fluid img-square" src="<?= $userfile ?>" alt="User profile picture" style="height: 150px ;width: 244px">
                        </div>
                        <input type="file" class="form-control-sm" name="userfile">
                    </div>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Alamat *<small class="text-danger  alamat"></small></label>
                    <textarea class="form-control" name="alamat" rows="1"><?= $perti->alamat ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block">Update</button>
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
</script>
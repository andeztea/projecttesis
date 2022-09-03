<form action="<?= site_url('KelasController/update/' . $kelas->id) ?>" method="post" id="form_update_kelas">
    <div class="modal-header elevation-1 d-flex justify-content-center py-2">
        <h4><strong>Edit Kelas</strong></h4>
    </div>

    <div class="modal-body elevation-1">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="text-muted m-0">Kode Kelas</label>
                    <input type="text" class="form-control" name="kode_kelas" value="<?= $kelas->kode_kelas ?>">
                    <small class="text-danger error-text kode_kelas"></small>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Nama Kelas</label>
                    <input type="text" class="form-control" name="nama_kelas" value="<?= $kelas->nama_kelas ?>">
                    <small class="text-danger error-text nama_kelas"></small>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Mata Kuliah</label>
                    <input type="text" class="form-control" name="mata_kuliah" value="<?= $kelas->mata_kuliah ?>">
                    <small class="text-danger error-text mata_kuliah"></small>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">SKS</label>
                    <input type="text" class="form-control" name="sks" value="<?= $kelas->sks ?>">
                    <small class="text-danger error-text sks"></small>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
    </div>
</form>
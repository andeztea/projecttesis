<form action="<?= site_url('FakultasController/update/' . $fakultas->id) ?>" method="post" id="form_store_fakultas">
    <div class="modal-header elevation-1 d-flex justify-content-center py-2">
        <h4><strong>Tambah Fakultas</strong></h4>
    </div>

    <div class="modal-body elevation-1">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Kode Fakultas *<small class="text-danger kd_fakultas"></small></label>
                    <input type="text" class="form-control" name="kd_fakultas" value="<?= $fakultas->kd_fakultas ?>">
                </div>

                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Nama Fakultas *<small class="text-danger fakultas"></small></label>
                    <input type="text" class="form-control" name="fakultas" value="<?= $fakultas->fakultas ?>">
                </div>

                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Kode Jurusan *<small class="text-danger kd_jurusan"></small></label>
                    <input type="text" class="form-control" name="kd_jurusan" value="<?= $fakultas->kd_jurusan ?>">
                </div>

                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Nama Jurusan *<small class="text-danger jurusan"></small></label>
                    <input type="text" class="form-control" name="jurusan" value="<?= $fakultas->jurusan ?>">
                </div>

                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Kode Prodi *<small class="text-danger kd_prodi"></small></label>
                    <input type="text" class="form-control" name="kd_prodi" value="<?= $fakultas->kd_program_studi ?>">
                </div>

                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Nama Prodi *<small class="text-danger program_studi"></small></label>
                    <input type="text" class="form-control" name="program_studi" value="<?= $fakultas->program_studi ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
    </div>
</form>
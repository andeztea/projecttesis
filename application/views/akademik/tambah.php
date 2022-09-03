<form action="<?= site_url('AkademikController/store') ?>" method="post" id="form_store_akademik">
    <div class="modal-header elevation-1 d-flex justify-content-center py-2">
        <h4><strong>Tambah Periode</strong></h4>
    </div>

    <div class="modal-body elevation-1">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Tahun Akademik *<small class="text-danger thn_akademik"></small></label>
                    <input type="text" class="form-control" name="thn_akademik">
                </div>

                <div class="form-group">
                    <div class="form-group">
                        <label class="text-muted d-flex justify-content-center m-0">Pilih Periode *<small class="text-danger periode"></small></label>
                        <select class="form-control select2bs4" name="periode">
                            <option value="">--Pilih--</option>
                            <option value="Ganjil">Ganjil</option>
                            <option value="Genap">Genap</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
    </div>
</form>
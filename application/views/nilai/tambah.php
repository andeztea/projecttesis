<form action="<?= site_url('NilaiController/store') ?>" method="post" id="form_store_nilai">
    <div class="modal-header elevation-1 d-flex justify-content-center py-2">
        <h4><strong>Tambah Bobot Nilai</strong></h4>
    </div>

    <div class="modal-body elevation-1">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Tahun Akademik</label>
                    <select class="form-control select2bs4" name="id_akd">
                        <option value="">--Pilih--</option>
                        <?php foreach ($akademiks as $akademik) { ?>
                            <option value="<?= $akademik->id ?>"><?= $akademik->thn_akademik ?> / <?= $akademik->periode ?></option>
                        <?php } ?>
                    </select>
                    <small class="text-danger d-flex justify-content-center id_akd"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-muted m-0">Nilai Min</label>
                    <input type="text" step="any" class="form-control" name="nilai_min">
                    <small class="text-danger error-text nilai_min"></small>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Nilai Huruf</label>
                    <input type="text" class="form-control" name="nilai_huruf">
                    <small class="text-danger error-text nilai_huruf"></small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-muted m-0">Nilai Max</label>
                    <input type="text" step="any" class="form-control" name="nilai_max">
                    <small class="text-danger error-text nilai_max"></small>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0">Keterangan</label>
                    <select class="form-control select2bs4" name="keterangan">
                        <option value="">--Pilih--</option>
                        <option value="1">Lulus</option>
                        <option value="2">Tidak Lulus</option>
                    </select>
                    <small class="text-danger error-text keterangan"></small>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
    </div>
</form>

<script>
    $('.select2bs4').select2({
        theme: "bootstrap4",
        dropdownParent: $(".myModal"),
        placeholder: "--Pilih--",
    })
</script>
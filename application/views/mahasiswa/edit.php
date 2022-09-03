<form action="<?= site_url('MahasiswaController/update/' . $mahasiswa->id) ?>" method="post" enctype="multipart/form-data" id="form_update_mhs">
    <div class="modal-header elevation-1 d-flex justify-content-center">
        <h3>EDIT MAHASISWA</h3>
    </div>

    <div class="modal-body elevation-1">
        <div class="row">
            <div class="col-md">
                <div class="form-group">
                    <label class="text-muted d-flex justify-content-center m-0">Pilih Perguruan Tinggi *<small class="text-danger nama_pt"></small></label>
                    <select class="form-control select2bs4" name="nama_pt">
                        <option value="">-- Pilihan --</option>
                        <?php foreach ($pertis as $perti) { ?>
                            <option <?= $perti->id == $mahasiswa->id_pt  ? 'selected' : '' ?> value="<?= $perti->id ?>"><?= $perti->nama ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        
            <div class="col-sm">
                <div class="form-group">
                    <strong for="nama_dosen">Dosen</strong>
                    <select name="nama_dosen" id="nama_dosen" class="form-control select2bs4" >
                        <option value="">-- Pilihan --</option>
                        <?php foreach ($dosenn as $dosen) { ?>
                            <option <?= $dosen->id == $mahasiswa->id_dosen ? 'selected' : '' ?> value="<?= $dosen->id ?>"><?= $dosen->nama ?></option>
                        <?php } ?>
                    </select>
                    <small class="text-danger nama_dosen_error"></small>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label class="text-muted m-0">Nomor Induk Mahasiswa *<small class="text-danger nim"></small></label>
                    <input type="text" class="form-control" name="nim" value="<?= $mahasiswa->nim ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="text-muted m-0">Nama Mahasiswa *<small class="text-danger  nama"></small></label>
                    <input type="text" class="form-control" name="nama" value="<?= $mahasiswa->nama ?>">
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label class="text-muted m-0">Kontak/No. Handphone *<small class="text-danger  kontak"></small></label>
                    <input type="text" class="form-control" name="kontak" value="<?= $mahasiswa->kontak ?>">
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label class="text-muted m-0" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email Perguruan Tinggi" aria-describedby="email" value="<?= $mahasiswa->email ?>">
                    <small class="text-danger email"></small>
                </div>
            </div>  
        </div>

        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label class="text-muted m-0">Fakultas / Jurusan / Prodi*<small class="text-danger fakultas"></small></label>
                    <select name="fakultas" id="fakultas" class="form-control select2bs4">
                        <option value="">-- Pilihan --</option>
                        <?php foreach ($fakuls as $fakultas) { ?>
                            <option <?= $fakultas->id == $mahasiswa->id_fakultas ? 'selected' : '' ?> value="<?= $fakultas->id ?>"><?= $fakultas->fakultas ?> / <?= $fakultas->jurusan ?> / <?= $fakultas->program_studi ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class="text-muted m-0">Semester *<small class="text-danger  semester"></small></label>
                    <select name="semester" id="semester" class="form-control select2bs4">
                        <option value="<?= $mahasiswa->id_semester ?>"><?= $mahasiswa->id_semester ?></option>
                        <option value="1">Semester I</option>
                        <option value="2">Semester II</option>
                        <option value="3">Semester III</option>
                        <option value="4">Semester IV</option>
                        <option value="5">Semester V</option>
                        <option value="6">Semester VI</option>
                        <option value="7">Semester VII</option>
                    </select>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label class="text-muted m-0">Tahun Akademik / Periode*<small class="text-danger thn_akademik"></small></label>
                    <select name="thn_akademik" id="thn_akademik" class="form-control select2bs4">
                        <option value="">-- Pilihan --</option>
                        <?php foreach ($akademika as $akademik) { ?>
                            <option <?= $akademik->id == $mahasiswa->id_akd ? 'selected' : '' ?> value="<?= $akademik->id ?>"><?= $akademik->thn_akademik ?> / <?= $akademik->periode ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="text-muted m-0" for="provinsi">Provinsi</label>
                    <select name="provinsi" id="provinsi" class="form-control provinsi">
                        <option selected value="<?= $mahasiswa->provinsi ?>"><?= $mahasiswa->nama_prov ?></option>
                    </select>
                    <small class="text-danger provinsi_error"></small>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0" for="kabupaten">Kabupaten</label>
                    <select name="kabupaten" id="kabupaten" class="form-control kabupaten">
                        <option selected value="<?= $mahasiswa->kabupaten ?>"><?= $mahasiswa->nama_kab ?></option>
                    </select>
                    <small class="text-danger kabupaten_error"></small>
                </div>

                <div class="form-group">
                    <label class="text-muted m-0" for="kecamatan">Kecamatan</label>
                    <select name="kecamatan" id="kecamatan" class="form-control kecamatan">
                        <option selected value="<?= $mahasiswa->kecamatan ?>"><?= $mahasiswa->nama_kec ?></option>
                    </select>
                    <small class="text-danger kecamatan_error"></small>
                </div>
            </div>
            <?php
            if ($mahasiswa->userfile == NULL) {
                $userfile = base_url('assets/dist/img/kemdikbud.jpg');
            } else {
                $userfile = base_url('uploads/' . $mahasiswa->userfile);
            }
            ?>
            <div class="col-md-6">
                <label class="text-muted m-0 d-flex justify-content-center">Kartu Mahasiswa</label>
                <div class="text-center mt-0">
                    <img class="profile-user-img img-fluid img-square" src="<?= $userfile ?>" alt="User profile picture" style="height: 150px ;width: 100%">
                </div>
                <input type="file" class="d-flex justify-content-center mt-2" name="userfile">
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="text-muted m-0">Alamat *<small class="text-danger alamat"></small></label>
                    <textarea class="form-control" name="alamat" rows="3"><?= $mahasiswa->alamat ?></textarea>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label class="text-muted m-0">Jenis Kegiatan Kewirausahaan Diluar Kampus *<small class="text-danger  jns_kwdk"></small></label>
                    <div class="card">
                        <div class="card-header px-2 py-1">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input jns_kwdk" type="radio" id="customRadio" name="jns_kwdk" value="Pendampingan Masyarakat" <?= $mahasiswa->jns_kwdk == 'Pendampingan Masyarakat' ? 'checked' : '' ?>>
                                <label for="customRadio" class="custom-control-label text-muted">Pendampingan Masyarakat</label>
                            </div>

                            <div class="custom-control custom-radio">
                                <input class="custom-control-input jns_kwdk" type="radio" id="customRadio1" name="jns_kwdk" value="Kegiatan Usaha Mandiri" <?= $mahasiswa->jns_kwdk == 'Kegiatan Usaha Mandiri' ? 'checked' : '' ?>>
                                <label for="customRadio1" class="custom-control-label text-muted">Kegiatan Usaha Mandiri</label>
                            </div>
                            <input type="text" class="form-control form-control-sm mt-1 jns_kwdk_lainnya" name="jns_kwdk_lainnya" id="jns_kwdk_lainnya" value="<?= $mahasiswa->jns_kwdk == 'Pendampingan Masyarakat' | $mahasiswa->jns_kwdk == 'Kegiatan Usaha Mandiri' ? NULL : $mahasiswa->jns_kwdk ?>" placeholder="Lainnya">
                        </div>
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
    $(document).ready(function() {
        regionSelect2();

        $('.select2bs4').select2({
            theme: "bootstrap4",
            dropdownParent: $("#myModal"),
            placeholder: "--Pilih--",
        })

        $(document).on('mousedown', '.jns_kwdk_lainnya', function() {
            $("input:radio").prop("checked", false)
        })

        $(document).on('click', '.jns_kwdk', function() {
            $(".jns_kwdk_lainnya").val(<?= $mahasiswa->jns_kwdk == 'Pendampingan Masyarakat' | $mahasiswa->jns_kwdk == 'Kegiatan Usaha Mandiri' ? NULL : $mahasiswa->jns_kwdk ?>)
        })
    });
</script>

<form action="<?= site_url('UserController/update/' . $users->id) ?>" method="POST" enctype="multipart/form-data" id="form_update_users">

    <?php
    if ($users->userfile == NULL) {
        $userfile = base_url('assets/dist/img/kemdikbud.jpg');
    } else {
        $userfile = base_url('uploads/' . $users->userfile);
    }
    ?>

    <div class="modal-header elevation-1 d-flex justify-content-center py-2">
        <h4><strong><?= $users->nama ?></strong></h4>
    </div>

    <div class="modal-body">
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="<?= $userfile ?>" alt="User profile picture" style="width: 128px; height: 128px">
                        </div>
                        <h3 class="profile-username text-center"> <?= $users->nama ?></h3>
                        <p class="text-muted text-center"> <?= $users->id_role ?></p>
                        <hr>
                        <strong><i class="fas fa-book mr-1"></i> Fakultas</strong>
                        <p class="text-muted"> B.S. in Computer Science</p>
                        <hr>
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Jurusan</strong>
                        <p class="text-muted">Malibu, California</p>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-muted">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="nama" value=" <?= $users->nama ?>">
                                <small class="text-danger error-text name_error"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-muted">Kontak/No. HP</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="kontak" value="<?= $users->kontak ?>">
                                <small class="text-danger error-text kontak_error"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-muted">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" value="<?= $users->email ?>">
                                <small class="text-danger error-text email_error"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-muted">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" value="<?= $users->username ?>">
                                <small class="text-danger error-text username_error"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-muted">Upload Foto</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="userfile">
                                <small class="text-danger error-text userfile_error"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-muted">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password">
                                <small class="text-danger error-text password_error"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-muted">Repassword</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="repassword">
                                <small class="text-danger error-text repassword_error"></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <button type="button" class="col-sm-2 btn btn-danger" data-dismiss="modal">Kembali</button>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary btn-block">Update</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
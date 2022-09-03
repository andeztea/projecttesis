<div class="modal-header d-flex justify-content-center">
  <h2>Data Dosen</h2>
</div>

<div class="modal-body">
  <form action="<?= site_url('AuthController/register_mhs') ?>" method="post" enctype="multipart/form-data" id="mhs_form">
  <div class="row d-flex justify-content-center mb-4">
    <?php
      if ($dosen->userfile == NULL) {
        $userfile = base_url('assets/dist/img/kemdikbud.jpg');
      } else {
        $userfile = base_url('uploads/' . $dosen->userfile);
      }
    ?>

    <div class="col-sm-3">
      <img class="profile-user-img img-fluid img-square" src="<?= $userfile ?>" alt="User profile picture" style="height: 300px ;width: 240px">
    </div>

    <div class="col-sm">
        <div class="form-group">
          <strong>Nama Dosen</strong>
          <input type="text" class="form-control" value="<?=$dosen->nama?>" disabled>
        </div>

        <div class="form-group">
          <strong>NIDN</strong>
          <input type="text" class="form-control" value="<?=$dosen->nidn?>" disabled>
        </div>

        <div class="form-group">
          <strong>Kontak</strong>
          <input type="text" class="form-control" value="<?=$dosen->kontak?>" disabled>
        </div>

        <div class="form-group">
          <strong>Email</strong>
          <input type="text" class="form-control" value="<?=$dosen->email?>" disabled>
        </div>
    </div>
  </div>

    <div class="row">
      
    </div>

    <div class="row">
       <div class="col-sm">
        <div class="form-group">
          <strong>Alamat</strong>
          <textarea class="form-control" value="<?=$dosen->alamat?>" disabled></textarea>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-sm">
        <div class="form-group">
          <strong>Provinsi</strong>
          <input type="text" class="form-control" value="<?=$dosen->provinsi?>" disabled>
        </div>
      </div>

      <div class="col-sm">
        <div class="form-group">
          <strong>Kabupaten</strong>
          <input type="text" class="form-control" value="<?=$dosen->kabupaten?>" disabled>
        </div>
      </div>
      
      <div class="col-sm">
        <div class="form-group">
          <strong>Kecamatan</strong>
          <input type="text" class="form-control" value="<?=$dosen->kecamatan?>" disabled>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
    </div>
  </form>
</div>
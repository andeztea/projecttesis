<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Monitoring Kegiatan Mahasiwa</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= site_url('DashController') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Monitoring Kegiatan</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <form action="<?= site_url('KelompokController/store') ?>" method="post" id="form_store_kelompok" enctype="multipart/form-data">
                            <div class="card-header">
                                Monitoring Kegiatan Mahasiwa :
                                <div class="card-tools">
                                    <div class="card-tools">
                                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                                        <a href="<?= site_url('KelompokController') ?>" type="button" class="btn btn-danger btn-sm">Kembali</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <strong for="fakultas">Fakultas/Jurusan/Prodi</strong>
                                            <select name="fakultas" id="fakultas" class="form-control select2bs4">
                                                <option value="">-- Pilihan --</option>
                                                <?php foreach ($fakultass as $fakultas) { ?>
                                                    <option value="<?= $fakultas->id ?>"><?= $fakultas->fakultas ?> / <?= $fakultas->jurusan ?> / <?= $fakultas->program_studi ?></option>
                                                <?php } ?>
                                            </select>
                                            <small class="text-danger fakultas_error"></small>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="form-group">
                                            <strong for="thn_akademik">Tahun Akademik</strong>
                                            <select name="thn_akademik" id="thn_akademik" class="form-control select2bs4">
                                                <option value="">-- Pilihan --</option>
                                                <?php foreach ($akademikk as $akademik) { ?>
                                                    <option value="<?= $akademik->id ?>"><?= $akademik->thn_akademik ?> / <?= $akademik->periode ?></option>
                                                <?php } ?>
                                            </select>
                                            <small class="text-danger thn_akademik_error"></small>
                                        </div>
                                    </div>

                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label class="text-muted d-flex justify-content-center m-0">Kelas </label>
                                            <select class="form-control select2bs4" name="kelas" id="kelas">
                                                <option value="">--Pilihan--</option>
                                                <?php foreach ($kelass as $kelas) { ?>
                                                    <option value="<?= $kelas->id ?>"><?= $kelas->nama_kelas ?> / <?= $kelas->mata_kuliah ?> / <?= $kelas->sks ?></option>
                                                <?php } ?>
                                            </select>
                                            <small class="text-danger kelas_error"></small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm">
                                        <div class="form-group">
                                            <label class="text-muted d-flex justify-content-center m-0">Pendampingan Masyarakat</label>
                                            <select class="form-control" name="id_msyr" id="id_msyr">
                                                <option value="">--Pilih--</option>
                                            </select>
                                            <small class="text-danger id_msyr"></small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-muted d-flex justify-content-center m-0">Kegiatan Usaha Mandiri</label>
                                            <select class="form-control select2bs4" name="id_msyr" id="id_msyr">
                                                <option value="">--Pilih--</option>
                                            </select>
                                            <small class="text-danger id_msyr"></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            Data Mahasiswa :
                            <div class="card-tools">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table-bordered table-hover table" id="mhsTableKegiatan">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Kategori Kegiatan</th>
                                                <th>Jenis Kegiatan Usaha</th>
                                            </tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- REQUIRED SCRIPTS -->
<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/script'); ?>

<script>
    $('.select2bs4').select2({
        theme: "bootstrap4",
        placeholder: "--Pilih--",
    })
</script>
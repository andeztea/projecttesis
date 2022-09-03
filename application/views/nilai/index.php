<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Bobot Nilai</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= site_url('DashController') ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Bobot Nilai</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            Bobot Nilai
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tableNilai" class="table-bordered table-hover table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Akademik</th>
                                        <th>Score Nilai</th>
                                        <th>N. Huruf</td>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/script'); ?>

<script>
    $(document).ready(function() {
        let tableakademik = $('#tableNilai').DataTable({
            processing: true,
            serverSide: true,
            order: [],
            dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
            ajax: {
                url: "<?= site_url('NilaiController/datatables_json') ?>",
                type: "POST",
            },
            columnDefs: [{
                targets: [0], //first column / numbering column
                orderable: false, //set not orderable
            }, ],
        });

        $('#buttons').html("<div class='text-center'>" +
            " <a href='<?= site_url('NilaiController/tambah') ?>' class='btn btn-sm btn-info modal_xxl'>Tambah</a>" +
            "</div>");

        form_submit('#form_store_nilai', '#tableNilai')

        form_submit('#form_update_nilai', '#tableNilai')

        swal_delete('#hapus_nilai', '#tableNilai')
    });
</script>
</body>

</html>
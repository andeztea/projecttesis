<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
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
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            Monitoring Kegiatan Mahasiwa :
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
                            <table class="table-bordered table-hover table" id="tableMonitoring">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Jenis Kegiatan Usaha</th>
                                        <th>Fak/Jur</th>
                                        <th>Program Studi</th>
                                        <th>Tahun Akd.</th>
                                    </tr>
                                </thead>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
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
        let tableakademik = $('#tableMonitoring').DataTable({
            // processing: true,
            // serverSide: true,
            order: [],
            dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
            // ajax: {
            //     url: "<?= site_url('KelasController/datatables_json') ?>",
            //     type: "POST",
            // },
            columnDefs: [{
                targets: [0], //first column / numbering column
                orderable: false, //set not orderable
            }, ],
        });

        $('#buttons').html("<div class='text-center'>" +
            " <a href='<?= site_url('MonitoringController/tambah') ?>' class='btn btn-sm btn-info'>Tambah</a>" +
            "</div>");

        form_submit('#form_store_monitoring', '#tableMonitoring')

        form_submit('#form_update_monitoring', '#tableMonitoring')

        swal_delete('#hapus_monitoring', '#tableMonitoring')
    });
</script>
</body>

</html>
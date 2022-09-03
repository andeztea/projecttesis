<?php $this->load->view('templates/header'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Akademik</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('DashController') ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Akademik</li>
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
              Data Akademik
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
              <table id="akademik_table" class="table-bordered table-hover table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tahun akademik</th>
                    <th>Periode</th>
                    <th>Status</th>
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
    let tableakademik = $('#akademik_table').DataTable({
      processing: true,
      serverSide: true,
      order: [],
      select: {
        style: 'multi',
      },
      dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
      ajax: {
        url: "<?= site_url('AkademikController/akademik_json') ?>",
        type: "POST",
      },
      columnDefs: [{
        targets: [0], //first column / numbering column
        orderable: false, //set not orderable
      }, ],
    });

    $('#buttons').html("<div class='text-center'>" +
      " <a href='<?= site_url('AkademikController/tambah') ?>' class='btn btn-sm btn-info modal_xxl'>Tambah</a>" +
      " <button id='set_aktiv' class='btn btn-sm btn-warning'>Set Aktiv/Tidak Aktiv</button>" +
      " <a href='<?= site_url('AkademikController/hapus') ?>' id='set_hapus' class='btn btn-sm btn-danger'>Hapus</a>" +
      "</div>");

    $('#set_aktiv').click(function(e) {
      e.preventDefault();

      var akademik = [];
      var setActive = [];
      var searchIDs = tableakademik.rows('.selected').data();

      $.each(searchIDs, function(index, value) {
        akademik += '/' + value[4];
        setActive += '/' + value[3];
      });

      $.ajax({
        type: "POST",
        url: "<?= site_url('AkademikController/update') ?>",
        data: {
          akademik: akademik,
          setActive: setActive,
        },
        dataType: "JSON",
        success: function(res) {
          $('#akademik_table').DataTable().ajax.reload(null, false);
          toasts_success(res.icon, res.title)
        }
      });
    });

    $(document).on('click', '#set_hapus', function(e) {
      e.preventDefault();
      var akademik = [];
      var searchIDs = tableakademik.rows('.selected').data();

      $.each(searchIDs, function(index, value) {
        akademik += '/' + value[4];
      });

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            data: {
              akademik: akademik,
            },
            dataType: "JSON",
            success: function(res) {
              $('#akademik_table').DataTable().ajax.reload(null, false);
              toasts_success(res.icon, res.title)
            }
          });
        }
      })
    })

    form_submit('#form_store_akademik', '#akademik_table')

  });
</script>
</body>

</html>
<?php $this->load->view('templates/header'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= site_url('DashController') ?>">Dashboard</a></li>
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
            <div class="card-body">
              <h3 class="display-6 text-center">Cari Perguruan Tinggi</h3>
              <div class="row">
                <div class="col-md-8 offset-md-2">
                  <form action="#">
                    <div class="input-group">
                      <input type="search" class="form-control form-control-lg" placeholder="Type your keywords here">
                      <div class="input-group-append">
                        <button type="submit" class="btn btn-lg btn-default">
                          <i class="fa fa-search"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              Narasi pengenalan model pembelajaran Entrepreneurship yang diinput oleh super admin model
              pembelajaran entrepreneurship
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
              <h4 class="card-title">Title</h4>
              <p class="card-text">Card Text</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">Dokumentasi kegiatan wirausaha mahasiswa di luar kampus</h3>
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
              <div class="row">
                <div class="col-sm-4">
                  <div class="position-relative bg-gray p-3" style="height: 180px">
                    <div class="ribbon-wrapper">
                      <div class="ribbon bg-primary">
                        Ribbon
                      </div>
                    </div>
                    Ribbon Default <br />
                    <small>.ribbon-wrapper.ribbon-lg .ribbon</small>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="position-relative bg-gray p-3" style="height: 180px">
                    <div class="ribbon-wrapper ribbon-lg">
                      <div class="ribbon bg-info">
                        Ribbon Large
                      </div>
                    </div>
                    Ribbon Large <br />
                    <small>.ribbon-wrapper.ribbon-lg .ribbon</small>
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="position-relative bg-gray p-3" style="height: 180px">
                    <div class="ribbon-wrapper ribbon-xl">
                      <div class="ribbon bg-secondary">
                        Ribbon Extra Large
                      </div>
                    </div>
                    Ribbon Extra Large <br />
                    <small>.ribbon-wrapper.ribbon-xl .ribbon</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">Area Chart</h3>
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
              <div class="chart">
                <canvas class="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
</div>
<!-- /.content-wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/script'); ?>
</body>

</html>
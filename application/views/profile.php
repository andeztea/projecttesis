<?php $this->load->view('templates/header'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Profile</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?= site_url('DashController') ?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Profile</li>
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
						<div class="row">
							<div class="col-md-12">

								<?php
								if ($users->userfile == NULL) {
									$userfile = base_url('assets/dist/img/kemdikbud.jpg');
								} else {
									$userfile = base_url('uploads/' . $users->userfile);
								}
								?>

								<div class="card-body box-profile">
									<div class="text-center">
										<img class="profile-user-img img-fluid img-square" src="<?= $userfile ?>" alt="User profile picture" style="height: 240px ;width: 360px">
									</div>

									<h3 class="profile-username text-center"><?= $users->nama ?></h3>

									<p class="text-muted text-center"><?= $users->id_role ?></p>
									<hr>
									<form action="<?= site_url('ProfileController/update/' . $users->id) ?>" method="post" enctype="multipart/form-data" id="updateProfile">
										<div class="form-group">
											<label class="text-muted m-0">Nama</label>
											<input type="text" class="form-control" name="nama" value="<?= $users->nama ?>">
											<small class="text-danger" nama></small>
										</div>

										<div class="form-group">
											<label class="text-muted m-0">Username</label>
											<input type="text" class="form-control" name="username" value="<?= $users->username ?>">
											<small class="text-danger username"></small>
										</div>

										<div class="form-group">
											<label class="text-muted m-0">Email</label>
											<input type="email" class="form-control" name="email" value="<?= $users->email ?>">
											<small class="text-danger email"></small>
										</div>

										<div class="form-group">
											<label class="text-muted m-0">Kontak</label>
											<input type="text" class="form-control" name="kontak" value="<?= $users->kontak ?>">
											<small class="text-danger kontak"></small>
										</div>

										<div class="form-group">
											<label class="text-muted m-0">Photo</label>
											<input type="file" class="form-control" name="userfile">
											<small class="text-danger userfile"></small>
										</div>

										<div class="form-group">
											<label class="text-muted m-0">Password <small class="text-danger">* Kosongkan jika tidak di ubah</small></label>
											<input type="password" class="form-control" name="password">
											<small class="text-danger password"></small>
										</div>

										<div class="form-group">
											<label class="text-muted m-0">Repassword <small class="text-danger">* Kosongkan jika tidak di ubah</small></label>
											<input type="password" class="form-control" name="repassword">
											<small class="text-danger repassword"></small>
										</div>

										<div class="d-flex justify-content-center">
											<button type="submit" class="btn btn-primary mr-4">Update</button>
											<a href="<?= site_url('DashController') ?>" class="btn btn-danger" data-dismiss="modal">Kembali</a>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php $this->load->view('templates/footer'); ?>
<?php $this->load->view('templates/script'); ?>

<script>
	$(document).on('submit', '#updateProfile', function(e) {
		e.preventDefault();
		var form = this;
		$.ajax({
			type: $(form).attr('method'),
			url: $(form).attr('action'),
			data: new FormData(form),
			dataType: "json",
			processData: false,
			contentType: false,
			beforeSend: function() {
				$(form).find('small.text-danger').html();
			},
			success: function(res) {
				if (res.error) {
					$.each(res.error, function(prefix, val) {
						$(form).find('small.' + prefix).html(val)
					})
				} else {
					toasts_success(res.icon, res.title)
				}
			}
		});
	})
</script>

</body>

</html>

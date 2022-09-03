
	<form action="<?= site_url('AuthController/login') ?>" method="post" id="form_login">
		<div class="modal-header elevation-1 d-flex justify-content-center">
			<h3>LOGIN</h3>
		</div>
		<div class="modal-body elevation-1">
			<h4 class="pesan_login text-danger text-center"></h4>
			<div class="row">
				<div class="col-md-4 d-flex align-items-center justify-content-center">
					<div class="elevation-1">
						<img class="image" style="width: 100%; height:180px" src="<?= base_url('assets') ?>/dist/img/kemdikbud.jpg">
					</div>
				</div>

				<div class="col-md-8">
					<div class="form-group">
						<label class="text-muted m-0">Username</label>
						<input type="text" class="form-control" name="username">
					</div>

					<div class="form-group">
						<label class="text-muted m-0">Password</label>
						<input type="password" class="form-control" name="password">
					</div>

					<a class="d-flex justify-content-center text-muted" href="">Lupa Password ?</a>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary btn-block">Login</button>
			<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
		</div>
	</form>

<script>
	$(document).on('submit', '#form_login', function(e) {
		e.preventDefault();
		var form = this;
		$.ajax({
			type: $(form).attr('method'),
			url: $(form).attr('action'),
			data: new FormData(form),
			processData: false,
			contentType: false,
			cache: false,
			success: function(res) {
				if (res.error) {
					$('.pesan_login').text(res.error)
				}

				if (res.login == true) {
					window.location.href = res.url
					// window.location.assign(res.url)
				}

			}
		});
	})
</script>
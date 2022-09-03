<form action="<?= site_url('DosenController/store_mhs/' . $dosen->id_user) ?>" method="post" id="form_store_mhss">
	<div class="modal-header elevation-1 d-flex justify-content-center py-2">
		<h4><strong>Tambah Mahasiswa</strong></h4>
	</div>

	<div class="modal-body elevation-1">
		<div class="row">
			<div class="col-md-12">
				<div class="message text-danger d-flex justify-content-center"></div>
				<table class="table-bordered table-hover table" id="mhsTableAdds">
					<thead>
						<tr>
							<th>No</th>
							<th>NIM</th>
							<th>Nama</th>
							<th>Kontak</th>
							<th>Fakultas / Jurusan / Prodi</th>
							<th>Tahun Ak. / Periode</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary btn-block">Simpan</button>
		<button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Kembali</button>
	</div>
</form>
<script>
	$(document).ready(function() {
		let tablemahasiswa = $('#mhsTableAdds').DataTable({
			processing: true,
			serverSide: true,
			order: [],
			select: {
				style: 'multi',
			},
			dom: "<'row' <'col-md-4'l> <'#buttons.col-md-4'> <'col-md-4'f>> <'row' <'col-sm-12'tr>> <'row' <'col-md-5'i> <'col-md-7'p>>",
			ajax: {
				url: "<?= site_url('DataTableController/datatables_mhs_by_fakultas/' . $dosen->id_fakultas) ?>",
				type: "POST",
			},
			columnDefs: [{
				targets: [0], //first column / numbering column
				orderable: false, //set not orderable
			}, ],
		});

		$(document).on('submit', '#form_store_mhss', function(e) {
			e.preventDefault();
			var form = this;
			var id_mhs = [];
			var searchIDs = tablemahasiswa.rows('.selected').data();

			$.each(searchIDs, function(index, value) {
				id_mhs += '/' + value[6];
			});

			$.ajax({
				type: $(this).attr('method'),
				url: $(this).attr('action'),
				data: {
					id_mhs: id_mhs,
				},
				dataType: "JSON",
				success: function(res) {
					$(form)[0].reset();
					$('.myModal').modal('hide')
					window.location.reload()
					toasts_success(res.icon, res.title)
				}
			});
		})
	});
</script>
</body>

</html>

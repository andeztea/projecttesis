<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MahasiswaController extends CI_Controller
{
	public function index()
	{
		$this->load->view('mahasiswa/index');
	}

	public function datatables_json()
	{
		$this->load->model('MahasiswaModel');
		$cek_role = $this->session->userdata('id_role');
		$cek_perti = $this->session->userdata('id_pt');

		if ($cek_role == "Superadmin") {
			$list = $this->MahasiswaModel->get_datatables_mhs();
			$count = $this->MahasiswaModel->count_all_mhs();
			$count_filter = $this->MahasiswaModel->count_filtered_mhs();
		} else {
			$list = $this->MahasiswaModel->get_datatables_mhs($cek_perti);
			$count = $this->MahasiswaModel->count_all_mhs($cek_perti);
			$count_filter = $this->MahasiswaModel->count_filtered_mhs($cek_perti);
		}

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nama;
			$nestedData[]    = $row->kontak;
			$nestedData[]    = $row->fakultas . '/' . $row->jurusan . '/' . $row->program_studi;
			$nestedData[]    = $row->thn_akademik . '/' . $row->periode;

			if ($cek_role == 'Superadmin') {
				$nestedData[] = "<a class='btn btn-sm btn-info modal_xl' href='" . site_url('MahasiswaController/view/' . $row->id) . "'><i class='fa fa-eye'></i></a>";
			} else {
				$nestedData[]    = "<a class='btn btn-sm btn-warning modal_xl' href='" . site_url('MahasiswaController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
                <a class='btn btn-sm btn-danger' href='" . site_url('MahasiswaController/hapus/' . $row->id) . "' id='Hapus_mhs'><i class='fa fa-trash'></i></a>";
			}

			$nestedData[]    = $row->id;
			$nestedData[]    = $row->nama_pt;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $count,
			"recordsFiltered" => $count_filter,
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function view($id = null)
	{
		$this->load->model('MahasiswaModel');
		$this->load->model('PertiModel');
		$this->load->model('AkademikModel');
		$this->load->model('FakultasModel');

		$mahasiswa =  $this->MahasiswaModel->get_entries($id)->row();
		$perti = $this->db->get('tb_perti')->result();
		$akademik = $this->AkademikModel->get_entries()->result();
		$fakultas = $this->db->get('tb_fakultas')->result();
		$dosen = $this->db->where('id_role', 'Dosen')->where('id_pt', $mahasiswa->id_pt)->get('tb_user')->result();
		$kelas = $this->db->get('tb_kelas')->result();

		$this->load->view('mahasiswa/view', ['dosenn' => $dosen, 'kelass' => $kelas, 'mahasiswa' => $mahasiswa, 'pertis' => $perti, 'akademika' => $akademik, 'fakuls' => $fakultas]);
	}

	public function edit($id = null)
	{
		$this->load->model('MahasiswaModel');
		$this->load->model('PertiModel');
		$this->load->model('AkademikModel');
		$this->load->model('FakultasModel');

		$mahasiswa =  $this->MahasiswaModel->get_entries($id)->row();
		$perti = $this->db->get('tb_perti')->result();
		$akademik = $this->AkademikModel->get_entries()->result();
		$fakultas = $this->db->get('tb_fakultas')->result();
		$dosen = $this->db->where('id_role', 'Dosen')->where('id_pt', $mahasiswa->id_pt)->get('tb_user')->result();
		$kelas = $this->db->get('tb_kelas')->result();

		$this->load->view('mahasiswa/edit', ['dosenn' => $dosen, 'kelass' => $kelas, 'mahasiswa' => $mahasiswa, 'pertis' => $perti, 'akademika' => $akademik, 'fakuls' => $fakultas]);
	}

	public function update($id = null)
	{
		$this->form_validation->set_rules('nama_pt', 'Perguruan Tinggi', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('nim', 'Nim', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('nama', 'Nama', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('kontak', 'Kontak', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('email', 'Email', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('fakultas', 'Fakultas', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('thn_akademik', 'Tahun Akademik', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('semester', 'Semester', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('provinsi', 'Provinsi', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required', ['required' => '%s is required.']);

		$docname = explode('.', $_FILES['userfile']['name']);
		$ext = end($docname);
		$folder = 'uploads/';
		$new_name    = "userfile-" . $this->input->post('nim') . "." . $ext;
		$temp = $_FILES['userfile']['tmp_name'];

		$cek_uname =  $this->db->where('id', $id)->get('tb_mahasiswa')->row();

		if (move_uploaded_file($temp, $folder . $new_name)) {
			$photo = $new_name;
		} else {
			$photo = $cek_uname->userfile;
		}

		if ($this->input->post('jns_kwdk') == null) {
			$data = $this->input->post('jns_kwdk_lainnya');
		} else {
			$data = $this->input->post('jns_kwdk');
		}

		$datapost = [
			'id_pt' => $this->input->post('nama_pt'),
			'id_dosen' => $this->input->post('nama_dosen'),
			'id_fakultas' => $this->input->post('fakultas'),
			'id_akd' => $this->input->post('thn_akademik'),
			'id_semester' => $this->input->post('semester'),
			'nim' => $this->input->post('nim'),
			'nama' => $this->input->post('nama'),
			'kontak' => $this->input->post('kontak'),
			'email' => $this->input->post('email'),
			'jns_kwdk' => $data,
			'alamat' => $this->input->post('alamat'),
			'provinsi' => $this->input->post('provinsi'),
			'kabupaten' => $this->input->post('kabupaten'),
			'kecamatan' => $this->input->post('kecamatan'),
			'userfile' =>  $photo
		];

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'nama_pt' => form_error('nama_pt'),
				'nim' => form_error('nim'),
				'nama' => form_error('nama'),
				'kontak' => form_error('kontak'),
				'email' => form_error('email'),
				'fakultas' => form_error('fakultas'),
				'thn_akademik' => form_error('thn_akademik'),
				'semester' => form_error('semester'),
				'jns_kwdk' => form_error('jns_kwdk'),
				'alamat' => form_error('alamat'),
				'provinsi' => form_error('provinsi'),
				'kabupaten' => form_error('kabupaten'),
				'kecamatan' => form_error('kecamatan'),
			]);
		} else {

			$model = $this->load->model('MahasiswaModel');
			$update = $this->MahasiswaModel->update_entry($datapost, $id);

			if ($update) {
				$response = ['icon' => 'success', 'title' => 'Update Berhasil'];
			} else {
				$response = ['icon' => 'error', 'title' => $model->query_error()];
			}
		}

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}

	public function hapus($id = null)
	{
		$model = $this->load->model('MahasiswaModel');
		$delete = $this->MahasiswaModel->delete_entry($id);

		if ($delete) {
			$this->load->model('PesanModel');
			$this->PesanModel->delete_entry($id, 2);
			$response = ['icon' => 'success', 'title' => 'Hapus Berhasil'];
		} else {
			$response = ['icon' => 'error', 'title' => $model->query_error()];
		}

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}
}

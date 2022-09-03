<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DosenController extends CI_Controller
{
	public function index()
	{
		$this->load->view('dosen/index');
	}

	public function datatables_json()
	{
		$this->load->model('DosenModel');
		$cek_role = $this->session->userdata('id_role');
		$cek_perti = $this->session->userdata('id_pt');

		$list = $this->DosenModel->get_datatables($cek_role, $cek_perti);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nama;
			$nestedData[]    = $row->nama_kelas;
			$nestedData[]    = $row->thn_akademik;

			if ($cek_role != 'Admin') {
				$nestedData[] = "<a class='btn btn-sm btn-info' href='" . site_url('DosenController/view/' . $row->id) . "'><i class='fa fa-eye'></i></a>";
			} else {
				$nestedData[] = "<a class='btn btn-sm btn-warning' href='" . site_url('DosenController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
                <a class='btn btn-sm btn-danger' href='" . site_url('DosenController/hapus/' . $row->id_user . '/' . $row->id_kelas) . "' id='hapus_dosen'><i class='fa fa-trash'></i></a>";
			}

			$nestedData[]    = $row->id;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->DosenModel->count_all($cek_role, $cek_perti),
			"recordsFiltered" => $this->DosenModel->count_filtered($cek_role, $cek_perti),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function tambah()
	{
		$cek_perti = $this->session->userdata('id_pt');
		$this->load->model('UserModel');
		$this->load->model('AkademikModel');
		$this->load->model('FakultasModel');
		$this->load->model('KelasModel');

		$akademik = $this->AkademikModel->get_entries()->result();
		$fakultas = $this->FakultasModel->get_entries(false, $cek_perti)->result();
		$user = $this->UserModel->get_entries_ds(false, $cek_perti)->result();
		$kelas = $this->KelasModel->get_entries(false, $cek_perti)->result();

		$this->load->view('dosen/tambah', ['kelass' => $kelas, 'akademikk' => $akademik, 'fakultass' => $fakultas, 'users' => $user]);
	}

	public function store()
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('id_akd', 'Akademik', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('id_kelas', 'Kelas', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('id_user', 'Dosen', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('id_fakultas', 'Program Studi', 'required', ['required' => '%s is required.']);

			if ($this->form_validation->run() == FALSE) {
				$response = array('error' => [
					'id_akd' => form_error('id_akd'),
					'id_kelas' => form_error('id_kelas'),
					'id_user' => form_error('id_user'),
					'id_fakultas' => form_error('id_fakultas'),
				]);
			} else {
				$datapost = [
					'id_user' => $this->input->post('id_user'),
					'id_pt' => $this->session->userdata('id_pt'),
					'id_akd' => $this->input->post('id_akd'),
					'id_kelas' => $this->input->post('id_kelas'),
					'id_fakultas' => $this->input->post('id_fakultas'),
					'id_kelas' => $this->input->post('id_kelas'),
					'nama' => $this->input->post('nama_dosen'),
				];
				$this->load->model('DosenModel');

				$cekdosen = $this->DosenModel->cek_dosen($datapost['id_user'], $datapost['id_kelas']);

				if (!$cekdosen) {
					$this->DosenModel->insert_entry($datapost);

					$id_mhs_exp = explode('/', $this->input->post('id_mhs'));

					for ($i = 1; $i < count($id_mhs_exp); $i++) {
						$datapost2 = [
							'id_user' => $this->input->post('id_user'),
							'id_pt' => $this->session->userdata('id_pt'),
							'id_akd' => $this->input->post('id_akd'),
							'id_kelas' => $this->input->post('id_kelas'),
							'id_fakultas' => $this->input->post('id_fakultas'),
							'id_kelas' => $this->input->post('id_kelas'),
							'id_mhs' => $id_mhs_exp[$i],
						];

						$this->db->where('id', $id_mhs_exp[$i])->update('tb_mahasiswa', ['sembunyikan' => 'ya']);

						$this->load->model('SetKelasModel');

						$this->SetKelasModel->insert_entry($datapost2);
					}

					$response = ['icon' => 'success', 'title' => 'Tambah Berhasil'];
				} else {
					$response = ['icon' => 'error', 'title' => 'Data Sudah Ada!'];
				}
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
			exit;
		}
	}

	public function tambah_mhs($id = null)
	{
		$this->load->model('DosenModel');

		$dosen = $this->DosenModel->get_entries($id)->row();

		$this->load->view('dosen/tambah_mhs', ['dosen' => $dosen]);
	}

	public function store_mhs($id = null)
	{
		if ($this->input->post()) {
			$this->load->model('DosenModel');
			$dosen = $this->DosenModel->get_entries($id)->row();
			$id_mhs_exp = explode('/', $this->input->post('id_mhs'));

			for ($i = 1; $i < count($id_mhs_exp); $i++) {
				$datapost = [
					'id_user' => $id,
					'id_kelas' => $dosen->id_kelas,
					'id_mhs' => $id_mhs_exp[$i],
				];

				$lodmod = $this->load->model('SetKelasModel');
				$insert = $this->SetKelasModel->insert_entry($datapost);

				if ($insert) {
					$this->db->where('id', $id_mhs_exp[$i])->update('tb_mahasiswa', ['sembunyikan' => 'ya']);
					$response = ['icon' => 'success', 'title' => 'Tambah Berhasil'];
				} else {
					$response = ['icon' => 'error', 'title' => $lodmod->query_error()];
				}
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
			exit;
		}
	}

	public function view($id = null)
	{
		$cek_perti = $this->session->userdata('id_pt');
		$this->load->model('DosenModel');

		$dosen = $this->DosenModel->get_entries($id)->row();

		$this->load->view('dosen/view', ['dosen' => $dosen]);
	}

	public function edit($id = null)
	{
		$this->load->model('DosenModel');

		$dosen = $this->DosenModel->get_entries($id)->row();

		$this->load->view('dosen/edit', ['dosen' => $dosen]);
	}

	public function update($id_dosen = null)
	{
		if ($this->input->post()) {
			$this->form_validation->set_rules('id_akd', 'Akademik', 'required', ['required' => '%s is required.']);


			if ($this->form_validation->run() == FALSE) {
				$response = array('error' => [
					'id_akd' => form_error('id_akd'),
				]);
			} else {
				$datapost = [
					'id_akd' => $this->input->post('id_akd'),
				];

				$this->load->model('DosenModel');
				$this->load->model('SetKelasModel');
				$update = $this->DosenModel->update_entry($datapost, $id_dosen);

				if ($update) {
					$response = ['icon' => 'success', 'title' => 'Update Berhasil'];
				} else {
					$response = ['icon' => 'error', 'title' => 'Update Gagal'];
				}
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
			exit;
		}
	}

	public function hapus($id, $id_kelas)
	{
		$this->load->model('DosenModel');
		$this->load->model('SetKelasModel');

		$cek_SetKelas = $this->db->where('id_user', $id)->where('id_kelas', $id_kelas)->count_all_results('tb_set_kelas');

		if ($cek_SetKelas <= 0) {
			$this->DosenModel->delete_entry($id);
			$response = ['icon' => 'success', 'title' => 'Hapus Berhasil'];
		} else {
			$response = ['icon' => 'error', 'title' => 'Hapus Data Mahasiswa Terlebih Dahulu !'];
		}

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}

	public function set_hapus()
	{
		$datamhs = explode('/', $this->input->post('datamhs'));
		$datakelas = explode('/', $this->input->post('datakelas'));

		for ($i = 1; $i < count($datamhs); $i++) {

			$lodmod = $this->load->model('SetKelasModel');
			$delete = $this->SetKelasModel->delete_entry($datakelas[$i]);
			if ($delete) {
				$this->db->where('id', $datamhs[$i])->update('tb_mahasiswa', ['sembunyikan' => 'tidak']);
				$response = ['icon' => 'success', 'title' => 'Hapus Berhasil'];
			} else {
				$response = ['icon' => 'error', 'title' => $lodmod->query_error()];
			}
		}

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}
}

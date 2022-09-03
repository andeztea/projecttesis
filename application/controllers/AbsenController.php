<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AbsenController extends CI_Controller
{
	public function index()
	{
		$this->load->view('absen/index');
	}

	public function datatables_json()
	{
		$this->load->model('AbsenModel');

		$cek_role = $this->session->userdata('id_role');
		$cek_perti = $this->session->userdata('id_pt');

		$list = $this->AbsenModel->get_datatables($cek_role, $cek_perti);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->thn_akademik;
			$nestedData[]    = $row->kategori;
			$nestedData[]    = $row->skor_nilai;
			$nestedData[]    = "<a class='btn btn-sm btn-warning modal_xxl' href='" . site_url('AbsenController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
            <a class='btn btn-sm btn-danger' href='" . site_url('AbsenController/hapus/' . $row->id) . "' id='hapus_absen'><i class='fa fa-trash'></i></a>";
			$nestedData[]    = $row->id;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->AbsenModel->count_all($cek_role, $cek_perti),
			"recordsFiltered" => $this->AbsenModel->count_filtered($cek_role, $cek_perti),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function tambah()
	{
		$this->load->model('AkademikModel');
		$akademik = $this->AkademikModel->get_entries()->result();
		$this->load->view('absen/tambah', ['akademiks' => $akademik]);
	}

	public function store()
	{
		$this->form_validation->set_rules('id_akd', 'Tahun Akademik', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('kategori', 'Kategori', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('skor_nilai', 'Skor Nilai', 'required', ['required' => '%s is required.']);

		$datapost = [
			'id_pt' => $this->session->userdata('id_pt'),
			'id_akd' => $this->input->post('id_akd'),
			'kategori' => $this->input->post('kategori'),
			'skor_nilai' => $this->input->post('skor_nilai'),
		];

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'id_akd' => form_error('id_akd'),
				'kategori' => form_error('kategori'),
				'skor_nilai' => form_error('skor_nilai'),
			]);
		} else {

			$model = $this->load->model('AbsenModel');
			$insert = $this->AbsenModel->insert_entry($datapost);

			if ($insert) {
				$response = ['icon' => 'success', 'title' => 'Tambah Berhasil'];
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

	public function edit($id = null)
	{
		$this->load->model('AbsenModel');
		$this->load->model('AkademikModel');

		$akademik = $this->AkademikModel->get_entries()->result();
		$absen = $this->AbsenModel->get_entries($id)->row();

		$this->load->view('absen/edit', ['akademiks' => $akademik, 'absen' => $absen]);
	}

	public function update($id = null)
	{
		$this->form_validation->set_rules('id_akd', 'Tahun Akademik', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('kategori', 'Kategori', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('skor_nilai', 'Skor Nilai', 'required', ['required' => '%s is required.']);

		$datapost = [
			'id_akd' => $this->input->post('id_akd'),
			'kategori' => $this->input->post('kategori'),
			'skor_nilai' => $this->input->post('skor_nilai'),
		];

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'id_akd' => form_error('id_akd'),
				'kategori' => form_error('kategori'),
				'skor_nilai' => form_error('skor_nilai'),
			]);
		} else {
			$model = $this->load->model('AbsenModel');
			$insert = $this->AbsenModel->update_entry($datapost, $id);

			if ($insert) {
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
		$model = $this->load->model('AbsenModel');
		$delete = $this->AbsenModel->delete_entry($id);

		if ($delete) {
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

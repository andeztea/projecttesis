<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasController extends CI_Controller
{
	public function index()
	{
		$this->load->view('kelas/index');
	}

	public function datatables_json()
	{
		$this->load->model('KelasModel');

		$cek_role = $this->session->userdata('id_role');
		$cek_perti = $this->session->userdata('id_pt');

		$list = $this->KelasModel->get_datatables($cek_role, $cek_perti);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->kode_kelas;
			$nestedData[]    = $row->nama_kelas;
			$nestedData[]    = $row->mata_kuliah;
			$nestedData[]    = $row->sks;
			$nestedData[]    = "<a class='btn btn-sm btn-warning modal_xxl' href='" . site_url('KelasController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
            <a class='btn btn-sm btn-danger' href='" . site_url('KelasController/hapus/' . $row->id) . "' id='hapus_kelas'><i class='fa fa-trash'></i></a>";
			$nestedData[]    = $row->id;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->KelasModel->count_all($cek_role, $cek_perti),
			"recordsFiltered" => $this->KelasModel->count_filtered($cek_role, $cek_perti),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function tambah()
	{
		$this->load->view('kelas/tambah');
	}

	public function store()
	{
		$this->form_validation->set_rules('kode_kelas', 'Kode Kelas', 'required|is_unique[tb_kelas.kode_kelas]', ['required' => '%s is required.', 'is_unique' => '%s sudah ada.']);
		$this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('mata_kuliah', 'Mata Kuliah', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('sks', 'SKS', 'required', ['required' => '%s is required.']);

		$datapost = [
			'id_pt' => $this->session->userdata('id_pt'),
			'kode_kelas' => $this->input->post('kode_kelas'),
			'nama_kelas' => $this->input->post('nama_kelas'),
			'mata_kuliah' => $this->input->post('mata_kuliah'),
			'sks' => $this->input->post('sks'),
		];

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'kode_kelas' => form_error('kode_kelas'),
				'nama_kelas' => form_error('nama_kelas'),
				'mata_kuliah' => form_error('mata_kuliah'),
				'sks' => form_error('sks'),
			]);
		} else {

			$model = $this->load->model('KelasModel');
			$insert = $this->KelasModel->insert_entry($datapost);

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
		$this->load->model('KelasModel');

		$kelas = $this->KelasModel->get_entries2($id)->row();

		$this->load->view('kelas/edit', ['kelas' => $kelas]);
	}

	public function update($id = null)
	{
		$this->form_validation->set_rules('kode_kelas', 'Kode Kelas', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('nama_kelas', 'Nama Kelas', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('mata_kuliah', 'Mata Kuliah', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('sks', 'SKS', 'required', ['required' => '%s is required.']);

		$datapost = [
			'kode_kelas' => $this->input->post('kode_kelas'),
			'nama_kelas' => $this->input->post('nama_kelas'),
			'mata_kuliah' => $this->input->post('mata_kuliah'),
			'sks' => $this->input->post('sks'),
		];

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'kode_kelas' => form_error('kode_kelas'),
				'nama_kelas' => form_error('nama_kelas'),
				'mata_kuliah' => form_error('mata_kuliah'),
				'sks' => form_error('sks'),
			]);
		} else {

			$model = $this->load->model('KelasModel');
			$insert = $this->KelasModel->update_entry($datapost, $id);

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
		$model = $this->load->model('KelasModel');
		$delete = $this->KelasModel->delete_entry($id);

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

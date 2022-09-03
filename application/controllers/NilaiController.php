<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NilaiController extends CI_Controller
{
	public function index()
	{
		$this->load->view('nilai/index');
	}

	public function datatables_json()
	{
		$this->load->model('NilaiModel');

		$cek_role = $this->session->userdata('id_role');
		$cek_perti = $this->session->userdata('id_pt');

		$list = $this->NilaiModel->get_datatables($cek_role, $cek_perti);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->thn_akademik;
			$nestedData[]    = $row->nilai_min . '-' . $row->nilai_max;
			$nestedData[]    = $row->nilai_huruf;
			$nestedData[]    = "<a class='btn btn-sm btn-warning modal_xxl' href='" . site_url('NilaiController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
            <a class='btn btn-sm btn-danger' href='" . site_url('NilaiController/hapus/' . $row->id) . "' id='hapus_nilai'><i class='fa fa-trash'></i></a>";
			$nestedData[]    = $row->id;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->NilaiModel->count_all($cek_role, $cek_perti),
			"recordsFiltered" => $this->NilaiModel->count_filtered($cek_role, $cek_perti),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function tambah()
	{
		$this->load->model('AkademikModel');
		$akademik = $this->AkademikModel->get_entries()->result();
		$this->load->view('nilai/tambah', ['akademiks' => $akademik]);
	}

	public function store()
	{
		$this->form_validation->set_rules('id_akd', 'Tahun Akademik', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('nilai_min', 'Nilai Min', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('nilai_huruf', 'Nilai Huruf', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('nilai_max', 'Nilai Max', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required', ['required' => '%s is required.']);

		$datapost = [
			'id_pt' => $this->session->userdata('id_pt'),
			'id_akd' => $this->input->post('id_akd'),
			'nilai_min' => $this->input->post('nilai_min'),
			'nilai_huruf' => $this->input->post('nilai_huruf'),
			'nilai_max' => $this->input->post('nilai_max'),
			'keterangan' => $this->input->post('keterangan'),
		];

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'id_akd' => form_error('id_akd'),
				'nilai_min' => form_error('nilai_min'),
				'nilai_huruf' => form_error('nilai_huruf'),
				'nilai_max' => form_error('nilai_max'),
				'keterangan' => form_error('keterangan'),
			]);
		} else {

			$model = $this->load->model('NilaiModel');
			$insert = $this->NilaiModel->insert_entry($datapost);

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
		$this->load->model('NilaiModel');
		$this->load->model('AkademikModel');

		$akademik = $this->AkademikModel->get_entries()->result();
		$nilai = $this->NilaiModel->get_entries($id)->row();

		$this->load->view('nilai/edit', ['akademiks' => $akademik, 'nilai' => $nilai]);
	}

	public function update($id = null)
	{
		$this->form_validation->set_rules('id_akd', 'Tahun Akademik', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('nilai_min', 'Nilai Min', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('nilai_huruf', 'Nilai Huruf', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('nilai_max', 'Nilai Max', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('keterangan', 'Keterangan', 'required', ['required' => '%s is required.']);

		$datapost = [
			'id_akd' => $this->input->post('id_akd'),
			'nilai_min' => $this->input->post('nilai_min'),
			'nilai_huruf' => $this->input->post('nilai_huruf'),
			'nilai_max' => $this->input->post('nilai_max'),
			'keterangan' => $this->input->post('keterangan'),
		];

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'id_akd' => form_error('id_akd'),
				'nilai_min' => form_error('nilai_min'),
				'nilai_huruf' => form_error('nilai_huruf'),
				'nilai_max' => form_error('nilai_max'),
				'keterangan' => form_error('keterangan'),
			]);
		} else {

			$model = $this->load->model('NilaiModel');
			$insert = $this->NilaiModel->update_entry($datapost, $id);

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
		$model = $this->load->model('NilaiModel');
		$delete = $this->NilaiModel->delete_entry($id);

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

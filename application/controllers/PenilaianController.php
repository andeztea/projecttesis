<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenilaianController extends CI_Controller
{
	public function index()
	{
		$this->load->view('penilaian/index');
	}

	public function datatables_json()
	{
		$this->load->model('PenilaianModel');
		$id_user = $this->session->userdata('id_user');
		$user = $this->PenilaianModel->get_dosen($id_user);

		$list = $this->PenilaianModel->get_datatables($user->dosen_id);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nama_kelas;
			$nestedData[]    = $row->fakultas . '/' . $row->jurusan . '/' . $row->program_studi;
			$nestedData[]    = $row->thn_akademik;
			$nestedData[]    = "<a class='btn btn-sm btn-warning' href='" . site_url('PenilaianController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
            <a class='btn btn-sm btn-danger' href='" . site_url('PenilaianController/hapus/' . $row->id) . "' id='hapus_penilaian'><i class='fa fa-trash'></i></a>";
			$nestedData[]    = $row->id;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->PenilaianModel->count_all($user->dosen_id),
			"recordsFiltered" => $this->PenilaianModel->count_filtered($user->dosen_id),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function tambah()
	{
		$this->load->model('AkademikModel');
		$this->load->model('FakultasModel');
		$this->load->model('PenilaianModel');

		$cek_perti = $this->session->userdata('id_pt');
		$id_user = $this->session->userdata('id_user');

		$akademik = $this->AkademikModel->get_entries()->result();
		$fakultas = $this->FakultasModel->get_entries(FALSE, $cek_perti)->result();
		$user = $this->PenilaianModel->get_dosen($id_user);

		$this->load->view('penilaian/tambah', ['akademikk' => $akademik, 'fakultass' => $fakultas, 'users' => $user]);
	}

	public function store()
	{
		$this->load->model('PenilaianModel');

		$penilai_post = [
			'id_pt' => $this->input->post('id_pt'),
			'id_akd' => $this->input->post('thn_akademik'),
			'id_fakultas' => $this->input->post('fakultas'),
			'id_dosen' => $this->input->post('id_dosen'),
			'id_kelas' => $this->input->post('id_kelas'),
		];

		$insert_penilai = $this->PenilaianModel->insert_entry($penilai_post);
		$insert_id = $this->db->insert_id($insert_penilai);

		if ($insert_penilai) {
			for ($i = 0; $i < count($this->input->post('kehadiran')); $i++) {
				$nilai_akhir_post = [
					'id_penilai' => $insert_id,
					'id_mhs' => $this->input->post('id_mhs')[$i],
					'kehadiran' => $this->input->post('kehadiran')[$i],
					'aktivitas' => $this->input->post('aktivitas')[$i],
					'medium' => $this->input->post('medium')[$i],
					'final' => $this->input->post('final')[$i],
					'rata_rata' => $this->input->post('rata_rata')[$i],
					'nilai_huruf' => $this->input->post('nilai_huruf')[$i],
				];

				$this->db->insert('tb_nilai_akhir', $nilai_akhir_post);
			}

			$response = ['icon' => 'success', 'title' => 'Tambah Berhasil'];
		} else {
			// $this->PenilaianModel->update_entry($cek_data->id_dosen,$datapost['id_mhs'],$datapost);
			$response = ['icon' => 'error', 'title' => 'Data Sudah Ada'];
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
		$this->load->model('PenilaianModel');

		$penilai = $this->PenilaianModel->get_data($id)->row();

		$this->load->view('penilaian/edit', ['penilai' => $penilai]);
	}

	public function update($id_penilai = null)
	{
		$this->load->model('NilaiAkhirModel');

		for ($i = 0; $i < count($this->input->post('kehadiran')); $i++) {
			$nilai_akhir_post = [
				'kehadiran' => $this->input->post('kehadiran')[$i],
				'aktivitas' => $this->input->post('aktivitas')[$i],
				'medium' => $this->input->post('medium')[$i],
				'final' => $this->input->post('final')[$i],
				'rata_rata' => $this->input->post('rata_rata')[$i],
				'nilai_huruf' => $this->input->post('nilai_huruf')[$i],
			];

			$this->NilaiAkhirModel->update_entry($nilai_akhir_post, $id_penilai, $this->input->post('id_mhs')[$i]);
		}


		$response = ['icon' => 'success', 'title' => 'Update Berhasil'];

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}

	public function hapus($id = null)
	{
		$this->load->model('NilaiAkhirModel');
		$this->load->model('PenilaianModel');

		$this->NilaiAkhirModel->delete_entry($id);
		$this->PenilaianModel->delete_entry($id);

		$response = ['icon' => 'success', 'title' => 'Delete Berhasil'];

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}
}

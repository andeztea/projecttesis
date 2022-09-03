<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SelectController extends CI_Controller
{
	public function kelas_json($dosenID = null)
	{
		$query = $this->db->select('a.*,b.nama_kelas,b.mata_kuliah,b.sks')
			->from('tb_set_kelas as a')
			->join('tb_kelas as b', 'a.id_kelas = b.id', 'left')
			->where('a.id_user', $dosenID)
			->limit(1);

		$search = $this->input->post('search');

		if ($search) {
			$result = $query->like('nama_kelas', $search)->get();
		} else {
			$result = $query->get();
		}

		$json = [];

		foreach ($result->result_array() as $value) {
			$json[] = ['id' => $value['id_kelas'], 'text' => $value['nama_kelas'] . ' / ' . $value['mata_kuliah'] . ' / ' . $value['sks']];
		}

		echo json_encode($json);
	}

	public function dosen_json()
	{
		$cek_perti = $this->session->userdata('id_pt');
		$query = $this->db
			->select('a.*,b.nama_kelas')
			->join('tb_kelas as b', 'a.id_kelas = b.id', 'left')
			->where('a.id_pt', $cek_perti)
			->where('a.tampilkan', 'ya');

		$search = $this->input->post('search');

		if ($search) {
			$result = $query->like('nama', $search)->get('tb_dosen as a');
		} else {
			$result = $query->get('tb_dosen as a');
		}

		$json = [];

		foreach ($result->result_array() as $value) {
			$json[] = ['id' => $value['id'], 'text' => $value['nama'] . ' / ' . $value['nama_kelas']];
		}

		echo json_encode($json);
	}

	public function kelas_penilaian_json($dosenID = null)
	{
		$query = $this->db->select('a.id_kelas,b.nama_kelas,b.mata_kuliah,b.sks')
			->from('tb_dosen as a')
			->join('tb_kelas as b', 'a.id_kelas = b.id', 'left')
			->where('a.id_user', $dosenID);

		$search = $this->input->post('search');

		if ($search) {
			$result = $query->like('b.nama_kelas', $search)->get();
		} else {
			$result = $query->get();
		}

		$json = [];

		foreach ($result->result_array() as $value) {
			$json[] = ['id' => $value['id_kelas'], 'text' => $value['nama_kelas'] . ' / ' . $value['mata_kuliah'] . ' / ' . $value['sks']];
		}

		echo json_encode($json);
	}

	public function perguruan_tinggi()
	{
		$query = $this->db->select('a.*')
			->from('tb_perti as a');

		$search = $this->input->post('search');

		if ($search) {
			$result = $query->like('a.nama', $search)->get();
		} else {
			$result = $query->get();
		}

		$json = [];

		foreach ($result->result_array() as $value) {
			$json[] = ['id' => $value['id'], 'text' => $value['nama']];
		}

		echo json_encode($json);
	}

	public function dosen_by_perti($id_perti = null)
	{
		$query = $this->db->select('a.*')
			->from('tb_user as a')->where('id_pt', $id_perti)->where('id_role', 'Dosen');

		$search = $this->input->post('search');

		if ($search) {
			$result = $query->like('a.nama', $search)->get();
		} else {
			$result = $query->get();
		}

		$json = [];

		foreach ($result->result_array() as $value) {
			$json[] = ['id' => $value['id'], 'text' => $value['nama']];
		}

		echo json_encode($json);
	}

	public function kelas_by_perti($id_perti = null)
	{
		$query = $this->db->select('a.*')
			->from('tb_kelas as a')->where('id_pt', $id_perti);

		$search = $this->input->post('search');

		if ($search) {
			$result = $query->like('a.nama_kelas', $search)->get();
		} else {
			$result = $query->get();
		}

		$json = [];

		foreach ($result->result_array() as $value) {
			$json[] = ['id' => $value['id'], 'text' => $value['nama_kelas']];
		}

		echo json_encode($json);
	}

	public function fakultas_by_perti($id_perti = null)
	{
		$query = $this->db->select('a.*')
			->from('tb_fakultas as a')->where('id_pt', $id_perti);

		$search = $this->input->post('search');

		if ($search) {
			$result = $query->like('a.fakultas', $search)->get();
		} else {
			$result = $query->get();
		}

		$json = [];

		foreach ($result->result_array() as $value) {
			$json[] = ['id' => $value['id'], 'text' => $value['fakultas'] . ' / ' . $value['jurusan'] . ' / ' . $value['program_studi']];
		}

		echo json_encode($json);
	}
}

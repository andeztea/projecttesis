<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelompokController extends CI_Controller
{
	public function index()
	{
		$this->load->view('kelompok/index');
	}

	public function tambah()
	{
		$this->load->model('AkademikModel');
		$this->load->model('FakultasModel');
		$this->load->model('PenilaianModel');
		$this->load->model('MasyarakatModel');

		$cek_perti = $this->session->userdata('id_pt');
		$id_user = $this->session->userdata('id_user');

		$akademik = $this->AkademikModel->get_entries()->result();
		$fakultas = $this->FakultasModel->get_entries(FALSE, $cek_perti)->result();
		$user = $this->PenilaianModel->get_dosen($id_user);
		$masyarakat = $this->MasyarakatModel->get_entries()->result();

		$this->load->view('kelompok/tambah', ['masyarakat' => $masyarakat, 'akademikk' => $akademik, 'fakultass' => $fakultas, 'users' => $user]);
	}

	public function edit()
	{
		$this->load->view('kelompok/edit');
	}

	public function view()
	{
		$this->load->view('kelompok/edit');
	}
}

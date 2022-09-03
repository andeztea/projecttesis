<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengajarController extends CI_Controller
{
	public function index()
	{
		$this->load->view('pengajar/index');
	}

	public function datatables_json()
	{
		$this->load->model('PengajarModel');
		$cek_role = $this->session->userdata('id_role');
		$cek_perti = $this->session->userdata('id_pt');
		$cek_user = $this->session->userdata('id_user');

		$list = $this->PengajarModel->get_datatables($cek_role, $cek_perti, $cek_user);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nama_kelas;
			$nestedData[]    = $row->thn_akademik;
			if ($cek_role == "Dosen") {
				$nestedData[]    = "<a class='btn btn-sm btn-warning' href='" . site_url('PengajarController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
                <a class='btn btn-sm btn-danger' href='" . site_url('PengajarController/hapus/' . $row->id) . "' id='hapus_pengajar'><i class='fa fa-trash'></i></a>";
			} else {
				$nestedData[]    = "<a class='btn btn-sm btn-info' href='" . site_url('PengajarController/view/' . $row->id) . "'><i class='fa fa-eye'></i></a>";
			}
			$nestedData[]    = $row->id;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->PengajarModel->count_all($cek_role, $cek_perti, $cek_user),
			"recordsFiltered" => $this->PengajarModel->count_filtered($cek_role, $cek_perti, $cek_user),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function tambah()
	{
		$cek_user = $this->session->userdata('id_user');
		$this->load->model('AkademikModel');
		$this->load->model('DosenModel');

		$dosen = $this->DosenModel->cek_dosen($cek_user);
		$akademik = $this->AkademikModel->get_entries()->result();

		$this->load->view('pengajar/tambah', ['dosen' => $dosen, 'akademikk' => $akademik]);
	}

	public function store()
	{
		$this->form_validation->set_rules('id_kelas', 'Kelas', 'required|is_unique[tb_pengajar.id_kelas]', ['required' => '%s is required.', 'is_unique' => '%s sudah terdaftar.']);
		$this->form_validation->set_rules('jml_pekan', 'Jumlah Pekan', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('pertemuan_ke', 'Pertemuan', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('materi_pokok', 'Materi Pokok', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('bahasan', 'Sub Pokok Bahasan', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('id_akd', 'Tahun Akademik', 'required', ['required' => '%s is required.']);

		$folder = 'uploads/berkas/';

		if (empty($_FILES['materi_temu']['name'])) {
			$this->form_validation->set_rules('materi_temu', 'Materi Pertemuan', 'required', ['required' => '%s is required.']);
		} else {
			$docname = explode('.', $_FILES['materi_temu']['name']);
			$ext = end($docname);
			$temp = $_FILES['materi_temu']['tmp_name'];
			$materi_temu    = "materi_temu-" . substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8) . "." . $ext;
			move_uploaded_file($temp, $folder . $materi_temu);
		}

		if (empty($_FILES['rps']['name'])) {
			$this->form_validation->set_rules('rps', 'RPS', 'required', ['required' => '%s is required.']);
		} else {
			$docname = explode('.', $_FILES['rps']['name']);
			$ext = end($docname);
			$temp = $_FILES['rps']['tmp_name'];
			$rps    = "rps-" . substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8) . "." . $ext;
			move_uploaded_file($temp, $folder . $rps);
		}

		if (empty($_FILES['modul']['name'])) {
			$this->form_validation->set_rules('modul', 'Modul', 'required', ['required' => '%s is required.']);
		} else {
			$docname = explode('.', $_FILES['modul']['name']);
			$ext = end($docname);
			$temp = $_FILES['modul']['tmp_name'];
			$modul    = "modul-" . substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8) . "." . $ext;
			move_uploaded_file($temp, $folder . $modul);
		}

		if (empty($_FILES['bukti']['name'])) {
			$this->form_validation->set_rules('bukti', 'Bukti Pertemuan', 'required', ['required' => '%s is required.']);
		} else {
			$docname = explode('.', $_FILES['bukti']['name']);
			$ext = end($docname);
			$temp = $_FILES['bukti']['tmp_name'];
			$bukti    = "bukti-" . substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8) . "." . $ext;
			move_uploaded_file($temp, $folder . $bukti);
		}

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'id_kelas' => form_error('id_kelas'),
				'id_akd' => form_error('id_akd'),
				'jml_pekan' => form_error('jml_pekan'),
				'rps' => form_error('rps'),
				'pertemuan_ke' => form_error('pertemuan_ke'),
				'modul' => form_error('modul'),
				'materi_temu' => form_error('materi_temu'),
				'bukti' => form_error('bukti'),
				'materi_pokok' => form_error('materi_pokok'),
				'bahasan' => form_error('bahasan'),
			]);
		} else {
			$datapost = [
				'id_pt' => $this->session->userdata('id_pt'),
				'id_akd' => $this->input->post('id_akd'),
				'id_user' => $this->input->post('id_dosen'),
				'id_kelas' => $this->input->post('id_kelas'),
				'jml_pekan' => $this->input->post('jml_pekan'),
				'rps' =>  $rps,
				'modul' => $modul,
				'materi_temu' => $materi_temu,
				'pertemuan_ke' => $this->input->post('pertemuan_ke'),
				'materi_pokok' => $this->input->post('materi_pokok'),
				'bahasan' => $this->input->post('bahasan'),
				'bukti' => $bukti,
			];

			$this->load->model('PengajarModel');
			$insert = $this->PengajarModel->insert_entry($datapost);
			$last_id = $this->db->insert_id($insert);

			$datapost2 = [
				'id_pengajar' => $last_id,
				'pertemuan_ke' => $this->input->post('pertemuan_ke'),
				'materi_pokok' => $this->input->post('materi_pokok'),
				'bahasan' => $this->input->post('bahasan'),
				'bukti' => $bukti,
			];

			$post_status = $this->input->post('status');
			$status_exp = explode('/', $post_status);
			$id_mhs_exp = explode('/', $this->input->post('id_mhs'));

			if ($insert) {
				$this->db->insert('tb_realisasi', $datapost2);

				for ($i = 1; $i < count($id_mhs_exp); $i++) {
					$datamhs = ['id_pengajar' => $last_id, 'id_mhs' => $id_mhs_exp[$i]];
					$this->db->insert('tb_penilaian', $datamhs);
				}

				for ($i = 1; $i < count($status_exp); $i++) {
					if ($this->db->where('id_pengajar', $this->input->post('id_dosen'))->where('id_mhs', $status_exp[$i][0])->count_all_results('tb_kehadiran') <= 0) {
						$this->db->insert('tb_kehadiran', ['id_pengajar' => $datapost2['id_pengajar'], 'id_mhs' => $status_exp[$i][0], 'p' . $datapost2['pertemuan_ke'] => $status_exp[$i][2]]);
					} else {
						$this->db->where('id_mhs', $status_exp[$i][0])->update('tb_kehadiran', ['p' . $datapost2['pertemuan_ke'] => $status_exp[$i][2]]);
					}
				}

				$response = ['icon' => 'success', 'title' => 'Tambah Berhasil'];
			} else {
				$response = ['icon' => 'error', 'title' => $insert->query_error()];
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
		$this->load->model('PengajarModel');

		$pengajarModel = $this->PengajarModel->get_entries($id)->row();
		$kehadiran = $this->PengajarModel->get_kehadiran($id)->result_array();
		$realisasi = $this->PengajarModel->get_realisasi($id)->result();

		$this->load->view('pengajar/edit', ['pengajar' => $pengajarModel, 'kehadiran' => $kehadiran, 'realisasi' => $realisasi]);
	}

	public function view($id = null)
	{
		$this->load->model('PengajarModel');

		$pengajarModel = $this->PengajarModel->get_entries($id)->row();
		$kehadiran = $this->PengajarModel->get_kehadiran($id)->result_array();
		$realisasi = $this->PengajarModel->get_realisasi($id)->result();

		$this->load->view('pengajar/view', ['pengajar' => $pengajarModel, 'kehadiran' => $kehadiran, 'realisasi' => $realisasi]);
	}

	public function update($id = null)
	{
		$this->form_validation->set_rules('jml_pekan', 'Jumlah Pekan', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('pertemuan_ke', 'Pertemuan', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('materi_pokok', 'Materi Pokok', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('bahasan', 'Sub Pokok Bahasan', 'required', ['required' => '%s is required.']);

		$this->load->model('PengajarModel');

		$pengajar = $this->PengajarModel->get_entries($id)->row();

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'jml_pekan' => form_error('jml_pekan'),
				'rps' => form_error('rps'),
				'pertemuan_ke' => form_error('pertemuan_ke'),
				'modul' => form_error('modul'),
				'materi_temu' => form_error('materi_temu'),
				'bukti' => form_error('bukti'),
				'materi_pokok' => form_error('materi_pokok'),
				'bahasan' => form_error('bahasan'),
			]);
		} else {
			$datapost = [
				'jml_pekan' => $this->input->post('jml_pekan'),
				'pertemuan_ke' => $this->input->post('pertemuan_ke'),
				'materi_pokok' => $this->input->post('materi_pokok'),
				'bahasan' => $this->input->post('bahasan'),
			];

			$files = [$_FILES['rps']['name'], $_FILES['modul']['name'], $_FILES['materi_temu']['name'], $_FILES['bukti']['name']];
			$folder = 'uploads/berkas/';

			if ($files[0] != null) {
				$docname = explode('.', $files[0]);
				$ext = end($docname);
				$temp = $_FILES['rps']['tmp_name'];
				$rps    = "rps-" . substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8) . "." . $ext;
				move_uploaded_file($temp, $folder . $rps);
			} else {
				$rps = $pengajar->rps;
			}

			if ($files[1] != null) {
				$docname = explode('.', $files[1]);
				$ext = end($docname);
				$temp = $_FILES['modul']['tmp_name'];
				$modul    = "modul-" . substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8) . "." . $ext;
				move_uploaded_file($temp, $folder . $modul);
			} else {
				$modul = $pengajar->modul;
			}

			if ($files[2] != null) {
				$docname = explode('.', $files[2]);
				$ext = end($docname);
				$temp = $_FILES['materi_temu']['tmp_name'];
				$materi_temu    = "materi_temu-" . substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8) . "." . $ext;
				move_uploaded_file($temp, $folder . $materi_temu);
			} else {
				$materi_temu = $pengajar->materi_temu;
			}

			if ($files[3] != null) {
				$docname = explode('.', $files[3]);
				$ext = end($docname);
				$temp = $_FILES['bukti']['tmp_name'];
				$bukti    = "bukti-" . substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8) . "." . $ext;
				move_uploaded_file($temp, $folder . $bukti);
			} else {
				$bukti = $pengajar->bukti;
			}

			$datapost += [
				'rps' =>  $rps,
				'modul' => $modul,
				'materi_temu' => $materi_temu,
				'bukti' => $bukti,
			];

			$datapost2 = [
				'id_pengajar' => $this->input->post('dosenID'),
				'pertemuan_ke' => $this->input->post('pertemuan_ke'),
				'materi_pokok' => $this->input->post('materi_pokok'),
				'bahasan' => $this->input->post('bahasan'),
				'bukti' => $bukti,
			];

			$this->load->model('PengajarModel');

			$cek_pertemuan =  $this->db->where('id_pengajar', $datapost2['id_pengajar'])->where('pertemuan_ke', $datapost2['pertemuan_ke'])->get('tb_realisasi')->row();

			if ($cek_pertemuan) {
				$this->db->where('id_pengajar', $datapost2['id_pengajar'])->where('pertemuan_ke', $datapost2['pertemuan_ke'])->update('tb_realisasi', $datapost2);
			} else {
				$this->db->insert('tb_realisasi', $datapost2);
			}

			$update = $this->PengajarModel->update_entry($datapost, $id);
			$post_status = $this->input->post('status');
			$status_exp = explode('/', $post_status);

			if ($update) {

				for ($i = 1; $i < count($status_exp); $i++) {
					$this->db->where('id_mhs', $status_exp[$i][0])->update('tb_kehadiran', ['p' . $datapost['pertemuan_ke'] => $status_exp[$i][2]]);
				}

				$response = ['icon' => 'success', 'title' => 'Update Berhasil'];
			} else {
				$response = ['icon' => 'error', 'title' => $update->query_error()];
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
		$model = $this->load->model('PengajarModel');
		$delete = $this->PengajarModel->delete_entry($id);

		if ($delete) {
			$this->db->where('id_pengajar', $id)->delete('tb_kehadiran');
			$this->db->where('id_pengajar', $id)->delete('tb_realisasi');
			$this->db->where('id_pengajar', $id)->delete('tb_penilaian');
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

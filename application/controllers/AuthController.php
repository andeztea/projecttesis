<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{
	public function login()
	{
		if ($this->input->post()) {
			$this->load->model('UserModel');

			$username = $this->input->post('username');
			$password = $this->input->post('password');

			$cek_uname =  $this->db->where('username', $username)->where('tampilkan', 'ya')->where('aktivasi',1)->get('tb_user')->row();

			if ($cek_uname) {
				if (password_verify($password, $cek_uname->password)) {

					if ($cek_uname->userfile == NULL) {
						$userfile = 'kemdikbud.jpg';
					} else {
						$userfile = $cek_uname->userfile;
					}

					$sessi = [
						'id_user' => $cek_uname->id,
						'id_pt' => $cek_uname->id_pt,
						'id_role' => $cek_uname->id_role,
						'username' => $cek_uname->nama,
						'userfile' => $userfile,
						'logged_in' => TRUE
					];

					$this->session->set_userdata($sessi);

					$response = array('login' => true, 'url' => site_url('DashController'));
				} else {
					$response = array('error' => 'Username atau Passwor Salah.');
				}
			} else {
				$response = array('error' => 'Username atau Password Salah / email belum di konfirmasi.');
			}
			header('Content-Type: application/json');
			echo json_encode($response);
			exit;
		} else {
			$this->load->view('auth/login');
		}
	}

	public function register_perti()
	{
		if ($this->input->post()) {

			$this->form_validation->set_rules('kode', 'Kode', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('nama', 'Nama Perguruan Tinggi', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('rektor', 'Nama Rektor', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('kontak', 'Kontak', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]|is_unique[tb_perti.email]', ['required' => '%s is required.', 'is_unique' => '%s sudah terdaftar.']);
			$this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('provinsi', 'Provinsi', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required', ['required' => '%s is required.']);

			if ($this->form_validation->run() == FALSE) {
				$response = array('error' => [
					'kode' => form_error('kode'),
					'nama' => form_error('nama'),
					'rektor' => form_error('rektor'),
					'kontak' => form_error('kontak'),
					'email' => form_error('email'),
					'alamat' => form_error('alamat'),
					'provinsi' => form_error('provinsi'),
					'kabupaten' => form_error('kabupaten'),
					'kecamatan' => form_error('kecamatan'),
				]);
			} else {
				$docname = explode('.', $_FILES['userfile']['name']);
				$ext = end($docname);
				$folder = 'uploads/';
				$new_name    = "userfile-" . $this->input->post('kode') . "." . $ext;
				$temp = $_FILES['userfile']['tmp_name'];

				if (move_uploaded_file($temp, $folder . $new_name)) {
					$photo = $new_name;
				} else {
					$photo = "";
				}

				$datapost = [
					'kode' => $this->input->post('kode'),
					'nama' => $this->input->post('nama'),
					'rektor' => $this->input->post('rektor'),
					'kontak' => $this->input->post('kontak'),
					'email' => $this->input->post('email'),
					'alamat' => $this->input->post('alamat'),
					'provinsi' => $this->input->post('provinsi'),
					'kabupaten' => $this->input->post('kabupaten'),
					'kecamatan' => $this->input->post('kecamatan'),
					'userfile' =>  $photo
				];

				$lodmod = $this->load->model('PertiModel');
				$lodmod = $this->load->model('PesanModel');
				$insert = $this->PertiModel->insert_entry($datapost);
				$lastID = $this->db->insert_id($insert);

				if ($insert) {
					$insert_pesan = [
						'id_user' => $this->db->insert_id($insert),
						'id_pt' => $lastID,
						'id_role' => '2',
						'userfile' => $photo,
						'title' => '' . $datapost['nama'] . '/' . $datapost['rektor'],
					];

					$lodmods = $this->PesanModel->insert_entry($insert_pesan);

					if ($lodmods) {
						$response = ['pesan' => 'Registrasi Berhasil'];
					} else {
						$response = ['pesan' => $lodmods->query_error()];
					}
				} else {
					$response = ['pesan' => $lodmod->query_error()];
				}
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
			exit;
		} else {
			$this->load->view('auth/register_perti');
		}
	}

	public function register_mhs()
	{
		if ($this->input->post()) {
			$code=rand(1,5);
			$email=$this->input->post('email');
			$this->form_validation->set_rules('nama_pt', 'Perguruan Tinggi', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('nim', 'Nim', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('nama', 'Nama', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('kontak', 'Kontak', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]|is_unique[tb_mahasiswa.email]', ['required' => '%s is required.', 'is_unique' => '%s sudah terdaftar.']);
			$this->form_validation->set_rules('fakultas', 'Fakultas', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('thn_akademik', 'Tahun Akademik', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('semester', 'Semester', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('provinsi', 'Provinsi', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required', ['required' => '%s is required.']);

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
				$docname = explode('.', $_FILES['userfile']['name']);
				$ext = end($docname);
				$folder = 'uploads/';
				$new_name    = "userfile-" . $this->input->post('nim') . "." . $ext;
				$temp = $_FILES['userfile']['tmp_name'];

				if (move_uploaded_file($temp, $folder . $new_name)) {
					$photo = $new_name;
				} else {
					$photo = "";
				}

				if ($this->input->post('jns_kwdk') == 'jns_kwdk_lainnya') {
					$data = $this->input->post('jns_kwdk_lainnya');
				} else {
					$data = $this->input->post('jns_kwdk');
				}

				$datapost = [
					'id_pt' => $this->input->post('nama_pt'),
					'id_fakultas' => $this->input->post('fakultas'),
					'id_akd' => $this->input->post('thn_akademik'),
					'id_dosen' => $this->input->post('nama_dosen'),
					'id_semester' => $this->input->post('semester'),
					'nim' => $this->input->post('nim'),
					'nama' => $this->input->post('nama'),
					'kontak' => $this->input->post('kontak'),
					'email' => $email,
					'jns_kwdk' => $data,
					'alamat' => $this->input->post('alamat'),
					'provinsi' => $this->input->post('provinsi'),
					'kabupaten' => $this->input->post('kabupaten'),
					'kecamatan' => $this->input->post('kecamatan'),
					'code'=>$code,
					'userfile' =>  $photo
				];

				$lodmod = $this->load->model('MahasiswaModel');
				$lodmod = $this->load->model('PesanModel');
				$insert = $this->MahasiswaModel->insert_entry($datapost);

				if ($insert) {
					$insert_pesan = [
						'id_user' => $this->db->insert_id($insert),
						'id_pt' => $this->input->post('nama_pt'),
						'id_role' => '3',
						'userfile' => $photo,
						'title' => '' . $datapost['nama'] . '/' . $datapost['nim'],
					];

					$lodmods = $this->PesanModel->insert_entry($insert_pesan);

					$htmlEmail='
						<h1>Terima Kasih Telah melakukan Pendaftaran</h1>
						<p>Silahkan konfirmasi melalu link berikut <a>http://localhost/project_skripsi/AuthController/konfirmasi/'.$code.'</a> </p>
					';

					if ($lodmods) {
						$send=send_mail($email,'Konfirmasi Email Pendaftaran',$htmlEmail);
						if($send){
							$response = ['pesan' => 'Registrasi Berhasil'];
						}else{
							$response = ['pesan' => 'Registrasi Berhasil, tetapi gagal mengirim email'];
						}
						
					} else {
						$response = ['pesan' => $lodmods->query_error()];
					}
				} else {
					$response = ['pesan' => $lodmod->query_error()];
				}
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
			exit;
		} else {
			$this->load->model('PertiModel');
			$this->load->model('FakultasModel');
			$this->load->model('AkademikModel');

			$perti = $this->PertiModel->get_entries()->result();
			$fakultas = $this->FakultasModel->get_entries_reg()->result();
			$akademik = $this->AkademikModel->get_entries()->result();

			$this->load->view('auth/register_mhs', ['pertig' => $perti, 'fakultass' => $fakultas, 'akademikk' => $akademik]);
		}
	}

	public function konfirmasi($code){
		$this->load->model('UserModel');
		$cek_uname =  $this->db->where('aktivasi',0)->where('code',$code)->get('tb_user')->row();
		$datapost=[
			'aktivasi' => 1,
		];
		if($cek_uname){

			$update=$this->UserModel->update_konfirmasi($datapost, $code);

			if($update){
				echo "Terima kasih sudah melakukan konfirmasi silahkan login di <a href=".base_url().">Disini</a> ";
			}else{
				echo "Code Tidak Terdaftar";
			}
		}
	}




	public function register_msyr()
	{
		if ($this->input->post()) {

			$this->form_validation->set_rules('nama_pt', 'Perguruan Tinggi', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('nama_kel', 'Nama Kelompok', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('nama_ket', 'Nama Ketua', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('kontak', 'Kontak', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]|is_unique[tb_masyarakat.email]', ['required' => '%s is required.', 'is_unique' => '%s sudah terdaftar.']);
			$this->form_validation->set_rules('jml_anggota', 'Jumlah Anggota', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('provinsi', 'Provinsi', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required', ['required' => '%s is required.']);
			$this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required', ['required' => '%s is required.']);

			if ($this->form_validation->run() == FALSE) {
				$response = array('error' => [
					'nama_pt' => form_error('nama_pt'),
					'nama_kel' => form_error('nama_kel'),
					'nama_ket' => form_error('nama_ket'),
					'kontak' => form_error('kontak'),
					'email' => form_error('email'),
					'jml_anggota' => form_error('jml_anggota'),
					'alamat' => form_error('alamat'),
					'provinsi' => form_error('provinsi'),
					'kabupaten' => form_error('kabupaten'),
					'kecamatan' => form_error('kecamatan'),
				]);
			} else {
				$docname = explode('.', $_FILES['userfile']['name']);
				$ext = end($docname);
				$folder = 'uploads/';
				$new_name    = "userfile-" . $this->input->post('nama_pt') . "." . $ext;
				$temp = $_FILES['userfile']['tmp_name'];

				if (move_uploaded_file($temp, $folder . $new_name)) {
					$photo = $new_name;
				} else {
					$photo = "";
				}

				if ($this->input->post('jns_produk') == FALSE) {
					$data = $this->input->post('jns_produk_lainnya');
				} else {
					$data = $this->input->post('jns_produk');
				}

				$datapost = [
					'id_pt' => $this->input->post('nama_pt'),
					'nama_kel' => $this->input->post('nama_kel'),
					'nama_ket' => $this->input->post('nama_ket'),
					'kontak' => $this->input->post('kontak'),
					'email' => $this->input->post('email'),
					'jml_anggota' => $this->input->post('jml_anggota'),
					'jns_produk' => $data,
					'alamat' => $this->input->post('alamat'),
					'provinsi' => $this->input->post('provinsi'),
					'kabupaten' => $this->input->post('kabupaten'),
					'kecamatan' => $this->input->post('kecamatan'),
					'userfile' =>  $photo
				];

				$lodmod = $this->load->model('MasyarakatModel');
				$lodmod = $this->load->model('PesanModel');
				$insert = $this->MasyarakatModel->insert_entry($datapost);

				if ($insert) {
					$insert_pesan = [
						'id_user' => $this->db->insert_id($insert),
						'id_pt' => $this->input->post('nama_pt'),
						'id_role' => '4',
						'userfile' => $photo,
						'title' => '' . $datapost['nama_kel'] . '/' . $datapost['nama_ket'],
					];

					$lodmods = $this->PesanModel->insert_entry($insert_pesan);

					if ($lodmods) {
						$response = ['pesan' => 'Registrasi Berhasil'];
					} else {
						$response = ['pesan' => $lodmods->query_error()];
					}
				} else {
					$response = ['pesan' => $lodmod->query_error()];
				}
			}

			$this->output
				->set_status_header(200)
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
				->_display();
			exit;
		} else {
			$this->load->model('PertiModel');
			$perti = $this->PertiModel->get_entries()->result();

			$this->load->view('auth/register_msyr', ['pertig' => $perti]);
		}
	}

	public function tambah_dosen()
	{
		$this->load->view('dosen/tambah_dosen');
	}

	public function store_dosen()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required|is_unique[tb_user.nama]', ['required' => '%s is required.', 'is_unique' => '%s sudah terdaftar.']);
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[tb_user.email]', ['required' => '%s is required.', 'is_unique' => '%s sudah terdaftar.']);
		$this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_user.username]', ['required' => '%s is required.', 'is_unique' => '%s sudah terdaftar.']);
		$this->form_validation->set_rules('password', 'Password', 'required', ['required' => '%s is required.']);
		$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required', ['required' => '%s is required.']);
		// $this->form_validation->set_rules('kontak', 'Kontak', 'required', ['required' => '%s is required.']);
		// $this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => '%s is required.']);
		// $this->form_validation->set_rules('provinsi', 'Provinsi', 'required', ['required' => '%s is required.']);
		// $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required', ['required' => '%s is required.']);
		// $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required', ['required' => '%s is required.']);

		// $datapost = [
		//     'nama' => $this->input->post('nama'),
		//     'username' => $this->input->post('username'),
		//     'email' => $this->input->post('email'),
		//     'kontak' => $this->input->post('kontak'),
		//     'alamat' => $this->input->post('alamat'),
		//     'provinsi' => $this->input->post('provinsi'),
		//     'kabupaten' => $this->input->post('kabupaten'),
		//     'kecamatan' => $this->input->post('kecamatan'),
		// ];

		$datapost = [
			'id_role' => 5,
			'id_pt' => $this->session->userdata('id_pt'),
			'nama' => $this->input->post('nama'),
			'username' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'kontak' => $this->input->post('kontak'),
			'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
		];

		if ($this->form_validation->run() == FALSE) {
			$response = array('error' => [
				'nama' => form_error('nama'),
				'email' => form_error('email'),
				'username' => form_error('username'),
				'password' => form_error('password'),
				'cpassword' => form_error('cpassword'),
				// 'kontak' => form_error('kontak'),
				// 'alamat' => form_error('alamat'),
				// 'provinsi' => form_error('provinsi'),
				// 'kabupaten' => form_error('kabupaten'),
				// 'kecamatan' => form_error('kecamatan'),
			]);
		} else {
			$this->load->model('UserModel');
			$insert = $this->UserModel->insert_entry($datapost);

			if ($insert) {
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

	public function logout()
	{
		$this->session->sess_destroy();

		$response = array('code' => 0, 'url' => site_url('/'));

		$this->output
			->set_status_header(200)
			->set_content_type('application/json', 'utf-8')
			->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
			->_display();
		exit;
	}
}

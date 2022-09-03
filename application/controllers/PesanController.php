<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PesanController extends CI_Controller
{
    public function index()
    {
        $this->load->model('PesanModel');

        $cek_role = $this->session->userdata('id_role');

        $cek_perti = $this->session->userdata('id_pt');

        if ($cek_role == 'Superadmin') {
            $lodmod = $this->PesanModel->get_entries_spa();
        }
        
        if($cek_role == 'Admin'){
            $lodmod = $this->PesanModel->get_entries_perti($cek_perti);
        }

        header('Content-Type: application/json');
        echo json_encode($lodmod->result());
    }

    public function confirm_perti($id = null)
    {
        $this->load->model('PesanModel');

        $lodmod = $this->PesanModel->get_entries_cf($id, 'tb_perti');

        $this->load->view('pesan/confirm_perti', ['pesan' => $lodmod]);
    }

    public function confirm_mahasiswa($id = null)
    {
        $this->load->model('PesanModel');

        $lodmod = $this->PesanModel->get_entries_cfm($id, 'tb_mahasiswa as a');

        $config['pesan']=$lodmod;

        $this->load->view('pesan/confirm_mhs',$config);
    }

    public function confirm_masyarakat($id = null)
    {
        $this->load->model('PesanModel');

        $lodmod = $this->PesanModel->get_entries_cfmr($id, 'tb_masyarakat as a');

        $this->load->view('pesan/confirm_msyr', ['pesan' => $lodmod]);
    }

    public function confirm_data_perti($id = null)
    {
        $this->load->model('PertiModel');
        $this->load->model('PesanModel');
        $this->load->model('UserModel');

        $cek_uname = $this->PesanModel->get_entries_cf($id);

        $update_perti = $this->PertiModel->update_entry(['tampilkan' => 'ya'], $id);

        if ($update_perti) {
            $update_pesan = $this->PesanModel->update_entry(['tampilkan' => 'tidak'], $id, 'Admin');

            if ($update_pesan) {
                $datapost = [
                    'id_role' => 'Admin',
                    'id_pt' => $cek_uname->id,
                    'nama' => $cek_uname->nama,
                    'username' => substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8),
                    'kontak' => $cek_uname->kontak,
                    'email' => $cek_uname->email,
                    'password' => password_hash('12345', PASSWORD_BCRYPT),
                    'userfile' => $cek_uname->userfile,
                ];

                $insert_user = $this->UserModel->insert_entry($datapost);
                $lastid = $this->db->insert_id($insert_user);
                $update = $this->db->where('id',$id)->update('tb_perti',['id_user' => $lastid]);

                if ($update) {
                    $response = ['icon' => 'success', 'title' => $cek_uname->nama . ' Telah dikonfirmasi !'];
                }
            }
        }

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    public function confirm_data_mhs($id = null)
    {
        $this->load->model('MahasiswaModel');
        $this->load->model('PesanModel');
        $this->load->model('UserModel');

        $cek_uname = $this->PesanModel->get_entries_cfm($id, 'tb_mahasiswa as a');

        $update_perti = $this->MahasiswaModel->update_entry(['tampilkan' => 'ya'], $id);

        if ($update_perti) {
            $update_pesan = $this->PesanModel->update_entry(['tampilkan' => 'tidak'], $id, 'Mahasiswa');

            if ($update_pesan) {
                $datapost = [
                    'id_role' => 'Mahasiswa',
                    'id_pt' => $cek_uname->id_pt,
                    'nama' => $cek_uname->nama,
                    'username' => substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8),
                    'kontak' => $cek_uname->kontak,
                    'email' => $cek_uname->email,
                    'password' => password_hash('12345', PASSWORD_BCRYPT),
                    'userfile' => $cek_uname->userfile,
                ];

                $insert_user = $this->UserModel->insert_entry($datapost);
                $lastid = $this->db->insert_id($insert_user);
                $update = $this->db->where('id',$id)->update('tb_mahasiswa',['id_user' => $lastid]);

                if ($update) {
                    $response = ['icon' => 'success', 'title' => $cek_uname->nama . ' Telah dikonfirmasi !'];
                }
            }
        }

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    public function confirm_data_msyr($id = null)
    {
        $this->load->model('MasyarakatModel');
        $this->load->model('PesanModel');
        $this->load->model('UserModel');

        $cek_uname = $this->PesanModel->get_entries_cfmr($id, 'tb_masyarakat as a');

        $update_perti = $this->MasyarakatModel->update_entry(['tampilkan' => 'ya'], $id);

        if ($update_perti) {
            $update_pesan = $this->PesanModel->update_entry(['tampilkan' => 'tidak'], $id, 'Masyarakat');

            if ($update_pesan) {
                $datapost = [
                    'id_pt' => $cek_uname->id_pt,
                    'id_role' => 'Masyarakat',
                    'nama' => $cek_uname->nama_kel,
                    'username' => substr(str_shuffle("abcdefghijklmnopqrstuvwxyz0123456789"), 0, 8),
                    'kontak' => $cek_uname->kontak,
                    'email' => $cek_uname->email,
                    'password' => password_hash('12345', PASSWORD_BCRYPT),
                    'userfile' => $cek_uname->userfile,
                ];

                $insert_user = $this->UserModel->insert_entry($datapost);
                $lastid = $this->db->insert_id($insert_user);
                $update = $this->db->where('id',$id)->update('tb_masyarakat',['id_user' => $lastid]);

                if ($update) {
                    $response = ['icon' => 'success', 'title' => $cek_uname->nama_kel . ' Telah dikonfirmasi !'];
                }
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

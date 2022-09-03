<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProfileController extends CI_Controller
{
    public function index($id = false)
    {
        $this->load->model('UserModel');

        $cek_uname =  $this->db->where('id', $id)->where('tampilkan', 'ya')->get('tb_user')->row();

        $this->load->view('profile', ['users' => $cek_uname]);
    }

    public function update($id = false)
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('username', 'Username', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('email', 'Email', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kontak', 'Kontak', 'required', ['required' => '%s is required.']);

        $docname = explode('.', $_FILES['userfile']['name']);
        $ext = end($docname);
        $folder = 'uploads/';
        $new_name    = "userfile" . $this->input->post('username') . "." . $ext;
        $temp = $_FILES['userfile']['tmp_name'];

        $cek_uname =  $this->db->where('id', $id)->where('tampilkan', 'ya')->get('tb_user')->row();

        if (move_uploaded_file($temp, $folder . $new_name)) {
            $photo = $new_name;
        } else {
            $photo = $cek_uname->userfile;
        }

        $datapost = [
            'nama' => $this->input->post('nama'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'kontak' => $this->input->post('kontak'),
            'userfile' => $photo
        ];

        if ($this->input->post('password') || $this->input->post('repassword')) {
            $this->form_validation->set_rules('password', 'Password', 'required', ['required' => '%s is required.']);
            $this->form_validation->set_rules('repassword', 'Confirm Password', 'required', ['required' => '%s is required.']);

            $datapost += [
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            ];
        }

        if ($this->form_validation->run() == FALSE) {
            $response = array('error' => [
                'nama' => form_error('nama'),
                'username' => form_error('username'),
                'email' => form_error('email'),
                'kontak' => form_error('kontak'),
                'email' => form_error('email'),
                'password' => form_error('password'),
                'repassword' => form_error('repassword'),
                'userfile' => form_error('userfile'),
            ]);
        } else {

            $model = $this->load->model('UserModel');
            $update = $this->UserModel->update_entry($datapost, $id);

            if ($update) {
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
}

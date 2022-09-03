<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserController extends CI_Controller
{
    public function index()
    {
        $this->load->view('user/index');
    }

    public function user_json()
    {
        $this->load->model('UserModel');
        $cek_role = $this->session->userdata('id_role');
        $cek_perti = $this->session->userdata('id_pt');
        $list = $this->UserModel->get_datatables($cek_role,$cek_perti);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $row) {
            $no++;
            $nestedData      = array();
            $nestedData[]    = $no;
            $nestedData[]    = $row->nama;
            $nestedData[]    = $row->username;
            $nestedData[]    = $row->email;
            $nestedData[]    = $row->kontak;
            $nestedData[]    = "<a class='btn btn-sm btn-warning modal_xl' href='" . site_url('UserController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
            <a class='btn btn-sm btn-danger' href='" . site_url('UserController/hapus/' . $row->id) . "' id='Hapus_user'><i class='fa fa-trash'></i></a>";
            $data[] = $nestedData;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->UserModel->count_all($cek_role,$cek_perti),
            "recordsFiltered" => $this->UserModel->count_filtered($cek_role,$cek_perti),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id = null)
    {
        $this->load->model('UserModel');

        $cek_uname =  $this->db->where('id', $id)->where('tampilkan', 'ya')->get('tb_user')->row();

        $this->load->view('user/edit', ['users' => $cek_uname]);
    }

    public function update($id = null)
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

    public function hapus($id = null)
    {
        $model = $this->load->model('UserModel');
        $delete = $this->UserModel->delete_entry($id);

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

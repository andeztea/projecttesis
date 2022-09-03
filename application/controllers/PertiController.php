<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PertiController extends CI_Controller
{
    public function index()
    {
        $this->load->view('perti/index');
    }

    public function Perti_json()
    {
        $this->load->model('PertiModel');

        $list = $this->PertiModel->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $row) {
            $no++;
            $nestedData      = array();
            $nestedData[]    = $no;
            $nestedData[]    = $row->kode;
            $nestedData[]    = $row->nama;
            $nestedData[]    = $row->rektor;
            $nestedData[]    = $row->alamat;
            $nestedData[]    = $row->kontak;
            $nestedData[]    = "<a class='btn btn-sm btn-warning modal_xl' href='" . site_url('PertiController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
            <a class='btn btn-sm btn-danger' href='" . site_url('PertiController/hapus/' . $row->id) . "' id='Hapus_perti'><i class='fa fa-trash'></i></a>";
            $nestedData[]    = $row->id;
            $data[] = $nestedData;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->PertiModel->count_all(),
            "recordsFiltered" => $this->PertiModel->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id = null)
    {
        $this->load->model('PertiModel');

        $cek_uname =  $this->PertiModel->get_entries($id)->row();

        $this->load->view('perti/edit', ['perti' => $cek_uname]);
    }

    public function update($id = null)
    {
        $this->form_validation->set_rules('nama', 'Nama Pergutuan Tinggi', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kode', 'Kode Pergutuan Tinggi', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('rektor', 'Nama Rektor', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('email', 'Email', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kontak', 'Kontak', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required', ['required' => '%s is required.']);

        $docname = explode('.', $_FILES['userfile']['name']);
        $ext = end($docname);
        $folder = 'uploads/';
        $new_name    = "userfile" . $this->input->post('kode') . "." . $ext;
        $temp = $_FILES['userfile']['tmp_name'];

        $cek_uname =  $this->db->where('id', $id)->where('tampilkan', 'ya')->get('tb_perti')->row();

        if (move_uploaded_file($temp, $folder . $new_name)) {
            $photo = $new_name;
        } else {
            $photo = $cek_uname->userfile;
        }

        $datapost = [
            'nama' => $this->input->post('nama'),
            'kode' => $this->input->post('kode'),
            'rektor' => $this->input->post('rektor'),
            'email' => $this->input->post('email'),
            'kontak' => $this->input->post('kontak'),
            'alamat' => $this->input->post('alamat'),
            'provinsi' => $this->input->post('provinsi'),
            'kabupaten' => $this->input->post('kabupaten'),
            'kecamatan' => $this->input->post('kecamatan'),
            'userfile' => $photo
        ];

        if ($this->form_validation->run() == FALSE) {
            $response = array('error' => [
                'nama' => form_error('nama'),
                'kode' => form_error('kode'),
                'rektor' => form_error('rektor'),
                'kontak' => form_error('kontak'),
                'email' => form_error('email'),
                'alamat' => form_error('alamat'),
                'provinsi' => form_error('provinsi'),
                'kecamatan' => form_error('kecamatan'),
                'userfile' => form_error('userfile'),
            ]);
        } else {

            $model = $this->load->model('PertiModel');
            $update = $this->PertiModel->update_entry($datapost, $id);

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
        $lodmod = $this->load->model('PertiModel');
        $delete = $this->PertiModel->delete_entry($id);

        if ($delete) {
            $this->load->model('PesanModel');
            $this->PesanModel->delete_entry($id, 1);

            $response = ['icon' => 'success', 'title' => 'Hapus Berhasil'];
        } else {
            $response = ['icon' => 'error', 'title' => $lodmod->query_error()];
        }

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }
}

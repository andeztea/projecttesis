<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FakultasController extends CI_Controller
{
    public function index()
    {
        $this->load->view('fakultas/index');
    }

    public function datatables_json()
    {
        $this->load->model('FakultasModel');

        $cek_role = $this->session->userdata('id_role');
        $cek_perti = $this->session->userdata('id_pt');

        $list = $this->FakultasModel->get_datatables($cek_role,$cek_perti);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $row) {
            $no++;
            $nestedData      = array();
            $nestedData[]    = $no;
            $nestedData[]    = $row->fakultas;
            $nestedData[]    = $row->jurusan;
            $nestedData[]    = $row->program_studi;
            $nestedData[]    = "<a class='btn btn-sm btn-warning modal_xxl' href='" . site_url('FakultasController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
            <a class='btn btn-sm btn-danger' href='" . site_url('FakultasController/hapus/' . $row->id) . "' id='hapus_fakultas'><i class='fa fa-trash'></i></a>";
            $data[] = $nestedData;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->FakultasModel->count_all($cek_role,$cek_perti),
            "recordsFiltered" => $this->FakultasModel->count_filtered($cek_role,$cek_perti),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function tambah()
    {
        $this->load->view('fakultas/tambah');
    }

    public function store()
    {
        $this->form_validation->set_rules('kd_fakultas', 'Kode Fakultas', 'required|is_unique[tb_fakultas.kd_fakultas]', ['required' => '%s is required.','is_unique' => '%s sudah terdaftar.']);
        $this->form_validation->set_rules('fakultas', 'Nama Fakultas', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kd_jurusan', 'Kode Jurusan', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('jurusan', 'Nama Jurusan', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kd_prodi', 'Kode Program Studi', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('program_studi', 'Program Studi', 'required', ['required' => '%s is required.']);

        $datapost = [
            'id_pt' => $this->session->userdata('id_pt'),
            'kd_fakultas' => $this->input->post('kd_fakultas'),
            'fakultas' => $this->input->post('fakultas'),
            'kd_jurusan' => $this->input->post('kd_jurusan'),
            'jurusan' => $this->input->post('jurusan'),
            'kd_program_studi' => $this->input->post('kd_prodi'),
            'program_studi' => $this->input->post('program_studi'),
        ];

        if ($this->form_validation->run() == FALSE) {
            $response = array('error' => [
                'kd_fakultas' => form_error('kd_fakultas'),
                'fakultas' => form_error('fakultas'),
                'kd_jurusan' => form_error('kd_jurusan'),
                'jurusan' => form_error('jurusan'),
                'kd_prodi' => form_error('kd_prodi'),
                'program_studi' => form_error('program_studi'),
            ]);
        } else {
            $model = $this->load->model('FakultasModel');
            $insert = $this->FakultasModel->insert_entry($datapost);

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
        $this->load->model('FakultasModel');

        $cek_uname =  $this->FakultasModel->get_entries($id)->row();

        $this->load->view('fakultas/edit', ['fakultas' => $cek_uname]);
    }

    public function update($id = null)
    {
        $this->form_validation->set_rules('kd_fakultas', 'Kode Fakultas', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('fakultas', 'Nama Fakultas', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kd_jurusan', 'Kode Jurusan', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('jurusan', 'Nama Jurusan', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kd_prodi', 'Kode Program Studi', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('program_studi', 'Program Studi', 'required', ['required' => '%s is required.']);

        $datapost = [
            'kd_fakultas' => $this->input->post('kd_fakultas'),
            'fakultas' => $this->input->post('fakultas'),
            'kd_jurusan' => $this->input->post('kd_jurusan'),
            'jurusan' => $this->input->post('jurusan'),
            'kd_program_studi' => $this->input->post('kd_prodi'),
            'program_studi' => $this->input->post('program_studi'),
        ];

        if ($this->form_validation->run() == FALSE) {
            $response = array('error' => [
                'kd_fakultas' => form_error('kd_fakultas'),
                'fakultas' => form_error('fakultas'),
                'kd_jurusan' => form_error('kd_jurusan'),
                'jurusan' => form_error('jurusan'),
                'kd_prodi' => form_error('kd_prodi'),
                'program_studi' => form_error('program_studi'),
            ]);
        } else {

            $model = $this->load->model('FakultasModel');
            $update = $this->FakultasModel->update_entry($datapost, $id);

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
        $model = $this->load->model('FakultasModel');
        $delete = $this->FakultasModel->delete_entry($id);

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

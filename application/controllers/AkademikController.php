<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AkademikController extends CI_Controller
{
    public function index()
    {
        $this->load->view('akademik/index');
    }

    public function akademik_json()
    {
        $this->load->model('AkademikModel');

        $list = $this->AkademikModel->get_datatables();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $row) {
            $no++;
            $nestedData      = array();
            $nestedData[]    = $no;
            $nestedData[]    = $row->thn_akademik;
            $nestedData[]    = $row->periode;
            $nestedData[]    = $row->status;
            $nestedData[]    = $row->id;
            $data[] = $nestedData;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AkademikModel->count_all(),
            "recordsFiltered" => $this->AkademikModel->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function tambah()
    {
        $this->load->view('akademik/tambah');
    }

    public function store()
    {
        $this->form_validation->set_rules('thn_akademik', 'Tahun Akademik', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('periode', 'Periode', 'required', ['required' => '%s is required.']);

        if ($this->form_validation->run() == FALSE) {
            $response = array('error' => [
                'thn_akademik' => form_error('thn_akademik'),
                'periode' => form_error('periode'),
            ]);
        } else {
            $datapost = [
                'thn_akademik' => $this->input->post('thn_akademik'),
                'periode' => $this->input->post('periode'),
            ];

            $lodmod = $this->load->model('AkademikModel');
            $insert = $this->AkademikModel->insert_entry($datapost);

            if ($insert) {
                $response = ['icon' => 'success', 'title' => 'Registrasi Berhasil'];
            } else {
                $response = ['icon' => 'error', 'title' => $lodmod->query_error()];
            }
        }

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    public function update()
    {
        $akademik = explode('/', $this->input->post('akademik'));
        $setActive = explode('/', $this->input->post('setActive'));

        for ($i = 1; $i < count($akademik); $i++) {
            if ($setActive[$i] == 'Aktiv') {
                $datapost = ['status' => 2];
            } else {
                $datapost = ['status' => 1];
            }

            $lodmod = $this->load->model('AkademikModel');
            $update = $this->AkademikModel->update_entry($datapost, $akademik[$i]);

            if ($update) {
                $response = ['icon' => 'success', 'title' => 'Update Berhasil'];
            } else {
                $response = ['icon' => 'error', 'title' => $lodmod->query_error()];
            }
        }

        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->_display();
        exit;
    }

    public function hapus()
    {
        $akademik = explode('/', $this->input->post('akademik'));

        for ($i = 1; $i < count($akademik); $i++) {

            $lodmod = $this->load->model('AkademikModel');
            $delete = $this->AkademikModel->delete_entry($akademik[$i]);

            if ($delete) {
                $response = ['icon' => 'success', 'title' => 'Hapus Berhasil'];
            } else {
                $response = ['icon' => 'error', 'title' => $lodmod->query_error()];
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

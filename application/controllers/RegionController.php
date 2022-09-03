<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RegionController extends CI_Controller
{
    protected $provinsi;
    protected $kabupaten;
    protected $kecamatan;

    public function provinsi()
    {
        $this->load->model('RegionModel');
        $this->provinsi = $this->RegionModel->get_region('tb_provinsi');

        $search = $this->input->post('search');

        if ($search) {
            $result = $this->provinsi->like('nama', $search)->get();
        } else {
            $result = $this->provinsi->get();
        }

        $json = [];

        foreach ($result->result_array() as $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['nama']];
        }

        echo json_encode($json);
    }

    public function kabupaten()
    {
        $provID = $this->input->post('provID');
        $search = $this->input->post('search');

        $this->load->model('RegionModel');
        $this->provinsi = $this->RegionModel->get_region('tb_kabupaten', ['provinsi_id' => $provID]);

        if ($search) {
            $result = $this->provinsi->like('nama', $search)->get();
        } else {
            $result = $this->provinsi->get();
        }

        $json = [];

        foreach ($result->result_array() as $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['nama']];
        }

        echo json_encode($json);
    }

    public function kecamatan()
    {
        $kabID = $this->input->post('kabID');
        $search = $this->input->post('search');

        $this->load->model('RegionModel');
        $this->provinsi = $this->RegionModel->get_region('tb_kecamatan', ['kabupaten_id' => $kabID]);

        if ($search) {
            $result = $this->provinsi->like('nama', $search)->get();
        } else {
            $result = $this->provinsi->get();
        }

        $json = [];

        foreach ($result->result_array() as $value) {
            $json[] = ['id' => $value['id'], 'text' => $value['nama']];
        }

        echo json_encode($json);
    }
}

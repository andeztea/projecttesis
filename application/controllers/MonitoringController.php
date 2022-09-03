<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MonitoringController extends CI_Controller
{
    public function index()
    {
        $this->load->view('monitoring/index');
    }

    public function tambah()
    {
        $this->load->view('monitoring/tambah');
    }

    public function edit()
    {
        $this->load->view('monitoring/edit');
    }
}

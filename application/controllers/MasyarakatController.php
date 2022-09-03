<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MasyarakatController extends CI_Controller
{
    public function index()
    {
        $this->load->view('masyarakat/index');
    }

    public function datatables_json()
    {
        $this->load->model('MasyarakatModel');
        $cek_role = $this->session->userdata('id_role');
        $cek_perti = $this->session->userdata('id_pt');
        $list = $this->MasyarakatModel->get_datatables($cek_role,$cek_perti);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $row) {
            $no++;
            $nestedData      = array();
            $nestedData[]    = $no;
            $nestedData[]    = $row->nama_kel;
            $nestedData[]    = $row->nama_ket;
            $nestedData[]    = $row->kontak;
            $nestedData[]    = $row->alamat;
            if ($cek_role == 'Superadmin') {
                $nestedData[] = "<a class='btn btn-sm btn-info modal_xl' href='" . site_url('MasyarakatController/show/' . $row->id) . "'><i class='fa fa-eye'></i></a>";
            }else{
               $nestedData[]    = "<a class='btn btn-sm btn-warning modal_xl' href='" . site_url('MasyarakatController/edit/' . $row->id) . "'><i class='fa fa-edit'></i></a>
                <a class='btn btn-sm btn-danger' href='" . site_url('MasyarakatController/hapus/' . $row->id) . "' id='Hapus_msyr'><i class='fa fa-trash'></i></a>";
            }

           $nestedData[]    = $row->id;
            $data[] = $nestedData;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->MasyarakatModel->count_all($cek_role,$cek_perti),
            "recordsFiltered" => $this->MasyarakatModel->count_filtered($cek_role,$cek_perti),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id = null)
    {
        $this->load->model('MasyarakatModel');
        $this->load->model('PertiModel');

        $masyarakat =  $this->MasyarakatModel->get_entries($id)->row();
        $perti = $this->PertiModel->get_entries()->result();

        $this->load->view('masyarakat/edit', ['masyarakat' => $masyarakat, 'pertis' => $perti]);
    }

    public function show($id = null)
    {
        $this->load->model('MasyarakatModel');
        $this->load->model('PertiModel');

        $masyarakat =  $this->MasyarakatModel->get_entries($id)->row();
        $perti = $this->PertiModel->get_entries()->result();

        $this->load->view('masyarakat/show', ['masyarakat' => $masyarakat, 'pertis' => $perti]);
    }

    public function update($id = null)
    {
        $this->form_validation->set_rules('id_pt', 'Perguruan Tinggi', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('nama_kel', 'Nama Kelompok', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('nama_ket', 'Nama Ketua', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('jml_anggota', 'Jumlah Anggota', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kontak', 'Kontak', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kabupaten', 'Kabupaten', 'required', ['required' => '%s is required.']);
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required', ['required' => '%s is required.']);

        $docname = explode('.', $_FILES['userfile']['name']);
        $ext = end($docname);
        $folder = 'uploads/';
        $new_name    = "userfile" . $this->input->post('username') . "." . $ext;
        $temp = $_FILES['userfile']['tmp_name'];

        $cek_uname =  $this->db->where('id', $id)->get('tb_masyarakat')->row();

        if (move_uploaded_file($temp, $folder . $new_name)) {
            $photo = $new_name;
        } else {
            $photo = $cek_uname->userfile;
        }

        if ($this->input->post('jns_produk') == NULL) {
            $jenisnya = $this->input->post('produk_lainnya');
        } else {
            $jenisnya = $this->input->post('jns_produk');
        }

        $datapost = [
            'id_pt' => $this->input->post('id_pt'),
            'nama_kel' => $this->input->post('nama_kel'),
            'nama_ket' => $this->input->post('nama_ket'),
            'jml_anggota' => $this->input->post('jml_anggota'),
            'kontak' => $this->input->post('kontak'),
            'jns_produk' => $jenisnya,
            'alamat' => $this->input->post('alamat'),
            'provinsi' => $this->input->post('provinsi'),
            'kabupaten' => $this->input->post('kabupaten'),
            'kecamatan' => $this->input->post('kecamatan'),
            'userfile' => $photo
        ];

        if ($this->form_validation->run() == FALSE) {
            $response = array('error' => [
                'id_pt' => form_error('id_pt'),
                'nama_kel' => form_error('nama_kel'),
                'nama_ket' => form_error('nama_ket'),
                'jml_anggota' => form_error('jml_anggota'),
                'kontak' => form_error('kontak'),
                'alamat' => form_error('alamat'),
                'provinsi' => form_error('provinsi'),
                'kecamatan' => form_error('kecamatan'),
                'userfile' => form_error('userfile'),
            ]);
        } else {

            $model = $this->load->model('MasyarakatModel');
            $update = $this->MasyarakatModel->update_entry($datapost, $id);

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
        $model = $this->load->model('MasyarakatModel');
        $delete = $this->MasyarakatModel->delete_entry($id);

        if ($delete) {
            $this->load->model('PesanModel');
            $this->PesanModel->delete_entry($id, 3);
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

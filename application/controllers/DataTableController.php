<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DataTableController extends CI_Controller
{
	public function datatables_mhs_by_fakultas($id_fakultas = false)
	{
		$this->load->model('DataTable/MahasiswaByFakultas', 'MahasiswaByFakultas');
		$cek_perti = $this->session->userdata('id_pt');
		$list = $this->MahasiswaByFakultas->get_datatables_mhs_by_fakultas($id_fakultas, $cek_perti);

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nama;
			$nestedData[]    = $row->kontak;
			$nestedData[]    = $row->fakultas . '/' . $row->jurusan . '/' . $row->program_studi;
			$nestedData[]    = $row->thn_akademik . '/' . $row->periode;
			$nestedData[]    = $row->id;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->MahasiswaByFakultas->count_all_mhs_by_fakultas($id_fakultas, $cek_perti),
			"recordsFiltered" => $this->MahasiswaByFakultas->count_filtered_mhs_by_fakultas($id_fakultas, $cek_perti),
			"data" => $data,
		);

		//output to json format
		echo json_encode($output);
	}

	public function datatables_set_kelas($id_kelas = false, $id_dosen = false)
	{
		$this->load->model('SetKelasModel');
		$list = $this->SetKelasModel->get_datatables($id_kelas, $id_dosen);

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nama_mhs;
			$nestedData[]    = $row->kontak;
			$nestedData[]    = $row->fakultas . '/' . $row->jurusan . '/' . $row->program_studi;
			$nestedData[]    = $row->thn_akademik . '/' . $row->periode;
			$nestedData[]    = $row->idmhs;
			$nestedData[]    = $row->id;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->SetKelasModel->count_all($id_kelas, $id_dosen),
			"recordsFiltered" => $this->SetKelasModel->count_filtered($id_kelas, $id_dosen),
			"data" => $data,
		);

		//output to json format
		echo json_encode($output);
	}

	public function datatables_mhs_absensi($id_kelas, $id_dosen)
	{
		$this->load->model('SetKelasModel');
		$list = $this->SetKelasModel->get_datatables($id_kelas, $id_dosen);

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nama_mhs;
			$nestedData[]    = '<select class="form-control status" name="status" data-id=' . $row->idmhs . '>
                                    <option value="H">Hadir</option>
                                    <option value="I">Izin</option>
                                    <option value="S">Sakit</option>
                                    <option value="A">Alpa</option>
                                </select>';
			$nestedData[]    = $row->idmhs;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->SetKelasModel->count_all($id_kelas, $id_dosen),
			"recordsFiltered" => $this->SetKelasModel->count_filtered($id_kelas, $id_dosen),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function datatables_realisasi_json($id_kelas)
	{
		$this->load->model('PengajarModel');

		$KelasDosen = $this->PengajarModel->get_datatables($id_kelas);

		$data = array();
		$no = $_POST['start'];

		foreach ($KelasDosen as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $row->pertemuan_ke;
			$nestedData[]    = $row->date;
			$nestedData[]    = "Materi Pokok :" . $row->materi_pokok . "<br>" . "Materi Sub Pokok :" . $row->bahasan;
			$nestedData[]    = $row->bukti;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->PengajarModel->count_all($id_kelas),
			"recordsFiltered" => $this->PengajarModel->count_filtered($id_kelas),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function datatables_rekapitulasi_json($id_kelas = null)
	{
		$this->load->model('PengajarModel');

		$list = $this->PengajarModel->get_datatables($id_kelas);

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nama_mhs;
			$nestedData[]    = $row->pertemuan_ke;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nim;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->PengajarModel->count_all($id_kelas),
			"recordsFiltered" => $this->PengajarModel->count_filtered($id_kelas),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function datatables_nilai_akhir_add($id_dosen, $id_kelas)
	{
		$this->load->model('SetKelasModel');

		$list = $this->SetKelasModel->get_datatables($id_kelas, $id_dosen);

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nama_mhs;
			$nestedData[]    = '<input type="text" step="any" class="form-control" name="kehadiran[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" name="aktivitas[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" name="medium[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" name="final[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" name="rata_rata[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" name="nilai_huruf[]"></input>';
			$nestedData[]    = '<input type="hidden" class="form-control" value="' . $row->idmhs . '" name="id_mhs[]"></input>';
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->SetKelasModel->count_all($id_dosen, $id_kelas),
			"recordsFiltered" => $this->SetKelasModel->count_filtered($id_dosen, $id_kelas),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function datatables_nilai_akhir_edit($id_penilai)
	{
		$this->load->model('NilaiAkhirModel');

		$list = $this->NilaiAkhirModel->get_datatables($id_penilai);

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nama;
			$nestedData[]    = '<input type="text" step="any" class="form-control" value="' . $row->kehadiran . '" name="kehadiran[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" value="' . $row->aktivitas . '" name="aktivitas[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" value="' . $row->medium . '" name="medium[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" value="' . $row->final . '" name="final[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" value="' . $row->rata_rata . '" name="rata_rata[]"></input>';
			$nestedData[]    = '<input type="text" step="any" class="form-control" value="' . $row->nilai_huruf . '" name="nilai_huruf[]"></input>';
			$nestedData[]    = '<input type="hidden" class="form-control" value="' . $row->id_mhs . '" name="id_mhs[]"></input>';;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->NilaiAkhirModel->count_all($id_penilai),
			"recordsFiltered" => $this->NilaiAkhirModel->count_filtered($id_penilai),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function datatables_mhs_kegiatan_add($id_kelas = false, $id_dosen = false)
	{
		$this->load->model('MasyarakatModel');
		$list = $this->MasyarakatModel->get_datatables_mhs_by_kelas($id_kelas, $id_dosen);

		$data = array();
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$nestedData      = array();
			$nestedData[]    = $no;
			$nestedData[]    = $row->nim;
			$nestedData[]    = $row->nama;
			$nestedData[]    = $row->jns_kwdk;
			$nestedData[]    = 'asdasdas';
			$nestedData[]    = $row->id;
			$data[] = $nestedData;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->MasyarakatModel->count_all_mhs_by_kelas($id_kelas, $id_dosen),
			"recordsFiltered" => $this->MasyarakatModel->count_filtered_mhs_by_kelas($id_kelas, $id_dosen),
			"data" => $data,
		);

		//output to json format
		echo json_encode($output);
	}
}

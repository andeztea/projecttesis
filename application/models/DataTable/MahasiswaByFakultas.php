<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MahasiswaByFakultas extends CI_Model
{
	protected $query;
	protected $column_order = array(null, 'a.nim', 'a.nama', 'a.kontak', 'b.fakultas', 'c.thn_akademik');
	protected $column_search = array('a.nim', 'a.nama', 'a.kontak', 'b.fakultas', 'c.thn_akademik', 'd.nama');
	protected $order = array('a.id' => 'asc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function datatables_mhs_by_fakultas($id_fakultas, $cek_perti)
	{

		$this->db->select('a.*,b.fakultas,b.jurusan,b.program_studi,c.thn_akademik,c.periode,d.nama as nama_pt')
			->from('tb_mahasiswa as a')
			->join('tb_fakultas as b', 'a.id_fakultas = b.id', 'left')
			->join('tb_akademik as c', 'a.id_akd = c.id', 'left')
			->join('tb_perti as d', 'a.id_pt = d.id', 'left')
			->where('a.id_fakultas', $id_fakultas)
			->where('a.id_pt', $cek_perti)
			->where('a.tampilkan', 'ya')
			->where('a.sembunyikan', 'tidak');

		$i = 0;

		foreach ($this->column_search as $item) // loop column 
		{
			if ($_POST['search']['value']) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables_mhs_by_fakultas($id_fakultas = false, $cek_perti = false)
	{
		$this->datatables_mhs_by_fakultas($id_fakultas, $cek_perti);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);

		$query = $this->db->get();

		return $query->result();
	}

	function count_filtered_mhs_by_fakultas($id_fakultas = false, $cek_perti = false)
	{
		$this->datatables_mhs_by_fakultas($id_fakultas, $cek_perti);

		return $this->db->get()->num_rows();
	}

	public function count_all_mhs_by_fakultas($id_fakultas = false, $cek_perti = false)
	{
		$query = $this->db->from('tb_mahasiswa')->where('id_fakultas', $id_fakultas)->where('id_pt', $cek_perti)->where('tampilkan', 'ya');

		return $query->count_all_results();
	}
}

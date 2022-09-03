<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NilaiAkhirModel extends CI_Model
{

	protected $table = 'tb_nilai_akhir';
	protected $query;
	protected $column_order = array(null, 'b.nim', 'b.nama', 'a.kehadiran', 'a.aktivitas', 'a.medium', 'a.final', 'a.rata_rata', 'a.nilai_huruf', null); //set column field database for datatable orderable
	protected $column_search = array('b.nim', 'b.nama'); //set column field database for datatable searchable 
	protected $order = array('a.id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_entries($id_penilai = false)
	{
		$query = $this->db
			->select('a.*,b.nim,b.nama')
			->join('tb_mahasiswa as b', 'b.id = a.id_mhs', 'left')
			->where('a.id', $id_penilai)
			->get('tb_nilai_akhir as a');

		return $query->result();
	}

	public function insert_entry($datapost)
	{
		return $this->db->insert($this->table, $datapost);
	}

	public function update_entry($datapost, $id_penilai, $id_mhs)
	{
		return $this->db->where('id_penilai', $id_penilai)->where('id_mhs', $id_mhs)->update($this->table, $datapost);
	}

	public function delete_entry($where)
	{
		return $this->db->where('id_penilai', $where)->delete($this->table);
	}

	private function _get_datatables_query($id_penilai)
	{
		$query = $this->db
			->select('a.*,b.nim,b.nama')
			->from('tb_nilai_akhir as a')
			->join('tb_mahasiswa as b', 'b.id = a.id_mhs', 'left')
			->where('a.id_penilai', $id_penilai);

		return $query;

		$i = 0;

		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {

				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables($id_penilai)
	{
		$this->_get_datatables_query($id_penilai);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($id_penilai)
	{
		$this->_get_datatables_query($id_penilai);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($id_penilai)
	{
		return $this->db->from($this->table)->where('id_penilai', $id_penilai)->count_all_results();
	}
}

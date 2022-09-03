<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SetKelasModel extends CI_Model
{

	protected $table = 'tb_set_kelas';
	protected $query;
	protected $column_order = array(null, 'b.nim', 'b.nama', 'b.kontak', 'c.fakultas', 'd.thn_akademik'); //set column field database for datatable orderable
	protected $column_search = array('b.nim', 'b.nama'); //set column field database for datatable searchable 
	protected $order = array('a.id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($id_kelas, $id_dosen)
	{
		$this->db->select('a.*,b.id as idmhs,b.nama as nama_mhs,b.nim,b.kontak,c.fakultas,c.jurusan,c.program_studi,d.thn_akademik,d.periode')
			->from('tb_set_kelas as a')
			->join('tb_mahasiswa as b', 'a.id_mhs = b.id', 'left')
			->join('tb_fakultas as c', 'b.id_fakultas = c.id', 'left')
			->join('tb_akademik as d', 'b.id_akd = d.id', 'left')
			->where('a.id_user', $id_dosen)
			->where('a.id_kelas', $id_kelas)
			->where('a.tampilkan', 'ya');

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

	function get_datatables($id_kelas, $id_dosen)
	{
		$this->_get_datatables_query($id_kelas, $id_dosen);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		return $this->db->get()->result();
	}

	function count_filtered($id_kelas, $id_dosen)
	{
		$this->_get_datatables_query($id_kelas, $id_dosen);

		return $this->db->get()->num_rows();
	}

	public function count_all($id_kelas, $id_dosen)
	{
		$this->db->where('id_kelas', $id_kelas)->from($this->table)->where('id_user', $id_dosen);

		return $this->db->count_all_results();
	}

	public function get_entries($where = false)
	{
		if ($where == FALSE) {
			$query = $this->db->where('tampilkan', 'ya')->get($this->table);
		} else {
			$query = $this->db->where('id', $where)->where('tampilkan', 'ya')->get($this->table);
		}

		return $query;
	}

	public function insert_entry($datapost)
	{
		return $this->db->insert($this->table, $datapost);
	}

	public function update_entry($datapost, $id_dosen)
	{
		return $this->db->where('id_dosen', $id_dosen)->update($this->table, $datapost);
	}

	public function delete_entry($id_dosen)
	{
		return $this->db->where('id', $id_dosen)->delete($this->table);
	}

	public function delete_double_entry($id_dosen, $id_kelas)
	{
		return $this->db->where('id_dosen', $id_dosen)->where('id_kelas', $id_kelas)->delete($this->table);
	}
}

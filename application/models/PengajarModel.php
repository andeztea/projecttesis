<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PengajarModel extends CI_Model
{

	protected $table = 'tb_pengajar';
	protected $query;
	protected $column_order = array(null, 'd.nama_kelas', 'c.thn_akademik'); //set column field database for datatable orderable
	protected $column_search = array('d.nama_kelas', 'c.thn_akademik'); //set column field database for datatable searchable 
	protected $order = array('a.id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_kehadiran($where = false)
	{
		return $this->db
			->select('a.*,b.nim,b.nama')
			->from('tb_kehadiran as a')
			->join('tb_mahasiswa as b', 'a.id_mhs = b.id', 'left')
			->where('a.id_pengajar', $where)->get();
	}

	public function get_realisasi($where = false)
	{
		return $this->db->where('id_pengajar', $where)->get('tb_realisasi');
	}

	public function get_entries($where = false)
	{
		$query = $this->db
			->select('a.*,b.nama,c.thn_akademik,d.nama_kelas,d.mata_kuliah,d.sks')
			->from('tb_pengajar as a')
			->join('tb_dosen as b', 'a.id_user = b.id', 'left')
			->join('tb_akademik as c', 'a.id_akd = c.id', 'left')
			->join('tb_kelas as d', 'a.id_kelas = d.id', 'left')
			->join('tb_fakultas as e', 'b.id_fakultas = e.id', 'left')
			->where('a.tampilkan', 'ya');

		if ($where == FALSE) {
			$result = $query->get();
		} else {
			$result = $query->where('a.id', $where)->get();
		}

		return $result;
	}

	private function _get_datatables_query($cek_role, $cek_perti, $cek_user)
	{
		$this->db
			->select('a.*,b.thn_akademik,c.nama_kelas,c.mata_kuliah,c.sks')
			->from('tb_pengajar as a')
			->join('tb_akademik as b', 'b.id = a.id_akd', 'left')
			->join('tb_kelas as c', 'c.id = a.id_kelas', 'left')
			->where('a.tampilkan', 'ya');

		if ($cek_role != 'Superadmin') {
			$this->db->where('a.id_pt', $cek_perti)->where('a.id_user', $cek_user);
		}

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

	function get_datatables($cek_role, $cek_perti, $cek_user)
	{
		$this->_get_datatables_query($cek_role, $cek_perti, $cek_user);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);

		$query = $this->db->get();

		return $query->result();
	}

	function count_filtered($cek_role, $cek_perti, $cek_user)
	{
		$this->_get_datatables_query($cek_role, $cek_perti, $cek_user);

		$query = $this->db->get();

		return $query->num_rows();
	}

	public function count_all($cek_role, $cek_perti, $cek_user)
	{
		$this->db->from($this->table);

		if ($cek_role != 'Superadmin') {
			$query = $this->db->where('id_pt', $cek_perti)->where('id_user', $cek_user)->where('tampilkan', 'ya')->count_all_results();
		} else {
			$query = $this->db->where('tampilkan', 'ya')->count_all_results();
		}

		return $query;
	}

	public function delete_entry($where)
	{
		return $this->db->where('id', $where)->delete($this->table);
	}

	public function insert_entry($datapost)
	{
		return $this->db->insert($this->table, $datapost);
	}

	public function update_entry($datapost, $where)
	{
		return $this->db->where('id', $where)->update($this->table, $datapost);
	}
}

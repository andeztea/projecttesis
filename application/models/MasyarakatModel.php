<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MasyarakatModel extends CI_Model
{

	protected $table = 'tb_masyarakat';
	protected $query;
	protected $column_order = array(null, 'a.nama_kel', 'a.nama_ket', 'a.kontak', 'a.alamat'); //set column field database for datatable orderable
	protected $column_search = array('a.nama_kel', 'a.nama_ket', 'a.kontak', 'a.alamat', 'b.nama'); //set column field database for datatable searchable 
	protected $order = array('id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_entries($where = false)
	{
		$cek_perti = $this->session->userdata('id_pt');
		$query = $this->db
			->select('a.*')
			->from('tb_masyarakat as a')
			->where('a.tampilkan', 'ya')
			->where('a.id_pt', $cek_perti);

		if ($where == FALSE) {
			$result = $query->get();
		} else {
			$result = $query->where('a.id', $where)->get();
		}

		return $result;
	}

	public function insert_entry($datapost)
	{
		return $this->db->insert($this->table, $datapost);
	}

	public function update_entry($datapost, $where)
	{
		return $this->db->where('id', $where)->update($this->table, $datapost);
	}

	public function delete_entry($where)
	{
		return $this->db->where('id', $where)->delete($this->table);
	}

	private function _get_datatables_query($cek_role, $cek_perti)
	{

		$this->db->select('a.*,b.nama')->from('tb_masyarakat as a')
			->join('tb_perti as b', 'a.id_pt = b.id', 'left')
			->where('a.tampilkan', 'ya');

		if ($cek_role != 'Superadmin') {
			$this->db->where('id_pt', $cek_perti);
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

	function get_datatables($cek_role, $cek_perti)
	{
		$this->_get_datatables_query($cek_role, $cek_perti);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($cek_role, $cek_perti)
	{
		$this->_get_datatables_query($cek_role, $cek_perti);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		$cek_role = $this->session->userdata('id_role');
		$cek_perti = $this->session->userdata('id_pt');

		if ($cek_role != 'Superadmin') {
			$query = $this->db->where('id_pt', $cek_perti)->where('tampilkan', 'ya')->count_all_results();
		} else {
			$query = $this->db->where('tampilkan', 'ya')->count_all_results();
		}

		return $query;
	}

	private function datatables_mhs_by_kelas($id_kelas, $id_dosen)
	{
		$this->db->select('b.*', 'a.*')
			->from('tb_set_kelas as a')
			->join('tb_mahasiswa as b', 'b.id=a.id_mhs', 'left')
			->where('a.id_kelas', $id_kelas)
			->where('a.id_user', $id_dosen)
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

	function get_datatables_mhs_by_kelas($id_kelas = false, $id_dosen = false)
	{
		$this->datatables_mhs_by_kelas($id_kelas, $id_dosen);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);

		$query = $this->db->get();

		return $query->result();
	}

	function count_filtered_mhs_by_kelas($id_kelas = false, $id_dosen = false)
	{
		$this->datatables_mhs_by_kelas($id_kelas, $id_dosen);

		return $this->db->get()->num_rows();
	}

	public function count_all_mhs_by_kelas($id_kelas = false, $id_dosen = false)
	{
		$query = $this->db->from('tb_set_kelas')->where('id_kelas', $id_kelas)->where('id_user', $id_dosen)->where('tampilkan', 'ya');

		return $query->count_all_results();
	}
}

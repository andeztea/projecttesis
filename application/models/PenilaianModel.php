<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PenilaianModel extends CI_Model
{

	protected $table = 'tb_penilaian';
	protected $query;
	protected $column_order = array(null, 'd.fakultas', 'e.nama_kelas', 'f.thn_akademik'); //set column field database for datatable orderable
	protected $column_search = array('d.fakultas', 'e.nama_kelas', 'f.thn_akademik'); //set column field database for datatable searchable 
	protected $order = array('a.id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query($id_dosen)
	{
		$this->db
			->select('a.*,d.fakultas,d.jurusan,d.program_studi,e.nama_kelas,f.thn_akademik')
			->from('tb_penilaian as a')
			->join('tb_fakultas as d', 'd.id = a.id_fakultas', 'left')
			->join('tb_kelas as e', 'e.id = a.id_kelas', 'left')
			->join('tb_akademik as f', 'f.id = a.id_akd', 'left')
			->where('a.id_dosen', $id_dosen);

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

	function get_datatables($id_dosen)
	{
		$this->_get_datatables_query($id_dosen);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);

		$query = $this->db->get();

		return $query->result();
	}

	function count_filtered($id_dosen)
	{
		$this->_get_datatables_query($id_dosen);

		$query = $this->db->get();


		return $query->num_rows();
	}

	public function count_all($id_dosen)
	{
		$this->db->from($this->table);

		return $this->db->where('id_dosen', $id_dosen)->count_all_results();
	}

	public function delete_entry($where)
	{
		return $this->db->where('id', $where)->delete($this->table);
	}

	public function insert_entry($datapost)
	{
		return $this->db->insert($this->table, $datapost);
	}

	public function update_entry($id_dosen, $id_mhs, $datapost)
	{
		return $this->db->where('id_dosen', $id_dosen)->where('id_mhs', $id_mhs)->update($this->table, $datapost);
	}

	public function get_dosen($id_user)
	{
		return $this->db
			->select('b.id as dosen_id,b.id_kelas,a.id_pt')
			->join('tb_dosen as b', 'a.id = b.id_user', 'left')
			->where('a.id', $id_user)->get('tb_user as a')
			->row();
	}

	public function cek_data($id_dosen, $id_kelas)
	{
		return $this->db
			->where('id_dosen', $id_dosen)
			->where('id_kelas', $id_kelas)
			->get($this->table)
			->row();
	}

	public function get_data($id)
	{
		return $this->db
			->select('a.*,d.fakultas,d.jurusan,d.program_studi,e.nama_kelas,e.mata_kuliah,e.sks,f.thn_akademik,f.periode')
			->from('tb_penilaian as a')
			->join('tb_fakultas as d', 'd.id = a.id_fakultas', 'left')
			->join('tb_kelas as e', 'e.id = a.id_kelas', 'left')
			->join('tb_akademik as f', 'f.id = a.id_akd', 'left')
			->where('a.id', $id)->get();
	}
}

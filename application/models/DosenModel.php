<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DosenModel extends CI_Model
{

	protected $table = 'tb_dosen';
	protected $query;
	protected $column_order = array(null, 'a.nidn', 'a.nama', 'c.thn_akademik'); //set column field database for datatable orderable
	protected $column_search = array('a.nidn', 'a.nama', 'c.thn_akademik', 'h.nama'); //set column field database for datatable searchable 
	protected $order = array('id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function cek_dosen($var = null, $var2 = null)
	{
		return $this->db->where('id_user', $var)->where('id_kelas', $var2)->get($this->table)->row();
	}

	public function get_entries($where = false)
	{
		$query = $this->db
			->select('a.*,c.thn_akademik,c.periode,d.nama_kelas,d.mata_kuliah,e.nama as nama_prov,f.nama as nama_kab,g.nama as nama_kec,h.program_studi,h.fakultas,h.jurusan')
			->from('tb_dosen as a')
			->join('tb_akademik as c', 'a.id_akd = c.id', 'left')
			->join('tb_kelas as d', 'a.id_kelas = d.id', 'left')
			->join('tb_provinsi as e', 'a.provinsi = e.id', 'left')
			->join('tb_kabupaten as f', 'a.kabupaten = f.id', 'left')
			->join('tb_kecamatan as g', 'a.kecamatan = g.id', 'left')
			->join('tb_fakultas as h', 'a.id_fakultas = h.id', 'left')
			->where('a.tampilkan', 'ya');

		if ($where == FALSE) {
			$result = $query;
		} else {
			$result = $query->where('a.id', $where);
		}

		return $result->get();
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
		$this->db
			->select('a.*,c.thn_akademik,d.nama_kelas,e.nama as nama_prov,f.nama as nama_kab,g.nama as nama_kec,h.nama as nama_pt')
			->from('tb_dosen as a')
			->join('tb_akademik as c', 'a.id_akd = c.id', 'left')
			->join('tb_kelas as d', 'a.id_kelas = d.id', 'left')
			->join('tb_provinsi as e', 'a.provinsi = e.id', 'left')
			->join('tb_kabupaten as f', 'a.kabupaten = f.id', 'left')
			->join('tb_kecamatan as g', 'a.kecamatan = g.id', 'left')
			->join('tb_perti as h', 'a.id_pt = h.id', 'left')
			->where('a.tampilkan', 'ya');

		if ($cek_role != 'Superadmin') {
			$this->db->where('a.id_pt', $cek_perti);
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
}

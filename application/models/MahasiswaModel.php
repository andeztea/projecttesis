<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MahasiswaModel extends CI_Model
{

	protected $table = 'tb_mahasiswa';
	protected $query;
	protected $column_order = array(null, 'a.nim', 'a.nama', 'a.kontak', 'b.fakultas', 'c.thn_akademik'); //set column field database for datatable orderable
	protected $column_search = array('a.nim', 'a.nama', 'a.kontak', 'b.fakultas', 'c.thn_akademik', 'd.nama'); //set column field database for datatable searchable 
	protected $order = array('a.id' => 'asc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function get_entries($where = false)
	{
		$query = $this->db
			->select('a.*,b.fakultas,b.jurusan,b.program_studi,c.thn_akademik,c.periode,d.nama as nama_pt,e.nama as nama_prov,f.nama as nama_kab,g.nama as nama_kec')
			->join('tb_fakultas as b', 'a.id_fakultas = b.id', 'left')
			->join('tb_akademik as c', 'a.id_akd = c.id', 'left')
			->join('tb_perti as d', 'a.id_pt = d.id', 'left')
			->join('tb_provinsi as e', 'a.provinsi = e.id', 'left')
			->join('tb_kabupaten as f', 'a.kabupaten = f.id', 'left')
			->join('tb_kecamatan as g', 'a.kecamatan = g.id', 'left')
			->where('a.tampilkan', 'ya');

		if ($where == FALSE) {
			$result = $query;
		} else {
			$result = $query->where('a.id', $where);
		}

		return $result->get('tb_mahasiswa as a');
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

	private function _get_datatables_mhs($cek_perti)
	{

		$this->db->select('a.*,b.fakultas,b.jurusan,b.program_studi,c.thn_akademik,c.periode,d.nama as nama_pt')
			->from('tb_mahasiswa as a')
			->join('tb_fakultas as b', 'a.id_fakultas = b.id', 'left')
			->join('tb_akademik as c', 'a.id_akd = c.id', 'left')
			->join('tb_perti as d', 'a.id_pt = d.id', 'left')
			->where('a.tampilkan', 'ya');

		if ($cek_perti) {
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

	function get_datatables_mhs($cek_perti = false)
	{
		$this->_get_datatables_mhs($cek_perti);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);

		$query = $this->db->get();

		return $query->result();
	}

	function count_filtered_mhs($cek_perti = false)
	{
		$this->_get_datatables_mhs($cek_perti);

		if ($cek_perti) {
			$this->db->where('a.id_pt', $cek_perti);

			if ($this->input->post('sembunyikan')) {
				$this->db->where('a.sembunyikan', 'tidak');
			}
		}

		return $this->db->get()->num_rows();
	}

	public function count_all_mhs($cek_perti = false)
	{
		$query = $this->db->from($this->table);

		if ($cek_perti) {
			$this->db->where('id_pt', $cek_perti);

			if ($this->input->post('sembunyikan')) {
				$this->db->where('sembunyikan', 'tidak');
			}
		}

		$this->db->where('tampilkan', 'ya');

		return $query->count_all_results();
	}
}

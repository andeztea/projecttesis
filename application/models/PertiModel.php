<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PertiModel extends CI_Model
{

    protected $table = 'tb_perti';
    protected $query;
    protected $column_order = array(null, 'kode', 'nama', 'rektor', 'alamat', 'kontak'); //set column field database for datatable orderable
    protected $column_search = array('kode', 'nama', 'rektor', 'alamat', 'kontak'); //set column field database for datatable searchable 
    protected $order = array('id' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_entries($where = false)
    {
        $query = $this->db
            ->select('a.*,e.nama as nama_prov,f.nama as nama_kab,g.nama as nama_kec')
            ->join('tb_provinsi as e', 'a.provinsi = e.id', 'left')
            ->join('tb_kabupaten as f', 'a.kabupaten = f.id', 'left')
            ->join('tb_kecamatan as g', 'a.kecamatan = g.id', 'left')
            ->where('a.tampilkan', 'ya');

        if ($where == FALSE) {
            $result = $query->get('tb_perti as a');
        } else {
            $result = $query->where('a.id', $where)->get('tb_perti as a');
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

    private function _get_datatables_query()
    {

        $this->db->from($this->table)->where('tampilkan', 'ya');

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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}

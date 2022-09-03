<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NilaiModel extends CI_Model
{

    protected $table = 'tb_bobot_nilai';
    protected $query;
    protected $column_order = array(null, 'b.thn_akademik', 'a.nilai_min', 'a.nilai_huruf'); //set column field database for datatable orderable
    protected $column_search = array('b.thn_akademik', 'a.nilai_min', 'a.nilai_huruf'); //set column field database for datatable searchable 
    protected $order = array('a.id' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_entries($where = false)
    {
        $query = $this->db
            ->select('a.*,b.thn_akademik')
            ->join('tb_akademik as b', 'a.id_akd = b.id', 'left')
            ->where('a.tampilkan', 'ya');

        if ($where == FALSE) {
            $result = $query->get('tb_bobot_nilai as a');
        } else {
            $result = $query->where('a.id', $where)->get('tb_bobot_nilai as a');
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

    private function _get_datatables_query($cek_role,$cek_perti)
    {
        $this->db->select('a.*,b.thn_akademik')->from('tb_bobot_nilai as a')->join('tb_akademik as b', 'a.id_akd = b.id', 'left')->where('a.tampilkan', 'ya');

        if ($cek_role != 'Superadmin') {
            $this->db->where('id_pt',$cek_perti);
        }

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

    function get_datatables($cek_role,$cek_perti)
    {
        $this->_get_datatables_query($cek_role,$cek_perti);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($cek_role,$cek_perti)
    {
        $this->_get_datatables_query($cek_role,$cek_perti);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        $cek_role = $this->session->userdata('id_role');
        $cek_perti = $this->session->userdata('id_pt');

        if ($cek_role != 'Superadmin') {
            $query = $this->db->where('id_pt',$cek_perti)->where('tampilkan', 'ya')->count_all_results();
        }else{
            $query = $this->db->where('tampilkan', 'ya')->count_all_results();
        }
        
        return $query;
    }
}

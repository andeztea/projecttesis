<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

    protected $table = 'tb_user';
    protected $query;
    protected $column_order = array(null, 'nama', 'username', 'email', 'kontak'); //set column field database for datatable orderable
    protected $column_search = array('nama', 'username', 'email', 'kontak'); //set column field database for datatable searchable 
    protected $order = array('id' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function cek_user($username, $password)
    {
        $cek_uname =  $this->db->where('username', $username)->where('tampilkan', 'ya')->get($this->table)->row();
    }

     public function get_entries($where = false,$id_pt = false)
    {
        $query = $this->db->where('tampilkan', 'ya')->where('id_pt', $id_pt);

        if ($where == FALSE) {
            $result = $query->get($this->table);
        } else {
            $result = $query->where('id', $where)->get($this->table);
        }

        return $result;
    }

     public function get_entries_ds($ids = false,$id_pt = false)
    {
        $query = $this->db->where('tampilkan', 'ya')->where('id_pt', $id_pt)->where('id_role','Dosen');

        if ($ids == FALSE) {
            $result = $query->get($this->table);
        } else {
            $result = $query->where('id', $ids)->get($this->table);
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

    public function update_konfirmasi($datapost, $code)
    {
        return $this->db->where('code', $code)->update($this->table, $datapost);
    }

    public function delete_entry($where)
    {
        return $this->db->where('id', $where)->delete($this->table);
    }

    private function _get_datatables_query($cek_role,$cek_perti)
    {

        $this->db->from($this->table)->where('tampilkan', 'ya');
        if ($cek_role != 'Superadmin') {
            $this->db->where('id_pt',$cek_perti);
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

    function get_datatables($cek_role,$cek_perti)
    {
        $this->_get_datatables_query($cek_role,$cek_perti);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
            
            if ($this->session->userdata('id_role') == 'Superadmin') {
                $query = $this->db->where('id_role','Admin')->get();
            }else{
                $query = $this->db->get();
            }

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

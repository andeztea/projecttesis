<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PesanModel extends CI_Model
{

    protected $table = 'tb_pesan';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_entries($where = false)
    {
        if ($where == FALSE) {
            $query = $this->db->where_not_in('id_role','Admin')->where('tampilkan', 'ya')->get($this->table);
        } else {
            $query = $this->db->where('id', $where)->where('tampilkan', 'ya')->get($this->table);
        }

        return $query;
    }

    public function get_entries_spa()
    {
        return $this->db->where('id_role','Admin')->where('tampilkan', 'ya')->get($this->table);
    }

     public function get_entries_perti($cek_perti)
    {
        return $this->db->where('id_pt',$cek_perti)->where('tampilkan', 'ya')->get($this->table);
    }

    public function insert_entry($datapost)
    {
        return $this->db->insert($this->table, $datapost);
    }

    public function delete_entry($where, $role)
    {
        return $this->db->where('id_role', $role)->where('id_user', $where)->delete($this->table);
    }

    public function update_entry($datapost, $where, $role)
    {
        return $this->db->where('id_user', $where)->where('id_role', $role)->update($this->table, $datapost);
    }

    public function get_entries_cf($where)
    {
        $query = $this->db
            ->select('a.*,e.nama as nama_prov,f.nama as nama_kab,g.nama as nama_kec')
            ->join('tb_provinsi as e', 'a.provinsi = e.id', 'left')
            ->join('tb_kabupaten as f', 'a.kabupaten = f.id', 'left')
            ->join('tb_kecamatan as g', 'a.kecamatan = g.id', 'left')
            ->where('a.tampilkan', 'tidak')
            ->where('a.id', $where);
        $cek= $query->get('tb_perti as a')->row();

        return $cek;
    }

    public function get_entries_cfm($where, $table)
    {
        $query = $this->db
            ->select('a.*,b.fakultas,b.jurusan,b.program_studi,c.thn_akademik,c.periode,d.nama as nama_pt,e.nama as nama_prov,f.nama as nama_kab,g.nama as nama_kec')
            ->join('tb_fakultas as b', 'a.id_fakultas = b.id', 'left')
            ->join('tb_akademik as c', 'a.id_akd = c.id', 'left')
            ->join('tb_perti as d', 'a.id_pt = d.id', 'left')
            ->join('tb_provinsi as e', 'a.provinsi = e.id', 'left')
            ->join('tb_kabupaten as f', 'a.kabupaten = f.id', 'left')
            ->join('tb_kecamatan as g', 'a.kecamatan = g.id', 'left')
            ->where('a.tampilkan', 'tidak')
            ->where('a.id', $where);

        return  $query->get($table)->row();
    }

    public function get_entries_cfmr($where, $table)
    {
        $query = $this->db
            ->select('a.*,b.nama as nama_pt,e.nama as nama_prov,f.nama as nama_kab,g.nama as nama_kec')
            ->join('tb_perti as b', 'a.id_pt = b.id', 'left')
            ->join('tb_provinsi as e', 'a.provinsi = e.id', 'left')
            ->join('tb_kabupaten as f', 'a.kabupaten = f.id', 'left')
            ->join('tb_kecamatan as g', 'a.kecamatan = g.id', 'left')
            ->where('a.tampilkan', 'tidak')
            ->where('a.id', $where);

        return $query->get($table)->row();
    }
}

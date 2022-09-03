<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RegionModel extends CI_Model
{
    public function get_region($table, $where = false)
    {
        if ($where == FALSE) {
            $query = $this->db->order_by('nama')->from($table);
        } else {
            $query = $this->db->where($where)->order_by('nama')->from($table);
        }

        return $query;
    }
}

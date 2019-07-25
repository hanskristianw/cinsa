<?php

class _t extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function return_all()
  {
    return $this->db->order_by("t_nama", "DESC")->get('t')->result_array();
  }

  public function find_tahun_nama($tahun_id)
  {
    return $this->db->where('t_id', $tahun_id)->get('t')->row_array();
  }

  public function find_by_id($tahun_id)
  {
    return $this->db->where('t_id', $tahun_id)->get('t')->row_array();
  }
}

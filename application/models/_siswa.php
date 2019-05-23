<?php

class _siswa extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function return_all()
  {
    return $this->db->join('t', 'sis_t_id=t_id', 'Left')->order_by("sis_nama_depan", "ASC")->get('sis')->result_array();
  }

  public function find_sis_nama($sis_id)
  {
    return $this->db->where('sis_id', $sis_id)->get('sis')->row_array();
  }

  public function find_by_id($sis_id)
  {
    return $this->db->where('sis_id', $sis_id)->get('sis')->row_array();
  }
}

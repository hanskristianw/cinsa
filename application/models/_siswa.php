<?php

class _siswa extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function return_all_by_sk($sk_id)
  {
    return $this->db->join('agama', 'sis_agama_id=agama_id', 'Left')->join('t', 'sis_t_id=t_id', 'Left')->join('sk', 'sis_sk_id=sk_id', 'Left')->where('sis_sk_id', $sk_id)->order_by("t_nama", "DESC")->order_by("sis_nama_depan", "ASC")->get('sis')->result_array();
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

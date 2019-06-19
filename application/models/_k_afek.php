<?php

class _k_afek extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function return_all_by_sk($sk_id)
  {
    return $this->db->join('t', 'k_afek_t_id=t_id', 'left')->join('bulan', 'k_afek_bulan_id=bulan_id', 'left')->join('sk', 'k_afek_sk_id=sk_id', 'left')->where('k_afek_sk_id', $sk_id)->order_by("k_afek_bulan_id", "ASC")->order_by("t_nama", "DESC")->get('k_afek')->result_array();
  }

  public function find_by_id($k_afek_id, $sk_id)
  {
    return $this->db->where('k_afek_id', $k_afek_id)->where('k_afek_sk_id', $sk_id)->get('k_afek')->row_array();
  }
}

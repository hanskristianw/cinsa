<?php

class _jenj extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function return_all_by_sk($sk_id)
  {
    return $this->db->where('jenj_sk_id', $sk_id)->get('jenj')->result_array();
  }

  public function find_by_id($jenj_id)
  {
    return $this->db->order_by("jenj_nama", "ASC")->where('jenj_id', $jenj_id)->get('jenj')->row_array();
  }
}

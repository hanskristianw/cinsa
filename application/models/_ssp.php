<?php

class _ssp extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function return_all(){
    return $this->db->join('sk', 'ssp_sk_id=sk_id', 'Left')->join('kr', 'ssp_kr_id=kr_id', 'Left')->join('t', 'ssp_t_id=t_id', 'Left')->order_by("ssp_nama", "ASC")->get('ssp')->result_array();
  }

  public function return_all_by_sk_id($sk_id){
    return $this->db->join('sk', 'ssp_sk_id=sk_id', 'Left')->join('kr', 'ssp_kr_id=kr_id', 'Left')->join('t', 'ssp_t_id=t_id', 'Left')->where('ssp_sk_id', $sk_id)->order_by("t_id", "DESC")->order_by("ssp_nama", "ASC")->get('ssp')->result_array();
  }

  public function find_ssp_nama($ssp_id){
    return $this->db->where('ssp_id', $ssp_id)->get('ssp')->row_array();
  }

  public function return_all_by_kr_id($kr_id){
    return $this->db->join('t', 'ssp_t_id=t_id', 'Left')->where('ssp_kr_id', $kr_id)->order_by("t_id", "DESC")->order_by("ssp_nama", "ASC")->get('ssp')->result_array();
  }

  public function find_by_id($ssp_id)
  {
    return $this->db->join('sk', 'ssp_sk_id=sk_id', 'left')->order_by("ssp_nama", "ASC")->where('ssp_id', $ssp_id)->get('ssp')->row_array();
  }
}
<?php

class _sk extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function return_all(){
    return $this->db->join('kr', 'sk_kepsek=kr_id', 'Left')->order_by("sk_nama", "ASC")->get('sk')->result_array();
  }

  public function find_sk_nama($sk_id){
    return $this->db->where('sk_id', $sk_id)->get('sk')->row_array();
  }

  public function find_by_username($sk_username){
    return $this->db->where('sk_username', $sk_username)->get('sk')->row_array();
  }

  public function find_by_id($sk_id){
    return $this->db->join('kr', 'sk_kepsek=kr_id', 'Left')->where('sk_id', $sk_id)->get('sk')->row_array();
  }
}
<?php

class _st extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  //return semua jabatan selain admin
  public function return_all(){
    return $this->db->get('st')->result_array();
  }

  public function find_jabatan_nama($st_id){
    return $this->db->where('st_id', $st_id)->get('st')->row_array();
  }
}
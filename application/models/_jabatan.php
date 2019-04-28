<?php

class _jabatan extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function return_all(){
    return $this->db->get('jabatan')->result_array();
  }

  public function find_jabatan_nama($jabatan_id){
    return $this->db->where('jabatan_id', $jabatan_id)->get('jabatan')->row_array();
  }
}
<?php

class _kr extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function return_all(){
    return $this->db->get('kr')->result_array();
  }

  public function find_username($kr_username){
    return $this->db->where('kr_username', $kr_username)->get('kr')->row_array();
  }
}
<?php

class _kr extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function return_all(){
    return $this->db->join('jabatan','kr_jabatan_id=jabatan_id','Left')->order_by("kr_nama_depan", "ASC")->get('kr')->result_array();
  }

  public function find_by_username($kr_username){
    return $this->db->where('kr_username', $kr_username)->get('kr')->row_array();
  }

  public function find_by_id($kr_id){
    return $this->db->where('kr_id', $kr_id)->get('kr')->row_array();
  }

  public function find_jabatan_by_kr_id($kr_id){
    return $this->db->join('jabatan','kr_jabatan_id=jabatan_id','Left')->where('kr_id', $kr_id)->get('kr')->row_array();
  }

}

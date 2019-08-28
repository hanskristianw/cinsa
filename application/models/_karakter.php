<?php

class _karakter extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function return_all(){
    return $this->db->order_by("karakter_urutan", "ASC")->get('karakter')->result_array();
  }

  // public function return_all_by_sk_id($sk_id){
  //   return $this->db->join('sk', 'mapel_sk_id=sk_id', 'Left')->where('mapel_sk_id', $sk_id)->order_by("mapel_urutan", "ASC")->order_by("mapel_nama", "ASC")->get('mapel')->result_array();
  // }

  public function find_mapel_nama($karakter_id){
    return $this->db->where('karakter_id', $karakter_id)->get('karakter')->row_array();
  }

  public function find_by_id($karakter_id)
  {
    return $this->db->where('karakter_id', $karakter_id)->get('karakter')->row_array();
  }
}
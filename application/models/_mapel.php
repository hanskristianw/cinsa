<?php

class _mapel extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function return_all(){
    return $this->db->join('sk', 'mapel_sk_id=sk_id', 'Left')->order_by("sk_nama", "ASC")->order_by("mapel_nama", "ASC")->get('mapel')->result_array();
  }

  public function return_all_by_sk_id($sk_id){
    return $this->db->join('sk', 'mapel_sk_id=sk_id', 'Left')->where('mapel_sk_id', $sk_id)->order_by("mapel_urutan", "ASC")->order_by("mapel_nama", "ASC")->get('mapel')->result_array();
  }

  public function find_mapel_nama($mapel_id){
    return $this->db->where('mapel_id', $mapel_id)->get('mapel')->row_array();
  }

  public function find_by_id($mapel_id)
  {
    return $this->db->join('sk', 'mapel_sk_id=sk_id', 'left')->order_by("mapel_nama", "ASC")->where('mapel_id', $mapel_id)->get('mapel')->row_array();
  }
}
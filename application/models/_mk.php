<?php

class _mk extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function return_all_by_sk_id($sk_id){
    return $this->db->join('t', 'mk_t_id=t_id', 'Left')->join('mapel', 'mk_mapel_id=mapel_id', 'Left')->where('mk_sk_id', $sk_id)->order_by("t_id", "DESC")->order_by("mk_nama", "ASC")->get('mk')->result_array();
  }

  public function find_by_id($mk_id)
  {
    return $this->db->join('t', 'mk_t_id=t_id', 'Left')->order_by("mk_nama", "ASC")->where('mk_id', $mk_id)->get('mk')->row_array();
  }

}
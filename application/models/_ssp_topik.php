<?php

class _ssp_topik extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function find_by_id($ssp_topik_id)
  {
    return $this->db->where('ssp_topik_id', $ssp_topik_id)->get('ssp_topik')->row_array();
  }
}
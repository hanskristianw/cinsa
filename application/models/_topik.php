<?php

class _topik extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  public function find_by_id($topik_id)
  {
    return $this->db->where('topik_id', $topik_id)->get('topik')->row_array();
  }
}
<?php

class _agama extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function return_all()
  {
    return $this->db->get('agama')->result_array();
  }
}

<?php

class _d_mpl extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function return_all()
  {
    return $this->db->get('d_mpl')->result_array();
  }
}

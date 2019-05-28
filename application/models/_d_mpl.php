<?php

class _d_mpl extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function return_all_by_kelas_id($kelas_id)
  {
    return $this->db->join('mapel', 'd_mpl_mapel_id=mapel_id', 'left')->where('d_mpl_kelas_id', $kelas_id)->get('d_mpl')->result_array();
  }
}

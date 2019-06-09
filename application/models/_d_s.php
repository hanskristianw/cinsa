<?php

class _d_s extends CI_Model {

  public function __construct(){
    parent::__construct();
  }

  //return semua jabatan selain admin
  public function return_siswa_by_kelas_id($kelas_id){
    return $this->db->join('sis', 'd_s_sis_id=sis_id', 'left')->join('t', 'sis_t_id=t_id', 'left')->where('d_s_kelas_id', $kelas_id)->order_by("sis_nama_depan", "ASC")->get('d_s')->result_array();
  }
}
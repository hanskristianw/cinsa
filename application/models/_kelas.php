<?php

class _kelas extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
  }

  public function return_all_by_sk($kelas_sk_id)
  {
    return $this->db->join('t', 'kelas_t_id=t_id', 'left')->join('jenj', 'kelas_jenj_id=jenj_id', 'left')->join('sk', 'kelas_sk_id=sk_id', 'left')->where('kelas_sk_id', $kelas_sk_id)->order_by("t_nama", "DESC")->order_by("jenj_nama", "ASC")->order_by("kelas_nama", "ASC")->get('kelas')->result_array();
  }

  public function return_all()
  {
    return $this->db->join('t', 'kelas_t_id=t_id', 'left')->join('sk', 'kelas_sk_id=sk_id', 'left')->order_by("sk_nama", "ASC")->order_by("t_nama", "DESC")->get('kelas')->result_array();
  }

  public function find_kelas_nama($kelas_id)
  {
    return $this->db->join('sk', 'kelas_sk_id=sk_id', 'left')->where('kelas_id', $kelas_id)->get('kelas')->row_array();
  }

  public function find_walkel_by_kelas_id($kelas_id)
  {
    return $this->db->join('kr', 'kelas_kr_id=kr_id', 'left')->where('kelas_id', $kelas_id)->get('kelas')->row_array();
  }

  public function find_by_walkel($kr_id)
  {
    return $this->db->join('t', 'kelas_t_id=t_id', 'left')->join('sk', 'kelas_sk_id=sk_id', 'left')->where('kelas_kr_id', $kr_id)->order_by("kelas_t_id", "DESC")->order_by("kelas_nama", "ASC")->get('kelas')->result_array();
  }

  public function find_by_id($kelas_id)
  {
    return $this->db->join('t', 'kelas_t_id=t_id', 'left')->join('sk', 'kelas_sk_id=sk_id', 'left')->order_by("kelas_nama", "ASC")->where('kelas_id', $kelas_id)->get('kelas')->row_array();
  }
}

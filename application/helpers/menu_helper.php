<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function walkel_menu(){
  $ci =& get_instance();
  $ci->load->model('_kr');
  $ci->load->model('_kelas');

  $count_walkel = $ci->db->where('kelas_kr_id',$ci->session->userdata('kr_id'))->from("kelas")->count_all_results();
  
  return $count_walkel;
}

function disjam_sekolah_lain($kr_id, $t_id, $sk_id){
  $ci =& get_instance();

  $sk_lain = $ci->db->query(
    'SELECT kr_id, kr_nama_depan, kr_nama_belakang, GROUP_CONCAT(mapel_id ORDER BY sk_id) as mapel_id, GROUP_CONCAT(mapel_nama ORDER BY sk_id) as mapel_nama, sum(d_mpl_beban) as beban, GROUP_CONCAT(sk_nama ORDER BY sk_id SEPARATOR "+") as sk_nama
    FROM d_mpl
    LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
    LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
    LEFT JOIN sk ON mapel_sk_id = sk_id
    LEFT JOIN kr ON d_mpl_kr_id = kr_id
    WHERE d_mpl_kr_id = '.$kr_id.' AND kelas_t_id = '.$t_id.' AND kelas_sk_id <>  '.$sk_id.'')->result_array();
  
  return $sk_lain;
}
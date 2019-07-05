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

function return_raport_mid($d_s_id){
  $ci =& get_instance();

  $raport_mid = $ci->db->query(
    'SELECT * FROM
      (SELECT mapel_id, mapel_urutan, tes_d_s_id, mapel_nama,mapel_kkm, 
      GROUP_CONCAT(kog_quiz ORDER BY topik_urutan) as kq, 
      GROUP_CONCAT(kog_ass ORDER BY topik_urutan) as ka, 
      GROUP_CONCAT(kog_test ORDER BY topik_urutan) as kt, 
      GROUP_CONCAT(psi_quiz ORDER BY topik_urutan) as pq, 
      GROUP_CONCAT(psi_ass ORDER BY topik_urutan) as pa, 
      GROUP_CONCAT(psi_test ORDER BY topik_urutan) as pt
      FROM tes 
      LEFT JOIN topik
      ON tes_topik_id = topik_id
      LEFT JOIN mapel
      ON topik_mapel_id = mapel_id
      WHERE tes_d_s_id = '.$d_s_id.'
      GROUP BY mapel_id
      ORDER BY mapel_urutan)as formative
      LEFT JOIN
      (
        SELECT mapel_id, uj_mid1_kog, uj_mid1_psi
        FROM uj
        LEFT JOIN mapel
        ON uj_mapel_id = mapel_id
        WHERE uj_d_s_id = '.$d_s_id.'
        GROUP BY mapel_id
        ORDER BY mapel_urutan
      )as summative ON formative.mapel_id = summative.mapel_id')->result_array();
  
  return $raport_mid;
}

function returnQATmidcek($value){
  $print = "<td class='biasa'>";
  if(isset($value)){
    if($value>0){
      $print .= $value;
    }
    elseif($value<0){
      $print .= "-";
    }
    else{
      $print .= " ";
    }
  }else{
    $print .= " ";
  }
  $print .= "</td>";
  return $print;
}

function returnQATastd($kq, $ka, $kt, $pq, $pa, $pt, $uj_mid1_kog, $uj_mid1_psi){
  $kq = explode(",",$kq);
  $ka = explode(",",$ka);
  $kt = explode(",",$kt);
  $pq = explode(",",$pq);
  $pa = explode(",",$pa);
  $pt = explode(",",$pt);

  $td = "";

  //KOGNITIF
  //quiz, ass, test 1
  $td .= returnQATmidcek($kq[0]);
  $td .= returnQATmidcek($ka[0]);
  $td .= returnQATmidcek($kt[0]);
  //quiz, ass, test 2
  $td .= returnQATmidcek($kq[1]);
  $td .= returnQATmidcek($ka[1]);
  $td .= returnQATmidcek($kt[1]);
  //PSIKOMOTOR
  //quiz, ass, test 1
  $td .= returnQATmidcek($pq[0]);
  $td .= returnQATmidcek($pa[0]);
  $td .= returnQATmidcek($pt[0]);
  //quiz, ass, test 2
  $td .= returnQATmidcek($pq[1]);
  $td .= returnQATmidcek($pa[1]);
  $td .= returnQATmidcek($pt[1]);
  $td .= returnQATmidcek($uj_mid1_kog);
  $td .= returnQATmidcek($uj_mid1_psi);

  return $td;
}
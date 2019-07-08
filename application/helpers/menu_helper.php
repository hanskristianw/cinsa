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

function return_raport_mid($d_s_id, $semester){
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
      WHERE tes_d_s_id = '.$d_s_id.' AND topik_semester = '.$semester.'
      GROUP BY mapel_id
      ORDER BY mapel_urutan)as formative
      LEFT JOIN
      (
        SELECT sis_nama_depan, sis_nama_bel, sis_no_induk, kelas_nama, mapel_id, uj_mid1_kog, uj_mid1_psi
        FROM uj
        LEFT JOIN mapel
        ON uj_mapel_id = mapel_id
        LEFT JOIN d_s
        ON uj_d_s_id = d_s_id
        LEFT JOIN sis
        ON d_s_sis_id = sis_id
        LEFT JOIN kelas
        ON d_s_kelas_id = kelas_id
        WHERE uj_d_s_id = '.$d_s_id.'
        GROUP BY mapel_id
        ORDER BY mapel_urutan
      )as summative ON formative.mapel_id = summative.mapel_id
      LEFT JOIN
      (
        SELECT mapel_id, GROUP_CONCAT(afektif_id) as afektif_id, mapel_nama, COUNT(mapel_id) as jum_bulan, 
        GROUP_CONCAT(bulan_nama ORDER BY afektif_id) as bulan_nama, 
        GROUP_CONCAT(afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3 ORDER BY afektif_id) as minggu1, 
        GROUP_CONCAT(afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3 ORDER BY afektif_id) as minggu2, 
        GROUP_CONCAT(afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3 ORDER BY afektif_id) as minggu3, 
        GROUP_CONCAT(afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3 ORDER BY afektif_id) as minggu4, 
        GROUP_CONCAT(afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3 ORDER BY afektif_id) as minggu5 
        FROM afektif 
        LEFT JOIN mapel ON afektif_mapel_id = mapel_id
        LEFT JOIN k_afek ON afektif_k_afek_id = k_afek_id
        LEFT JOIN bulan ON k_afek_bulan_id = bulan_id
        WHERE afektif_d_s_id = '.$d_s_id.' AND bulan_semester = '.$semester.'
        GROUP BY mapel_id
        ORDER BY mapel_urutan
      )as afektif ON formative.mapel_id = afektif.mapel_id')->result_array();
  
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

function returnNilaiPerBulan($minggu1, $minggu2, $minggu3, $minggu4, $minggu5){
  $jumAktif = 0;

  if($minggu1 > 0)
    $jumAktif++;

  if($minggu2 > 0)
    $jumAktif++;

  if($minggu3 > 0)
    $jumAktif++;

  if($minggu4 > 0)
    $jumAktif++;

  if($minggu5 > 0)
    $jumAktif++;

  $nilai_bulan = $minggu1+$minggu2+$minggu3+$minggu4+$minggu5;

  return $nilai_bulan/$jumAktif;
}

function returnQATastd($kq, $ka, $kt, $pq, $pa, $pt, $minggu1, $minggu2, $minggu3, $minggu4, $minggu5, $uj_mid1_kog, $uj_mid1_psi){
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

  //AFEKTIF
  $minggu1 = explode(",",$minggu1);
  $minggu2 = explode(",",$minggu2);
  $minggu3 = explode(",",$minggu3);
  $minggu4 = explode(",",$minggu4);
  $minggu5 = explode(",",$minggu5);

  $jumBulan = count($minggu1);

  $total_afek = 0;
  for($i=0;$i<count($minggu1);$i++){
    //cek berapa minggu aktif
    $total_afek += returnNilaiPerBulan($minggu1[$i],$minggu2[$i],$minggu3[$i],$minggu4[$i],$minggu5[$i]);
  }

  
  $td .= "<td class='biasa'>".return_abjad_afek($total_afek/$jumBulan)."</td>";
  
  //SUMMATIVE
  $td .= returnQATmidcek($uj_mid1_kog);
  $td .= returnQATmidcek($uj_mid1_psi);

  return $td;
}

function return_abjad_afek($nilai){
  if($nilai >=7.65){
      return "A";
  }elseif($nilai >=6.3){
      return "B";
  }elseif($nilai >=4.95){
      return "C";
  }else{
      return "D";
  }
}
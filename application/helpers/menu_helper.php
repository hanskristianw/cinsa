<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function walkel_menu(){
  $ci =& get_instance();
  $ci->load->model('_kr');
  $ci->load->model('_kelas');

  $count_walkel = $ci->db->where('kelas_kr_id',$ci->session->userdata('kr_id'))->from("kelas")->count_all_results();
  
  return $count_walkel;
}

function ssp_menu(){
  $ci =& get_instance();

  $count_walkel = $ci->db->where('ssp_kr_id',$ci->session->userdata('kr_id'))->from("ssp")->count_all_results();
  
  return $count_walkel;
}

function scout_menu(){
  $ci =& get_instance();

  $count_scout = $ci->db->where('sk_scout_kr_id',$ci->session->userdata('kr_id'))->from("sk")->count_all_results();

  return $count_scout;
}

function konselor_menu(){
  $ci =& get_instance();

  $count_walkel = $ci->db->where('konselor_kr_id',$ci->session->userdata('kr_id'))->from("konselor")->count_all_results();
  
  return $count_walkel;
}

function mapel_menu(){
  $ci =& get_instance();

  $count_walkel = $ci->db->where('d_mpl_kr_id',$ci->session->userdata('kr_id'))->from("d_mpl")->count_all_results();
  
  return $count_walkel;
}

function return_mk($mapel_id, $d_s_id){
  $ci =& get_instance();

  $mapel_lain = $ci->db->query(
    'SELECT mk_nama
    FROM mk_detail
    LEFT JOIN mk ON mk_detail_mk_id = mk_id
    WHERE mk_detail_d_s_id = '.$d_s_id.' AND mk_mapel_id = '.$mapel_id.'')->row_array();
  
  return $mapel_lain;
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

function return_konseling_report($d_s_id){
  $ci =& get_instance();
  $raport_konseling = $ci->db->query(
    'SELECT sis_nama_depan, sis_nama_bel, konseling_alasan, konseling_hasil, konseling_saran, konseling_tanggal, konseling_kategori_nama, kelas_nama
    FROM konseling 
    LEFT JOIN d_s ON konseling_d_s_id = d_s_id
    LEFT JOIN kelas ON d_s_kelas_id = kelas_id
    LEFT JOIN sis ON sis_id = d_s_sis_id
    LEFT JOIN konseling_kategori ON konseling_kategori_id = konseling_konseling_kategori_id
    WHERE konseling_d_s_id = '.$d_s_id.' ORDER BY konseling_tanggal')->result_array();
  
  return $raport_konseling;
}

function return_raport_mid($d_s_id, $semester){
  $ci =& get_instance();

  $raport_mid = $ci->db->query(
    'SELECT * FROM
      (SELECT mapel_id, mapel_urutan, tes_d_s_id, mapel_nama,mapel_kkm, sis_nama_depan, sis_nama_bel, sis_no_induk, kelas_nama,  d_s_komen_sis, d_s_komen_sis2, d_s_sick, d_s_sick2, d_s_absenin, d_s_absenin2, d_s_absenex, d_s_absenex2,
      GROUP_CONCAT(kog_quiz ORDER BY topik_urutan) as kq, 
      GROUP_CONCAT(kog_ass ORDER BY topik_urutan) as ka, 
      GROUP_CONCAT(kog_test ORDER BY topik_urutan) as kt, 
      GROUP_CONCAT(psi_quiz ORDER BY topik_urutan) as pq, 
      GROUP_CONCAT(psi_ass ORDER BY topik_urutan) as pa, 
      GROUP_CONCAT(psi_test ORDER BY topik_urutan) as pt
      FROM tes 
      LEFT JOIN topik
      ON tes_topik_id = topik_id
      LEFT JOIN d_s
      ON tes_d_s_id = d_s_id
      LEFT JOIN sis
      ON d_s_sis_id = sis_id
      LEFT JOIN kelas
      ON d_s_kelas_id = kelas_id
      LEFT JOIN mapel
      ON topik_mapel_id = mapel_id
      WHERE tes_d_s_id = '.$d_s_id.' AND topik_semester = '.$semester.'
      GROUP BY mapel_id
      ORDER BY mapel_urutan)as formative
      LEFT JOIN
      (
        SELECT mapel_id, uj_mid1_kog, uj_mid1_psi, uj_mid2_kog, uj_mid2_psi
        FROM uj
        LEFT JOIN mapel
        ON uj_mapel_id = mapel_id
        WHERE uj_d_s_id = '.$d_s_id.'
        GROUP BY mapel_id
        ORDER BY mapel_urutan
      )as summative ON formative.mapel_id = summative.mapel_id
      LEFT JOIN
      (
        SELECT mapel_id, GROUP_CONCAT(afektif_id) as afektif_id, COUNT(mapel_id) as jum_bulan, 
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
      )as afektif ON formative.mapel_id = afektif.mapel_id
      LEFT JOIN
      (
        SELECT mk_mapel_id, mk_nama
        FROM mk
        LEFT JOIN mk_detail ON mk_detail_mk_id = mk_id
        LEFT JOIN d_s ON mk_detail_d_s_id = d_s_id
        WHERE mk_detail_d_s_id = '.$d_s_id.'
      )as mk_fix ON formative.mapel_id = mk_fix.mk_mapel_id')->result_array();
  
  return $raport_mid;
}

function returnNilaiSspSisipan($d_s_id, $semester){
  $ci =& get_instance();

  $ssp_mid = $ci->db->query(
    'SELECT ssp_nama, SUM(ssp_nilai_angka)/count(ssp_id) as total_nilai FROM ssp_nilai
    LEFT JOIN ssp_topik ON ssp_nilai_ssp_topik_id = ssp_topik_id
    LEFT JOIN ssp ON ssp_id = ssp_topik_ssp_id
    WHERE ssp_nilai_d_s_id = '.$d_s_id.' AND ssp_topik_semester = '.$semester.'
    GROUP BY ssp_id
      ')->row_array();
  
  if($ssp_mid['ssp_nama']){
    $td = "<td style='padding: 0px 0px 0px 5px; margin: 0px;'>".$ssp_mid['ssp_nama']."</td>
    <td class='biasa' colspan='13'></td>
    <td class='biasa' colspan='3'>".return_abjad_base4($ssp_mid['total_nilai'])."</td>";
  }else{
    $td = "<td style='padding: 0px 0px 0px 5px; margin: 0px;'>No SSP Data</td>
    <td class='biasa' colspan='13'></td>
    <td class='biasa' colspan='3'>No SSP Data</td>";
  }
  
  
  
  //var_dump($td);
  return $td;
}

function returnQATmidcek($value){
  $print = "<td class='biasa'>";
  if(isset($value)){
    if($value>0){
      $print .= $value;
    }
    elseif($value == -1){
      $print .= "0";
    }
    elseif($value == 0){
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

function returnQATastd($kq, $ka, $kt, $pq, $pa, $pt, $minggu1, $minggu2, $minggu3, $minggu4, $minggu5, $uj_mid1_kog, $uj_mid1_psi, $uj_mid2_kog, $uj_mid2_psi, $semester){
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

  if(isset($kq[1])){
    $td .= returnQATmidcek($kq[1]);
    $td .= returnQATmidcek($ka[1]);
    $td .= returnQATmidcek($kt[1]);
  }
  else{
    $td .= "<td class='biasa'> </td>";
    $td .= "<td class='biasa'> </td>";
    $td .= "<td class='biasa'> </td>";
  }


  //PSIKOMOTOR
  //quiz, ass, test 1
  $td .= returnQATmidcek($pq[0]);
  $td .= returnQATmidcek($pa[0]);
  $td .= returnQATmidcek($pt[0]);
  //quiz, ass, test 2
  if(isset($kq[1])){
    $td .= returnQATmidcek($pq[1]);
    $td .= returnQATmidcek($pa[1]);
    $td .= returnQATmidcek($pt[1]);
  }
  else{
    $td .= "<td class='biasa'> </td>";
    $td .= "<td class='biasa'> </td>";
    $td .= "<td class='biasa'> </td>";
  }

  //AFEKTIF
  $minggu1 = explode(",",$minggu1);
  $minggu2 = explode(",",$minggu2);
  $minggu3 = explode(",",$minggu3);
  $minggu4 = explode(",",$minggu4);
  $minggu5 = explode(",",$minggu5);

  $jumBulan = count($minggu1);

  //var_dump($minggu1);

  if($minggu1[0]!=""){
    $total_afek = 0;
    for($i=0;$i<count($minggu1);$i++){
      //cek berapa minggu aktif
      $total_afek += returnNilaiPerBulan($minggu1[$i],$minggu2[$i],$minggu3[$i],$minggu4[$i],$minggu5[$i]);
    }
    
    $td .= "<td class='biasa'>".return_abjad_afek($total_afek/$jumBulan)."</td>";
  }else{
    $td .= "<td class='biasa'>No Data</td>";
  }

  
  
  //SUMMATIVE
  if($semester == 1){
    $td .= returnQATmidcek($uj_mid1_kog);
    $td .= returnQATmidcek($uj_mid1_psi);
  }
  elseif($semester == 2){
    $td .= returnQATmidcek($uj_mid2_kog);
    $td .= returnQATmidcek($uj_mid2_psi);
  }

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

function return_abjad_base4($nilai){
  if($nilai >3.25){
      return "A";
  }elseif($nilai >2.50){
      return "B";
  }elseif($nilai >1.75){
      return "C";
  }else{
      return "D";
  }
}

function return_nama_bulan($bulan_angka){
  if($bulan_angka == '1'){
    $bulan = 'January';
  }elseif($bulan_angka == '2'){
    $bulan = 'February';
  }elseif($bulan_angka == '3'){
    $bulan = 'March';
  }elseif($bulan_angka == '4'){
    $bulan = 'April';
  }elseif($bulan_angka == '5'){
    $bulan = 'May';
  }elseif($bulan_angka == '6'){
    $bulan = 'June';
  }elseif($bulan_angka == '7'){
    $bulan = 'July';
  }elseif($bulan_angka == '8'){
    $bulan = 'August';
  }elseif($bulan_angka == '9'){
    $bulan = 'September';
  }elseif($bulan_angka == '10'){
    $bulan = 'October';
  }elseif($bulan_angka == '11'){
    $bulan = 'November';
  }elseif($bulan_angka == '12'){
    $bulan = 'December';
  }else{
    $bulan = '';
  }

  return $bulan;
}

function return_menu_kepsek(){
  $ci =& get_instance();

  $kr_id = $ci->session->userdata('kr_id');

  $kepsek = $ci->db->query(
    "SELECT *
    FROM sk
    WHERE sk_kepsek = $kr_id")->row_array();
  
  return $kepsek;
}

function show_laporan($topik_id, $kelas_id){
  $ci =& get_instance();
  $laporan = $ci->db->query(
    "SELECT *
    FROM tes
    LEFT JOIN topik ON tes_topik_id = topik_id
    LEFT JOIN mapel ON topik_mapel_id = mapel_id
    LEFT JOIN d_s ON tes_d_s_id = d_s_id
    LEFT JOIN sis ON d_s_sis_id = sis_id
    WHERE tes_topik_id = $topik_id AND d_s_kelas_id = $kelas_id
    ORDER BY sis_no_induk, sis_nama_depan")->result_array();

  return $laporan;
}
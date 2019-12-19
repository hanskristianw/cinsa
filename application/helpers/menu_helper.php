<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function return_ip_login(){
  $ip = getenv('HTTP_CLIENT_IP')?:
  getenv('HTTP_X_FORWARDED_FOR')?:
  getenv('HTTP_X_FORWARDED')?:
  getenv('HTTP_FORWARDED_FOR')?:
  getenv('HTTP_FORWARDED')?:
  getenv('REMOTE_ADDR');

  return $ip;
}

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

function wakasis_menu(){
  $ci =& get_instance();

  $count_wakasis = $ci->db->where('sk_wakasis',$ci->session->userdata('kr_id'))->from("sk")->count_all_results();
  
  return $count_wakasis;
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
  if($nilai >=3.34){
      return "A";
  }elseif($nilai >=2.66){
      return "B";
  }elseif($nilai >=1.66){
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

function return_nama_bulan_indo($bulan_angka){
  if($bulan_angka == '1'){
    $bulan = 'Januari';
  }elseif($bulan_angka == '2'){
    $bulan = 'Februari';
  }elseif($bulan_angka == '3'){
    $bulan = 'Maret';
  }elseif($bulan_angka == '4'){
    $bulan = 'April';
  }elseif($bulan_angka == '5'){
    $bulan = 'Mei';
  }elseif($bulan_angka == '6'){
    $bulan = 'Juni';
  }elseif($bulan_angka == '7'){
    $bulan = 'Juli';
  }elseif($bulan_angka == '8'){
    $bulan = 'Agustus';
  }elseif($bulan_angka == '9'){
    $bulan = 'September';
  }elseif($bulan_angka == '10'){
    $bulan = 'Oktober';
  }elseif($bulan_angka == '11'){
    $bulan = 'November';
  }elseif($bulan_angka == '12'){
    $bulan = 'Desember';
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

function show_mapel_header_summary($kelas_id){
  $ci =& get_instance();

  if (mapel_menu() >= 1 && $ci->session->userdata('kr_jabatan_id')!=5 && $ci->session->userdata('kr_jabatan_id')!=4) {

    $kr_id = $ci->session->userdata('kr_id');

    $laporan = $ci->db->query(
      "SELECT DISTINCT mapel_id, mapel_nama, mapel_sing
      FROM d_mpl
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      WHERE d_mpl_kelas_id = $kelas_id AND d_mpl_kr_id = $kr_id
      ORDER BY mapel_nama")->result_array();
  }else{
    $laporan = $ci->db->query(
      "SELECT DISTINCT mapel_id, mapel_nama, mapel_sing, mapel_kkm
      FROM d_mpl
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      WHERE d_mpl_kelas_id = $kelas_id
      ORDER BY mapel_nama")->result_array();
  }


  return $laporan;
}

function show_mapel_header_summary_order_by_mapel_urutan($kelas_id){
  $ci =& get_instance();

  if (mapel_menu() >= 1 && $ci->session->userdata('kr_jabatan_id')!=5 && $ci->session->userdata('kr_jabatan_id')!=4) {

    $kr_id = $ci->session->userdata('kr_id');

    $laporan = $ci->db->query(
      "SELECT DISTINCT mapel_id, mapel_nama, mapel_sing
      FROM d_mpl
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      WHERE d_mpl_kelas_id = $kelas_id AND d_mpl_kr_id = $kr_id
      ORDER BY mapel_urutan")->result_array();
  }else{
    $laporan = $ci->db->query(
      "SELECT DISTINCT mapel_id, mapel_nama, mapel_sing, mapel_kkm
      FROM d_mpl
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      WHERE d_mpl_kelas_id = $kelas_id
      ORDER BY mapel_urutan")->result_array();
  }


  return $laporan;
}

function show_cog_count($mapel_id, $kelas_id, $sem){
  $ci =& get_instance();
  $laporan = $ci->db->query(
    "SELECT COUNT(*) as jumlah
    FROM tes
    LEFT JOIN topik ON tes_topik_id = topik_id
    LEFT JOIN d_s ON tes_d_s_id = d_s_id
    WHERE topik_mapel_id = $mapel_id AND d_s_kelas_id = $kelas_id AND topik_semester = $sem")->row_array();

  return $laporan;
}

function show_mid_final_count($mapel_id, $kelas_id){
  $ci =& get_instance();
  $laporan = $ci->db->query(
    "SELECT count(*) as jumlah
    FROM uj
    LEFT JOIN d_s ON uj_d_s_id = d_s_id
    WHERE d_s_kelas_id = $kelas_id AND uj_mapel_id = $mapel_id")->row_array();

  return $laporan;
}

function show_af_count($k_afek_id, $mapel_id, $kelas_id){
  $ci =& get_instance();
  $laporan = $ci->db->query(
    "SELECT COUNT(*) as jumlah
    FROM afektif
    LEFT JOIN d_s ON afektif_d_s_id = d_s_id
    WHERE afektif_k_afek_id = $k_afek_id AND afektif_mapel_id= $mapel_id AND d_s_kelas_id = $kelas_id")->row_array();

  return $laporan;
}

function show_cb_count($kelas_id, $semester){
  $ci =& get_instance();

  $laporan = $ci->db->query(
    "SELECT COUNT(*) as jumlah
    FROM nilai_cb
    LEFT JOIN d_s ON nilai_cb_d_s_id = d_s_id
    LEFT JOIN topik_cb ON nilai_cb_topik_cb_id = topik_cb_id
    WHERE d_s_kelas_id = $kelas_id AND topik_cb_semester = $semester")->row_array();

  return $laporan;
}

function show_siswa_by_kelas($kelas_id){
  $ci =& get_instance();

  $siswa = $ci->db->query(
    "SELECT d_s_id, sis_no_induk, sis_nama_depan, sis_nama_bel, sis_nisn, d_s_scout_nilai, d_s_scout_nilai2
    FROM d_s
    LEFT JOIN sis ON d_s_sis_id = sis_id
    WHERE d_s_kelas_id = $kelas_id
    ORDER BY sis_nama_depan, sis_no_induk")->result_array();

  return $siswa;
}

function hitung_afek_siswa_perbulan($arr_bulan_id, $d_s_id){
  
  $ci =& get_instance();

  $bulan_id = "";
  for($i=0;$i<count($arr_bulan_id);$i++){
    $bulan_id .= $arr_bulan_id[$i];

    if($i != count($arr_bulan_id)-1)
      $bulan_id .= ",";
  }

  $siswa = $ci->db->query(
    "SELECT afektif_mapel_id, ROUND(SUM(jumlah)/COUNT(afektif_mapel_id),2) AS total
    FROM(
       SELECT afektif_mapel_id, ROUND((afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3+
        afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3+
        afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3+
        afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3+
        afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3)/afektif_minggu_aktif,2) AS jumlah, k_afek_bulan_id
        FROM afektif
        LEFT JOIN k_afek ON afektif_k_afek_id = k_afek_id
        WHERE afektif_d_s_id = $d_s_id AND k_afek_bulan_id IN ($bulan_id)) AS afektif_jumlah
        GROUP BY afektif_mapel_id")->result_array();

  return $siswa;
}

function return_raport_fin($d_s_id, $semester, $jenjang){
  $ci =& get_instance();
  //formative (harian) didapat dari nilai kognitif tes * persen tes

  $siswa = $ci->db->query(
    "SELECT * FROM 
      (SELECT mapel_nama, mapel_id, kelas_jenj_id, mapel_urutan, tes_d_s_id,mapel_kkm, sis_nama_depan, sis_nama_bel, sis_no_induk, sis_jk, kelas_nama, COUNT(DISTINCT tes_topik_id), d_s_komen_sem, d_s_komen_sem2, d_s_scout_nilai, d_s_scout_nilai2, d_s_sick, d_s_sick2, d_s_absenin, d_s_absenin2, d_s_absenex, d_s_absenex2,
      (pfhf_absent+pfhf_uks+pfhf_tardiness)/3 AS pfhf_sem1, (pfhf_absent2+pfhf_uks2+pfhf_tardiness2)/3 AS pfhf_sem2,
      moralb_lo AS mb_sem1, moralb_lo2 AS mb_sem2,
      (emo_aware_ex+emo_aware_so+emo_aware_ne)/3 AS emo_sem1, (emo_aware_ex2+emo_aware_so2+emo_aware_ne2)/3 AS emo_sem2,
      (spirit_coping+spirit_emo+spirit_grate)/3 AS spirit_sem1, (spirit_coping2+spirit_emo2+spirit_grate2)/3 AS spirit_sem2,
      (ss_relationship+ss_cooperation+ss_conflict+ss_self_a)/4 AS ss_sem1, (ss_relationship2+ss_cooperation2+ss_conflict2+ss_self_a2)/4 AS ss_sem2,
      ROUND(SUM(ROUND(kog_quiz*kog_quiz_persen/100 + kog_ass*kog_ass_persen/100 + kog_test*kog_test_persen/100,0))/COUNT(DISTINCT tes_topik_id),0) AS for_kog,
      ROUND(SUM(ROUND(psi_quiz*psi_quiz_persen/100 + psi_ass*psi_ass_persen/100 + psi_test*psi_test_persen/100,0))/COUNT(DISTINCT tes_topik_id),0) AS for_psi
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
      WHERE tes_d_s_id = $d_s_id AND topik_semester = $semester
      GROUP BY mapel_id
      ORDER BY mapel_urutan ) AS formative
  LEFT JOIN
    (SELECT mapel_id,
    ROUND((uj_mid1_kog * uj_mid1_kog_persen + uj_fin1_kog * uj_fin1_kog_persen) /100,0) as sum_kog_sem1,
    ROUND((uj_mid1_psi * uj_mid1_psi_persen + uj_fin1_psi * uj_fin1_psi_persen) /100,0) as sum_psi_sem1,
    ROUND((uj_mid2_kog * uj_mid2_kog_persen + uj_fin2_kog * uj_fin2_kog_persen) /100,0) as sum_kog_sem2,
    ROUND((uj_mid2_psi * uj_mid2_psi_persen + uj_fin2_psi * uj_fin2_psi_persen) /100,0) as sum_psi_sem2
    FROM uj
    LEFT JOIN mapel
    ON uj_mapel_id = mapel_id
    WHERE uj_d_s_id = $d_s_id
    GROUP BY mapel_id
    ORDER BY mapel_urutan) AS summative ON formative.mapel_id = summative.mapel_id
  LEFT JOIN
    (SELECT * FROM persen
      WHERE persen_jenj_id = $jenjang
    ) AS persentase ON persentase.persen_mapel_id = formative.mapel_id
  LEFT JOIN
    (SELECT afektif_mapel_id, ROUND(SUM(jumlah)/COUNT(afektif_mapel_id),2) AS total
      FROM(
        SELECT afektif_mapel_id, mapel_nama, ROUND((afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3+
            afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3+
            afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3+
            afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3+
            afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3)/afektif_minggu_aktif,2) AS jumlah, k_afek_bulan_id
        FROM afektif
        LEFT JOIN k_afek ON afektif_k_afek_id = k_afek_id
        LEFT JOIN bulan ON k_afek_bulan_id = bulan_id
        LEFT JOIN mapel ON afektif_mapel_id = mapel_id
        WHERE afektif_d_s_id = $d_s_id AND bulan_semester = $semester
      ) AS afektif_jumlah
      GROUP BY afektif_mapel_id
  ) AS afektif_akhir ON afektif_akhir.afektif_mapel_id = formative.mapel_id
  ORDER BY formative.mapel_urutan")->result_array();

  return $siswa;
}

function returnNilaiSspFinal($d_s_id, $semester){
  $ci =& get_instance();

  $ssp_fin = $ci->db->query(
    "SELECT ssp_nama, ssp_topik_nama, ssp_nilai_angka, ssp_topik_a, ssp_topik_b, ssp_topik_c
    FROM ssp_nilai
    LEFT JOIN ssp_topik ON ssp_nilai_ssp_topik_id = ssp_topik_id
    LEFT JOIN ssp ON ssp_id = ssp_topik_ssp_id
    WHERE ssp_nilai_d_s_id = $d_s_id AND ssp_topik_semester = $semester")->result_array();

  //var_dump($td);
  return $ssp_fin;
}

function returnGuruSsp($d_s_id){
  $ci =& get_instance();

  $ssp_fin = $ci->db->query(
    "SELECT kr_gelar_depan, kr_nama_depan, kr_nama_belakang, kr_gelar_belakang
    FROM ssp_peserta
    LEFT JOIN ssp ON ssp_peserta_ssp_id = ssp_id
    LEFT JOIN kr ON ssp_kr_id = kr_id
    WHERE ssp_peserta_d_s_id = $d_s_id")->row_array();

  //var_dump($td);
  return $ssp_fin;
}

function returnNilaiCB($d_s_id, $semester){
  $ci =& get_instance();

  $cb_fin = $ci->db->query(
    "SELECT *, (nilai_cb1+nilai_cb2+nilai_cb3+nilai_cb4+nilai_cb5)/nilai_cb_jum AS nilai
    FROM nilai_cb
    LEFT JOIN topik_cb ON nilai_cb_topik_cb_id = topik_cb_id
    WHERE nilai_cb_d_s_id = $d_s_id AND topik_cb_semester = $semester")->result_array();

  //var_dump($td);
  return $cb_fin;
}

function returnNilaiKarakter($d_s_id, $semester){
  $ci =& get_instance();

  $cb_fin = $ci->db->query(
    "SELECT karakter_id, karakter_nama, SUM(jumlah)/COUNT(karakter_id) AS total, karakter_a, karakter_b, karakter_c
    FROM(
    SELECT afektif_mapel_id, mapel_nama, karakter_nama, ROUND((afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3+
    afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3+
    afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3+
    afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3+
    afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3)/afektif_minggu_aktif,2) AS jumlah, k_afek_bulan_id, karakter_id, karakter_urutan, karakter_a, karakter_b, karakter_c
    FROM afektif
    LEFT JOIN k_afek ON afektif_k_afek_id = k_afek_id
    LEFT JOIN bulan ON k_afek_bulan_id = bulan_id
    LEFT JOIN mapel ON afektif_mapel_id = mapel_id
    LEFT JOIN karakter_detail ON karakter_detail_mapel_id = mapel_id
    LEFT JOIN karakter ON karakter_detail_karakter_id = karakter_id
    WHERE afektif_d_s_id = $d_s_id AND bulan_semester = $semester
    )AS karakter
    GROUP BY karakter_id
    ORDER BY karakter_urutan")->result_array();

  //var_dump($td);
  return $cb_fin;
}

function show_topik_ssp($ssp_id){
  $ci =& get_instance();

  $topik_ssp = $ci->db->query(
    "SELECT *, COUNT(ssp_nilai_id) as jumlah_nilai
    FROM ssp_topik
    LEFT JOIN ssp_nilai ON ssp_topik_id = ssp_nilai_ssp_topik_id
    WHERE ssp_topik_ssp_id = $ssp_id
    GROUP BY ssp_topik_id
    ORDER BY ssp_topik_semester")->result_array();

  //var_dump($td);
  return $topik_ssp;
}

function show_life_skill_by_kelas($kelas_id){
  $ci =& get_instance();

  $siswa = $ci->db->query(
    "SELECT d_s_id, sis_no_induk, sis_nama_depan, sis_nama_bel,
    pfhf_absent,pfhf_uks,pfhf_tardiness,
    pfhf_absent2,pfhf_uks2,pfhf_tardiness2,
    (pfhf_absent+pfhf_uks+pfhf_tardiness)/3 AS pfhf_sem1, (pfhf_absent2+pfhf_uks2+pfhf_tardiness2)/3 AS pfhf_sem2,
    moralb_lo, moralb_lo2,
    emo_aware_ex,emo_aware_so,emo_aware_ne,
    emo_aware_ex2,emo_aware_so2,emo_aware_ne2,
    (emo_aware_ex+emo_aware_so+emo_aware_ne)/3 AS emo_sem1, (emo_aware_ex2+emo_aware_so2+emo_aware_ne2)/3 AS emo_sem2,
    spirit_coping,spirit_emo,spirit_grate,
    spirit_coping2,spirit_emo2,spirit_grate2,
    (spirit_coping+spirit_emo+spirit_grate)/3 AS spirit_sem1, (spirit_coping2+spirit_emo2+spirit_grate2)/3 AS spirit_sem2,
    ss_relationship,ss_cooperation,ss_conflict,ss_self_a,
    ss_relationship2,ss_cooperation2,ss_conflict2,ss_self_a2,
    (ss_relationship+ss_cooperation+ss_conflict+ss_self_a)/4 AS ss_sem1, (ss_relationship2+ss_cooperation2+ss_conflict2+ss_self_a2)/4 AS ss_sem2
    FROM d_s
    LEFT JOIN sis ON d_s_sis_id = sis_id
    WHERE d_s_kelas_id = $kelas_id
    ORDER BY sis_nama_depan, sis_no_induk")->result_array();

  return $siswa;
}

function showutsuas($mapel_id, $d_s_id){
  $ci =& get_instance();

  $siswa = $ci->db->query(
    "SELECT uj_mid1_kog,uj_mid2_kog,uj_fin1_kog,uj_fin2_kog
    FROM uj
    LEFT JOIN mapel
    ON uj_mapel_id = mapel_id
    WHERE uj_d_s_id = $d_s_id AND mapel_id = $mapel_id")->row_array();

  return $siswa;
}

function returnRataMapelKelas($mapel_id, $kelas_id){
  $ci =& get_instance();

  $siswa = $ci->db->query(
    "SELECT SUM(uj_mid1_kog)/COUNT(uj_mid1_kog) as ruj_mid1_kog, 
    SUM(uj_mid2_kog)/COUNT(uj_mid2_kog) as ruj_mid2_kog, 
    SUM(uj_fin1_kog)/COUNT(uj_fin1_kog) as ruj_fin1_kog, 
    SUM(uj_fin2_kog)/COUNT(uj_fin2_kog) as ruj_fin2_kog
    FROM uj
    LEFT JOIN mapel ON uj_mapel_id = mapel_id
    LEFT JOIN d_s ON d_s_id = uj_d_s_id
    WHERE d_s_kelas_id = $kelas_id AND mapel_id = $mapel_id")->row_array();

  return $siswa;
}

function returnKurangKkmKelas($mapel_id, $kelas_id, $jenis, $semester){
  $ci =& get_instance();

  if($jenis == 1 && $semester == 1){
    $siswa = $ci->db->query(
      "SELECT COUNT(uj_mid1_kog) as kurang
      FROM uj
      LEFT JOIN mapel ON uj_mapel_id = mapel_id
      LEFT JOIN d_s ON d_s_id = uj_d_s_id
      WHERE d_s_kelas_id = $kelas_id AND mapel_id = $mapel_id AND uj_mid1_kog < mapel_kkm")->row_array();
  }
  elseif($jenis == 1 && $semester == 2){
    $siswa = $ci->db->query(
      "SELECT COUNT(uj_mid2_kog) as kurang
      FROM uj
      LEFT JOIN mapel ON uj_mapel_id = mapel_id
      LEFT JOIN d_s ON d_s_id = uj_d_s_id
      WHERE d_s_kelas_id = $kelas_id AND mapel_id = $mapel_id AND uj_mid2_kog < mapel_kkm")->row_array();
  }
  elseif($jenis == 2 && $semester == 1){
    $siswa = $ci->db->query(
      "SELECT COUNT(uj_fin1_kog) as kurang
      FROM uj
      LEFT JOIN mapel ON uj_mapel_id = mapel_id
      LEFT JOIN d_s ON d_s_id = uj_d_s_id
      WHERE d_s_kelas_id = $kelas_id AND mapel_id = $mapel_id AND uj_fin1_kog < mapel_kkm")->row_array();
  }
  elseif($jenis == 2 && $semester == 2){
    $siswa = $ci->db->query(
      "SELECT COUNT(uj_fin2_kog) as kurang
      FROM uj
      LEFT JOIN mapel ON uj_mapel_id = mapel_id
      LEFT JOIN d_s ON d_s_id = uj_d_s_id
      WHERE d_s_kelas_id = $kelas_id AND mapel_id = $mapel_id AND uj_fin2_kog < mapel_kkm")->row_array();
  }
  
  return $siswa;
}

function return_nama_kriteria_afektif($bulan_id, $t_id, $sk_id){
  $ci =& get_instance();
  $kriteria = $ci->db->query(
    "SELECT k_afek_topik_nama, bulan_nama
    FROM k_afek
    LEFT JOIN bulan ON k_afek_bulan_id = bulan_id
    WHERE k_afek_t_id = $t_id AND k_afek_bulan_id = $bulan_id AND k_afek_sk_id = $sk_id
    ORDER BY bulan_id")->row_array();

  return $kriteria;
}

function return_nilai_afek_perbulan($bulan_id, $d_s_id){
  $ci =& get_instance();
  $kriteria = $ci->db->query(
    "SELECT ROUND(SUM(jumlah)/COUNT(jumlah),2) AS rata
    FROM(
        SELECT afektif_mapel_id, ROUND((afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3+
        afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3+
        afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3+
        afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3+
        afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3)/afektif_minggu_aktif,2) AS jumlah
        FROM afektif
        LEFT JOIN k_afek ON afektif_k_afek_id = k_afek_id
        WHERE afektif_d_s_id = $d_s_id AND k_afek_bulan_id = $bulan_id
    )AS a")->row_array();

  return $kriteria;
}

function get_mapel_ajar_kelas_kr($kelas_id, $kr_id){
  $ci =& get_instance();
  $kriteria = $ci->db->query(
    "SELECT *
    FROM d_mpl
    LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
    WHERE d_mpl_kr_id = $kr_id AND d_mpl_kelas_id = $kelas_id
    ORDER BY mapel_nama")->result_array();

  return $kriteria;
}

function return_raport_fin_mapel($d_s_id, $semester, $jenjang, $mapel_id){
  $ci =& get_instance();
  //formative (harian) didapat dari nilai kognitif tes * persen tes

  $siswa = $ci->db->query(
    "SELECT * FROM 
      (SELECT mapel_nama, mapel_id, kelas_jenj_id, mapel_urutan, tes_d_s_id,mapel_kkm, sis_nama_depan, sis_nama_bel, sis_no_induk, sis_jk, kelas_nama, COUNT(DISTINCT tes_topik_id), d_s_komen_sem, d_s_komen_sem2, d_s_scout_nilai, d_s_scout_nilai2, d_s_sick, d_s_sick2, d_s_absenin, d_s_absenin2, d_s_absenex, d_s_absenex2,
      (pfhf_absent+pfhf_uks+pfhf_tardiness)/3 AS pfhf_sem1, (pfhf_absent2+pfhf_uks2+pfhf_tardiness2)/3 AS pfhf_sem2,
      moralb_lo AS mb_sem1, moralb_lo2 AS mb_sem2,
      (emo_aware_ex+emo_aware_so+emo_aware_ne)/3 AS emo_sem1, (emo_aware_ex2+emo_aware_so2+emo_aware_ne2)/3 AS emo_sem2,
      (spirit_coping+spirit_emo+spirit_grate)/3 AS spirit_sem1, (spirit_coping2+spirit_emo2+spirit_grate2)/3 AS spirit_sem2,
      (ss_relationship+ss_cooperation+ss_conflict+ss_self_a)/4 AS ss_sem1, (ss_relationship2+ss_cooperation2+ss_conflict2+ss_self_a2)/4 AS ss_sem2,
      ROUND(SUM(ROUND(kog_quiz*kog_quiz_persen/100 + kog_ass*kog_ass_persen/100 + kog_test*kog_test_persen/100,0))/COUNT(DISTINCT tes_topik_id),0) AS for_kog,
      ROUND(SUM(ROUND(psi_quiz*psi_quiz_persen/100 + psi_ass*psi_ass_persen/100 + psi_test*psi_test_persen/100,0))/COUNT(DISTINCT tes_topik_id),0) AS for_psi
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
      WHERE tes_d_s_id = $d_s_id AND topik_semester = $semester AND mapel_id = $mapel_id
      GROUP BY mapel_id
      ORDER BY mapel_urutan ) AS formative
  LEFT JOIN
    (SELECT mapel_id,
    ROUND((uj_mid1_kog * uj_mid1_kog_persen + uj_fin1_kog * uj_fin1_kog_persen) /100,0) as sum_kog_sem1,
    ROUND((uj_mid1_psi * uj_mid1_psi_persen + uj_fin1_psi * uj_fin1_psi_persen) /100,0) as sum_psi_sem1,
    ROUND((uj_mid2_kog * uj_mid2_kog_persen + uj_fin2_kog * uj_fin2_kog_persen) /100,0) as sum_kog_sem2,
    ROUND((uj_mid2_psi * uj_mid2_psi_persen + uj_fin2_psi * uj_fin2_psi_persen) /100,0) as sum_psi_sem2
    FROM uj
    LEFT JOIN mapel
    ON uj_mapel_id = mapel_id
    WHERE uj_d_s_id = $d_s_id AND mapel_id = $mapel_id
    GROUP BY mapel_id
    ORDER BY mapel_urutan) AS summative ON formative.mapel_id = summative.mapel_id
  LEFT JOIN
    (SELECT * FROM persen
      WHERE persen_jenj_id = $jenjang
    ) AS persentase ON persentase.persen_mapel_id = formative.mapel_id
  LEFT JOIN
    (SELECT afektif_mapel_id, ROUND(SUM(jumlah)/COUNT(afektif_mapel_id),2) AS total
      FROM(
        SELECT afektif_mapel_id, mapel_nama, ROUND((afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3+
            afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3+
            afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3+
            afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3+
            afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3)/afektif_minggu_aktif,2) AS jumlah, k_afek_bulan_id
        FROM afektif
        LEFT JOIN k_afek ON afektif_k_afek_id = k_afek_id
        LEFT JOIN bulan ON k_afek_bulan_id = bulan_id
        LEFT JOIN mapel ON afektif_mapel_id = mapel_id
        WHERE afektif_d_s_id = $d_s_id AND bulan_semester = $semester AND mapel_id = $mapel_id
      ) AS afektif_jumlah
      GROUP BY afektif_mapel_id
  ) AS afektif_akhir ON afektif_akhir.afektif_mapel_id = formative.mapel_id
  ORDER BY formative.mapel_urutan")->row_array();

  return $siswa;
}

function show_mapel_header_summary_urut_raport($kelas_id){
  $ci =& get_instance();

  if (mapel_menu() >= 1 && $ci->session->userdata('kr_jabatan_id')!=5 && $ci->session->userdata('kr_jabatan_id')!=4) {

    $kr_id = $ci->session->userdata('kr_id');

    $laporan = $ci->db->query(
      "SELECT DISTINCT mapel_id, mapel_nama, mapel_sing
      FROM d_mpl
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      WHERE d_mpl_kelas_id = $kelas_id AND d_mpl_kr_id = $kr_id
      ORDER BY mapel_urutan")->result_array();
  }else{
    $laporan = $ci->db->query(
      "SELECT DISTINCT mapel_id, mapel_nama, mapel_sing, mapel_kkm
      FROM d_mpl
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      WHERE d_mpl_kelas_id = $kelas_id
      ORDER BY mapel_urutan")->result_array();
  }


  return $laporan;
}

function returnSSPSiswa($d_s_id){
  $ci =& get_instance();

  $ssp_fin = $ci->db->query(
    "SELECT ssp_id, ssp_nama
    FROM ssp_peserta
    LEFT JOIN ssp ON ssp_id = ssp_peserta_ssp_id
    WHERE ssp_peserta_d_s_id = $d_s_id")->result_array();

  //var_dump($td);
  return $ssp_fin;
}

function returnnilSSPSiswa($d_s_id, $semester, $ssp_id){
  $ci =& get_instance();

  $ssp_fin = $ci->db->query(
    "SELECT SUM(ssp_nilai_angka)/COUNT(ssp_topik_id) AS total
    FROM ssp_nilai
    LEFT JOIN ssp_topik ON ssp_nilai_ssp_topik_id = ssp_topik_id
    LEFT JOIN ssp ON ssp_id = ssp_topik_ssp_id
    WHERE ssp_nilai_d_s_id = $d_s_id AND ssp_topik_semester = $semester AND ssp_id = $ssp_id")->row_array();

  return $ssp_fin;
}

function returnNilaiKarakterbyID($d_s_id, $semester, $karakter_id){
  $ci =& get_instance();

  $cb_fin = $ci->db->query(
    "SELECT karakter_id, karakter_nama, SUM(jumlah)/COUNT(karakter_id) AS total, karakter_a, karakter_b, karakter_c
    FROM(
    SELECT afektif_mapel_id, mapel_nama, karakter_nama, ROUND((afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3+
    afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3+
    afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3+
    afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3+
    afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3)/afektif_minggu_aktif,2) AS jumlah, k_afek_bulan_id, karakter_id, karakter_urutan, karakter_a, karakter_b, karakter_c
    FROM afektif
    LEFT JOIN k_afek ON afektif_k_afek_id = k_afek_id
    LEFT JOIN bulan ON k_afek_bulan_id = bulan_id
    LEFT JOIN mapel ON afektif_mapel_id = mapel_id
    LEFT JOIN karakter_detail ON karakter_detail_mapel_id = mapel_id
    LEFT JOIN karakter ON karakter_detail_karakter_id = karakter_id
    WHERE afektif_d_s_id = $d_s_id AND bulan_semester = $semester AND karakter_id = $karakter_id
    )AS karakter
    GROUP BY karakter_id
    ORDER BY karakter_urutan")->row_array();

  //var_dump($td);
  return $cb_fin;
}


function show_siswa_by_sis_arr($sis_arr){
  $ci =& get_instance();

  $d_s_id = "";
  for($i=0;$i<count($sis_arr);$i++){
    $d_s_id .= $sis_arr[$i];

    if($i != count($sis_arr)-1)
      $d_s_id .= ",";
  }

  $siswa = $ci->db->query(
    "SELECT d_s_id, sis_no_induk, sis_nama_depan, sis_nama_bel, sis_nisn, d_s_scout_nilai, d_s_scout_nilai2
    FROM d_s
    LEFT JOIN sis ON d_s_sis_id = sis_id
    WHERE d_s_id IN ($d_s_id)
    ORDER BY sis_nama_depan, sis_no_induk")->result_array();

  return $siswa;
}

function return_detail_siswa($d_s_id){
  $ci =& get_instance();

  $siswa = $ci->db->query(
    "SELECT d_s_id, sis_no_induk, sis_nama_depan, sis_nama_bel, sis_nisn, kelas_nama
    FROM d_s
    LEFT JOIN sis ON d_s_sis_id = sis_id
    LEFT JOIN kelas ON d_s_kelas_id = kelas_id
    WHERE d_s_id = $d_s_id")->result_array();

  return $siswa;
}
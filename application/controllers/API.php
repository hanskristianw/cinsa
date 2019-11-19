<?php
defined('BASEPATH') or exit('No direct script access allowed');

class API extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_sk');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_kelas');
    $this->load->model('_mapel');
    $this->load->model('_topik');
    $this->load->model('_k_afek');

    //jika bukan guru dan sudah login redirect ke home
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){
    redirect('Profile');
  }

  public function get_detail_konseling_by_siswa(){
    if($this->input->post('d_s_id', true)){
      $d_s_id = $this->input->post('d_s_id', true);

      $data = $this->db->query(
        "SELECT *
        FROM konseling
        LEFT JOIN konseling_kategori ON konseling_konseling_kategori_id = konseling_kategori_id
        WHERE konseling_d_s_id = $d_s_id ORDER BY konseling_tanggal DESC, konseling_konseling_kategori_id")->result();
  
      echo json_encode($data);

    }
  }

  public function cek_topik_afektif_exist(){
    if($this->input->post('k_afek_bulan_id', true)){
      $bulan_id = $this->input->post('k_afek_bulan_id', true);
      $t_id = $this->input->post('k_afek_t_id', true);
      $sk_id = $this->input->post('sk_id', true);

      $data = $this->db->query(
        "SELECT *
        FROM k_afek
        WHERE k_afek_t_id = $t_id AND k_afek_bulan_id = $bulan_id AND k_afek_sk_id = $sk_id")->result();
  
      echo json_encode($data);
    }
    else{
      echo "halo";
    }
  }

  public function get_siswaMK(){
    if($this->input->post('mkId',TRUE)){
    
      $mkId = $this->input->post('mkId',TRUE);
      
      //temukan jenjang id pada kelas itu
      $data = $this->db->query(
        "SELECT kelas_nama, sis_nama_depan, sis_nama_bel, d_s_id, mk_detail_id
        FROM mk_detail
        LEFT JOIN d_s ON mk_detail_d_s_id = d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN kelas ON d_s_kelas_id = kelas_id
        WHERE mk_detail_mk_id = $mkId
        ORDER BY sis_nama_depan")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }
  }

  public function get_subject_by_karakter_and_sk(){
    if($this->input->post('karakter_id',TRUE)){
    
      $karakter_id = $this->input->post('karakter_id',TRUE);
      $sk_id = $this->input->post('sk_id',TRUE);
      
      //temukan jenjang id pada kelas itu
      $data = $this->db->query(
        "SELECT * FROM 
        (
          SELECT * FROM mapel
          WHERE mapel_sk_id = $sk_id
        ) as mapel_awal
        LEFT JOIN
        (
          SELECT karakter_detail_mapel_id FROM karakter_detail
          LEFT JOIN mapel ON karakter_detail_mapel_id = mapel_id
          LEFT JOIN karakter ON karakter_detail_karakter_id = karakter_id
          WHERE mapel_sk_id = $sk_id AND karakter_id = $karakter_id
        ) as mapel_karakter ON mapel_karakter.karakter_detail_mapel_id = mapel_awal.mapel_id
        ORDER BY mapel_nama")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }
  }

  public function get_siswa_by_kelas(){
    if($this->input->post('kelas_id',TRUE)){
    
      $kelas_id = $this->input->post('kelas_id',TRUE);
      
      //temukan jenjang id pada kelas itu
      $data = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE d_s_kelas_id = $kelas_id
        ORDER BY sis_nama_depan")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }
  }

  public function get_konselor_by_sk(){
    if($this->input->post('sk_id', true)){
      $sk_id = $this->input->post('sk_id', true);

      $data = $this->db->query(
        "SELECT *
        FROM konselor
        LEFT JOIN kr ON konselor_kr_id = kr_id
        WHERE konselor_sk_id = $sk_id ORDER BY kr_nama_depan")->result();
  
      echo json_encode($data);
    }
  }

  
  public function get_kelas_by_kr(){

    if($this->input->post('t_id',TRUE)){
      $t_id = $this->input->post('t_id',TRUE);
      $kr_id = $this->session->userdata('kr_id');

      $kr_jabatan = $this->session->userdata('kr_jabatan_id');
      $kr_sk_id = $this->session->userdata('kr_sk_id');

      //jika kurikulum
      if($kr_jabatan == 4){
        //cari mapel disekolah itu
        $data = $this->db->query(
          "SELECT kelas_id, kelas_nama, sk_nama
          FROM kelas
          LEFT JOIN sk ON kelas_sk_id = sk_id
          WHERE kelas_t_id = $t_id AND kelas_sk_id = $kr_sk_id
          ORDER BY kelas_nama")->result();
      }
      else{
        $data = $this->db->query(
          "SELECT DISTINCT kelas_id, kelas_nama, sk_nama
          FROM d_mpl
          LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
          LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
          LEFT JOIN sk ON kelas_sk_id = sk_id
          WHERE kelas_t_id = $t_id AND d_mpl_kr_id = $kr_id
          ORDER BY kelas_nama")->result();
      }

      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

  }
  

  public function get_mapel_by_kr_kelas(){
    if($this->input->post('kelas_id', true)){

      $kelas_id = $this->input->post('kelas_id', true);
      $kr_id = $this->session->userdata('kr_id');
      
      $kr_jabatan = $this->session->userdata('kr_jabatan_id');
      if($kr_jabatan == 4){
        //cari mapel dikelas itu
        $data = $this->db->query(
          "SELECT DISTINCT mapel_id, mapel_nama
          FROM d_mpl
          LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
          WHERE d_mpl_kelas_id = $kelas_id ORDER BY mapel_nama")->result();
      }
      else{
      $data = $this->db->query(
        "SELECT DISTINCT mapel_id, mapel_nama
        FROM d_mpl
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        WHERE d_mpl_kelas_id = $kelas_id AND d_mpl_kr_id = $kr_id ORDER BY mapel_nama")->result();
      }
      echo json_encode($data);
    }
  }

  public function get_kelas_by_year_sk(){
    if($this->input->post('t_id', true)){

      $t_id = $this->input->post('t_id', true);
      $sk_id = $this->input->post('sk_id', true);
      $data = $this->db->query(
        "SELECT kelas_id, kelas_nama
        FROM kelas
        WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id ORDER BY kelas_nama")->result();
  
      echo json_encode($data);
    }
  }

  public function get_mapel_by_kelas(){
    if($this->input->post('kelas_id', true)){

      $kelas_id = $this->input->post('kelas_id', true);

      $data = $this->db->query(
        "SELECT DISTINCT mapel_id, mapel_nama
        FROM d_mpl
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        WHERE d_mpl_kelas_id = $kelas_id ORDER BY mapel_nama")->result();
  
      echo json_encode($data);
    }
  }

  public function get_topik_by_mapel(){
    if($this->input->post('mapel_id',TRUE)){
    
      $mapel_id = $this->input->post('mapel_id',TRUE);
      $kelas_id = $this->input->post('kelas_id',TRUE);
      
      //temukan jenjang id pada kelas itu
      $jenjang = $this->db->query(
        "SELECT jenj_id
        FROM kelas
        LEFT JOIN jenj ON kelas_jenj_id = jenj_id
        WHERE kelas_id = $kelas_id")->row_array();
  
      //print_r($jenjang['jenj_id']);
  
      $jenj_id = $jenjang['jenj_id'];
      $data = $this->db->query(
        "SELECT topik_id, topik_nama, topik_semester
        FROM topik
        LEFT JOIN jenj ON topik_jenj_id = jenj_id
        LEFT JOIN mapel ON topik_mapel_id = mapel_id
        WHERE jenj_id = $jenj_id AND mapel_id = $mapel_id")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }
  }

  public function get_kelas_by_year(){
    if($this->input->post('t_id', true)){

      $t_id = $this->input->post('t_id', true);
      $sk_id = $this->session->userdata('kr_sk_id');
      $data = $this->db->query(
        "SELECT kelas_id, kelas_nama
        FROM kelas
        WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id ORDER BY kelas_nama")->result();
  
      echo json_encode($data);
    }
  }

  public function get_laporan_afek_header_by_kelas_bulan(){
    if($this->input->post('sk_id', true)){

      $sk_id = $this->input->post('sk_id', true);
      $t_id = $this->input->post('t_id', true);
      $bulan_id = $this->input->post('bulan_id', true);
      $kelas_id = $this->input->post('kelas_id', true);


      $mapel_header = $this->db->query("
        SELECT DISTINCT mapel_id, mapel_sing
        FROM d_mpl 
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        WHERE d_mpl_kelas_id = $kelas_id ORDER BY mapel_urutan,mapel_nama")->result();

      echo json_encode($mapel_header);
    }
  }

  public function get_desc_afek_by_sk_t_bulan(){
    if($this->input->post('sk_id', true)){

      $sk_id = $this->input->post('sk_id', true);
      $t_id = $this->input->post('t_id', true);
      $bulan_id = $this->input->post('bulan_id', true);

      $kriteria = $this->db->query("
      SELECT *
      FROM k_afek 
      WHERE k_afek_bulan_id = $bulan_id AND k_afek_t_id = $t_id AND k_afek_sk_id = $sk_id")->result();

      echo json_encode($kriteria);
    }
  }

  public function get_laporan_afek_by_kelas_bulan(){

    if($this->input->post('sk_id', true)){

      $sk_id = $this->input->post('sk_id', true);
      $t_id = $this->input->post('t_id', true);
      $bulan_id = $this->input->post('bulan_id', true);
      $kelas_id = $this->input->post('kelas_id', true);

      $data['k_afek'] = $this->db->query("
      SELECT *
      FROM k_afek 
      WHERE k_afek_bulan_id = $bulan_id AND k_afek_t_id = $t_id AND k_afek_sk_id = $sk_id")->row_array();


      $mapel_header = $this->db->query("
        SELECT DISTINCT mapel_id, mapel_sing
        FROM d_mpl 
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        WHERE d_mpl_kelas_id = $kelas_id ORDER BY mapel_urutan,mapel_nama")->result_array();

      $query_concat ="";
      foreach ($mapel_header as $m){
        $query_concat .= "GROUP_CONCAT(IF(afektif_mapel_id = {$m['mapel_id']}, afektif_nilai, '') SEPARATOR '') AS '{$m['mapel_sing']}'";
        $query_concat .= ",";
      }
      $query_concat = substr($query_concat, 0, -1);
      //echo $query_concat;
      //var_dump($mapel_header);

      $afektif_all = $this->db->query(
      "SELECT afektif_d_s_id, sis_nama_depan, sis_nama_bel, d_s_kelas_id, sis_no_induk, kelas_nama, $query_concat
      FROM 
      (SELECT afektif_d_s_id, sis_nama_depan, sis_nama_bel, d_s_kelas_id, sis_no_induk, kelas_nama,
      (afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3+afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3+afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3+afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3+afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3)/afektif_minggu_aktif AS afektif_nilai, afektif_mapel_id 
      FROM afektif
      LEFT JOIN d_s on afektif_d_s_id = d_s_id 
      LEFT JOIN sis on d_s_sis_id = sis_id 
      LEFT JOIN k_afek on k_afek_id = afektif_k_afek_id 
      LEFT JOIN kelas on d_s_kelas_id = kelas_id 
      WHERE k_afek_bulan_id = {$bulan_id} AND d_s_kelas_id = {$kelas_id}) as afektif_kelas
      GROUP BY afektif_d_s_id")->result();

      echo json_encode($afektif_all);
    }
  }

  public function get_pengajar_by_mapel(){
    if($this->input->post('mapel_id', true)){

      $mapel_id = $this->input->post('mapel_id', true);
      $kelas_id = $this->input->post('kelas_id', true);

      $guru = $this->db->query("
                  SELECT kr_nama_depan, kr_nama_belakang
                  FROM d_mpl 
                  LEFT JOIN kr ON d_mpl_kr_id = kr_id 
                  WHERE d_mpl_mapel_id = $mapel_id AND d_mpl_kelas_id = $kelas_id")->result();

      echo json_encode($guru);
    }
  }

  public function get_cog_by_mapel_kelas_sem(){
    if($this->input->post('mapel_id', true)){

      $mapel_id = $this->input->post('mapel_id', true);
      $kelas_id = $this->input->post('kelas_id', true);
      $sem = $this->input->post('semester', true);

      $guru = $this->db->query("
              SELECT sis_nama_depan, sis_nama_bel, topik_nama, kog_quiz, kog_test, kog_ass, kog_quiz_persen, kog_test_persen, kog_ass_persen, 
              psi_quiz, psi_test, psi_ass, psi_quiz_persen, psi_test_persen, psi_ass_persen
              FROM tes
              LEFT JOIN topik ON tes_topik_id = topik_id
              LEFT JOIN d_s ON tes_d_s_id = d_s_id
              LEFT JOIN sis ON d_s_sis_id = sis_id
              WHERE topik_mapel_id = $mapel_id AND d_s_kelas_id = $kelas_id AND topik_semester = $sem
              ORDER BY topik_id, sis_nama_depan")->result();

      echo json_encode($guru);
    }
  }

  public function get_uj_by_mapel_kelas(){
    if($this->input->post('mapel_id', true)){

      $mapel_id = $this->input->post('mapel_id', true);
      $kelas_id = $this->input->post('kelas_id', true);

      $guru = $this->db->query("
              SELECT sis_nama_depan, sis_nama_bel, 
              uj_mid1_kog, uj_mid1_kog_persen, uj_mid1_psi, uj_mid1_psi_persen, uj_fin1_kog, uj_fin1_kog_persen, uj_fin1_psi, uj_fin1_psi_persen,
              uj_mid2_kog, uj_mid2_kog_persen, uj_mid2_psi, uj_mid2_psi_persen, uj_fin2_kog, uj_fin2_kog_persen, uj_fin2_psi, uj_fin2_psi_persen
              FROM uj
              LEFT JOIN d_s ON uj_d_s_id = d_s_id
              LEFT JOIN sis ON d_s_sis_id = sis_id
              WHERE d_s_kelas_id = $kelas_id AND uj_mapel_id = $mapel_id")->result();

      echo json_encode($guru);
    }
  }

  public function get_topik_cb(){
    if($this->input->post('topik_sk_id', true)){

      $sk_id = $this->input->post('topik_sk_id', true);

      $topik = $this->db->query("
              SELECT *, count(nilai_cb_id) as jum_cb
              FROM topik_cb
              LEFT JOIN jenj ON topik_cb_jenj_id = jenj_id
              LEFT JOIN nilai_cb ON nilai_cb_topik_cb_id = topik_cb_id
              WHERE topik_cb_sk_id = $sk_id
              GROUP BY topik_cb_id
              ORDER BY topik_cb_jenj_id, topik_cb_semester")->result();

      echo json_encode($topik);
    }
  }

  public function get_indicator_cb(){
    if($this->input->post('topik_cb_id', true)){

      $topik_cb_id = $this->input->post('topik_cb_id', true);

      $topik = $this->db->query("
              SELECT *
              FROM ind_cb
              WHERE ind_cb_topik_cb_id = $topik_cb_id
              ORDER BY ind_cb_nama")->result();

      echo json_encode($topik);
    }
  }

  public function get_topik_cb_by_jenj_sk(){
    if($this->input->post('sk_id', true)){

      $sk_id = $this->input->post('sk_id', true);
      $kelas_id = $this->input->post('kelas_id', true);

      //cari jenjang
      $jenjang = $this->db->query(
        "SELECT jenj_id
        FROM kelas
        LEFT JOIN jenj ON kelas_jenj_id = jenj_id
        WHERE kelas_id = $kelas_id")->row_array();
  
      //print_r($jenjang['jenj_id']);
  
      $jenj_id = $jenjang['jenj_id'];

      $topik = $this->db->query("
              SELECT *
              FROM topik_cb
              WHERE topik_cb_sk_id = $sk_id AND topik_cb_jenj_id = $jenj_id
              ORDER BY topik_cb_semester")->result();

      echo json_encode($topik);
    }
  }

  public function get_nilai_cb_by_kelas_semester(){
    if($this->input->post('kelas_id', true)){
      
      $semester = $this->input->post('semester', true);
      $kelas_id = $this->input->post('kelas_id', true);

      $nilai = $this->db->query("SELECT topik_cb_nama, sis_no_induk, sis_nama_depan, sis_nama_bel, nilai_cb1, nilai_cb2, nilai_cb3, nilai_cb4, nilai_cb5, nilai_cb_jum
                                FROM nilai_cb
                                LEFT JOIN d_s ON nilai_cb_d_s_id = d_s_id
                                LEFT JOIN sis ON d_s_sis_id = sis_id
                                LEFT JOIN topik_cb ON nilai_cb_topik_cb_id = topik_cb_id
                                WHERE d_s_kelas_id = $kelas_id AND topik_cb_semester = $semester
                                ORDER BY topik_cb_id")->result();

      echo json_encode($nilai);

    }
  }

  public function get_bulan_afek_terisi(){
    if($this->input->post('sk_id', true)){
      
      $sk_id = $this->input->post('sk_id', true);
      $t_id = $this->input->post('t_id', true);

      $bulan = $this->db->query("SELECT DISTINCT k_afek_bulan_id, bulan_nama
                                FROM afektif 
                                LEFT JOIN d_s ON afektif_d_s_id = d_s_id
                                LEFT JOIN sis ON d_s_sis_id = sis_id
                                LEFT JOIN k_afek ON afektif_k_afek_id = k_afek_id
                                LEFT JOIN bulan ON k_afek_bulan_id = bulan_id
                                WHERE sis_sk_id = $sk_id AND k_afek_t_id = $t_id
                                ORDER BY k_afek_bulan_id")->result();

      echo json_encode($bulan);

    }
  }

  public function get_detail_nilai_afek(){
    if($this->input->post('bulan_id', true) && $this->input->post('d_s_id', true)){
      
      $bulan_id = $this->input->post('bulan_id', true);
      $d_s_id = $this->input->post('d_s_id', true);
      $mapel_id = $this->input->post('mapel_id', true);

      $detail = $this->db->query("SELECT afektif_mapel_id, afektif_minggu1a1,afektif_minggu1a2,afektif_minggu1a3,
        afektif_minggu2a1,afektif_minggu2a2,afektif_minggu2a3,
        afektif_minggu3a1,afektif_minggu3a2,afektif_minggu3a3,
        afektif_minggu4a1,afektif_minggu4a2,afektif_minggu4a3,
        afektif_minggu5a1,afektif_minggu5a2,afektif_minggu5a3, afektif_minggu_aktif, k_afek_bulan_id, k_afek_topik_nama,
        ROUND((afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3+
        afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3+
        afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3+
        afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3+
        afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3)/afektif_minggu_aktif,2) AS jumlah
        FROM afektif
        LEFT JOIN k_afek ON afektif_k_afek_id = k_afek_id
        WHERE afektif_d_s_id = $d_s_id AND k_afek_bulan_id IN ($bulan_id) AND afektif_mapel_id = $mapel_id
        ORDER BY k_afek_bulan_id
      ")->result();

      echo json_encode($detail);
    }

  }

  public function get_percent_by_mapel_jenj(){
    if($this->input->post('mapel_id', true) && $this->input->post('jenj_id', true)){
      $mapel_id = $this->input->post('mapel_id', true);
      $jenj_id = $this->input->post('jenj_id', true);

      $detail = $this->db->query("SELECT *
        FROM persen
        WHERE persen_mapel_id = $mapel_id AND persen_jenj_id = $jenj_id
      ")->result();

      echo json_encode($detail);
    }

  }

  public function get_pengajar_ssp(){
    if($this->input->post('ssp_id', true)){
      $ssp_id = $this->input->post('ssp_id', true);

      $detail = $this->db->query("SELECT kr_nama_depan, kr_nama_belakang
        FROM ssp
        LEFT JOIN kr ON ssp_kr_id= kr_id
        WHERE ssp_id = $ssp_id
      ")->result();

      echo json_encode($detail);
    }

  }

  public function get_siswa_ssp(){
    if($this->input->post('ssp_id', true)){
      $ssp_id = $this->input->post('ssp_id', true);

      $detail = $this->db->query("SELECT sis_no_induk, sis_nama_depan, sis_nama_bel
        FROM ssp_peserta
        LEFT JOIN d_s ON ssp_peserta_d_s_id = d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE ssp_peserta_ssp_id = $ssp_id
        ORDER BY sis_no_induk, sis_nama_depan
      ")->result();

      echo json_encode($detail);
    }

  }

  public function get_detail_nilai_topik_ssp(){
    if($this->input->post('ssp_topik_id', true)){
      $ssp_topik_id = $this->input->post('ssp_topik_id', true);

      $detail = $this->db->query("SELECT sis_no_induk, sis_nama_depan, sis_nama_bel, ssp_nilai_angka
        FROM ssp_nilai
        LEFT JOIN d_s ON ssp_nilai_d_s_id = d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE ssp_nilai_ssp_topik_id = $ssp_topik_id
        ORDER BY sis_no_induk, sis_nama_depan
      ")->result();

      echo json_encode($detail);
    }
  }

  public function get_st(){

    $detail = $this->db->query("SELECT *
      FROM st")->result();

    echo json_encode($detail);
  }

  public function get_history_st(){
    if($this->input->post('kr_id', true)){
      $kr_id = $this->input->post('kr_id', true);

      $detail = $this->db->query("SELECT *
        FROM kr_h_status
        LEFT JOIN st ON kr_h_status_status_id = st_id
        WHERE kr_h_status_kr_id = $kr_id
        ORDER BY kr_h_status_tanggal DESC
      ")->result();

      echo json_encode($detail);
    }
  }

  public function get_formative_by_mapel(){
    if($this->input->post('mapel_id', true)){
      $mapel_id = $this->input->post('mapel_id', true);
      $d_s_id = $this->input->post('d_s_id', true);
      $semester = $this->input->post('semester', true);

      $detail = $this->db->query("SELECT 
        kog_quiz,kog_quiz_persen,kog_ass,kog_ass_persen,kog_test,kog_test_persen,tes_topik_id,
        psi_quiz,psi_quiz_persen,psi_ass,psi_ass_persen,psi_test,psi_test_persen, topik_nama
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
        ")->result();

      echo json_encode($detail);
    }
  }

  public function get_summative_by_mapel(){
    if($this->input->post('mapel_id', true)){
      $mapel_id = $this->input->post('mapel_id', true);
      $d_s_id = $this->input->post('d_s_id', true);

      $detail = $this->db->query("SELECT 
            uj_mid1_kog, uj_mid1_kog_persen, uj_fin1_kog, uj_fin1_kog_persen,
            uj_mid1_psi, uj_mid1_psi_persen, uj_fin1_psi, uj_fin1_psi_persen,
            uj_mid2_kog, uj_mid2_kog_persen, uj_fin2_kog, uj_fin2_kog_persen,
            uj_mid2_psi, uj_mid2_psi_persen, uj_fin2_psi, uj_fin2_psi_persen
            FROM uj
            WHERE uj_d_s_id = $d_s_id AND uj_mapel_id = $mapel_id
        ")->result();

      echo json_encode($detail);
    }
  }

}

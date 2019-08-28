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

}

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

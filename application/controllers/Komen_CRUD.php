<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Komen_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_jenj');
    $this->load->model('_t');
    $this->load->model('_siswa');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_d_s');
    $this->load->model('_kelas');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    
    if ($this->session->userdata('kr_jabatan_id') != 7 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Student Comment';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['kelas_all'] = $this->_kelas->find_by_walkel($this->session->userdata('kr_id'));

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('komen_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function input()
  {

    if($this->input->post('kelas_komen',TRUE)){

      $data = [
        'd_s_sick' => $this->input->post('d_s_sick',true),
        'd_s_absenin' => $this->input->post('d_s_absenin',true),
        'd_s_absenex' => $this->input->post('d_s_absenex',true),
        'd_s_sick2' => $this->input->post('d_s_sick2',true),
        'd_s_absenin2' => $this->input->post('d_s_absenin2',true),
        'd_s_absenex2' => $this->input->post('d_s_absenex2',true),
        'd_s_komen_sis' => $this->input->post('d_s_komen_sis',true),
        'd_s_komen_sem' => $this->input->post('d_s_komen_sem',true),
        'd_s_komen_sis2' => $this->input->post('d_s_komen_sis2',true),
        'd_s_komen_sem2' => $this->input->post('d_s_komen_sem2',true)
      ];
      
      $this->db->where('d_s_id', $this->input->post('d_s_id'));
      $this->db->update('d_s', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success!</div>');
      redirect('Komen_CRUD');
    } 
    else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function get_siswa()
  {

    if($this->input->post('id',TRUE)){
      
      $kelas_id = $this->input->post('id',TRUE);
      
      $data = $this->db->query(
        "SELECT *
        FROM d_s
        LEFT JOIN sis ON sis_id = d_s_sis_id
        WHERE d_s_kelas_id = $kelas_id")->result();
  
      //var_dump($data);
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function get_komen()
  {

    if($this->input->post('id',TRUE)){
      
      $d_s_id = $this->input->post('id',TRUE);
      
      $data = $this->db->query(
        "SELECT *
        FROM d_s
        WHERE d_s_id = $d_s_id")->result();
  
      //var_dump($data);
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }
  
}

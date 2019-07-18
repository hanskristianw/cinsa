<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SSP_topik_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_sk');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_mapel');
    $this->load->model('_jenj');
    $this->load->model('_topik');
    $this->load->model('_ssp');


    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan guru dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=7 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    $cek = $this->db->where('ssp_kr_id',$this->session->userdata('kr_id'))->from("ssp")->count_all_results();

    if($cek == 0){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['title'] = 'SSP Topic';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $kr_id = $data['kr']['kr_id'];

    $data['ssp_all'] = $this->_ssp->return_all_by_kr_id($kr_id);

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('ssp_topik_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function proses_update(){
    
    $ssp_topik_semester = $this->input->post('ssp_topik_semester', true);

    //jika bukan dari form update sendiri
    if (!$ssp_topik_semester) {
      //ambil id dari method get
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data = [
    	'ssp_topik_nama' => $this->input->post('ssp_topik_nama', true),
    	'ssp_topik_semester' => $this->input->post('ssp_topik_semester', true),
    	'ssp_topik_a' => $this->input->post('ssp_topik_a', true),
    	'ssp_topik_b' => $this->input->post('ssp_topik_b', true),
    	'ssp_topik_c' => $this->input->post('ssp_topik_c', true)
    ];

    $this->db->where('ssp_topik_id', $this->input->post('ssp_id'));
    $this->db->update('ssp_topik', $data); 

    $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Topic Updated!</div>');
    redirect('SSP_topik_CRUD');
  }

  public function get_topik(){
    if($this->input->post('ssp_id',TRUE)){
      
      $ssp_id = $this->input->post('ssp_id',TRUE);
      
      $data = $this->db->query(
        "SELECT *
        FROM ssp_topik
        WHERE ssp_topik_ssp_id = $ssp_id
        ORDER BY ssp_topik_semester, ssp_topik_nama")->result();
  
      //var_dump($data);
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function add(){


    $ssp_topik_ssp_id = $this->input->post('ssp_topik_ssp_id', true);
    $ssp_topik_semester = $this->input->post('ssp_topik_semester', true);

    //jika bukan dari form update sendiri
    if (!$ssp_topik_ssp_id || !$ssp_topik_semester) {
      //ambil id dari method get
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data = [
    	'ssp_topik_ssp_id' => $this->input->post('ssp_topik_ssp_id', true),
    	'ssp_topik_nama' => $this->input->post('ssp_topik_nama', true),
    	'ssp_topik_semester' => $this->input->post('ssp_topik_semester', true),
    	'ssp_topik_a' => $this->input->post('ssp_topik_a', true),
    	'ssp_topik_b' => $this->input->post('ssp_topik_b', true),
    	'ssp_topik_c' => $this->input->post('ssp_topik_c', true)
    ];

    $this->db->insert('ssp_topik', $data);
    $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">SSP Topic Created!</div>');
    redirect('SSP_topik_CRUD');

  }

  public function edit_page(){
    
    if ($this->input->post('_id', true)) {
      
      $data['title'] = 'Update Topic';
      $ssp_topik_id = $this->input->post('_id', true);
      
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $kr_id = $data['kr']['kr_id'];

      $data['ssp'] = $this->db->query(
        "SELECT *
        FROM ssp_topik 
        WHERE ssp_topik_id = $ssp_topik_id")->row_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('ssp_topik_crud/update',$data);
      $this->load->view('templates/footer');

    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
    
  }
}

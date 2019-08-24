<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konselor_CRUD extends CI_Controller
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
    if($this->session->userdata('kr_jabatan_id')!=5 && !$this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){
    $data['title'] = 'Select School';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk_all'] = $this->_sk->return_all();


    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('konselor_crud/index',$data);
    $this->load->view('templates/footer');
  }
  public function add(){

    $sk_id = $this->input->post('sk_id', true);
    if ($sk_id) {
      $data['title'] = 'Select Employee';

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kr_all'] = $this->_kr->return_all_teacher();
      $data['sk_id'] = $sk_id;

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('konselor_crud/add',$data);
      $this->load->view('templates/footer');
    }
  }
 
  public function proses_add(){

    $sk_id = $this->input->post('sk_id', true);

    if (!$sk_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{
      $data = [
        'konselor_kr_id' => $this->input->post('kr_id'),
        'konselor_sk_id' => $this->input->post('sk_id')
      ];
  
      $this->db->insert('konselor', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Counselor Added!</div>');
      redirect('Konselor_CRUD');
    }

  }

  public function edit(){
    
    $konselor_id = $this->input->post('konselor_id', true);

    if(!$konselor_id){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['konselor'] = $this->db->query(
      "SELECT *
      FROM konselor
      WHERE konselor_id = $konselor_id")->row_array();

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['kr_all'] = $this->_kr->return_all_teacher();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Konselor_CRUD/edit',$data);
    $this->load->view('templates/footer');

  }

  public function edit_proses(){
    if($this->input->post('konselor_id', true)){
      $data = [
        'konselor_kr_id' => $this->input->post('kr_id')
      ];

      //simpan ke db

      $this->db->where('konselor_id', $this->input->post('konselor_id', true));
      $this->db->update('konselor', $data); 
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Counselor Updated!</div>');
      redirect('Konselor_CRUD');
    }
  }

  public function delete_proses(){
    $konselor_id = $this->input->post('konselor_id', true);
    if ($konselor_id) {
      $this->db->where('konselor_id', $konselor_id);
      $this->db->delete('konselor');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Counselor Deleted!</div>');
      redirect('Konselor_CRUD');
    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }
}

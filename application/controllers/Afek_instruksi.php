<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Afek_instruksi extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_sk');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');


    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan guru dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=8 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'Affective Score Instruction';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk'] = $this->_sk->find_sk_nama($this->session->userdata('kr_sk_id'));
    

    //var_dump($this->db->last_query());
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('afek_instruksi/index',$data);
    $this->load->view('templates/footer');

  }

  public function input(){
  
    if($this->input->post('sk_instruksi_afek_1',true)){
      $sk_id = $this->session->userdata('kr_sk_id');
      $data = [
        'sk_instruksi_afek1' => $this->input->post('sk_instruksi_afek_1',true),
        'sk_instruksi_afek2' => $this->input->post('sk_instruksi_afek_2',true),
        'sk_instruksi_afek3' => $this->input->post('sk_instruksi_afek_3',true)
      ];
  
      $this->db->where('sk_id',$sk_id);
      $this->db->update('sk', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Instruction Updated!</div>');
      redirect('Afek_instruksi');
    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
    
  }
  
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kadiv_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_sk');
    $this->load->model('_t');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=5 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    redirect('Profile');

  }

  public function ujian(){

    $sk_count = $this->db->count_all('sk');

    if($sk_count == 0){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Please inform ADMIN to add school first!</div>');
      redirect('Profile');
    }

    $data['title'] = 'Mid and Final';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk_all'] = $this->_sk->return_all();
    $data['t_all'] = $this->_t->return_all();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Kadiv_CRUD/ujian_list',$data);
    $this->load->view('templates/footer');
	
  }

  public function tes(){

    $sk_count = $this->db->count_all('sk');

    if($sk_count == 0){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Please inform ADMIN to add school first!</div>');
      redirect('Profile');
    }

    $data['title'] = 'Cognitive and Psychomotor';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk_all'] = $this->_sk->return_all();
    $data['t_all'] = $this->_t->return_all();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Kadiv_CRUD/tes_list',$data);
    $this->load->view('templates/footer');
	
  }

  public function last_login(){

    $data['title'] = 'Login Activity';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['kr_all'] = $this->db->query(
      "SELECT kr_nama_depan, kr_nama_belakang, kr_last_login, sk_nama, kr_last_login_ip
      FROM kr
      LEFT JOIN sk ON kr_sk_id = sk_id
      ORDER BY kr_last_login DESC")->result_array();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Kadiv_CRUD/last_login',$data);
    $this->load->view('templates/footer');
  }

}

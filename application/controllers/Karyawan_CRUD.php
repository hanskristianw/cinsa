<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=3 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'Employee List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['kr_all'] = $this->_kr->return_all();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('karyawan_crud/index',$data);
    $this->load->view('templates/footer');
    
  }

  public function add(){

    $data['title'] = 'Create Employee';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_username($this->session->userdata('kr_username'));

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('karyawan_crud/add',$data);
    $this->load->view('templates/footer');
    
  }

}
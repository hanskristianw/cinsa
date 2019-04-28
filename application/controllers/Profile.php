<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('auth');
    }
  }

  public function index(){
    $data['title'] = 'Employee Profile';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    
    
    
    $data['jabatan'] = $this->_kr->find_jabatan_by_kr_id($this->session->userdata('kr_id'));

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('profile/index',$data);
    $this->load->view('templates/footer');
  }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    
    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('auth');
    }

    //jika bukan admin dan sudah login redirect ke profile
    if($this->session->userdata('kr_jabatan_id')!=1 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){
    $data['title'] = 'Admin';
    $data['kr'] = $this->db->get_where('kr', ['kr_username'=>$this->session->userdata('kr_username')])->row_array();
    
    
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('admin/index',$data);
    $this->load->view('templates/footer');
  }
}
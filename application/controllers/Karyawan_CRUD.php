<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    
    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('auth');
    }

    //jika bukan karyawan dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=3 && $this->session->userdata('kr_jabatan_id')){
      redirect('Home');
    }
  }

  public function index(){
    $data['title'] = 'Employee Master';
    $data['kr'] = $this->db->get_where('kr', ['kr_username'=>$this->session->userdata('kr_username')])->row_array();
    
    $data['kr_all'] = $this->db->get('kr')->result_array();
    
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('karyawan_crud/index',$data);
    $this->load->view('templates/footer');
  }
}
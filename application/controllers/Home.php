<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    //jika tidak ada jabatan di session
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('auth');
    }
  }

  public function index(){
    $data['title'] = 'Homepage';
    $data['kr'] = $this->db->get_where('kr', ['kr_username'=>$this->session->userdata('kr_username')])->row_array();
    
    
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('home/index',$data);
    $this->load->view('templates/footer');
  }
}
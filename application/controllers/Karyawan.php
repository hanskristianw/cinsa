<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
  public function index(){
    $data['title'] = 'My Profile';
    $data['kr'] = $this->db->get_where('kr', ['kr_username'=>$this->session->userdata('kr_username')])->row_array();
    
    
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('karyawan/index',$data);
    $this->load->view('templates/footer');
  }
}
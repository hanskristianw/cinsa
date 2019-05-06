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

  public function update(){

    $this->form_validation->set_rules('kr_nama_depan', 'First Name', 'required|trim');
		$this->form_validation->set_rules('kr_nama_belakang', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('kr_username', 'Username', 'required|trim|is_unique[kr.kr_username]',['is_unique' => 'This username already exist!']);
		$this->form_validation->set_rules('kr_password1', 'Password', 'required|trim|min_length[3]|matches[kr_password2]',['matches' => 'Password not match', 'min_length' => 'Password too short']);
		$this->form_validation->set_rules('kr_password2', 'Password', 'required|trim|matches[kr_password1]');

		if($this->form_validation->run() == false){
      //set judul
      $data['title'] = 'Update Profile';
      
      //ambil data karyawan yang sedang login
      $data['kr'] = $this->_kr->find_by_id($this->session->userdata('kr_id'));
      
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('profile/update',$data);
      $this->load->view('templates/footer');
    }
  }
}
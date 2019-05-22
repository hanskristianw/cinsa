<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_kelas');
    $this->load->model('_t');
    $this->load->model('_sk');
    $this->load->model('_st');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan wakakur dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 4 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'List of Class';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['kelas_all'] = $this->_kelas->return_all_by_sk($this->session->userdata('kr_sk_id'));

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('kelas_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function add()
  {

    $this->form_validation->set_rules('kelas_nama', 'Kelas Nama', 'required|trim');

    if ($this->form_validation->run() == false) {
      //jika belum ada tahun ajaran sama sekali
      $t_count = $this->db->count_all('t');

      if($t_count == 0){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Please inform ADMIN to year first!</div>');
        redirect('Kelas_CRUD');
      }

      $data['title'] = 'Create Class';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas_all'] = $this->_kelas->return_all();
      $data['tahun_all'] = $this->_t->return_all();
      $data['sk_all'] = $this->_sk->return_all();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('kelas_crud/add', $data);
      $this->load->view('templates/footer');
    }
    else {

      $data = [
        'kelas_nama' => $this->input->post('kelas_nama'),
        'kelas_sk_id' => $this->input->post('kelas_sk_id'),
        'kelas_t_id' => $this->input->post('kelas_t_id')
      ];

      $this->db->insert('kelas', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Class Created!</div>');
      redirect('kelas_crud/add');
    }
  }

  public function update(){
    
    //dari method post
    $kelas_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if(!$kelas_post){
      //ambil id dari method get
      $kelas_get = $this->_kelas->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if(!$kelas_get['kelas_id']){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Kelas_CRUD');
      }
    }
    
    $this->form_validation->set_rules('kelas_nama', 'Kelas Nama', 'required|trim');
    $this->form_validation->set_rules('kelas_t_id', 'Kelas Tahun', 'required');

    if($this->form_validation->run() == false){
      //jika menekan tombol edit
      $data['title'] = 'Update Class Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      
      $data['tahun_all'] = $this->_t->return_all();

      //simpan data primary key
      $kelas_id = $this->input->get('_id', true);
      
      $data['kelas_update'] = $this->_kelas->find_by_id($kelas_id);
      
      //load view dengan data query
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('kelas_crud/update',$data);
      $this->load->view('templates/footer');
    }
    else{
      //fetch data hasil inputan
      $data = [
        'kelas_nama' => $this->input->post('kelas_nama'),
        'kelas_t_id' => $this->input->post('kelas_t_id')
      ];

      //simpan ke db

      $this->db->where('kelas_id', $this->input->post('_id'));
      $this->db->update('kelas', $data); 
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Class Data Updated!</div>');
      redirect('Kelas_CRUD');
    }

  }
}

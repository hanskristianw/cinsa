<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wakasis_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kelas');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');
    $this->load->model('_t');
    $this->load->model('_siswa');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan guru dan sudah login redirect ke home
    if(wakasis_menu() == 0){
      redirect('Profile');
    }
  }

  public function index(){

  }
  public function jenis(){
    
    $data['title'] = 'Daftar Jenis Pelanggaran';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['j_all'] = $this->db->query(
      "SELECT *
      FROM jenis_pel
      WHERE jenis_pel_sk_id = $sk_id
      ORDER BY jenis_pel_nama ASC")->result_array();

    
    $data['sk'] = $this->db->query(
      "SELECT sk_id, sk_nama
      FROM sk
      WHERE sk_id = $sk_id")->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Wakasis_CRUD/jenis', $data);
    $this->load->view('templates/footer');
  }

  public function add_jenis(){

    $data['title'] = 'Tambah Jenis Pelanggaran';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['sk_id'] = $this->session->userdata('kr_sk_id');
    $sk_id = $this->session->userdata('kr_sk_id');

    $data['sk'] = $this->db->query(
      "SELECT sk_id, sk_nama
      FROM sk
      WHERE sk_id = $sk_id")->row_array();
      
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Wakasis_CRUD/add_jenis', $data);
    $this->load->view('templates/footer');
  }
  public function add_jenis_proses(){

    $sk_id = $this->input->post('sk_id', true);
    $jenis_pel_nama = $this->input->post('jenis_pel_nama', true);

    if (!$sk_id || !$jenis_pel_nama) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{
      $data = [
        'jenis_pel_sk_id' => $sk_id,
        'jenis_pel_nama' => $jenis_pel_nama
      ];
  
      $this->db->insert('jenis_pel', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Jenis pelanggaran berhasil ditambah!</div>');
      redirect('Wakasis_CRUD/jenis');
    }
  }

  public function edit_jenis(){

    $jenis_pel_id = $this->input->post('jenis_pel_id', true);

    if($jenis_pel_id){

      $data['title'] = 'Edit Jenis Pelanggaran';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
  
      $data['sk_id'] = $this->session->userdata('kr_sk_id');
      $sk_id = $this->session->userdata('kr_sk_id');
  
      $data['sk'] = $this->db->query(
        "SELECT sk_id, sk_nama
        FROM sk
        WHERE sk_id = $sk_id")->row_array();

      $data['jenis_pel'] = $this->db->query(
        "SELECT *
        FROM jenis_pel
        WHERE jenis_pel_id = $jenis_pel_id")->row_array();
        
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Wakasis_CRUD/edit_jenis', $data);
      $this->load->view('templates/footer');
    }

  }

  public function edit_jenis_proses(){

    $jenis_pel_id = $this->input->post('jenis_pel_id', true);

    if (!$jenis_pel_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{
      $jenis_pel_nama = $this->input->post('jenis_pel_nama', true);

      $data = [
        'jenis_pel_nama' => $jenis_pel_nama
      ];
  
      $this->db->where('jenis_pel_id', $jenis_pel_id);
      $this->db->update('jenis_pel', $data);
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Jenis pelanggaran berhasil dirubah!</div>');
      redirect('Wakasis_CRUD/jenis');
    }
  }

  public function pelanggaran(){
    
    $data['title'] = 'Daftar Kategori Pelanggaran';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['p_all'] = $this->db->query(
      "SELECT *
      FROM pelanggaran
      WHERE pelanggaran_sk_id = $sk_id
      ORDER BY pelanggaran_nama ASC")->result_array();

    
    $data['sk'] = $this->db->query(
      "SELECT sk_id, sk_nama
      FROM sk
      WHERE sk_id = $sk_id")->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Wakasis_CRUD/pelanggaran', $data);
    $this->load->view('templates/footer');
  }

  public function add(){

    $data['title'] = 'Tambah Kategori Pelanggaran';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['sk_id'] = $this->session->userdata('kr_sk_id');
    $sk_id = $this->session->userdata('kr_sk_id');

    $data['sk'] = $this->db->query(
      "SELECT sk_id, sk_nama
      FROM sk
      WHERE sk_id = $sk_id")->row_array();
      
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Wakasis_CRUD/add', $data);
    $this->load->view('templates/footer');
  }

  public function add_proses(){

    $sk_id = $this->input->post('sk_id', true);
    $pelanggaran_nama = $this->input->post('pelanggaran_nama', true);

    if (!$sk_id || !$pelanggaran_nama) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{
      $data = [
        'pelanggaran_sk_id' => $sk_id,
        'pelanggaran_nama' => $pelanggaran_nama
      ];
  
      $this->db->insert('pelanggaran', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Kategori pelanggaran berhasil ditambah!</div>');
      redirect('Wakasis_CRUD/pelanggaran');
    }
  }

  public function edit(){

    $pelanggaran_id = $this->input->post('pelanggaran_id', true);

    if($pelanggaran_id){

      $data['title'] = 'Edit Kategori Pelanggaran';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
  
      $data['sk_id'] = $this->session->userdata('kr_sk_id');
      $sk_id = $this->session->userdata('kr_sk_id');
  
      $data['sk'] = $this->db->query(
        "SELECT sk_id, sk_nama
        FROM sk
        WHERE sk_id = $sk_id")->row_array();

      $data['pelanggaran'] = $this->db->query(
        "SELECT *
        FROM pelanggaran
        WHERE pelanggaran_id = $pelanggaran_id")->row_array();
        
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Wakasis_CRUD/edit', $data);
      $this->load->view('templates/footer');
    }

  }

  public function edit_proses(){

    $pelanggaran_id = $this->input->post('pelanggaran_id', true);

    if (!$pelanggaran_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{
      $pelanggaran_nama = $this->input->post('pelanggaran_nama', true);

      $data = [
        'pelanggaran_nama' => $pelanggaran_nama
      ];
  
      $this->db->where('pelanggaran_id', $pelanggaran_id);
      $this->db->update('pelanggaran', $data);
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Kategori pelanggaran berhasil dirubah!</div>');
      redirect('Wakasis_CRUD/pelanggaran');
    }
  }

}

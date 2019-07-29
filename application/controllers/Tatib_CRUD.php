<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tatib_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_k_afek');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_sk');
    $this->load->model('_d_s');
    $this->load->model('_t');

    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 8 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Infraction & Achievement';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['t_all'] = $this->_t->return_all();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('tatib_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function get_kelas(){
    if($this->input->post('id',TRUE)){
    
      $t_id = $this->input->post('id',TRUE);
      $sk_id = $this->session->userdata('kr_sk_id');
      
      //temukan jenjang id pada kelas itu
      $data = $this->db->query(
        "SELECT kelas_id, kelas_nama
        FROM kelas
        WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id
        ORDER BY kelas_nama")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function get_siswa(){
    if($this->input->post('id',TRUE)){
    
      $kelas_id = $this->input->post('id',TRUE);
      
      //temukan jenjang id pada kelas itu
      $data = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE d_s_kelas_id = $kelas_id
        ORDER BY sis_nama_depan")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }
  public function delete()
  {
    if ($this->input->post('tatib_id',TRUE)) {
      
      $tatib_id = $this->input->post('tatib_id',TRUE);

      $this->db->where('tatib_id', $tatib_id);
      $this->db->delete('tatib');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Delete Success!</div>');
      redirect('Tatib_CRUD');
    } else {

      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }
  public function add()
  {

    if ($this->input->post('siswa_tatib_id',TRUE)) {
      $data['title'] = 'Add Infraction & Achievement';

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['d_s_id'] = $this->input->post('siswa_tatib_id',TRUE);
      $data['sis'] = $this->_d_s->return_nama_by_d_s_id($this->input->post('siswa_tatib_id',TRUE));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Tatib_CRUD/add', $data);
      $this->load->view('templates/footer');
      
    } else {

      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function get_detail_tatib(){
    if($this->input->post('id',TRUE)){
    
      $tatib_d_s_id = $this->input->post('id',TRUE);
      
      //temukan jenjang id pada kelas itu
      $data = $this->db->query(
        "SELECT *
        FROM tatib
        LEFT JOIN d_s ON tatib_d_s_id = d_s_id
        WHERE d_s_id = $tatib_d_s_id ORDER BY tatib_tanggal DESC, tatib_langgar, tatib_jenis")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function add_proses()
  {
    if ($this->input->post('d_s_id',TRUE)) {

      $data = [
        'tatib_langgar' => $this->input->post('langgar_id'),
        'tatib_jenis' => $this->input->post('langgar_jenis'),
        'tatib_tanggal' => $this->input->post('tatib_tgl'),
        'tatib_notes' => $this->input->post('tatib_notes'),
        'tatib_d_s_id' => $this->input->post('d_s_id')
      ];
      
      $this->db->insert('tatib', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Input Success!</div>');
      redirect('Tatib_CRUD');
      
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }
  public function edit_proses()
  {
    if ($this->input->post('tatib_id',TRUE)) {

      $data = [
        'tatib_langgar' => $this->input->post('langgar_id'),
        'tatib_jenis' => $this->input->post('langgar_jenis'),
        'tatib_tanggal' => $this->input->post('tatib_tgl'),
        'tatib_notes' => $this->input->post('tatib_notes')
      ];
      
      $this->db->where('tatib_id', $this->input->post('tatib_id', true));
      $this->db->update('tatib', $data); 

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Edit Success!</div>');
      redirect('Tatib_CRUD');
      
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function edit()
  {
    if ($this->input->post('tatib_id',TRUE)) {
      $data['title'] = 'Update Infraction & Achievement';

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $tatib_id = $this->input->post('tatib_id',TRUE);
      $data['sis'] = $this->_d_s->return_nama_by_d_s_id($this->input->post('siswa_tatib_id',TRUE));

      $data['tatib_update'] = $this->db->query(
        "SELECT *
        FROM tatib
        WHERE tatib_id = $tatib_id")->row_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Tatib_CRUD/edit', $data);
      $this->load->view('templates/footer');
      
    } else {

      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }
}

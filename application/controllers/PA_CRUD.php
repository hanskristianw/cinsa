<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PA_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    if($this->session->userdata('kr_jabatan_id')!=1 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }

  }

  public function index()
  {

    $data['title'] = 'Kompetensi PA';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['kpi_all'] = $this->db->query(
      "SELECT kompe_pa_id, kompe_pa_nama, GROUP_CONCAT(indi_pa_nama SEPARATOR ';;') as indi_pa_nama
      FROM kompe_pa
      LEFT JOIN indi_pa ON indi_pa_kompe_pa_id = kompe_pa_id
      GROUP BY kompe_pa_id
      ORDER BY kompe_pa_nama"
    )->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('PA_CRUD/index', $data);
    $this->load->view('templates/footer');
  }

  public function add(){
    $data['title'] = 'Tambah Kompetensi';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('PA_CRUD/add', $data);
    $this->load->view('templates/footer');
  }

  public function add_proses(){
    if($this->input->post('kompe_pa_nama')){
      $data = [
        'kompe_pa_nama' => $this->input->post('kompe_pa_nama'),
      ];

      $this->db->insert('kompe_pa', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kompetensi berhasil dibuat!</div>');
      redirect('PA_CRUD/add');
    }
  }

  public function edit(){
    if($this->input->post('kompe_pa_id')){
      $data['title'] = 'Edit Kompetensi PA';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kompe_pa_id = $this->input->post('kompe_pa_id');

      $data['a'] = $this->db->query(
        "SELECT * FROM
        kompe_pa
        WHERE kompe_pa_id = $kompe_pa_id"
      )->row_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('PA_CRUD/edit', $data);
      $this->load->view('templates/footer');
    }else{
      redirect('PA_CRUD');
    }
  }

  public function edit_proses()
  {
    if ($this->input->post('kompe_pa_id')) {

      $data = [
        'kompe_pa_nama' => $this->input->post('kompe_pa_nama')
      ];

      $this->db->where('kompe_pa_id', $this->input->post('kompe_pa_id'));
      $this->db->update('kompe_pa', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kompetensi berhasil diupdate!</div>');
      redirect('PA_CRUD');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function add_indi(){
    if ($this->input->post('kompe_pa_id')) {

      $kompe_pa_id = $this->input->post('kompe_pa_id');
      $cek = $this->db->query(
        "SELECT * FROM
        kompe_pa
        WHERE kompe_pa_id = $kompe_pa_id"
      )->row_array();

      $data['all_indi'] = $this->db->query(
        "SELECT * FROM
        indi_pa
        WHERE indi_pa_kompe_pa_id = $kompe_pa_id"
      )->result_array();

      $data['title'] = 'Tambah Indikator '.$cek['kompe_pa_nama'];

      $data['kompe_pa_id'] = $kompe_pa_id;
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('PA_CRUD/add_indi', $data);
      $this->load->view('templates/footer');
    }else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function add_indi_proses(){
    if($this->input->post('kompe_pa_id')){
      $data = [
        'indi_pa_kompe_pa_id' => $this->input->post('kompe_pa_id'),
        'indi_pa_nama' => $this->input->post('indi_pa_nama'),
      ];

      $this->db->insert('indi_pa', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Indikator berhasil dibuat!</div>');
      redirect('PA_CRUD');
    }
  }

  public function edit_indi(){
    if ($this->input->post('indi_pa_id')) {

      $indi_pa_id = $this->input->post('indi_pa_id');
      $data['indi'] = $this->db->query(
        "SELECT * FROM
        indi_pa
        WHERE indi_pa_id = $indi_pa_id"
      )->row_array();


      $data['title'] = 'Edit Indikator';
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('PA_CRUD/edit_indi', $data);
      $this->load->view('templates/footer');
    }else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function edit_indi_proses()
  {
    if ($this->input->post('indi_pa_id')) {

      $data = [
        'indi_pa_nama' => $this->input->post('indi_pa_nama')
      ];

      $this->db->where('indi_pa_id', $this->input->post('indi_pa_id'));
      $this->db->update('indi_pa', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Indikator berhasil diupdate!</div>');
      redirect('PA_CRUD');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

}

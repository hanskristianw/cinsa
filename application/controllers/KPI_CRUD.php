<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KPI_CRUD extends CI_Controller
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
    if($this->input->get('jabatan_kpi_id')){

      $jabatan_kpi_id = $this->input->get('jabatan_kpi_id');

      $cek = $this->db->query(
        "SELECT COUNT(*) AS jum
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id"
      )->row_array();

      if($cek['jum'] == 0){
        redirect('Profile');
      }

      $jb = $this->db->query(
        "SELECT jabatan_kpi_nama
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id"
      )->row_array();

      $data['title'] = 'Kompetensi KPI untuk '.$jb['jabatan_kpi_nama'];
      $data['jabatan_kpi_id'] = $jabatan_kpi_id;

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['kpi_all'] = $this->db->query(
        "SELECT kompe_kpi_id, kompe_kpi_nama, GROUP_CONCAT(indi_kpi_nama SEPARATOR ';;') as indi_kpi_nama, kompe_kpi_bobot
        FROM kompe_kpi
        LEFT JOIN indi_kpi ON indi_kpi_kompe_kpi_id = kompe_kpi_id
        WHERE kompe_kpi_jabatan_kpi_id = $jabatan_kpi_id
        GROUP BY kompe_kpi_id
        ORDER BY kompe_kpi_id"
      )->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('KPI_CRUD/index', $data);
      $this->load->view('templates/footer');
    }else {
      redirect('Profile');
    }
  }

  public function add(){
    if($this->input->post('jabatan_kpi_id')){

      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id');
      $jb = $this->db->query(
        "SELECT jabatan_kpi_nama
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id"
      )->row_array();

      $data['title'] = 'Tambah Kompetensi KPI '.$jb['jabatan_kpi_nama'];

      $data['jabatan_kpi_id'] = $this->input->post('jabatan_kpi_id');
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('KPI_CRUD/add', $data);
      $this->load->view('templates/footer');
    }
  }

  public function add_proses(){
    if($this->input->post('kompe_kpi_nama')){
      $data = [
        'kompe_kpi_nama' => $this->input->post('kompe_kpi_nama'),
        'kompe_kpi_bobot' => $this->input->post('kompe_kpi_bobot'),
        'kompe_kpi_jabatan_kpi_id' => $this->input->post('jabatan_kpi_id'),
      ];

      $this->db->insert('kompe_kpi', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kompetensi berhasil dibuat!</div>');
      redirect('KPI_CRUD?jabatan_kpi_id='.$this->input->post('jabatan_kpi_id'));
    }
  }

  public function edit(){
    if($this->input->post('kompe_kpi_id')){
      $data['title'] = 'Edit Kompetensi KPI';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kompe_kpi_id = $this->input->post('kompe_kpi_id');
      $data['jabatan_kpi_id'] = $this->input->post('jabatan_kpi_id');

      $data['a'] = $this->db->query(
        "SELECT * FROM
        kompe_kpi
        WHERE kompe_kpi_id = $kompe_kpi_id"
      )->row_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('KPI_CRUD/edit', $data);
      $this->load->view('templates/footer');
    }else{
      redirect('KPI_CRUD');
    }
  }

  public function edit_proses()
  {
    if ($this->input->post('kompe_kpi_id')) {

      $data = [
        'kompe_kpi_nama' => $this->input->post('kompe_kpi_nama'),
        'kompe_kpi_bobot' => $this->input->post('kompe_kpi_bobot'),
      ];

      $this->db->where('kompe_kpi_id', $this->input->post('kompe_kpi_id'));
      $this->db->update('kompe_kpi', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Kompetensi berhasil diupdate!</div>');
      redirect('KPI_CRUD?jabatan_kpi_id='.$this->input->post('jabatan_kpi_id'));
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function add_indi(){
    if ($this->input->post('kompe_kpi_id')) {

      $kompe_kpi_id = $this->input->post('kompe_kpi_id');
      $cek = $this->db->query(
        "SELECT * FROM
        kompe_kpi
        WHERE kompe_kpi_id = $kompe_kpi_id"
      )->row_array();

      $data['all_indi'] = $this->db->query(
        "SELECT * FROM
        indi_kpi
        WHERE indi_kpi_kompe_kpi_id = $kompe_kpi_id"
      )->result_array();

      $data['title'] = 'Tambah Indikator '.$cek['kompe_kpi_nama'];

      $data['kompe_kpi_id'] = $kompe_kpi_id;
      $data['jabatan_kpi_id'] = $this->input->post('jabatan_kpi_id');
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('KPI_CRUD/add_indi', $data);
      $this->load->view('templates/footer');
    }else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function add_indi_proses(){
    if($this->input->post('kompe_kpi_id')){
      $data = [
        'indi_kpi_kompe_kpi_id' => $this->input->post('kompe_kpi_id'),
        'indi_kpi_nama' => $this->input->post('indi_kpi_nama'),
        'indi_kpi_target' => $this->input->post('indi_kpi_target'),
        'indi_kpi_bobot' => $this->input->post('indi_kpi_bobot'),
      ];

      $this->db->insert('indi_kpi', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Indikator berhasil dibuat!</div>');
      redirect('KPI_CRUD?jabatan_kpi_id='.$this->input->post('jabatan_kpi_id'));
    }
  }

  public function edit_indi(){
    if ($this->input->post('indi_kpi_id')) {

      $indi_kpi_id = $this->input->post('indi_kpi_id');
      $data['indi'] = $this->db->query(
        "SELECT * FROM
        indi_kpi
        WHERE indi_kpi_id = $indi_kpi_id"
      )->row_array();

      $data['jabatan_kpi_id'] = $this->input->post('jabatan_kpi_id');
      $data['title'] = 'Edit Indikator';
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('KPI_CRUD/edit_indi', $data);
      $this->load->view('templates/footer');
    }else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function edit_indi_proses()
  {
    if ($this->input->post('indi_kpi_id')) {

      $data = [
        'indi_kpi_nama' => $this->input->post('indi_kpi_nama'),
        'indi_kpi_target' => $this->input->post('indi_kpi_target'),
        'indi_kpi_bobot' => $this->input->post('indi_kpi_bobot'),
      ];

      $this->db->where('indi_kpi_id', $this->input->post('indi_kpi_id'));
      $this->db->update('indi_kpi', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Indikator berhasil diupdate!</div>');
      redirect('KPI_CRUD?jabatan_kpi_id='.$this->input->post('jabatan_kpi_id'));
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

}

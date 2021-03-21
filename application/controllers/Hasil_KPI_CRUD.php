<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hasil_KPI_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    if(kpi_menu()<=0 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }

  }

  public function index()
  {
    $data['title'] = 'Laporan Hasil KPI dan PA';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $kr_id = $this->session->userdata('kr_id');

    //cari jabatan user apa
    $data['jab_all'] = $this->db->query(
      "SELECT jabatan_kpi_id, jabatan_kpi_nama
      FROM d_jabatan_kpi
      LEFT JOIN jabatan_kpi ON jabatan_kpi_id = d_jabatan_kpi_jabatan_kpi_id
      WHERE d_jabatan_kpi_kr_id = $kr_id"
    )->result_array();

    $data['t_all'] = $this->db->query(
      "SELECT *
      FROM t
      ORDER BY t_nama DESC"
    )->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Hasil_KPI_CRUD/index', $data);
    $this->load->view('templates/footer');

  }

  public function get_jabatan_dinilai(){
    if($this->input->post('jabatan_kpi_id', true)){
      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id', true);

      $data = $this->db->query(
        "SELECT jabatan_kpi_id, jabatan_kpi_nama
        FROM lap
        LEFT JOIN jabatan_kpi ON jabatan_kpi_id = lap_jabatan_kpi_dilihat
        WHERE lap_jabatan_kpi_melihat = $jabatan_kpi_id")->result();

      echo json_encode($data);

    }
  }

  public function show(){
    if($this->input->post('kr_id', true)){
      $data['title'] = 'Laporan Hasil KPI dan PA';

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['kr_id'] = $this->input->post('kr_id', true);
      $data['t_id'] = $this->input->post('t_id', true);

      $t_id = $this->input->post('t_id', true);

      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id', true);

      $data['jab'] = $this->db->query(
        "SELECT jabatan_kpi_id, jabatan_kpi_nama
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id"
      )->row_array();

      $data['per'] = $this->db->query(
        "SELECT *
        FROM persen_master WHERE persen_master_t_id = $t_id"
      )->row_array();

      if(!$data['per']){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Persentase master belum diset untuk tahun ini, hubungi admin!</div>');
        redirect('Hasil_KPI_CRUD');
      }

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hasil_KPI_CRUD/show', $data);
      $this->load->view('templates/footer');

    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Pilih setidaknya 1 karyawan!</div>');
      redirect('Hasil_KPI_CRUD');
    }
  }


}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Lihat_nilai_kpi extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    if(cek_nilai_kpi_ada()==0){
      redirect('Profile');
    }

  }

  public function index()
  {

    $data['title'] = 'Pilih tahun ajaran';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $kr_id = $this->session->userdata('kr_id');

    //data karyawan untuk konten
    $data['jabatan'] = $this->db->query(
      "SELECT DISTINCT jabatan_kpi_id, jabatan_kpi_nama, t_id, t_nama
      FROM nilai_kpi
      LEFT JOIN d_jabatan_kpi ON d_jabatan_kpi_kr_id = nilai_kpi_dinilai_kr_id
      LEFT JOIN jabatan_kpi ON jabatan_kpi_id = d_jabatan_kpi_jabatan_kpi_id
      LEFT JOIN t ON nilai_kpi_t_id = t_id
      WHERE nilai_kpi_dinilai_kr_id = $kr_id
      ORDER BY t_nama DESC"
    )->result_array();

    //var_dump($data['jabatan']);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Lihat_nilai_kpi/index', $data);
    $this->load->view('templates/footer');
  }

  public function proses()
  {

    $jabatan = $this->input->post('jabatan', true);

    if($jabatan){
      $data['title'] = 'Hasil KPI dan PA';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $ex = explode("^", $jabatan);

      $t_id = $ex[0];
      $jabatan_kpi_id = $ex[1];
      $kr_id = $this->session->userdata('kr_id');

      $data['jab'] = $this->db->query(
        "SELECT jabatan_kpi_id, jabatan_kpi_nama
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id"
      )->row_array();

      $data['kr_id'] = $kr_id;
      $data['t_id'] = $t_id;

      $data['per'] = $this->db->query(
        "SELECT *
        FROM persen_master WHERE persen_master_t_id = $t_id"
      )->row_array();

      if(!$data['per']){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Gagal, persentase master belum diset untuk tahun ini, hubungi admin!</div>');
        redirect('Lihat_nilai_kpi');
      }

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hasil_KPI_CRUD/show', $data);
      $this->load->view('templates/footer');

    }

  }

}

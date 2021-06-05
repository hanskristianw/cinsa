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

    if(kpi_menu()==0 && cek_nilai_kpi_ada() == 0){
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

  public function rata(){

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['title'] = 'Laporan Hasil PA '. $data['kr']['kr_nama_depan'].' '. $data['kr']['kr_nama_belakang'];

    $kr_id = $this->session->userdata('kr_id');

    // //cari jabatan user apa
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
    $this->load->view('Hasil_KPI_CRUD/rata', $data);
    $this->load->view('templates/footer');
  }

  public function rata_show(){
    if($this->input->post('t_id', true)){

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['title'] = 'Laporan Hasil PA '. $data['kr']['kr_nama_depan'].' '. $data['kr']['kr_nama_belakang'];

      $data['nama'] = $data['kr']['kr_nama_depan'].' '. $data['kr']['kr_nama_belakang'];

      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id', true);
      $t_id = $this->input->post('t_id', true);
      $kr_id = $this->session->userdata('kr_id');

      $penilai_query = $this->db->query(
        "SELECT GROUP_CONCAT(kr_id) as kr_id
        FROM(
          SELECT kr_id, kr_nama_depan, kr_nama_belakang
          FROM nilai_pa
          LEFT JOIN indi_pa ON nilai_pa_indi_pa_id = indi_pa_id
          LEFT JOIN kompe_pa ON kompe_pa_id = indi_pa_kompe_pa_id
          LEFT JOIN kr ON nilai_pa_penilai_kr_id = kr_id
          WHERE nilai_pa_dinilai_kr_id = $kr_id AND kompe_pa_jabatan_kpi_id = $jabatan_kpi_id AND kompe_pa_t_id = $t_id
          GROUP BY kr_id
          ORDER BY kr_nama_depan
        ) as a
        ")->row_array();

      $penilai = $penilai_query['kr_id'];

      $data['dinilai_all'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang
        FROM kr
        WHERE kr_id = $kr_id
        ")->row_array();

      $data['t_id'] = $t_id;

      $data['jabatan_kpi'] = $this->db->query(
        "SELECT jabatan_kpi_id, jabatan_kpi_nama
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id")->row_array();

      $data['penilai_all'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang
        FROM kr
        WHERE kr_id IN ($penilai)
        ORDER BY kr_nama_depan")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hasil_KPI_CRUD/rata_show', $data);
      $this->load->view('templates/footer');


    }else{
      redirect('Profile');
    }
  }


}

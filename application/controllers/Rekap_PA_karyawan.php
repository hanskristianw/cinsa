<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rekap_PA_karyawan extends CI_Controller
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

    $data['title'] = 'Pilih Tahun Ajaran';

    $data['t_all'] = $this->db->query(
                    "SELECT t_id, t_nama
                    FROM t
                    ORDER BY t_nama DESC"
                  )->result_array();

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Rekap_PA_karyawan/index', $data);
    $this->load->view('templates/footer');

  }

  public function view_kr(){

    if($this->input->post('t_id')){

      $data['title'] = 'Pilih Karyawan';

      $t_id = $this->input->post('t_id');

      $data['t_id'] = $t_id;

      $data['sk_all'] = $this->db->query(
        "SELECT sk_id, sk_nama
        FROM sk
        ORDER BY sk_nama"
      )->result_array();

      $data['kr_all'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang
        FROM nilai_pa
        LEFT JOIN kr ON kr_id = nilai_pa_dinilai_kr_id
        WHERE nilai_pa_t_id = $t_id
        GROUP BY kr_id
        ORDER BY kr_nama_depan"
      )->result_array();

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Rekap_PA_karyawan/view_kr', $data);
      $this->load->view('templates/footer');
    }
    else {
      redirect('Profile');
    }

  }

  public function hasil(){
    if($this->input->post('kr_penilai[]')){

      $penilai = implode (", ", $this->input->post('kr_penilai[]', true));
      $dinilai = $this->input->post('kr_dinilai', true);
      $data['t_id'] = $this->input->post('t_id', true);
      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id', true);

      $data['title'] = 'Laporan PA';
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['jabatan_kpi'] = $this->db->query(
        "SELECT jabatan_kpi_id, jabatan_kpi_nama
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id")->row_array();

      $data['penilai_all'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang
        FROM kr
        WHERE kr_id IN ($penilai)
        ORDER BY kr_nama_depan")->result_array();

      $data['dinilai_all'] = $this->db->query(
        "SELECT kr_gelar_depan, kr_gelar_belakang, kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
        FROM kr
        LEFT JOIN sk ON kr_sk_id = sk_id
        WHERE kr_id = $dinilai
        ORDER BY kr_nama_depan")->row_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Rekap_PA_karyawan/hasil', $data);
      $this->load->view('templates/footer');
    }


  }

  public function get_jabatan_by_karyawan(){
    if($this->input->post('kr_id')){
      $kr_id = $this->input->post('kr_id', true);
      $t_id = $this->input->post('t_id', true);

      $data = $this->db->query(
        "SELECT jabatan_kpi_id, jabatan_kpi_nama
          FROM nilai_pa
          LEFT JOIN indi_pa ON indi_pa_id = nilai_pa_indi_pa_id
          LEFT JOIN kompe_pa ON kompe_pa_id = indi_pa_kompe_pa_id
          LEFT JOIN jabatan_kpi ON jabatan_kpi_id = kompe_pa_jabatan_kpi_id
          WHERE nilai_pa_t_id = $t_id AND nilai_pa_dinilai_kr_id = $kr_id
          GROUP BY jabatan_kpi_id
          ORDER BY jabatan_kpi_nama")->result();

      echo json_encode($data);
    }
  }

  public function get_penilai(){
    if($this->input->post('kr_id')){

      $kr_id = $this->input->post('kr_id');
      $jabatan_dinilai = $this->input->post('jabatan_kpi_id');
      $t_id = $this->input->post('t_id');


      $data = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang
        FROM nilai_pa
        LEFT JOIN indi_pa ON nilai_pa_indi_pa_id = indi_pa_id
        LEFT JOIN kompe_pa ON kompe_pa_id = indi_pa_kompe_pa_id
        LEFT JOIN kr ON nilai_pa_penilai_kr_id = kr_id
        WHERE nilai_pa_dinilai_kr_id = $kr_id AND kompe_pa_jabatan_kpi_id = $jabatan_dinilai AND kompe_pa_t_id = $t_id
        GROUP BY kr_id
        ORDER BY kr_nama_depan")->result();

      echo json_encode($data);
    }
  }


}

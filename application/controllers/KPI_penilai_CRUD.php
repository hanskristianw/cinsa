<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KPI_penilai_CRUD extends CI_Controller
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
    $data['title'] = 'Kompetensi KPI';

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
    $this->load->view('KPI_penilai_CRUD/index', $data);
    $this->load->view('templates/footer');
  }

  public function get_jabatan_dinilai(){
    if($this->input->post('jabatan_kpi_id', true)){
      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id', true);

      $data = $this->db->query(
        "SELECT jabatan_kpi_id, jabatan_kpi_nama
        FROM dkpi
        LEFT JOIN jabatan_kpi ON jabatan_kpi_id = dkpi_responden_jabatan_kpi_id
        WHERE dkpi_penilai_jabatan_kpi_id = $jabatan_kpi_id")->result();

      echo json_encode($data);

    }
  }

  public function get_guru_dinilai(){
    if($this->input->post('jabatan_kpi_id', true)){
      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id', true);

      $data = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
        FROM d_jabatan_kpi
        LEFT JOIN kr ON kr_id = d_jabatan_kpi_kr_id
        LEFT JOIN sk ON kr_sk_id = sk_id
        WHERE d_jabatan_kpi_jabatan_kpi_id = $jabatan_kpi_id
        ORDER BY kr_nama_depan")->result();

      echo json_encode($data);

    }
  }

  public function input(){
    if($this->input->post('jabatan_kpi_id')){

      $t_id = $this->input->post('t_id');
      $kr_penilai = $this->session->userdata('kr_id');
      $kr_dinilai = $this->input->post('kr_id');
      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id');

      $data['title'] = 'Nilai KPI';
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['t_id'] = $t_id;

      $data['kr_dinilai'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
        FROM kr
        LEFT JOIN sk ON kr_sk_id = sk_id
        WHERE kr_id = $kr_dinilai"
      )->row_array();

      $data['kr_penilai'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
        FROM kr
        LEFT JOIN sk ON kr_sk_id = sk_id
        WHERE kr_id = $kr_penilai"
      )->row_array();

      $data['jab'] = $this->db->query(
        "SELECT jabatan_kpi_id, jabatan_kpi_nama
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id"
      )->row_array();

      //cek dulu apakah nilai sudah ada
      //yang dinilai, penilai, tahun, dengan jabatan
      $cek_nilai = $this->db->query(
        "SELECT nilai_kpi_id, kompe_kpi_nama, indi_kpi_nama, indi_kpi_target, nilai_kpi_hasil
        FROM nilai_kpi
        LEFT JOIN indi_kpi ON indi_kpi_id = nilai_kpi_indi_kpi_id
        LEFT JOIN kompe_kpi ON kompe_kpi_id = indi_kpi_kompe_kpi_id
        WHERE nilai_kpi_t_id = $t_id AND nilai_kpi_penilai_kr_id = $kr_penilai AND nilai_kpi_dinilai_kr_id = $kr_dinilai
        ORDER BY kompe_kpi_id, indi_kpi_id"
      )->result_array();

      if($cek_nilai){
        //sudah ada nilai

        $data['update'] = $cek_nilai;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('KPI_penilai_CRUD/update', $data);
        $this->load->view('templates/footer');
      }
      else{
        //belum ada nilai

        $data['indi'] = $this->db->query(
          "SELECT indi_kpi_nama, indi_kpi_target, kompe_kpi_nama, indi_kpi_id
          FROM indi_kpi
          LEFT JOIN kompe_kpi ON indi_kpi_kompe_kpi_id = kompe_kpi_id
          WHERE kompe_kpi_jabatan_kpi_id = $jabatan_kpi_id
          ORDER BY kompe_kpi_id, indi_kpi_id"
        )->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('KPI_penilai_CRUD/input', $data);
        $this->load->view('templates/footer');
      }
    }
  }

  public function input_proses(){
    if($this->input->post('indi_kpi_id[]')){
      $data = array();
      $indi_kpi_id = $this->input->post('indi_kpi_id[]');
      $t_id = $this->input->post('t_id');
      $nilai_kpi_hasil = $this->input->post('nilai_kpi_hasil[]');
      $nilai_kpi_penilai_kr_id = $this->input->post('nilai_kpi_penilai_kr_id');
      $nilai_kpi_dinilai_kr_id = $this->input->post('nilai_kpi_dinilai_kr_id');

      $cek_nilai = $this->db->query(
        "SELECT nilai_kpi_id, kompe_kpi_nama, indi_kpi_nama, indi_kpi_target, nilai_kpi_hasil
        FROM nilai_kpi
        LEFT JOIN indi_kpi ON indi_kpi_id = nilai_kpi_indi_kpi_id
        LEFT JOIN kompe_kpi ON kompe_kpi_id = indi_kpi_kompe_kpi_id
        WHERE nilai_kpi_t_id = $t_id AND nilai_kpi_penilai_kr_id = $nilai_kpi_penilai_kr_id AND nilai_kpi_dinilai_kr_id = $nilai_kpi_dinilai_kr_id
        ORDER BY kompe_kpi_id, indi_kpi_id"
      )->result_array();

      if($cek_nilai){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Nilai sudah ada!</div>');
        redirect('KPI_penilai_CRUD');
      }

      for($i=0;$i<count($indi_kpi_id);$i++){
          $data[$i] = [
            'nilai_kpi_hasil' => $nilai_kpi_hasil[$i],
            'nilai_kpi_t_id' => $t_id,
            'nilai_kpi_penilai_kr_id' => $nilai_kpi_penilai_kr_id,
            'nilai_kpi_dinilai_kr_id' => $nilai_kpi_dinilai_kr_id,
            'nilai_kpi_indi_kpi_id' => $indi_kpi_id[$i]
          ];
      }

      $this->db->insert_batch('nilai_kpi', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Sukses!</div>');
      redirect('KPI_penilai_CRUD');
    }
  }

  public function update_proses(){
    if($this->input->post('nilai_kpi_id[]')){

      $nilai_kpi_id = $this->input->post('nilai_kpi_id[]');
      $nilai_kpi_hasil = $this->input->post('nilai_kpi_hasil[]');

      for($i=0;$i<count($nilai_kpi_id);$i++){

        $data[$i] = [
          'nilai_kpi_hasil' => $nilai_kpi_hasil[$i],
          'nilai_kpi_id' =>  $nilai_kpi_id[$i]
        ];
      }

      $this->db->update_batch('nilai_kpi',$data, 'nilai_kpi_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Sukses!</div>');
      redirect('KPI_penilai_CRUD');
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
      ];

      $this->db->insert('indi_kpi', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Indikator berhasil dibuat!</div>');
      redirect('KPI_CRUD');
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
      redirect('KPI_CRUD');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

}

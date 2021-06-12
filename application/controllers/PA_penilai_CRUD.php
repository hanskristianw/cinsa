<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PA_penilai_CRUD extends CI_Controller
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

    $cek = $this->db->query(
      "SELECT *
      FROM akses_kpi_pa"
    )->row_array();

    if($cek['akses_pa'] == 0){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Akses penilaian PA sudah ditutup!</div>');
      redirect('Profile');
    }

  }

  public function index()
  {
    $data['title'] = 'Kompetensi PA';

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
    $this->load->view('PA_penilai_CRUD/index', $data);
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


      $data['jabatan_kpi_id'] = $this->input->post('jabatan_kpi_id');

      $data['title'] = 'Nilai PA';
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['t_id'] = $t_id;

      $data['kr_dinilai'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama, kr_google_drive
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
        "SELECT nilai_pa_id, kompe_pa_nama, indi_pa_nama, nilai_pa_hasil
        FROM nilai_pa
        LEFT JOIN indi_pa ON indi_pa_id = nilai_pa_indi_pa_id
        LEFT JOIN kompe_pa ON kompe_pa_id = indi_pa_kompe_pa_id
        WHERE nilai_pa_t_id = $t_id AND nilai_pa_penilai_kr_id = $kr_penilai AND nilai_pa_dinilai_kr_id = $kr_dinilai AND kompe_pa_t_id = $t_id AND kompe_pa_jabatan_kpi_id = $jabatan_kpi_id
        ORDER BY kompe_pa_id, indi_pa_id"
      )->result_array();

      if($cek_nilai){
        //sudah ada nilai

        //cek apakah ada indikator baru yang tidak ada di daftar update
        $data['new_indi'] = $this->db->query(
          "SELECT indi_pa_nama, kompe_pa_nama, indi_pa_id
          FROM indi_pa
          LEFT JOIN kompe_pa ON indi_pa_kompe_pa_id = kompe_pa_id
          WHERE kompe_pa_jabatan_kpi_id = $jabatan_kpi_id  AND kompe_pa_t_id = $t_id
          AND indi_pa_id NOT IN (
            SELECT indi_pa_id
            FROM nilai_pa
            LEFT JOIN indi_pa ON indi_pa_id = nilai_pa_indi_pa_id
            LEFT JOIN kompe_pa ON kompe_pa_id = indi_pa_kompe_pa_id
            WHERE nilai_pa_t_id = $t_id AND nilai_pa_penilai_kr_id = $kr_penilai AND nilai_pa_dinilai_kr_id = $kr_dinilai AND kompe_pa_t_id = $t_id AND kompe_pa_jabatan_kpi_id = $jabatan_kpi_id
          )
          ORDER BY kompe_pa_id, indi_pa_id"
        )->result_array();

        $data['update'] = $cek_nilai;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('PA_penilai_CRUD/update', $data);
        $this->load->view('templates/footer');
      }
      else{
        //belum ada nilai

        $data['indi'] = $this->db->query(
          "SELECT indi_pa_nama, kompe_pa_nama, indi_pa_id
          FROM indi_pa
          LEFT JOIN kompe_pa ON indi_pa_kompe_pa_id = kompe_pa_id
          WHERE kompe_pa_jabatan_kpi_id = $jabatan_kpi_id AND kompe_pa_t_id = $t_id
          ORDER BY kompe_pa_id, indi_pa_id"
        )->result_array();

        if($data['indi']){
          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('templates/topbar', $data);
          $this->load->view('PA_penilai_CRUD/input', $data);
          $this->load->view('templates/footer');
        }else{
          $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Belum terdapat indikator PA, hubungi admin!</div>');
          redirect('PA_penilai_CRUD');
        }

      }
    }
    else {
      $this->session->set_flashdata('message','<div class="alert alert-dange" role="alert">Silahkan akses melalui halaman penilai!</div>');
      redirect('Profile');
    }
  }

  public function input_new_proses(){
    if($this->input->post('indi_pa_id[]')){
      $data = array();
      $indi_pa_id = $this->input->post('indi_pa_id[]');
      $t_id = $this->input->post('t_id');
      $nilai_pa_hasil = $this->input->post('nilai_pa_hasil[]');
      $nilai_pa_penilai_kr_id = $this->input->post('nilai_pa_penilai_kr_id');
      $nilai_pa_dinilai_kr_id = $this->input->post('nilai_pa_dinilai_kr_id');

      $indi_pa_str = "";

      for ($i=0; $i < count($indi_pa_id); $i++) {
        $indi_pa_str .= $indi_pa_id[$i];
        if($i != count($indi_pa_id) - 1){
          $indi_pa_str .= ",";
        }
      }

      //var_dump($indi_kpi_str);

      $cek_nilai = $this->db->query(
        "SELECT indi_pa_id
        FROM nilai_pa
        LEFT JOIN indi_pa ON indi_pa_id = nilai_pa_indi_pa_id
        LEFT JOIN kompe_pa ON kompe_pa_id = indi_pa_kompe_pa_id
        WHERE nilai_pa_t_id = $t_id AND nilai_pa_penilai_kr_id = $nilai_pa_penilai_kr_id AND nilai_pa_dinilai_kr_id = $nilai_pa_dinilai_kr_id AND kompe_pa_t_id = $t_id
        AND indi_pa_id IN ($indi_pa_str)
        ORDER BY kompe_pa_id, indi_pa_id"
      )->result_array();

      // var_dump($cek_nilai);
      //
      // if($cek_nilai)
      //   echo "ada";
      // else
      //   echo "gak ada";


      if($cek_nilai){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Nilai sudah ada</div>');
        redirect('PA_penilai_CRUD');
      }

      for($i=0;$i<count($indi_pa_id);$i++){
          $data[$i] = [
            'nilai_pa_hasil' => $nilai_pa_hasil[$i],
            'nilai_pa_t_id' => $t_id,
            'nilai_pa_penilai_kr_id' => $nilai_pa_penilai_kr_id,
            'nilai_pa_dinilai_kr_id' => $nilai_pa_dinilai_kr_id,
            'nilai_pa_indi_pa_id' => $indi_pa_id[$i]
          ];
      }

      $this->db->insert_batch('nilai_pa', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Nilai Baru Sukses!</div>');
      redirect('PA_penilai_CRUD');
    }
  }

  public function input_proses(){
    if($this->input->post('indi_pa_id[]')){
      $data = array();
      $indi_pa_id = $this->input->post('indi_pa_id[]');
      $t_id = $this->input->post('t_id');
      $nilai_pa_hasil = $this->input->post('nilai_pa_hasil[]');
      $nilai_pa_penilai_kr_id = $this->input->post('nilai_pa_penilai_kr_id');
      $nilai_pa_dinilai_kr_id = $this->input->post('nilai_pa_dinilai_kr_id');


      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id');

      $cek_nilai = $this->db->query(
        "SELECT nilai_pa_id, kompe_pa_nama, indi_pa_nama, nilai_pa_hasil
        FROM nilai_pa
        LEFT JOIN indi_pa ON indi_pa_id = nilai_pa_indi_pa_id
        LEFT JOIN kompe_pa ON kompe_pa_id = indi_pa_kompe_pa_id
        WHERE nilai_pa_t_id = $t_id AND nilai_pa_penilai_kr_id = $nilai_pa_penilai_kr_id AND nilai_pa_dinilai_kr_id = $nilai_pa_dinilai_kr_id
        AND kompe_pa_jabatan_kpi_id = $jabatan_kpi_id
        ORDER BY kompe_pa_id, indi_pa_id"
      )->result_array();

      if($cek_nilai){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Nilai sudah ada!</div>');
        redirect('PA_penilai_CRUD');
      }

      for($i=0;$i<count($indi_pa_id);$i++){
          $data[$i] = [
            'nilai_pa_hasil' => $nilai_pa_hasil[$i],
            'nilai_pa_t_id' => $t_id,
            'nilai_pa_penilai_kr_id' => $nilai_pa_penilai_kr_id,
            'nilai_pa_dinilai_kr_id' => $nilai_pa_dinilai_kr_id,
            'nilai_pa_indi_pa_id' => $indi_pa_id[$i]
          ];
      }

      $this->db->insert_batch('nilai_pa', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Sukses!</div>');
      redirect('PA_penilai_CRUD');
    }
  }

  public function update_proses(){
    if($this->input->post('nilai_pa_id[]')){

      $nilai_pa_id = $this->input->post('nilai_pa_id[]');
      $nilai_pa_hasil = $this->input->post('nilai_pa_hasil[]');

      for($i=0;$i<count($nilai_pa_id);$i++){

        $data[$i] = [
          'nilai_pa_hasil' => $nilai_pa_hasil[$i],
          'nilai_pa_id' =>  $nilai_pa_id[$i]
        ];
      }

      $this->db->update_batch('nilai_pa',$data, 'nilai_pa_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Sukses!</div>');
      redirect('PA_penilai_CRUD');
    }
  }

}

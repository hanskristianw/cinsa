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
      $jabatan_penilai = $this->input->post('jabatan_penilai', true);

      $kr_id = $this->session->userdata('kr_id');

      //cek hak jabatan penilai
      $cek = $this->db->query(
        "SELECT jabatan_kpi_hak_penilai
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_penilai")->row_array();

      if($cek['jabatan_kpi_hak_penilai'] == 1){
        //hanya unit yang sama dengan penilai
        $cek_unit = $this->db->query(
          "SELECT kr_sk_id
          FROM kr
          WHERE kr_id = $kr_id")->row_array();

        $kr_sk_id = $cek_unit['kr_sk_id'];

        //karyawan yang sama dengan penilai
        $data = $this->db->query(
          "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
          FROM d_jabatan_kpi
          LEFT JOIN kr ON kr_id = d_jabatan_kpi_kr_id
          LEFT JOIN sk ON kr_sk_id = sk_id
          WHERE d_jabatan_kpi_jabatan_kpi_id = $jabatan_kpi_id AND kr_sk_id = $kr_sk_id
          ORDER BY kr_nama_depan, kr_nama_belakang")->result();

        //karyawan yang unit tambahannya sama dengan penilai tetapi jabatannya yang dinilai
        $data2 = $this->db->query(
          "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
          FROM d_jabatan_kpi
          LEFT JOIN kr ON kr_id = d_jabatan_kpi_kr_id
          LEFT JOIN sk ON kr_sk_id = sk_id
          LEFT JOIN kr_sk_tam ON kr_sk_tam_kr_id = kr_id
          WHERE d_jabatan_kpi_jabatan_kpi_id = $jabatan_kpi_id AND kr_sk_tam_sk_id = $kr_sk_id
          ORDER BY kr_nama_depan, kr_nama_belakang")->result();

        $query = array_merge($data,$data2);

        echo json_encode($query);

      }else if($cek['jabatan_kpi_hak_penilai'] == 0){
        //semua unit
        $data = $this->db->query(
          "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
          FROM d_jabatan_kpi
          LEFT JOIN kr ON kr_id = d_jabatan_kpi_kr_id
          LEFT JOIN sk ON kr_sk_id = sk_id
          WHERE d_jabatan_kpi_jabatan_kpi_id = $jabatan_kpi_id
          ORDER BY kr_nama_depan, kr_nama_belakang")->result();

        echo json_encode($data);
      }


    }
  }

  public function get_guru_dinilai_laporan(){
    if($this->input->post('jabatan_kpi_id', true)){
      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id', true);
      $jabatan_penilai = $this->input->post('jabatan_penilai', true);

      $kr_id = $this->session->userdata('kr_id');

      //cek hak jabatan penilai
      $cek = $this->db->query(
        "SELECT jabatan_kpi_hak
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_penilai")->row_array();

      if($cek['jabatan_kpi_hak'] == 1){
        //hanya unit yang sama dengan penilai
        $cek_unit = $this->db->query(
          "SELECT kr_sk_id
          FROM kr
          WHERE kr_id = $kr_id")->row_array();

        $kr_sk_id = $cek_unit['kr_sk_id'];

        $data = $this->db->query(
          "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
          FROM d_jabatan_kpi
          LEFT JOIN kr ON kr_id = d_jabatan_kpi_kr_id
          LEFT JOIN sk ON kr_sk_id = sk_id
          WHERE d_jabatan_kpi_jabatan_kpi_id = $jabatan_kpi_id AND kr_sk_id = $kr_sk_id
          ORDER BY kr_nama_depan, kr_nama_belakang")->result();

        //karyawan yang unit tambahannya sama dengan penilai tetapi jabatannya yang dinilai
        $data2 = $this->db->query(
          "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
          FROM d_jabatan_kpi
          LEFT JOIN kr ON kr_id = d_jabatan_kpi_kr_id
          LEFT JOIN sk ON kr_sk_id = sk_id
          LEFT JOIN kr_sk_tam ON kr_sk_tam_kr_id = kr_id
          WHERE d_jabatan_kpi_jabatan_kpi_id = $jabatan_kpi_id AND kr_sk_tam_sk_id = $kr_sk_id
          ORDER BY kr_nama_depan, kr_nama_belakang")->result();

        $query = array_merge($data,$data2);

        echo json_encode($query);
      }else{
        //semua unit
        $data = $this->db->query(
          "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
          FROM d_jabatan_kpi
          LEFT JOIN kr ON kr_id = d_jabatan_kpi_kr_id
          LEFT JOIN sk ON kr_sk_id = sk_id
          WHERE d_jabatan_kpi_jabatan_kpi_id = $jabatan_kpi_id
          ORDER BY kr_nama_depan, kr_nama_belakang")->result();

        echo json_encode($data);
      }


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
        "SELECT nilai_kpi_id, kompe_kpi_nama, indi_kpi_nama, indi_kpi_target, nilai_kpi_hasil
        FROM nilai_kpi
        LEFT JOIN indi_kpi ON indi_kpi_id = nilai_kpi_indi_kpi_id
        LEFT JOIN kompe_kpi ON kompe_kpi_id = indi_kpi_kompe_kpi_id
        WHERE nilai_kpi_t_id = $t_id AND nilai_kpi_penilai_kr_id = $kr_penilai AND nilai_kpi_dinilai_kr_id = $kr_dinilai AND kompe_kpi_t_id = $t_id
        ORDER BY kompe_kpi_id, indi_kpi_id"
      )->result_array();

      if($cek_nilai){
        //sudah ada nilai

        //cek apakah ada indikator baru yang tidak ada di daftar update
        $data['new_indi'] = $this->db->query(
          "SELECT indi_kpi_nama, indi_kpi_target, kompe_kpi_nama, indi_kpi_id
          FROM indi_kpi
          LEFT JOIN kompe_kpi ON indi_kpi_kompe_kpi_id = kompe_kpi_id
          WHERE kompe_kpi_jabatan_kpi_id = $jabatan_kpi_id AND kompe_kpi_t_id = $t_id
          AND indi_kpi_id NOT IN (
            SELECT indi_kpi_id
            FROM nilai_kpi
            LEFT JOIN indi_kpi ON indi_kpi_id = nilai_kpi_indi_kpi_id
            LEFT JOIN kompe_kpi ON kompe_kpi_id = indi_kpi_kompe_kpi_id
            WHERE nilai_kpi_t_id = $t_id AND nilai_kpi_penilai_kr_id = $kr_penilai AND nilai_kpi_dinilai_kr_id = $kr_dinilai AND kompe_kpi_t_id = $t_id
          )
          ORDER BY kompe_kpi_id, indi_kpi_id"
        )->result_array();

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
          WHERE kompe_kpi_jabatan_kpi_id = $jabatan_kpi_id AND kompe_kpi_t_id = $t_id
          ORDER BY kompe_kpi_id, indi_kpi_id"
        )->result_array();

        if($data['indi']){
          $this->load->view('templates/header', $data);
          $this->load->view('templates/sidebar', $data);
          $this->load->view('templates/topbar', $data);
          $this->load->view('KPI_penilai_CRUD/input', $data);
          $this->load->view('templates/footer');
        }else{
          $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Belum terdapat indikator KPI, hubungi admin!</div>');
          redirect('KPI_penilai_CRUD');
        }

      }
    }
  }

  public function input_new_proses(){
    if($this->input->post('indi_kpi_id[]')){
      $data = array();
      $indi_kpi_id = $this->input->post('indi_kpi_id[]');
      $t_id = $this->input->post('t_id');
      $nilai_kpi_hasil = $this->input->post('nilai_kpi_hasil[]');
      $nilai_kpi_penilai_kr_id = $this->input->post('nilai_kpi_penilai_kr_id');
      $nilai_kpi_dinilai_kr_id = $this->input->post('nilai_kpi_dinilai_kr_id');

      $indi_kpi_str = "";

      for ($i=0; $i < count($indi_kpi_id); $i++) {
        $indi_kpi_str .= $indi_kpi_id[$i];
        if($i != count($indi_kpi_id) - 1){
          $indi_kpi_str .= ",";
        }
      }

      //var_dump($indi_kpi_str);

      $cek_nilai = $this->db->query(
        "SELECT indi_kpi_id
        FROM nilai_kpi
        LEFT JOIN indi_kpi ON indi_kpi_id = nilai_kpi_indi_kpi_id
        LEFT JOIN kompe_kpi ON kompe_kpi_id = indi_kpi_kompe_kpi_id
        WHERE nilai_kpi_t_id = $t_id AND nilai_kpi_penilai_kr_id = $nilai_kpi_penilai_kr_id AND nilai_kpi_dinilai_kr_id = $nilai_kpi_dinilai_kr_id  AND kompe_kpi_t_id = $t_id
        AND indi_kpi_id IN ($indi_kpi_str)
        ORDER BY kompe_kpi_id, indi_kpi_id"
      )->result_array();

      // var_dump($cek_nilai);
      //
      // if($cek_nilai)
      //   echo "ada";
      // else
      //   echo "gak ada";


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
        WHERE nilai_kpi_t_id = $t_id AND nilai_kpi_penilai_kr_id = $nilai_kpi_penilai_kr_id AND nilai_kpi_dinilai_kr_id = $nilai_kpi_dinilai_kr_id AND kompe_kpi_t_id = $t_id
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

}

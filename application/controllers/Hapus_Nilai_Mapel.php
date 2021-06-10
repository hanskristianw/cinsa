<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Hapus_Nilai_Mapel extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    if($this->session->userdata('kr_jabatan_id')!=4 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }

  }

  public function ujian_index()
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
    $this->load->view('Hapus_Nilai_Mapel/ujian_index', $data);
    $this->load->view('templates/footer');

  }

  public function topik_index()
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
    $this->load->view('Hapus_Nilai_Mapel/topik_index', $data);
    $this->load->view('templates/footer');

  }

  public function view_kelas_ujian(){

    if($this->input->post('t_id')){

      $data['title'] = 'Pilih Kelas';
      $kr_id = $this->session->userdata('kr_id');

      $sk = $this->db->query(
        "SELECT kr_sk_id
        FROM kr
        WHERE kr_id = $kr_id"
      )->row_array();

      $sk_id = $sk['kr_sk_id'];

      $t_id = $this->input->post('t_id');

      $data['t_id'] = $t_id;

      $data['kelas_all'] = $this->db->query(
        "SELECT kelas_id, kelas_nama
        FROM kelas
        WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id
        ORDER BY kelas_nama"
      )->result_array();

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hapus_Nilai_Mapel/view_kelas_ujian', $data);
      $this->load->view('templates/footer');
    }
    else {
      redirect('Profile');
    }

  }

  public function view_mapel_ujian(){
    if($this->input->post('kelas_id')){
      $kelas_id = $this->input->post('kelas_id');

      $data['title'] = 'Pilih Mapel';

      $data['kelas_id'] = $kelas_id;

      $data['mapel_all'] = $this->db->query(
        "SELECT mapel_id, mapel_nama
        FROM uj
        LEFT JOIN d_s ON d_s_id = uj_d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN mapel ON uj_mapel_id = mapel_id
        WHERE d_s_kelas_id = $kelas_id
        GROUP BY mapel_id
        ORDER BY mapel_nama"
      )->result_array();

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hapus_Nilai_Mapel/view_mapel_ujian', $data);
      $this->load->view('templates/footer');

    }
  }

  public function hasil_ujian(){
    if($this->input->post('kelas_id')){

      $data['title'] = 'Nilai Mid dan Final';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kelas_id = $this->input->post('kelas_id');
      $mapel_id = $this->input->post('mapel_id');

      $data['mapel'] = $this->db->query(
        "SELECT mapel_id, mapel_nama
        FROM mapel
        WHERE mapel_id = $mapel_id"
      )->row_array();

      $data['kelas'] = $this->db->query(
        "SELECT kelas_id, kelas_nama
        FROM kelas
        WHERE kelas_id = $kelas_id"
      )->row_array();

      $data['uj_all'] = $this->db->query(
        "SELECT uj_id, sis_nama_depan, sis_nama_bel, mapel_nama, uj_mid1_kog, uj_mid1_psi, uj_mid2_kog, uj_mid2_psi, uj_fin1_kog, uj_fin1_psi, uj_fin2_kog, uj_fin2_psi
        FROM uj
        LEFT JOIN d_s ON d_s_id = uj_d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN mapel ON mapel_id = uj_mapel_id
        WHERE d_s_kelas_id = $kelas_id AND uj_mapel_id = $mapel_id
        ORDER BY sis_nama_depan, sis_nama_bel"
      )->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hapus_Nilai_Mapel/hasil_ujian', $data);
      $this->load->view('templates/footer');

    }
  }

  public function hapus_ujian_proses(){
    if($this->input->post('uj_id[]')){

      $arr = $this->input->post('uj_id[]');

      $this->db->where_in('uj_id', $arr);
      $this->db->delete('uj');

      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Nilai Ujian berhasil dihapus!</div>');
      redirect('Hapus_Nilai_Mapel/ujian_index');
    }
  }

  public function view_kelas_topik(){

    if($this->input->post('t_id')){

      $data['title'] = 'Pilih Kelas';
      $kr_id = $this->session->userdata('kr_id');

      $sk = $this->db->query(
        "SELECT kr_sk_id
        FROM kr
        WHERE kr_id = $kr_id"
      )->row_array();

      $sk_id = $sk['kr_sk_id'];

      $t_id = $this->input->post('t_id');

      $data['t_id'] = $t_id;

      $data['kelas_all'] = $this->db->query(
        "SELECT kelas_id, kelas_nama
        FROM kelas
        WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id
        ORDER BY kelas_nama"
      )->result_array();

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hapus_Nilai_Mapel/view_kelas_topik', $data);
      $this->load->view('templates/footer');
    }
    else {
      redirect('Profile');
    }

  }

  public function view_mapel_topik(){
    if($this->input->post('kelas_id')){
      $kelas_id = $this->input->post('kelas_id');
      $mapel_id = $this->input->post('mapel_id');

      $data['title'] = 'Pilih Mapel';

      $data['kelas_id'] = $kelas_id;

      $data['mapel_all'] = $this->db->query(
        "SELECT mapel_id, mapel_nama
        FROM tes
        LEFT JOIN topik ON tes_topik_id = topik_id
        LEFT JOIN d_s ON tes_d_s_id = d_s_id
        LEFT JOIN mapel ON topik_mapel_id = mapel_id
        WHERE d_s_kelas_id = $kelas_id
        GROUP BY mapel_id
        ORDER BY mapel_nama"
      )->result_array();

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hapus_Nilai_Mapel/view_mapel_topik', $data);
      $this->load->view('templates/footer');

    }

  }

  public function view_topik(){
    //di kelas ini ada topik apa dari mapel dan kelas id
    if($this->input->post('kelas_id')){
      $kelas_id = $this->input->post('kelas_id');
      $mapel_id = $this->input->post('mapel_id');

      $data['title'] = 'Pilih Topik';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas_id'] = $kelas_id;
      $data['mapel_id'] = $mapel_id;

      $data['topik_all'] = $this->db->query(
        "SELECT topik_id, topik_nama
        FROM tes
        LEFT JOIN topik ON tes_topik_id = topik_id
        LEFT JOIN d_s ON tes_d_s_id = d_s_id
        LEFT JOIN mapel ON topik_mapel_id = mapel_id
        WHERE d_s_kelas_id = $kelas_id AND topik_mapel_id = $mapel_id
        GROUP BY topik_id
        ORDER BY topik_nama"
      )->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hapus_Nilai_Mapel/view_topik', $data);
      $this->load->view('templates/footer');
    }
  }

  public function hasil_topik(){
    if($this->input->post('kelas_id')){

      $data['title'] = 'Nilai Topik';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kelas_id = $this->input->post('kelas_id');
      $mapel_id = $this->input->post('mapel_id');
      $topik_id = $this->input->post('topik_id');

      $data['mapel'] = $this->db->query(
        "SELECT mapel_id, mapel_nama
        FROM mapel
        WHERE mapel_id = $mapel_id"
      )->row_array();

      $data['kelas'] = $this->db->query(
        "SELECT kelas_id, kelas_nama
        FROM kelas
        WHERE kelas_id = $kelas_id"
      )->row_array();

      $data['topik'] = $this->db->query(
        "SELECT topik_id, topik_nama
        FROM topik
        WHERE topik_id = $topik_id"
      )->row_array();

      $data['tes_all'] = $this->db->query(
        "SELECT tes_id, sis_nama_depan, sis_nama_bel, kog_quiz, kog_ass, kog_test, psi_quiz, psi_test, psi_ass
        FROM tes
        LEFT JOIN d_s ON d_s_id = tes_d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE tes_topik_id = $topik_id AND d_s_kelas_id = $kelas_id
        ORDER BY sis_nama_depan, sis_nama_bel"
      )->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Hapus_Nilai_Mapel/hasil_topik', $data);
      $this->load->view('templates/footer');

    }
  }

  public function hapus_tes_proses(){
    if($this->input->post('tes_id[]')){

      $arr = $this->input->post('tes_id[]');

      $this->db->where_in('tes_id', $arr);
      $this->db->delete('tes');

      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Nilai topik berhasil dihapus!</div>');
      redirect('Hapus_Nilai_Mapel/topik_index');
    }
  }



}

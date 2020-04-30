<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ortu_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_mk');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');
    $this->load->model('_t');
    $this->load->model('_siswa');
    $this->load->model('_mapel');

    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }
  }

  public function index()
  {

    if (walkel_menu() >= 1) {
      //cek kelas ajar

      $data['title'] = 'Pilih Kelas';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');

      $data['kelas_all'] = $this->db->query(
        "SELECT kelas_id, kelas_nama, t_nama
        FROM kelas
        LEFT JOIN t ON t_id = kelas_t_id
        WHERE kelas_kr_id = $kr_id
        ORDER BY t_nama DESC"
      )->result_array();

      //$data['tes'] = var_dump($this->db->last_query());

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('ortu_crud/index', $data);
      $this->load->view('templates/footer');
    } else {
      //jika bukan walkel redirect
      redirect('Profile');
    }
  }

  public function daftar_siswa()
  {

    $kelas_id = $this->input->post('kelas_id', true);

    if ($kelas_id) {
      $data['title'] = 'Daftar Siswa';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['sis_all'] = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk, sis_username, d_s_blokir, sis_last_login
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE d_s_kelas_id = $kelas_id
        ORDER BY sis_nama_depan"
      )->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('ortu_crud/daftar_siswa', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('Profile');
    }
  }

  public function proses_blokir()
  {

    //dari method post
    $d_s_id = $this->input->post('d_s_id[]', true);
    $d_s_blokir = $this->input->post('d_s_blokir[]', true);

    if ($d_s_id) {

      $data = array();

      for ($i = 0; $i < count($d_s_id); $i++) {

        $data[$i] = [
          'd_s_blokir' => $d_s_blokir[$i],
          'd_s_id' =>  $d_s_id[$i]
        ];
      }

      $this->db->update_batch('d_s', $data, 'd_s_id');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update Hak Akses Sukses!</div>');
      redirect('Ortu_CRUD');
    } else {
      redirect('Profile');
    }
  }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Disjam_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_jenj');
    $this->load->model('_t');
    $this->load->model('_siswa');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_d_s');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan wakakur dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 5 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'List of School';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data jenjang untuk konten
    $data['sekolah_all'] = $this->_sk->return_all();
    $data['t_all'] = $this->_t->return_all();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('disjam_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function proses()
  {

    if($this->input->post('t_id', true)){
      $t_id = $this->input->post('t_id', true);
      $sk_id = $this->input->post('sk_id', true);

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['title'] = 'Distribusi Jam';

      $data['sk_detail'] = $this->db->query(
        "SELECT *
        FROM sk
        WHERE sk_id = $sk_id")->row_array();

      $data['t_detail'] = $this->db->query(
        "SELECT *
        FROM t
        WHERE t_id = $t_id")->row_array();

      $data['kr_all'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, GROUP_CONCAT(st_nama ORDER BY kr_h_status_tanggal DESC) as st_nama
        FROM kr
        LEFT JOIN jabatan ON kr_jabatan_id = jabatan_id
        LEFT JOIN sk ON kr_sk_id = sk_id
        LEFT JOIN kr_h_status ON kr_h_status_kr_id = kr_id
        LEFT JOIN st ON kr_h_status_status_id = st_id
        WHERE kr_sk_id = $sk_id
        GROUP BY kr_id
        ORDER BY kr_nama_depan")->result_array();

      $data['kelas_all'] = $this->db->query(
        "SELECT kelas_id, kelas_nama, kelas_nama_singkat FROM kelas WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id ORDER BY kelas_nama")->result_array();


      //$data['kr_all'] = $this->_kr->return_all_by_sk_id($sk_id);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('disjam_crud/disjam', $data);
      $this->load->view('templates/footer');

    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

}

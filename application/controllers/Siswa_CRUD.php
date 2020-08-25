<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_kelas');
    $this->load->model('_t');
    $this->load->model('_agama');
    $this->load->model('_siswa');



    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan TU dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 6 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Daftar Siswa';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $sk_id = $this->session->userdata('kr_sk_id');
    $data['sis_all'] = $this->db->query(
      "SELECT *
      FROM sis
      LEFT JOIN agama ON agama_id = sis_agama_id
      LEFT JOIN t ON sis_t_id = t_id
      WHERE sis_sk_id = $sk_id AND sis_alumni = 0
      ORDER BY sis_nama_depan"
    )->result_array();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('siswa_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function add()
  {

    $this->form_validation->set_rules('sis_nama_depan', 'First Name', 'required|trim');
    $this->form_validation->set_rules('sis_nama_bel', 'Last Name', 'trim');
    $this->form_validation->set_rules('sis_no_induk', 'Registration number', 'required|trim');
    $this->form_validation->set_rules('sis_nisn', 'NISN number', 'trim|is_unique[sis.sis_nisn]', ['is_unique' => 'NISN already exist!']);

    if ($this->form_validation->run() == false) {
      //jika belum ada tahun ajaran sama sekali
      $t_count = $this->db->count_all('t');

      if($t_count == 0){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Silahkan tambah tahun ajaran terlebih dahulu!</div>');
        redirect('Siswa_CRUD');
      }

      $data['title'] = 'Tambah Siswa';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['tahun_all'] = $this->_t->return_all();
      $data['agama_all'] = $this->_agama->return_all();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('siswa_crud/add', $data);
      $this->load->view('templates/footer');
    }
    else {

      $sis_email = $this->input->post('sis_email');

      $cekEmail = $this->db->query(
        "SELECT *
        FROM sis
        WHERE sis_email = '$sis_email'")->result_array();

      if($cekEmail){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Gagal, email gsuite sudah terdaftar pada siswa lain!</div>');
        redirect('Siswa_CRUD');
      }

      $data = [
        'sis_nama_depan' => $this->input->post('sis_nama_depan'),
        'sis_nama_bel' => $this->input->post('sis_nama_bel'),
        'sis_nisn' => $this->input->post('sis_nisn'),
        'sis_no_induk' => $this->input->post('sis_no_induk'),
        'sis_sk_id' => $this->session->userdata('kr_sk_id'),
        'sis_jk' => $this->input->post('sis_jk'),
        'sis_agama_id' => $this->input->post('sis_agama_id'),
        'sis_t_id' => $this->input->post('sis_t_id'),
        'sis_email' => $sis_email
      ];

      $this->db->insert('sis', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Siswa berhasil dibuat!</div>');
      redirect('siswa_crud/add');
    }
  }

  public function update_baru(){
    $sis_id = $this->input->post('sis_id', true);
    if($sis_id){

      $data['title'] = 'Update Siswa';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['tahun_all'] = $this->_t->return_all();
      $data['agama_all'] = $this->_agama->return_all();
      //cek apakah siswa sudah ada di dalam kelas, jika sudah maka angkatan tidak bisa dirubah
      $data['cek_siswa'] = $this->db->query(
        "SELECT COUNT(d_s_id) as jum
        FROM d_s
        WHERE d_s_sis_id = $sis_id"
      )->row_array();
      $data['siswa_update'] = $this->_siswa->find_by_id($sis_id);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('siswa_crud/update', $data);
      $this->load->view('templates/footer');
    }
  }

  public function update_baru_proses(){

    if($this->input->post('sis_id')){
      $data = [
        'sis_nama_depan' => $this->input->post('sis_nama_depan'),
        'sis_nama_bel' => $this->input->post('sis_nama_bel'),
        'sis_no_induk' => $this->input->post('sis_no_induk'),
        'sis_nisn' => $this->input->post('sis_nisn'),
        'sis_jk' => $this->input->post('sis_jk'),
        'sis_agama_id' => $this->input->post('sis_agama_id'),
        'sis_t_id' => $this->input->post('sis_t_id'),
        'sis_email' => $this->input->post('sis_email')
      ];

      //cek lagi apakah siswa sudah didalam kelas
      $sis_id = $this->input->post('sis_id');
      $cek = $this->db->query(
        "SELECT COUNT(d_s_id) as jum
        FROM d_s
        WHERE d_s_sis_id = $sis_id"
      )->row_array();

      if($cek['jum'] == 0){
        $this->db->where('sis_id', $this->input->post('sis_id'));
        $this->db->update('sis', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data siswa berhasil diupdate!</div>');
        redirect('Siswa_CRUD');
      }
      else{
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data siswa baru saja dirubah oleh wakakur, silahkan ulangi proses edit sekali lagi!</div>');
        redirect('Siswa_CRUD');
      }

    }
  }

  public function add_csv(){

    $data['title'] = 'Upload dari CSV';

    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk_id'] = $this->session->userdata('kr_sk_id');

    $data['t'] = $this->db->query(
      "SELECT t_id, t_nama
      FROM t
      ORDER BY t_nama DESC"
    )->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('siswa_crud/add_csv', $data);
    $this->load->view('templates/footer');
  }

  public function add_csv_proses(){

    $sis_no_induk = $this->input->post('sis_no_induk[]', true);
    $sis_nama_depan = $this->input->post('sis_nama_depan[]', true);
    $sis_nama_bel = $this->input->post('sis_nama_bel[]', true);
    $sis_agama = $this->input->post('sis_agama[]', true);
    $sis_jk = $this->input->post('sis_jk[]', true);

    if($sis_no_induk){
      $data = array();

      for($i=0;$i<count($sis_no_induk);$i++){
        $data[$i] = [
          'sis_no_induk' => $sis_no_induk[$i],
          'sis_nama_depan' => $sis_nama_depan[$i],
          'sis_nama_bel' => $sis_nama_bel[$i],
          'sis_agama_id' =>  $sis_agama[$i],
          'sis_t_id' => $this->input->post('sis_t_id'),
          'sis_sk_id' => $this->input->post('sis_sk_id'),
          'sis_jk' => $sis_jk[$i]
        ];
      }

      $this->db->insert_batch('sis', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
      redirect('Siswa_CRUD');
    }

  }

  public function delete(){

    $sis_id = $this->input->post('sis_id', true);

    if($sis_id){
      $cek = $this->db->query(
        "SELECT COUNT(d_s_id) as jum
        FROM d_s
        WHERE d_s_sis_id = $sis_id"
      )->row_array();

      if($cek['jum'] == 0){
        $this->db->where('sis_id', $sis_id);
        $this->db->delete('sis');
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berhasil menghapus murid!</div>');
        redirect('Siswa_CRUD');
      }
      else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Gagal, murid sudah ada dalam kelas!</div>');
        redirect('Siswa_CRUD');
      }

    }
  }
}

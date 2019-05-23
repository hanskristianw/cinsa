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

    //jika bukan HRD dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 6 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Students List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['sis_all'] = $this->_siswa->return_all_by_sk($this->session->userdata('kr_sk_id'));

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
    $this->form_validation->set_rules('sis_nama_bel', 'Last Name', 'required|trim');
    $this->form_validation->set_rules('sis_no_induk', 'Registration number', 'required|trim|is_unique[sis.sis_no_induk]', ['is_unique' => 'This registration number already exist!']);


    if ($this->form_validation->run() == false) {
      //jika belum ada tahun ajaran sama sekali
      $t_count = $this->db->count_all('t');

      if($t_count == 0){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Please inform ADMIN to year first!</div>');
        redirect('Kelas_CRUD');
      }

      $data['title'] = 'Insert Student';

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
      $data = [
        'sis_nama_depan' => $this->input->post('sis_nama_depan'),
        'sis_nama_bel' => $this->input->post('sis_nama_bel'),
        'sis_no_induk' => $this->input->post('sis_no_induk'),
        'sis_sk_id' => $this->session->userdata('kr_sk_id'),
        'sis_jk' => $this->input->post('sis_jk'),
        'sis_agama_id' => $this->input->post('sis_agama_id'),
        'sis_t_id' => $this->input->post('sis_t_id')
      ];

      $this->db->insert('sis', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Student Created!</div>');
      redirect('siswa_crud/add');
    }
  }

  public function update()
  {

    //dari method post
    $sis_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if (!$sis_post) {
      //ambil id dari method get
      $sis_get = $this->_siswa->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if (!$sis_get['sis_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Siswa_CRUD');
      }
    }

    if($this->input->post('_sis_no_induk') == $this->input->post('sis_no_induk')){
      $this->form_validation->set_rules('sis_no_induk', 'Registration number', 'required|trim');
    }else{
      $this->form_validation->set_rules('sis_no_induk', 'Registration number', 'required|trim|is_unique[sis.sis_no_induk]', ['is_unique' => 'This registration number already exist!']);
    }

    $this->form_validation->set_rules('sis_nama_depan', 'First Name', 'required|trim');
    $this->form_validation->set_rules('sis_nama_bel', 'Last Name', 'required|trim');
    $this->form_validation->set_rules('sis_t_id', 'Tahun Ajaran Siswa', 'required');

    if ($this->form_validation->run() == false) {
      //jika menekan tombol edit
      $data['title'] = 'Update Students Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['tahun_all'] = $this->_t->return_all();
      $data['agama_all'] = $this->_agama->return_all();

      //simpan data primary key
      $sis_id = $this->input->get('_id', true);

      $data['siswa_update'] = $this->_siswa->find_by_id($sis_id);

      //load view dengan data query
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('siswa_crud/update', $data);
      $this->load->view('templates/footer');
    } else {
      //fetch data hasil inputan
      $data = [
        'sis_nama_depan' => $this->input->post('sis_nama_depan'),
        'sis_nama_bel' => $this->input->post('sis_nama_bel'),
        'sis_no_induk' => $this->input->post('sis_no_induk'),
        'sis_jk' => $this->input->post('sis_jk'),
        'sis_agama_id' => $this->input->post('sis_agama_id'),
        'sis_t_id' => $this->input->post('sis_t_id')
      ];

      //simpan ke db

      $this->db->where('sis_id', $this->input->post('_id'));
      $this->db->update('sis', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Student Data Updated!</div>');
      redirect('Siswa_CRUD');
    }
  }
}

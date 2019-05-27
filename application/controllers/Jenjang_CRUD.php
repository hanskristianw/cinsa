<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenjang_CRUD extends CI_Controller
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
    if ($this->session->userdata('kr_jabatan_id') != 4 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'List of Level';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data jenjang untuk konten
    $data['jenj_all'] = $this->_jenj->return_all_by_sk($this->session->userdata('kr_sk_id'));

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('jenjang_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function add()
  {

    $this->form_validation->set_rules('jenj_nama', 'Level Name', 'required|trim');

    if ($this->form_validation->run() == false) {

      $data['title'] = 'Create Level';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Jenjang_crud/add', $data);
      $this->load->view('templates/footer');
    } 
    else {

      $data = [
        'jenj_nama' => $this->input->post('jenj_nama'),
        'jenj_sk_id' => $this->session->userdata('kr_sk_id')
      ];

      
      $this->db->insert('jenj', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Level Created!</div>');
      redirect('jenjang_crud/add');
    }
  }

  public function update()
  {

    //dari method post
    $jenj_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if (!$jenj_post) {
      //ambil id dari method get
      $jenj_get = $this->_jenj->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update
      if (!$jenj_get['jenj_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Jenjang_CRUD');
      }
    }

    $this->form_validation->set_rules('jenj_nama', 'Level Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      //jika menekan tombol edit
      $data['title'] = 'Update Level Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));


      //simpan data primary key
      $jenj_id = $this->input->get('_id', true);

      $data['jenj_update'] = $this->_jenj->find_by_id($jenj_id);

      //load view dengan data query
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Jenjang_crud/update', $data);
      $this->load->view('templates/footer');
    } else {
      //fetch data hasil inputan
      $data = [
        'jenj_nama' => $this->input->post('jenj_nama')
      ];

      //simpan ke db

      $this->db->where('jenj_id', $this->input->post('_id'));
      $this->db->update('jenj', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Level Updated!</div>');
      redirect('Jenjang_CRUD');
    }
  }
}

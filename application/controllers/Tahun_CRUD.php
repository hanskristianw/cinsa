<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tahun_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_t');

    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan Admin dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 1 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Tahun Ajaran List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['tahun_all'] = $this->_t->return_all();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('tahun_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function check_default($post_string)
  {
    return $post_string == '0' ? FALSE : TRUE;
  }

  public function add()
  {

    $this->form_validation->set_rules('tahun_nama', 'Tahun Nama', 'required|trim|is_unique[t.t_nama]', ['is_unique' => 'This year already exist!']);


    if ($this->form_validation->run() == false) {
      $data['title'] = 'Create Year';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['tahun_all'] = $this->_t->return_all();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('tahun_crud/add', $data);
      $this->load->view('templates/footer');
    } else {
      $data = [
        't_nama' => $this->input->post('tahun_nama')
      ];

      $this->db->insert('t', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Year Created!</div>');
      redirect('tahun_crud/add');
    }
  }

  public function update()
  {

    //dari method post
    $tahun_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if (!$tahun_post) {
      //ambil id dari method get
      $tahun_get = $this->_t->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if (!$tahun_get['t_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Tahun_CRUD');
      }
    }

    $this->form_validation->set_rules('tahun_nama', 'Tahun', 'required|trim|is_unique[t.t_nama]', ['is_unique' => 'This year already exist!']);

    if ($this->form_validation->run() == false) {
      //jika menekan tombol edit
      $data['title'] = 'Update Year';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      //simpan data primary key
      $tahun_id = $this->input->get('_id', true);

      $data['tahun_update'] = $this->_t->find_by_id($tahun_id);

      //load view dengan data query
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('tahun_crud/update', $data);
      $this->load->view('templates/footer');
    } else {
      //fetch data hasil inputan
      $data = [
        't_nama' => $this->input->post('tahun_nama')
      ];

      //simpan ke db

      $this->db->where('t_id', $this->input->post('_id'));
      $this->db->update('t', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Year Updated!</div>');
      redirect('Tahun_CRUD');
    }
  }
}

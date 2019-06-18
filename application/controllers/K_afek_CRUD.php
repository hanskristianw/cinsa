<?php
defined('BASEPATH') or exit('No direct script access allowed');

class K_afek_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_k_afek');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_sk');
    $this->load->model('_bulan');
    $this->load->model('_t');

    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 8 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Afective Criteria';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['k_afek_all'] = $this->_k_afek->return_all_by_sk($this->session->userdata('kr_sk_id'));

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('k_afek_crud/index', $data);
    $this->load->view('templates/footer');
  }

  function check_topik()
  {
    $topik_count = $this->db->where('k_afek_t_id', $this->input->post('k_afek_t_id'))->where('k_afek_bulan_id', $this->input->post('k_afek_bulan_id'))->where('k_afek_sk_id', $this->session->userdata('kr_sk_id'))->from("k_afek")->count_all_results();
    if ($topik_count > 0) {
      $this->form_validation->set_message('check_topik', 'Topic with MONTH and YEAR already exist');
      return FALSE;
    } else {
      return TRUE;
    }
  }

  public function add()
  {

    $this->form_validation->set_rules('k_afek_nama', 'Criteria Name', 'required|trim|callback_check_topik');
    $this->form_validation->set_rules('k_afek_1', 'Afektif 1', 'required|trim');
    $this->form_validation->set_rules('k_afek_2', 'Afektif 2', 'required|trim');
    $this->form_validation->set_rules('k_afek_3', 'Afektif 3', 'required|trim');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'Afective Criteria';

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['sk_all'] = $this->_sk->return_all();
      $data['bulan_all'] = $this->_bulan->return_all();
      $data['tahun_all'] = $this->_t->return_all();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('k_afek_crud/add', $data);
      $this->load->view('templates/footer');
    } else {

      // jika tidak ada topik dengan, bulan, tahun dan sekolah yang sama
      $data = [
        'k_afek_topik_nama' => $this->input->post('k_afek_nama'),
        'k_afek_1' => $this->input->post('k_afek_1'),
        'k_afek_2' => $this->input->post('k_afek_2'),
        'k_afek_3' => $this->input->post('k_afek_3'),
        'k_afek_t_id' => $this->input->post('k_afek_t_id'),
        'k_afek_sk_id' => $this->session->userdata('kr_sk_id'),
        'k_afek_bulan_id' => $this->input->post('k_afek_bulan_id')
      ];

      $this->db->insert('k_afek', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Criteria Created!</div>');
      redirect('k_afek_crud/add');
    }
  }

  public function update()
  {

    //dari method post
    $sk_post = $this->input->get('_id', true);

    //jika bukan dari form update sendiri
    if (!$sk_post) {
      //ambil id dari method get
      $sk_get = $this->_sk->find_by_id($this->input->post('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if ($sk_get['sk_id'] == 0 || !$sk_get['sk_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Sekolah_CRUD');
      }
    }

    $this->form_validation->set_rules('sk_nama', 'School Name', 'required|trim');

    if ($this->form_validation->run() == false) {
      //jika menekan tombol edit
      $data['title'] = 'Update School Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();
      $data['st_all'] = $this->_st->return_all();

      //simpan data primary key
      $sk_id = $this->input->get('_id', true);

      $data['sk_update'] = $this->_sk->find_by_id($sk_id);

      //load view dengan data query
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('sekolah_crud/update', $data);
      $this->load->view('templates/footer');
    } else {
      //fetch data hasil inputan
      $data = [
        'sk_nama' => $this->input->post('sk_nama'),
      ];

      //simpan ke db

      $this->db->where('sk_id', $this->input->post('_id'));
      $this->db->update('sk', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">School Name Updated!</div>');
      redirect('Sekolah_CRUD');
    }
  }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Siswa_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_kelas');
    $this->load->model('_t');
    $this->load->model('_sk');
    $this->load->model('_st');
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

    $data['title'] = 'List Students';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['sis_all'] = $this->_siswa->return_all();

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
    $this->form_validation->set_rules('sis_t_id', 'Tahun Ajaran Siswa', 'required');
    $this->form_validation->set_rules('sis_no_induk', 'No Induk Siswa', 'required|trim|is_unique[sis.sis_no_induk]', ['is_unique' => 'This NIK already exist!']);


    if ($this->form_validation->run() == false) {
      $data['title'] = 'Create Student';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas_all'] = $this->_kelas->return_all();
      $data['tahun_all'] = $this->_tahun->return_all();
      $data['sk_all'] = $this->_sk->return_all();
      $data['sis_all'] = $this->_siswa->return_all();


      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('siswa_crud/add', $data);
      $this->load->view('templates/footer');
    } elseif ($this->input->post('sis_no_induk') != null) {
      $sis_nama_depan = $this->input->post('sis_nama_depan');
      $sis_nama_bel = $this->input->post('sis_nama_bel');
      $sis_no_induk = $this->input->post('sis_no_induk');
      $sis_t_id = $this->input->post('sis_t_id');
      $cek1 = $this->db->get_where('sis', array('sis_no_induk' => $sis_no_induk))->row_array();
      if ($cek1 != null) {
        $data['title'] = 'Create Student';

        //data karyawan yang sedang login untuk topbar
        $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
        $data['kelas_all'] = $this->_kelas->return_all();
        $data['tahun_all'] = $this->_tahun->return_all();
        $data['sk_all'] = $this->_sk->return_all();
        $data['sis_all'] = $this->_siswa->return_all();

        $this->session->set_flashdata('warning', '<small class="text-danger pl-3">No Induk sudah pernah terisi!</small>');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('siswa_crud/add', $data);
        $this->load->view('templates/footer');
      } else {

        $data = [
          'sis_nama_depan' => $this->input->post('sis_nama_depan'),
          'sis_nama_bel' => $this->input->post('sis_nama_bel'),
          'sis_no_induk' => $this->input->post('sis_no_induk'),
          'sis_t_id' => $this->input->post('sis_t_id')
        ];


        $this->db->insert('sis', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">List Students Created!</div>');
        redirect('siswa_crud/add');
      }
    }
  }

  public function update()
  {

    //dari method post
    $sis_post = $this->input->get('_id', true);

    //jika bukan dari form update sendiri
    if (!$sis_post) {
      //ambil id dari method get
      $sis_get = $this->_siswa->find_by_id($this->input->post('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if ($sis_get['sis_id'] == 0 || !$sis_get['sis_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Siswa_CRUD');
      }
    }

    $this->form_validation->set_rules('sis_nama_depan', 'Frist Name', 'required|trim');
    $this->form_validation->set_rules('sis_nama_bel', 'Last Name', 'required|trim');
    $this->form_validation->set_rules('sis_t_id', 'Tahun Ajaran Siswa', 'required');

    if ($this->form_validation->run() == false) {
      //jika menekan tombol edit
      $data['title'] = 'Update Students Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();
      $data['st_all'] = $this->_st->return_all();
      $data['sk_all'] = $this->_sk->return_all();
      $data['tahun_all'] = $this->_tahun->return_all();
      $data['sis_all'] = $this->_siswa->return_all();

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
        'sis_t_id' => $this->input->post('sis_t_id')
      ];

      //simpan ke db

      $this->db->where('sis_id', $this->input->post('_id'));
      $this->db->update('sis', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Students Data Updated!</div>');
      redirect('Siswa_CRUD');
    }
  }
}

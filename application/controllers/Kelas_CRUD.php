<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_kelas');
    $this->load->model('_t');
    $this->load->model('_siswa');
    $this->load->model('_jenj');
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

    $data['title'] = 'List of Class';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['kelas_all'] = $this->_kelas->return_all_by_sk($this->session->userdata('kr_sk_id'));

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('kelas_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function add()
  {

    $this->form_validation->set_rules('kelas_nama', 'Kelas Nama', 'required|trim');

    if ($this->form_validation->run() == false) {
      //jika belum ada tahun ajaran sama sekali
      $t_count = $this->db->count_all('t');

      if ($t_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please inform ADMIN to year first!</div>');
        redirect('Kelas_CRUD');
      }

      $jenjang_count = $this->db->where('jenj_sk_id',$this->session->userdata('kr_sk_id'))->from("jenj")->count_all_results();

      if ($jenjang_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please add level first!</div>');
        redirect('Kelas_CRUD');
      }

      $data['title'] = 'Create Class';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas_all'] = $this->_kelas->return_all();
      $data['tahun_all'] = $this->_t->return_all();
      $data['jenj_all'] = $this->_jenj->return_all_by_sk($this->session->userdata('kr_sk_id'));
      $data['sk_all'] = $this->_sk->return_all();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('kelas_crud/add', $data);
      $this->load->view('templates/footer');
    } else {

      $data = [
        'kelas_nama' => $this->input->post('kelas_nama'),
        'kelas_sk_id' => $this->input->post('kelas_sk_id'),
        'kelas_jenj_id' => $this->input->post('jenj_id'),
        'kelas_t_id' => $this->input->post('kelas_t_id')
      ];

      $this->db->insert('kelas', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Class Created!</div>');
      redirect('kelas_crud/add');
    }
  }

  public function edit_subject(){
    $kelas_id_post = $this->input->post('kelas_id', true);
    if(!$kelas_id_post){
      $kelas_get = $this->_kelas->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update
      if (!$kelas_get['kelas_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Kelas_CRUD');
      }
    }
  }

  public function edit_student()
  {

    $kelas_id_post = $this->input->post('kelas_id', true);
    if(!$kelas_id_post){
      $kelas_get = $this->_kelas->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update
      if (!$kelas_get['kelas_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Kelas_CRUD');
      }
    }

    $this->form_validation->set_rules('sis_id', 'Siswa Nama', 'required|trim');
    $this->form_validation->set_rules('kelas_id', 'Kelas Nama', 'required|trim');

    if ($this->form_validation->run() == false) {

      $sk_id = $this->session->userdata('kr_sk_id');

      //jika belum ada murid sama sekali

      $sis_count = $this->db->where('sis_sk_id',$sk_id)->from("sis")->count_all_results();

      if ($sis_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please inform school administrative to add student first!</div>');
        redirect('Kelas_CRUD');
      }

      $data['title'] = 'All Students';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas_all'] = $this->_kelas->find_by_id($this->input->get('_id', true));

      //var_dump($data['kelas_all']);

      //return siswa yang belum mempunyai kelas pada kelas dengan tahun ajaran
      //$data['sis_all'] = $this->_siswa->return_all_by_sk($this->session->userdata('kr_sk_id'));

      //var_dump($data['kelas_all']['kelas_t_id']);

      $data['sis_all'] = $this->db->query(
        "SELECT * FROM sis
        LEFT JOIN agama ON sis_agama_id = agama_id
        LEFT JOIN t ON sis_t_id = t_id
        LEFT JOIN sk ON sis_sk_id = sk_id
        WHERE sis_sk_id = $sk_id
        AND sis_id NOT IN (SELECT d_s_sis_id FROM d_s
                            LEFT JOIN sis ON d_s_sis_id = sis_id
                            LEFT JOIN kelas ON d_s_kelas_id = kelas_id
                            WHERE sis_sk_id = $sk_id AND kelas_t_id = ".$data['kelas_all']['kelas_t_id'].")
        ORDER BY sis_t_id DESC, sis_nama_depan ASC")->result_array();


      //var_dump($this->db->last_query());

      $data['d_s_all'] = $this->_d_s->return_siswa_by_kelas_id($this->input->get('_id', true));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('kelas_crud/edit_student', $data);
      $this->load->view('templates/footer');
    }
    else {

      $sis = $this->_siswa->find_by_id($this->input->post('sis_id'));

      //var_dump($sis);
      $data = [
        'd_s_sis_id' => $this->input->post('sis_id'),
        'd_s_kelas_id' => $this->input->post('kelas_id')
      ];

      $this->db->insert('d_s', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully add '.$sis['sis_nama_depan'].'!</div>');
      redirect('kelas_crud/edit_student?_id='.$this->input->post('kelas_id'));
    }
  }

  public function update()
  {

    //dari method post
    $kelas_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if (!$kelas_post) {
      //ambil id dari method get
      $kelas_get = $this->_kelas->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update
      if (!$kelas_get['kelas_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Kelas_CRUD');
      }
    }

    $this->form_validation->set_rules('kelas_nama', 'Kelas Nama', 'required|trim');
    $this->form_validation->set_rules('kelas_t_id', 'Kelas Tahun', 'required');

    if ($this->form_validation->run() == false) {
      //jika menekan tombol edit
      $data['title'] = 'Update Class Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jenj_all'] = $this->_jenj->return_all_by_sk($this->session->userdata('kr_sk_id'));

      $data['tahun_all'] = $this->_t->return_all();

      //simpan data primary key
      $kelas_id = $this->input->get('_id', true);

      $data['kelas_update'] = $this->_kelas->find_by_id($kelas_id);

      //load view dengan data query
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('kelas_crud/update', $data);
      $this->load->view('templates/footer');
    } else {
      //fetch data hasil inputan
      $data = [
        'kelas_nama' => $this->input->post('kelas_nama'),
        'kelas_jenj_id' => $this->input->post('jenj_id'),
        'kelas_t_id' => $this->input->post('kelas_t_id')
      ];

      //simpan ke db

      $this->db->where('kelas_id', $this->input->post('_id'));
      $this->db->update('kelas', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Class Data Updated!</div>');
      redirect('Kelas_CRUD');
    }
  }
}

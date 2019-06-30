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
      $data['title'] = 'Hour Distribution';

      $data['kr_all'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, mapel_id, mapel_nama, GROUP_CONCAT(d_mpl_beban ORDER BY mapel_id) as beban_jam, GROUP_CONCAT(kelas_id ORDER BY mapel_id) as kelas_id, st_nama, kelas_t_id, kelas_sk_id
        FROM kr
        LEFT JOIN d_mpl ON d_mpl_kr_id = kr_id
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN st ON kr_st_id = st_id
        WHERE kr_sk_id = $sk_id AND kelas_t_id = $t_id  AND mapel_sk_id = $sk_id
        GROUP BY kr_id, mapel_id")->result_array();


      // $data['kr_all'] = $this->db->query(
      //   "SELECT kr_all.kr_id as kr_id, kr_nama_depan, kr_nama_belakang, mapel_id, mapel_id_dis, jum_mapel, mapel_nama, mapel_nama_all, beban_jam, kelas_id, st_nama FROM
      //   (
      //     SELECT kr_id, kr_nama_depan, kr_nama_belakang, st_nama
      //     FROM kr
      //     LEFT JOIN st ON kr_st_id = st_id
      //     WHERE kr_sk_id = $sk_id) AS kr_all
      //   JOIN(
      //     SELECT kr_id, COUNT(DISTINCT mapel_id) as jum_mapel, GROUP_CONCAT(DISTINCT mapel_nama ORDER BY mapel_id SEPARATOR ';') as mapel_nama,
      //     GROUP_CONCAT(DISTINCT mapel_id ORDER BY mapel_id) as mapel_id_dis, 
      //     GROUP_CONCAT(mapel_id ORDER BY mapel_id) as mapel_id, GROUP_CONCAT(mapel_nama ORDER BY mapel_id) as mapel_nama_all, GROUP_CONCAT(d_mpl_beban ORDER BY mapel_id) as beban_jam, GROUP_CONCAT(kelas_id ORDER BY mapel_id) as kelas_id
      //       FROM kr
      //       LEFT JOIN d_mpl ON d_mpl_kr_id = kr_id
      //       LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      //       LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
      //       WHERE kr_sk_id = $sk_id AND kelas_t_id = $t_id
      //       GROUP BY kr_id) as disjam ON kr_all.kr_id = disjam.kr_id
      //   ORDER BY kr_nama_depan")->result_array();

      $data['kelas_all'] = $this->db->query(
        "SELECT kelas_id, kelas_nama, kelas_nama_singkat FROM kelas WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id")->result_array();


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

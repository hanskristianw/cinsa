<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uj_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_sk');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_kelas');


    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan guru dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=7 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'Mid and Final';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //$data['tes'] = var_dump($this->db->last_query());

    //cari guru mengajar mapel mana saja

    $kr_id = $data['kr']['kr_id'];

    //SELECT * from d_mpl WHERE d_mpl_kr_id = $data['kr']['kr_id']

    $data['mapel_all'] = $this->db->query(
      "SELECT t_nama, sk_nama, d_mpl_mapel_id, mapel_nama, kelas_id, kelas_nama
      FROM d_mpl
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
      LEFT JOIN t ON kelas_t_id = t_id
      LEFT JOIN sk ON kelas_sk_id = sk_id
      WHERE d_mpl_kr_id = $kr_id
      ORDER BY t_id DESC, sk_nama, kelas_nama")->result_array();

    //var_dump($this->db->last_query());
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('uj_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function input(){

    if(!$this->input->post('arr')){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly!</div>');
      redirect('Uj_CRUD');
    }

    $arr = explode("|",$this->input->post('arr'));
    $mapel_id = $arr[0];
    $kelas_id = $arr[1];

    $data['title'] = 'Mid and Final';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['kelas'] = $this->_kelas->find_kelas_nama($kelas_id);

    $data['siswa_all'] = $this->db->query(
      "SELECT sis_nama_depan, sis_nama_bel, sis_no_induk
      FROM d_s
      LEFT JOIN sis ON d_s_sis_id = sis_id
      WHERE d_s_kelas_id = $kelas_id
      ORDER BY sis_nama_depan")->result_array();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('uj_crud/input',$data);
    $this->load->view('templates/footer');

  }

  public function update(){

    //dari method post
    $sk_post = $this->input->get('_id', true);

    //jika bukan dari form update sendiri
    if(!$sk_post){
      //ambil id dari method get
      $sk_get = $this->_sk->find_by_id($this->input->post('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if($sk_get['sk_id'] == 0 || !$sk_get['sk_id']){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Sekolah_CRUD');
      }
    }

    $this->form_validation->set_rules('sk_nama', 'School Name', 'required|trim');

    if($this->form_validation->run() == false){
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
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('sekolah_crud/update',$data);
      $this->load->view('templates/footer');
    }
    else{
      //fetch data hasil inputan
      $data = [
        'sk_nama' => $this->input->post('sk_nama'),
      ];

      //simpan ke db

      $this->db->where('sk_id', $this->input->post('_id'));
      $this->db->update('sk', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">School Name Updated!</div>');
      redirect('Sekolah_CRUD');
    }

  }
}

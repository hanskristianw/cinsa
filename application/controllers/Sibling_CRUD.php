<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sibling_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');



    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan TU dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 8 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Daftar Siswa NSA - YPPI';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $sk_id = $this->session->userdata('kr_sk_id');
    $data['sis_all'] = $this->db->query(
      "SELECT sk_nama, sis_nama_depan, sis_nama_bel, sis_no_induk, sis_ayah, sis_ibu, t_nama, sis_jk, IF(sis_alumni>0, 'Alumni', 'Aktif') as sis_alumni, IF(sis_jk>1, 'Perempuan', 'Laki-Laki') as sis_jk
      FROM sis
      LEFT JOIN t ON sis_t_id = t_id
      LEFT JOIN sk ON sis_sk_id = sk_id
      ORDER BY sis_nama_depan, sis_nama_bel"
    )->result_array();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('sibling_crud/index', $data);
    $this->load->view('templates/footer');
  }

}

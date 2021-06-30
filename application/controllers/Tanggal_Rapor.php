<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tanggal_Rapor extends CI_Controller
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
    if ($this->session->userdata('kr_jabatan_id') != 4 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {


    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['sk'] = $this->db->query(
      "SELECT *
      FROM sk
      WHERE sk_id = $sk_id")->row_array();

    $data['title'] = 'Tanggal Penerimaan Rapor '.$data['sk']['sk_nama'];

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Tanggal_Rapor/index', $data);
    $this->load->view('templates/footer');
  }

  public function update()
  {
    if($this->input->post('sk_id',true)){
      $rawdate = htmlentities($this->input->post('sk_mid'));
      $sk_mid = date('Y-m-d', strtotime($rawdate));

      $rawdate = htmlentities($this->input->post('sk_fin'));
      $sk_fin = date('Y-m-d', strtotime($rawdate));

      $data = [
        'sk_mid' => $sk_mid,
        'sk_fin' => $sk_fin
      ];

      $this->db->where('sk_id', $this->input->post('sk_id'));
      $this->db->update('sk', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil melakukan update!</div>');
      redirect('Tanggal_Rapor');
    }
  }

}

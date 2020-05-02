<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Changelog_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan wakakur, kadiv
    if ($this->session->userdata('kr_jabatan_id') != 1) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Changelog';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('changelog_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function save()
  {
    if ($this->input->post('changelog_alert', true)) {

      $changelog_alert = $this->input->post('changelog_alert', true);
      $changelog_jenis = $this->input->post('changelog_jenis', true);
      $changelog_text = $this->input->post('changelog_text', true);
      $changelog_tgl = $this->input->post('changelog_tgl', true);

      $data = [
        'changelog_alert' => $changelog_alert,
        'changelog_jenis' => $changelog_jenis,
        'changelog_text' => $changelog_text,
        'changelog_tgl' => $changelog_tgl,
      ];

      $this->db->insert('changelog', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Changelog Berhasil diinput!</div>');
      redirect('Profile');
    }
    else {
      redirect('Profile');
    }
  }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Announcement_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

  }

  public function changelog()
  {

    $data['title'] = 'Changelog';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Announcement_CRUD/changelog', $data);
    $this->load->view('templates/footer');
  }

}

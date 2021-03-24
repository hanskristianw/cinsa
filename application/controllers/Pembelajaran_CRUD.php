<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelajaran_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');


    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

  }

  public function index(){

    $data['title'] = 'Google Drive';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $kr_id = $this->session->userdata('kr_id');

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['gd'] = $this->db->query("SELECT kr_google_drive
                      FROM kr
                      WHERE kr_id = $kr_id")->row_array();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Pembelajaran_CRUD/index',$data);
    $this->load->view('templates/footer');

  }

  public function save_proses(){
    if($this->input->post('kr_google_drive')){

      $data = [
        'kr_google_drive' => $this->input->post('kr_google_drive')
      ];

      $this->db->where('kr_id', $this->session->userdata('kr_id'));
      $this->db->update('kr', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil menyimpan link!</div>');
      redirect('Pembelajaran_CRUD');
    }
  }

}

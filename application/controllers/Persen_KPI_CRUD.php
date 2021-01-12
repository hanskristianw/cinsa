<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Persen_KPI_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    if($this->session->userdata('kr_jabatan_id')!=1 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }

  }

  public function index()
  {

    $data['title'] = 'Master Persentase KPI & PA';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['p_master'] = $this->db->query(
      "SELECT *
      FROM
      persen_master
      WHERE persen_master_id = 1"
    )->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Persen_KPI_CRUD/index', $data);
    $this->load->view('templates/footer');
  }

  public function save()
  {

    if ($this->input->post('persen_master_id')) {

      $data = [
        'persen_master_pa' => $this->input->post('persen_master_pa'),
        'persen_master_kpi' => $this->input->post('persen_master_kpi'),
      ];

      $this->db->where('persen_master_id', $this->input->post('persen_master_id'));
      $this->db->update('persen_master', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Persentase berhasil diupdate!</div>');
      redirect('Persen_KPI_CRUD');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }


}

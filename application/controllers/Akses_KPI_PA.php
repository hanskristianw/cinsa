<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akses_KPI_PA extends CI_Controller
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

    $data['title'] = 'Akses KPI - PA';

    $data['a'] = $this->db->query(
                    "SELECT *
                    FROM akses_kpi_pa"
                  )->row_array();

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Akses_KPI_PA/index', $data);
    $this->load->view('templates/footer');

  }

  public function update_pa(){
    if($this->input->post('akses_pa') != NULL){
      $akses_pa = $this->input->post('akses_pa');

      if($akses_pa == 1){
        $data = [
          'akses_pa' => 0,
        ];
      }elseif($akses_pa == 0){
        $data = [
          'akses_pa' => 1,
        ];
      }

      $this->db->where('akses_kpi_pa_id', 1);
      $this->db->update('akses_kpi_pa', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berhasil merubah akses</div>');
      redirect('Akses_KPI_PA');

    }
  }

  public function update_kpi(){
    if($this->input->post('akses_kpi') != NULL){
      $akses_kpi = $this->input->post('akses_kpi');

      if($akses_kpi == 1){
        $data = [
          'akses_kpi' => 0,
        ];
      }elseif($akses_kpi == 0){
        $data = [
          'akses_kpi' => 1,
        ];
      }

      $this->db->where('akses_kpi_pa_id', 1);
      $this->db->update('akses_kpi_pa', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berhasil merubah akses</div>');
      redirect('Akses_KPI_PA');

    }
  }


}

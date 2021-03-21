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

    $data['t_all'] = $this->db->query(
      "SELECT *
      FROM t
      ORDER BY t_nama DESC"
    )->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Persen_KPI_CRUD/index', $data);
    $this->load->view('templates/footer');
  }

  public function persen(){

    if($this->input->post('t_id')){

      $t_id = $this->input->post('t_id');

      $cek = $this->db->query(
        "SELECT *
        FROM
        persen_master
        WHERE persen_master_t_id = $t_id"
      )->row_array();

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['t_nama'] =$this->db->query(
        "SELECT t_nama, t_id
        FROM
        t
        WHERE t_id = $t_id"
      )->row_array();

      if($cek){
        $data['title'] = 'Update Persentase KPI & PA';
        //sudah ada persentase

        $data['p_master'] = $this->db->query(
          "SELECT *
          FROM
          persen_master
          WHERE persen_master_t_id = $t_id"
        )->row_array();

        //var_dump($data['p_master']);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('Persen_KPI_CRUD/persen_update', $data);
        $this->load->view('templates/footer');

      }else{
        $data['title'] = 'Simpan Persentase KPI & PA';
        //belum ada persentase
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('Persen_KPI_CRUD/persen_save', $data);
        $this->load->view('templates/footer');
      }

    }

  }

  public function persen_update_proses()
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

  public function persen_save_proses()
  {

    if ($this->input->post('persen_master_pa')) {

      $data = [
        'persen_master_pa' => $this->input->post('persen_master_pa'),
        'persen_master_kpi' => $this->input->post('persen_master_kpi'),
        'persen_master_t_id' => $this->input->post('persen_master_t_id'),
      ];

      $this->db->insert('persen_master', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Persentase berhasil disimpan!</div>');
      redirect('Persen_KPI_CRUD');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }


}

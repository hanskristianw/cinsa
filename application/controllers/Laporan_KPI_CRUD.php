<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_KPI_CRUD extends CI_Controller
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
    if($this->input->get('jabatan_kpi_id', true)){
      $jabatan_kpi_id = $this->input->get('jabatan_kpi_id', true);

      $data['title'] = 'Pilih Jabatan';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['lap_jabatan_kpi_melihat'] = $jabatan_kpi_id;

      $kr_id = $this->session->userdata('kr_id');

      $data['jabatan_nama'] = $this->db->query(
        "SELECT jabatan_kpi_nama
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id"
      )->row_array();

      $data['jabatan_ada'] = $this->db->query(
        "SELECT lap_id, jabatan_kpi_nama
        FROM lap
        LEFT JOIN jabatan_kpi ON jabatan_kpi_id = lap_jabatan_kpi_dilihat
        WHERE lap_jabatan_kpi_melihat = $jabatan_kpi_id
        ORDER BY jabatan_kpi_nama"
      )->result_array();

      $data['jabatan_tidak_ada'] = $this->db->query(
        "SELECT jabatan_kpi_id, jabatan_kpi_nama
        FROM jabatan_kpi
        LEFT JOIN lap ON jabatan_kpi_id = lap_jabatan_kpi_dilihat
        WHERE jabatan_kpi_id NOT IN
        (SELECT jabatan_kpi_id
        FROM lap
        LEFT JOIN jabatan_kpi ON jabatan_kpi_id = lap_jabatan_kpi_dilihat
        WHERE lap_jabatan_kpi_melihat = $jabatan_kpi_id)
        GROUP BY jabatan_kpi_id
        ORDER BY jabatan_kpi_nama"
      )->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Laporan_KPI_CRUD/index', $data);
      $this->load->view('templates/footer');
    }

  }

  public function input_proses(){
    if($this->input->post('jabatan_kpi_id[]')){
      $data = array();
      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id[]');

      $jabatan_kpi_str = "";

      for ($i=0; $i < count($jabatan_kpi_id); $i++) {
        $jabatan_kpi_str .= $jabatan_kpi_id[$i];
        if($i != count($jabatan_kpi_id) - 1){
          $jabatan_kpi_str .= ",";
        }
      }

      $lap_jabatan_kpi_melihat = $this->input->post('lap_jabatan_kpi_melihat', true);

      $cek = $this->db->query(
        "SELECT *
        FROM lap
        WHERE lap_jabatan_kpi_melihat = $lap_jabatan_kpi_melihat AND lap_jabatan_kpi_dilihat IN ($jabatan_kpi_str)"
      )->result_array();

      // var_dump($cek);
      // //
      // if($cek)
      //   echo "ada";
      // else
      //   echo "gak ada";


      if($cek){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">1 atau lebih jabatan sudah terdaftar, silahkan cek daftar jabatan kembali!</div>');
        redirect('Laporan_KPI_CRUD?jabatan_kpi_id='.$lap_jabatan_kpi_melihat);
      }

      for($i=0;$i<count($jabatan_kpi_id);$i++){
          $data[$i] = [
            'lap_jabatan_kpi_melihat' => $lap_jabatan_kpi_melihat,
            'lap_jabatan_kpi_dilihat' => $jabatan_kpi_id[$i],
          ];
      }

      $this->db->insert_batch('lap', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Sukses menambahkan jabatan!</div>');
      redirect('Laporan_KPI_CRUD?jabatan_kpi_id='.$lap_jabatan_kpi_melihat);
    }
  }

  public function delete(){
    if($this->input->post('lap_id')){
      $lap_id = $this->input->post('lap_id');
      $lap_jabatan_kpi_melihat = $this->input->post('lap_jabatan_kpi_melihat', true);

      $this->db->where('lap_id', $lap_id);
      $this->db->delete('lap');

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berhasil menghapus jabatan!</div>');
      redirect('Laporan_KPI_CRUD?jabatan_kpi_id='.$lap_jabatan_kpi_melihat);
    }
  }

}

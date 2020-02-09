<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jurnal_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_jenj');
    $this->load->model('_t');
    $this->load->model('_siswa');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_d_s');
    $this->load->model('_kelas');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    
    if ($this->session->userdata('kr_jabatan_id') != 7 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {
    if(mapel_menu() >= 1){
      //cek kelas ajar

      $data['title'] = 'Class List';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');

      $data['t_all'] = $this->db->query(
        "SELECT t_id, t_nama
        FROM t
        ORDER BY t_nama DESC")->result_array();
  
      //$data['tes'] = var_dump($this->db->last_query());
  
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('jurnal_crud/index', $data);
      $this->load->view('templates/footer');
    }else{
      //jika bukan walkel redirect
      redirect('Profile');
    }

  }

  public function laporan()
  {
    if(mapel_menu() >= 1){
      //cek kelas ajar

      $data['title'] = 'Journal Report';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');

      $data['t_all'] = $this->db->query(
        "SELECT t_id, t_nama
        FROM t
        ORDER BY t_nama DESC")->result_array();
  
      //$data['tes'] = var_dump($this->db->last_query());
  
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('jurnal_crud/laporan', $data);
      $this->load->view('templates/footer');
    }else{
      //jika bukan walkel redirect
      redirect('Profile');
    }

  }

  public function save()
  {
    
    $jurnal_id = $this->input->post('jurnal_id',true);

    if(!$jurnal_id){

      $jurnal_isi = $this->input->post('jurnal_isi',true);
      $jurnal_tgl = $this->input->post('tgl_jurnal',true);
      $jurnal_mapel_id = $this->input->post('mapel_id',true);
      $jurnal_kelas_id = $this->input->post('kelas_id',true);


      $cek = $this->db->query(
        "SELECT *
        FROM jurnal
        WHERE jurnal_mapel_id = $jurnal_mapel_id AND jurnal_kelas_id = $jurnal_kelas_id  AND jurnal_tgl = '$jurnal_tgl'")->result();

      if(!$cek){

        $data = [
          'jurnal_isi' => $jurnal_isi,
          'jurnal_tgl' => $jurnal_tgl,
          'jurnal_mapel_id' => $jurnal_mapel_id,
          'jurnal_kelas_id' => $jurnal_kelas_id
        ];
  
        $this->db->insert('jurnal', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('Jurnal_CRUD');
      }
      else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Jurnal Sudah ada!</div>');
        redirect('Jurnal_CRUD');
      }
    }
    else{
      
      $jurnal_isi = $this->input->post('jurnal_isi',true);
      $data = [
        'jurnal_isi' => $jurnal_isi
      ];

      $this->db->where('jurnal_id', $jurnal_id);
      $this->db->update('jurnal', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update Success!</div>');
      redirect('Jurnal_CRUD');
    }
  }

  public function delete_absent(){
    
    $jurnal_id = $this->input->post('jurnal_id',true);

    if($jurnal_id){

      $this->db->where('jurnal_id', $jurnal_id);
      $this->db->delete('jurnal');
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Delete Success!</div>');
      redirect('Jurnal_CRUD/laporan');
    }
  }

  
}

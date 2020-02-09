<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Absent_CRUD extends CI_Controller
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
    if(walkel_menu() >= 1){
      //cek kelas ajar

      $data['title'] = 'Class List';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');

      $data['kelas_all'] = $this->db->query(
        "SELECT kelas_id, kelas_nama, t_nama
        FROM kelas
        LEFT JOIN t ON t_id = kelas_t_id
        WHERE kelas_kr_id = $kr_id
        ORDER BY t_nama DESC")->result_array();
  
      //$data['tes'] = var_dump($this->db->last_query());
  
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('absent_crud/index', $data);
      $this->load->view('templates/footer');
    }else{
      //jika bukan walkel redirect
      redirect('Profile');
    }

  }

  public function save()
  {
    
    $d_s_id = $this->input->post('d_s_id[]',true);

    if($d_s_id){

      $absen_siswa_tgl = $this->input->post('tgl_absen',true);
      $absen_siswa_ket = $this->input->post('absen_siswa_ket[]',true);


      //var_dump($absen_siswa_ket);
      
      for($i=0;$i<count($d_s_id);$i++){

        if($this->input->post($d_s_id[$i],true)!=0){
          $data[$i] = [
            'absen_siswa_d_s_id' => $d_s_id[$i],
            'absen_siswa_tgl' => $absen_siswa_tgl,
            'absen_siswa_status' => $this->input->post($d_s_id[$i],true),
            'absen_siswa_ket' => $absen_siswa_ket[$i]
          ];
        }
      }
      
      //var_dump($data);

      if($data){
        $this->db->insert_batch('absen_siswa', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('Absent_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Pilih Setidaknya 1 siswa Tidak Masuk, Ijin atau Alpha!</div>');
        redirect('Absent_CRUD');
      }

    }
  }

  public function delete_absent(){
    $absen_siswa_id = $this->input->post('absen_siswa_id',true);

    if($absen_siswa_id){
      
      $this->db->where('absen_siswa_id', $absen_siswa_id);
      $this->db->delete('absen_siswa');
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Delete Success!</div>');
      redirect('Absent_CRUD');
    }
  }
  
}

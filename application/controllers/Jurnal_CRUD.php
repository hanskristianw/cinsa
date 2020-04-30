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
  }

  public function index()
  {
    if(mapel_menu() >= 1){
      //cek kelas ajar

      $data['title'] = 'Jurnal Guru per Mapel';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');

      $data['t_all'] = $this->db->query(
        "SELECT t_id, t_nama
        FROM t
        ORDER BY t_nama DESC")->result_array();

      $data['bulan'] = $this->db->query(
        "SELECT *
        FROM bulan ORDER BY bulan_semester")->result_array();

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

  public function input(){

    $mapel_id = $this->input->post('mapel_id',true);
    $t_id = $this->input->post('t_id',true);
    $bulan_id = $this->input->post('bulan_id',true);

    if($mapel_id && $t_id){

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['bulan'] = $this->db->query(
        "SELECT *
        FROM bulan WHERE bulan_id = $bulan_id")->row_array();

      $kr_id = $this->session->userdata('kr_id');
      $data['kr_id'] = $kr_id;
      $data['t_id'] = $t_id;
      $data['mapel_id'] = $mapel_id;
      $data['kelas_ajar'] = $this->db->query(
        "SELECT DISTINCT jampel_kelas_id, kelas_nama
        FROM jampel
        LEFT JOIN kelas ON jampel_kelas_id = kelas_id
        WHERE jampel_kr_id = $kr_id AND jampel_mapel_id = $mapel_id AND kelas_t_id = $t_id
        ORDER BY jampel_kelas_id ")->result_array();

      $data['mapel'] = $this->db->query(
        "SELECT mapel_id, mapel_nama
        FROM mapel
        WHERE mapel_id = $mapel_id")->row_array();

      ///////////////////////////////////////////////
      //////cek dulu datanya sudah ada atau Belum////
      ///////////////////////////////////////////////
      $cek = $this->db->query(
        "SELECT *
        FROM jurnal
        WHERE jurnal_mapel_id = $mapel_id AND jurnal_bulan_id = $bulan_id AND jurnal_t_id = $t_id")->result_array();

      if($cek){
        $data['title'] = 'Update Jurnal';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('jurnal_crud/update', $data);
        $this->load->view('templates/footer');
      }else{
        $data['title'] = 'Input Jurnal';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('jurnal_crud/input', $data);
        $this->load->view('templates/footer');
      }

    }
  }


  public function save_jurnal()
  {
    //untuk tabel jurnal
    $counter = $this->input->post('counter[]',true);
    $jurnal_kelas_id = $this->input->post('kelas_id[]',true);
    $jurnal_mapel_id = $this->input->post('mapel_id',true);
    $jurnal_mapel_outline_id = $this->input->post('jurnal_mapel_outline_id[]',true);
    $bulan_id = $this->input->post('bulan_id',true);
    $jurnal_jam_ke = $this->input->post('jurnal_jam_ke[]',true);
    $jurnal_hari_ke = $this->input->post('jurnal_hari_ke[]',true);
    $jurnal_minggu_ke = $this->input->post('jurnal_minggu_ke[]',true);
    $jurnal_t_id = $this->input->post('t_id',true);


    ///////////////////////////////////////////////
    //////cek dulu datanya sudah ada atau Belum////
    ///////////////////////////////////////////////
    $cek = $this->db->query(
      "SELECT *
      FROM jurnal
      WHERE jurnal_mapel_id = $jurnal_mapel_id AND jurnal_bulan_id = $bulan_id AND jurnal_t_id = $jurnal_t_id")->result_array();

    if($counter && !$cek){

      //var_dump($counter);
      for($i=0;$i<count($counter);$i++){

        $jurnal_d_s_id_absen = "";
        $jurnal_d_s_id_ket = "";
        if($this->input->post("c".$counter[$i],true)){
          $d_s_tak_masuk = $this->input->post("c".$counter[$i],true);
          $ket_tak_masuk = $this->input->post("k".$counter[$i],true);

          for($j=0;$j<count($d_s_tak_masuk);$j++){
            if($j!=0){
              $jurnal_d_s_id_absen .= ",".$d_s_tak_masuk[$j];
              $jurnal_d_s_id_ket .= "{/}".$ket_tak_masuk[$j];
            }
            else{
              $jurnal_d_s_id_absen .= $d_s_tak_masuk[$j];
              $jurnal_d_s_id_ket .= $ket_tak_masuk[$j];
            }
          }
        }
        //echo $jurnal_d_s_id_absen;

        // if($this->input->post($d_s_id[$i],true)!=0){
          $data[$i] = [
            'jurnal_mapel_id' => $jurnal_mapel_id,
            'jurnal_mapel_outline_id' => $jurnal_mapel_outline_id[$i],
            'jurnal_kelas_id' => $jurnal_kelas_id[$i],
            'jurnal_bulan_id' => $bulan_id,
            'jurnal_jam_ke' => $jurnal_jam_ke[$i],
            'jurnal_hari_ke' => $jurnal_hari_ke[$i],
            'jurnal_minggu_ke' => $jurnal_minggu_ke[$i],
            'jurnal_d_s_id_absen' => $jurnal_d_s_id_absen,
            'jurnal_t_id' => $jurnal_t_id,
            'jurnal_d_s_id_ket' => $jurnal_d_s_id_ket
          ];
        // }
      }

      //var_dump($data);
      $this->db->insert_batch('jurnal', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
      redirect('Jurnal_CRUD');

    }
    else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal, kemungkinan data sudah ada atau anda tidak memiliki akses ke halaman ini!</div>');
      redirect('Jurnal_CRUD');
    }
  }

  public function save_update(){

    $jurnal_id = $this->input->post('jurnal_id[]',true);
    $counter = $this->input->post('counter[]',true);
    $jurnal_kelas_id = $this->input->post('kelas_id[]',true);
    $jurnal_mapel_id = $this->input->post('mapel_id',true);
    $jurnal_mapel_outline_id = $this->input->post('jurnal_mapel_outline_id[]',true);
    $bulan_id = $this->input->post('bulan_id',true);
    $jurnal_jam_ke = $this->input->post('jurnal_jam_ke[]',true);
    $jurnal_hari_ke = $this->input->post('jurnal_hari_ke[]',true);
    $jurnal_minggu_ke = $this->input->post('jurnal_minggu_ke[]',true);
    $jurnal_t_id = $this->input->post('jurnal_t_id[]',true);


    if($jurnal_id){

      //var_dump($jurnal_id);
      for($i=0;$i<count($jurnal_id);$i++){

        $jurnal_d_s_id_absen = "";
        $jurnal_d_s_id_ket = "";
        if($this->input->post("c".$counter[$i],true)){
          $d_s_tak_masuk = $this->input->post("c".$counter[$i],true);
          $ket_tak_masuk = $this->input->post("k".$counter[$i],true);

          for($j=0;$j<count($d_s_tak_masuk);$j++){
            if($j!=0){
              $jurnal_d_s_id_absen .= ",".$d_s_tak_masuk[$j];
              $jurnal_d_s_id_ket .= "{/}".$ket_tak_masuk[$j];
            }
            else{
              $jurnal_d_s_id_absen .= $d_s_tak_masuk[$j];
              $jurnal_d_s_id_ket .= $ket_tak_masuk[$j];
            }
          }
        }
        //echo $jurnal_d_s_id_absen;

        // if($this->input->post($d_s_id[$i],true)!=0){
          $data[$i] = [
            'jurnal_mapel_id' => $jurnal_mapel_id,
            'jurnal_mapel_outline_id' => $jurnal_mapel_outline_id[$i],
            'jurnal_kelas_id' => $jurnal_kelas_id[$i],
            'jurnal_bulan_id' => $bulan_id,
            'jurnal_jam_ke' => $jurnal_jam_ke[$i],
            'jurnal_hari_ke' => $jurnal_hari_ke[$i],
            'jurnal_minggu_ke' => $jurnal_minggu_ke[$i],
            'jurnal_d_s_id_absen' => $jurnal_d_s_id_absen,
            'jurnal_id' => $jurnal_id[$i],
            'jurnal_t_id' => $jurnal_t_id[$i],
            'jurnal_d_s_id_ket' => $jurnal_d_s_id_ket
          ];
        // }
      }

      //var_dump($data);
      $this->db->update_batch('jurnal',$data, 'jurnal_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
      redirect('Jurnal_CRUD');

    }
    else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Jurnal_CRUD');
    }
  }

}

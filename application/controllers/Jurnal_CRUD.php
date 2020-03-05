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

      $data['title'] = 'Jurnal Kelas per Mapel';

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

      $data['title'] = 'Report Jurnal';

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
      
      redirect('Profile');
    }

  }

  public function add_jurnal(){
    
    $mapel_id = $this->input->post('mapel_id',true);
    $kelas_id = $this->input->post('kelas_id',true);
    if($mapel_id && $kelas_id){

      $data['title'] = 'Tambah Jurnal';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));


      $data['kelas_nama'] = $this->db->query(
        "SELECT kelas_nama
        FROM kelas
        WHERE kelas_id = $kelas_id")->row_array();

      $jenj_id = $this->db->query(
        "SELECT jenj_id
        FROM kelas
        LEFT JOIN jenj ON kelas_jenj_id = jenj_id
        WHERE kelas_id = $kelas_id")->row_array(); 

      $jenj_id = $jenj_id['jenj_id'];
      
      $data['outline_all'] = $this->db->query(
        "SELECT mapel_outline_id, mapel_outline_nama
        FROM mapel_outline
        WHERE mapel_outline_mapel_id = $mapel_id AND mapel_outline_jenj_id = $jenj_id")->result_array();

      $data['mapel_nama'] = $this->db->query(
        "SELECT mapel_id, mapel_nama
        FROM mapel
        WHERE mapel_id = $mapel_id")->row_array();

      $data['kelas_id'] = $kelas_id;

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('jurnal_crud/add_jurnal', $data);
      $this->load->view('templates/footer');
    }
  }

  public function save_jurnal()
  {
    //untuk tabel jurnal
    $jurnal_tgl = $this->input->post('jurnal_tgl',true);
    $jurnal_mapel_outline_id = $this->input->post('jurnal_mapel_outline_id',true);
    $jurnal_kelas_id = $this->input->post('jurnal_kelas_id',true);
    $mapel_id = $this->input->post('mapel_id',true);
    

    if($jurnal_tgl && $jurnal_mapel_outline_id && $jurnal_kelas_id){

      //cek apakah data sudah ada
      $cek = $this->db->query(
        "SELECT *
        FROM jurnal
        LEFT JOIN mapel_outline ON mapel_outline_id = jurnal_mapel_outline_id
        LEFT JOIN mapel ON mapel_outline_mapel_id = mapel_id
        WHERE jurnal_tgl = '$jurnal_tgl' AND jurnal_kelas_id = $jurnal_kelas_id AND mapel_id = $mapel_id")->row_array();

      if(!$cek){

        $data2 = [
          'jurnal_tgl' => $jurnal_tgl,
          'jurnal_mapel_outline_id' => $jurnal_mapel_outline_id,
          'jurnal_kelas_id' => $jurnal_kelas_id
        ];
  
        $this->db->insert('jurnal', $data2);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('Jurnal_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Jurnal sudah ada!</div>');
        redirect('Jurnal_CRUD');
      }


      ////////////////////////////
      //untuk tabel absen jurnal//
      ////////////////////////////
      // $absen_j_jurnal_id = $this->db->insert_id();
      // $absen_j_ket = $this->input->post('absen_j_ket[]',true);
      // $d_s_id = $this->input->post('d_s_id[]',true);

      // for($i=0;$i<count($d_s_id);$i++){

      //   if($this->input->post($d_s_id[$i],true)!=0){
      //     $data[$i] = [
      //       'absen_j_jurnal_id' => $absen_j_jurnal_id,
      //       'absen_j_d_s_id' => $d_s_id[$i],
      //       'absen_j_ket' => $absen_j_ket[$i]
      //     ];
      //   }
      // }

      // if($data){
      //   //ada yang tidak masuk
      //   $this->db->insert_batch('absen_j', $data);
      //   $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
      //   redirect('Jurnal_CRUD');
      // }else{
      //  //semua masuk
      //  $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
      //  redirect('Jurnal_CRUD');
      // }
    }
    else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Jurnal_CRUD');
    }
  }

  public function edit_jurnal(){
    
    $jurnal_id = $this->input->post('jurnal_id',true);

    if($jurnal_id){

      $data['title'] = 'Edit Jurnal';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['jurnal'] = $this->db->query(
        "SELECT *
        FROM jurnal
        LEFT JOIN mapel_outline ON mapel_outline_id = jurnal_mapel_outline_id
        LEFT JOIN mapel ON mapel_outline_mapel_id = mapel_id
        LEFT JOIN kelas ON jurnal_kelas_id = kelas_id
        LEFT JOIN jenj ON kelas_jenj_id = jenj_id
        WHERE jurnal_id = $jurnal_id")->row_array();

      $jenj_id = $data['jurnal']['jenj_id'];
      $mapel_id = $data['jurnal']['mapel_id'];
      

      $data['outline_all'] = $this->db->query(
        "SELECT mapel_outline_id, mapel_outline_nama
        FROM mapel_outline
        WHERE mapel_outline_mapel_id = $mapel_id AND mapel_outline_jenj_id = $jenj_id")->result_array();
        
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('jurnal_crud/edit_jurnal', $data);
      $this->load->view('templates/footer');
    }
  }

  public function save_update(){
    
    $jurnal_tgl = $this->input->post('jurnal_tgl',true);
    $jurnal_mapel_outline_id = $this->input->post('jurnal_mapel_outline_id',true);
    $jurnal_kelas_id = $this->input->post('jurnal_kelas_id',true);
    $mapel_id = $this->input->post('mapel_id',true);
    $tgl_skrng = $this->input->post('tgl_skrng',true);

    if($jurnal_tgl && $jurnal_mapel_outline_id && $jurnal_kelas_id){

      //cek apakah data sudah ada dan bukan merupakan tanggal yang sedang diupdate
      $cek = $this->db->query(
        "SELECT *
        FROM jurnal
        LEFT JOIN mapel_outline ON mapel_outline_id = jurnal_mapel_outline_id
        LEFT JOIN mapel ON mapel_outline_mapel_id = mapel_id
        WHERE jurnal_tgl = '$jurnal_tgl' AND jurnal_kelas_id = $jurnal_kelas_id AND mapel_id = $mapel_id AND jurnal_tgl <> '$tgl_skrng'")->row_array();

      if(!$cek){

        $data = [
          'jurnal_tgl' => $jurnal_tgl,
          'jurnal_mapel_outline_id' => $jurnal_mapel_outline_id
        ];
  
        $this->db->where('jurnal_id', $this->input->post('jurnal_id', true));
        $this->db->update('jurnal', $data); 

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Success!</div>');
        redirect('Jurnal_CRUD');

      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Jurnal sudah ada!</div>');
        redirect('Jurnal_CRUD');
      }

    }
    else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Jurnal_CRUD');
    }
  }

  public function add_absen(){
    $jurnal_id = $this->input->post('jurnal_id',true);
    if($jurnal_id){

      $data['title'] = 'Absensi Ketidakhadiran';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $jurnal = $this->db->query(
        "SELECT *
        FROM jurnal
        LEFT JOIN mapel_outline ON mapel_outline_id = jurnal_mapel_outline_id
        LEFT JOIN kelas ON jurnal_kelas_id = kelas_id
        WHERE jurnal_id = $jurnal_id")->row_array(); 

      $kelas_id = $jurnal['kelas_id'];
      $jurnal_tgl = $jurnal['jurnal_tgl'];

      
      $data['kelas_nama'] = $jurnal['kelas_nama'];
      $data['jurnal_id'] = $jurnal['jurnal_id'];
      $data['kelas_id'] = $kelas_id;
      $data['mapel_outline_nama'] = $jurnal['mapel_outline_nama'];
      $data['jurnal_tgl'] = $jurnal_tgl;

      $data['siswa_tdk_masuk_walkel'] = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk, absen_siswa_status, absen_siswa_ket
        FROM absen_siswa
        LEFT JOIN d_s ON absen_siswa_d_s_id = d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE d_s_kelas_id = $kelas_id AND absen_siswa_tgl = '$jurnal_tgl'")->result_array(); 

      $data['siswa_tdk_masuk_jurnal'] = $this->db->query(
        "SELECT absen_j_id, sis_nama_depan, sis_nama_bel, sis_no_induk, absen_j_ket
        FROM absen_j
        LEFT JOIN d_s ON absen_j_d_s_id = d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE absen_j_jurnal_id = $jurnal_id")->result_array(); 

      //cari siswa dikelas itu
      $data['sis'] = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE d_s_kelas_id = $kelas_id AND d_s_id NOT IN (
          SELECT absen_j_d_s_id
          FROM absen_j
          WHERE absen_j_jurnal_id = $jurnal_id
        )
        ORDER BY sis_nama_depan")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('jurnal_crud/add_absen', $data);
      $this->load->view('templates/footer');
    }
  }

  public function add_absen_proses(){
    $tidak_masuk = $this->input->post('tidak_masuk[]',true);
    $jurnal_id = $this->input->post('jurnal_id',true);

    if($tidak_masuk){
      for($i=0;$i<count($tidak_masuk);$i++){
        $data[$i] = [
          'absen_j_jurnal_id' => $jurnal_id,
          'absen_j_d_s_id' => $tidak_masuk[$i],
          'absen_j_ket' => $this->input->post($tidak_masuk[$i],true)
        ];
      }

      //var_dump($data);

      $this->db->insert_batch('absen_j', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
      redirect('Jurnal_CRUD');

    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pilih Setidaknya 1 siswa yang tidak masuk!</div>');
      redirect('Jurnal_CRUD');
    }

  }

  public function delete_absen(){
    $absen_j_id = $this->input->post('absen_j_id',true);
    if($absen_j_id){
      $this->db->where('absen_j_id', $absen_j_id);
      $this->db->delete('absen_j');
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Delete Success!</div>');
      redirect('Jurnal_CRUD');
    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Jurnal_CRUD');
    }
  }

  public function laporan_show(){
    $mapel_id = $this->input->post('mapel_id',true);
    $t_id = $this->input->post('t_id',true);
    if($mapel_id){
      
      $mapel = $this->db->query(
        "SELECT *
        FROM mapel
        WHERE mapel_id = $mapel_id")->row_array(); 

      $data['mapel_nama'] = $mapel['mapel_nama'];

      $data['title'] = 'Laporan Jurnal';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      
      $data['lapor'] = $this->db->query(
        "SELECT mapel_outline_nama, jurnal_tgl, kelas_nama, sk_nama, jenj_urutan
        FROM jurnal
        LEFT JOIN mapel_outline ON jurnal_mapel_outline_id = mapel_outline_id
        LEFT JOIN kelas ON jurnal_kelas_id = kelas_id
        LEFT JOIN jenj ON kelas_jenj_id = jenj_id
        LEFT JOIN sk ON kelas_sk_id = sk_id
        WHERE kelas_t_id = $t_id AND mapel_outline_mapel_id = $mapel_id
        ORDER BY sk_nama, jenj_urutan, kelas_nama, jurnal_tgl DESC")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('jurnal_crud/laporan_show', $data);
      $this->load->view('templates/footer');

    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }
  
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admission_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kelas');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');
    $this->load->model('_t');
    $this->load->model('_siswa');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan guru dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id') != 8){
      redirect('Profile');
    }
  }

  public function index(){

  }
  public function buku(){
    
    $data['title'] = 'Daftar Buku';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['b_all'] = $this->db->query(
      "SELECT *
      FROM buku
      LEFT JOIN penerbit ON buku_penerbit_id = penerbit_id
      ORDER BY buku_nama ASC")->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Admission_CRUD/buku', $data);
    $this->load->view('templates/footer');
  }

  public function add_buku(){

    $data['p_all'] = $this->db->query(
      "SELECT *
      FROM penerbit
      ORDER BY penerbit_nama ASC")->result_array();

    if(count($data['p_all'])>0){

      $data['title'] = 'Tambah Buku';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
  
      $data['sk_id'] = $this->session->userdata('kr_sk_id');
      $sk_id = $this->session->userdata('kr_sk_id');
  
        
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Admission_CRUD/add_buku', $data);
      $this->load->view('templates/footer');
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Tambahkan setidaknya 1 penerbit!</div>');
      redirect('Admission_CRUD/buku');
    }

  }

  public function add_buku_proses(){

    $buku_nama = $this->input->post('buku_nama', true);
    $buku_harga_beli = $this->input->post('buku_harga_beli', true);
    $buku_harga_jual = $this->input->post('buku_harga_jual', true);
    $buku_penerbit_id = $this->input->post('buku_penerbit_id', true);

    if (!$buku_nama || !$buku_harga_beli || !$buku_harga_jual) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{
      $data = [
        'buku_nama' => $buku_nama,
        'buku_harga_beli' => $buku_harga_beli,
        'buku_harga_jual' => $buku_harga_jual,
        'buku_penerbit_id' => $buku_penerbit_id
      ];
  
      $this->db->insert('buku', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Buku berhasil ditambah!</div>');
      redirect('Admission_CRUD/buku');
    }
  }

  public function edit_buku(){

    $buku_id = $this->input->post('buku_id', true);

    if($buku_id){

      $data['title'] = 'Edit Buku';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
  
      $data['sk_id'] = $this->session->userdata('kr_sk_id');
      $sk_id = $this->session->userdata('kr_sk_id');

      $data['buku'] = $this->db->query(
        "SELECT *
        FROM buku
        WHERE buku_id = $buku_id")->row_array();

      $data['cek_jual'] = $this->db->query(
        "SELECT *
        FROM buku_terjual_baru
        LEFT JOIN sis_baru ON buku_terjual_baru_sis_baru_id = sis_baru_id
        LEFT JOIN buku_jual ON buku_terjual_baru_buku_jual_id = buku_jual_id
        WHERE sis_konfirmasi = 1 AND buku_jual_buku_id = $buku_id
        ")->result_array();
      
      $data['p_all'] = $this->db->query(
        "SELECT *
        FROM penerbit
        ORDER BY penerbit_nama ASC")->result_array();
        
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Admission_CRUD/edit_buku', $data);
      $this->load->view('templates/footer');
    }

  }

  public function edit_buku_proses(){

    $buku_id = $this->input->post('buku_id', true);

    if (!$buku_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{

      $buku_nama = $this->input->post('buku_nama', true);
      $buku_harga_beli = $this->input->post('buku_harga_beli', true);
      $buku_harga_jual = $this->input->post('buku_harga_jual', true);
      $buku_penerbit_id = $this->input->post('buku_penerbit_id', true);

      $data = [
        'buku_nama' => $buku_nama,
        'buku_harga_beli' => $buku_harga_beli,
        'buku_harga_jual' => $buku_harga_jual,
        'buku_penerbit_id' => $buku_penerbit_id
      ];
  
      $this->db->where('buku_id', $buku_id);
      $this->db->update('buku', $data);
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Buku berhasil dirubah!</div>');
      redirect('Admission_CRUD/buku');
    }
  }

  public function penjualan(){
    $data['title'] = 'Daftar Penjualan Buku';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['sk_id'] = $this->session->userdata('kr_sk_id');
    $sk_id = $this->session->userdata('kr_sk_id');

		$data['sk_all'] = $this->db->query(
      "SELECT sk_id, sk_nama
      FROM sk
      WHERE sk_type = 0
      ORDER BY sk_nama ASC")->result_array();

    $data['t_all'] = $this->db->query(
      "SELECT t_id, t_nama
      FROM t
      ORDER BY t_nama DESC")->result_array();

		$data['buku_all'] = $this->db->query(
      "SELECT *
      FROM buku
      ORDER BY buku_nama")->result_array();
      
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Admission_CRUD/penjualan', $data);
    $this->load->view('templates/footer');

  }

  public function add_buku_to_penjualan(){
    
    $buku_id = $this->input->post('buku_id[]', true);
    $jenj_id = $this->input->post('jenj_id', true);
    $t_id = $this->input->post('t_id', true);

    if($buku_id){
      for($i=0;$i<count($buku_id);$i++){
        $data[$i] = [
          'buku_jual_buku_id' => $buku_id[$i],
          'buku_jual_jenj_id' => $jenj_id,
          'buku_jual_t_id' => $t_id
        ];
      }
      
      $this->db->insert_batch('buku_jual', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Buku berhasil didaftarkan ke penjualan!</div>');
      redirect('Admission_CRUD/penjualan');

    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Pilih 1 atau lebih buku!</div>');
      redirect('Admission_CRUD/penjualan');
    }
  }

  public function delete_buku(){
    if($this->input->post('buku_jual_id', true)){

      $buku_jual_id = $this->input->post('buku_jual_id', true);

      $this->db->where('buku_jual_id', $buku_jual_id);
      $this->db->delete('buku_jual');
      
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Buku berhasil dihapus dari penjualan!</div>');
      redirect('Admission_CRUD/penjualan');
    }
  }

  public function penerbit(){
    
    $data['title'] = 'Daftar Penerbit';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['p_all'] = $this->db->query(
      "SELECT *
      FROM penerbit
      ORDER BY penerbit_nama ASC")->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Admission_CRUD/penerbit', $data);
    $this->load->view('templates/footer');
  }

  public function add_penerbit(){
    
    $data['title'] = 'Tambah Penerbit';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['sk_id'] = $this->session->userdata('kr_sk_id');
    $sk_id = $this->session->userdata('kr_sk_id');
      
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Admission_CRUD/add_penerbit', $data);
    $this->load->view('templates/footer');
  }

  public function add_penerbit_proses(){
    
    $penerbit_nama = $this->input->post('penerbit_nama', true);

    if (!$penerbit_nama) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{
      $data = [
        'penerbit_nama' => $penerbit_nama
      ];
  
      $this->db->insert('penerbit', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Penerbit berhasil ditambah!</div>');
      redirect('Admission_CRUD/penerbit');
    }
  }

  public function edit_penerbit(){

    $penerbit_id = $this->input->post('penerbit_id', true);

    if($penerbit_id){

      $data['title'] = 'Edit Penerbit';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
  
      $data['sk_id'] = $this->session->userdata('kr_sk_id');
      $sk_id = $this->session->userdata('kr_sk_id');

      $data['penerbit'] = $this->db->query(
        "SELECT *
        FROM penerbit
        WHERE penerbit_id = $penerbit_id")->row_array();
        
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Admission_CRUD/edit_penerbit', $data);
      $this->load->view('templates/footer');
    }

  }

  public function edit_penerbit_proses(){

    $penerbit_id = $this->input->post('penerbit_id', true);

    if (!$penerbit_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{

      $penerbit_nama = $this->input->post('penerbit_nama', true);

      $data = [
        'penerbit_nama' => $penerbit_nama
      ];
  
      $this->db->where('penerbit_id', $penerbit_id);
      $this->db->update('penerbit', $data);
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Penerbit berhasil dirubah!</div>');
      redirect('Admission_CRUD/penerbit');
    }
  }

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keuangan_CRUD extends CI_Controller
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
    if($this->session->userdata('kr_jabatan_id') != 9){
      redirect('Profile');
    }
  }
  
  public function konfirmasi_buku(){
    
    $data['title'] = 'Daftar Bukti Pembayaran';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['k_all'] = $this->db->query(
      "SELECT *
      FROM konfirmasi
      WHERE konfirmasi_status = 0
      ORDER BY konfirmasi_tgl DESC")->result_array();

    $data['sis_baru_all'] = $this->db->query(
      "SELECT *
      FROM sis_baru
      LEFT JOIN d_s ON sis_baru_d_s_id = d_s_id
      LEFT JOIN sis ON sis_id = d_s_sis_id
      WHERE sis_konfirmasi = 0
      ORDER BY sis_tagihan, sis_baru_nama ASC")->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Keuangan_CRUD/konfirmasi_buku', $data);
    $this->load->view('templates/footer');
  }

  public function konfirmasi_baru_proses(){
    
    $sis_baru_id = $this->input->post('sis_baru_id', true);

    if (!$sis_baru_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{

      $cek = $this->db->query(
        "SELECT *
        FROM trans_baru
        WHERE trans_baru_sis_baru_id = $sis_baru_id")->result_array();

      if(!$cek){
        
        ///////////////////////////////////////////////
        //ubah status tagihan menjadi sudah dikonfirmasi
        ///////////////////////////////////////////////
        $data = [
          'sis_konfirmasi' => 1
        ];
    
        $this->db->where('sis_baru_id', $sis_baru_id);
        $this->db->update('sis_baru', $data);

        ///////////////////////////////////////////////
        //ubah bukti tagihan menjadi sudah dikonfirmasi
        ///////////////////////////////////////////////
        $konfirmasi_id = $this->input->post('konfirmasi_id', true);
        $data2 = [
          'konfirmasi_status' => 1
        ];
    
        $this->db->where('konfirmasi_id', $konfirmasi_id);
        $this->db->update('konfirmasi', $data2);

        /////////////////////////////////////////////////////////////////
        //pasangkan bukti tagihan dan tagihan dalam 1 tabel untuk laporan
        /////////////////////////////////////////////////////////////////

        $data = [
          'trans_baru_sis_baru_id' => $sis_baru_id,
          'trans_baru_konfirmasi_id' => $konfirmasi_id
        ];
    
        $this->db->insert('trans_baru', $data);


        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Konfirmasi Berhasil!</div>');
        redirect('Keuangan_CRUD/konfirmasi_buku');
      }
      else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Konfirmasi Sudah Pernah Dilakukan!</div>');
        redirect('Keuangan_CRUD/konfirmasi_buku');
      }
    }
  }

  public function laporan_buku(){
    $data['title'] = 'Laporan Penjualan Buku';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['t_all'] = $this->db->query(
      "SELECT t_id, t_nama
      FROM t
      ORDER BY t_nama DESC")->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Keuangan_CRUD/laporan_buku', $data);
    $this->load->view('templates/footer');
  }

  public function get_laporan_buku(){
    if($this->input->post('t_id', true)){
      
      $t_id = $this->input->post('t_id', true);

      $data = $this->db->query(
        "SELECT buku_id, buku_nama, sis_tagihan, buku_harga_beli, sis_baru_nama, sis_nama_depan, sis_nama_bel, buku_harga_beli, buku_harga_jual, penerbit_nama
        FROM buku_terjual_baru
        LEFT JOIN sis_baru ON buku_terjual_baru_sis_baru_id = sis_baru_id
        LEFT JOIN buku_jual ON buku_terjual_baru_buku_jual_id = buku_jual_id
        LEFT JOIN buku ON buku_jual_buku_id = buku_id
        LEFT JOIN penerbit ON buku_penerbit_id = penerbit_id
        LEFT JOIN d_s ON sis_baru_d_s_id = d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE sis_konfirmasi = 1 AND buku_jual_t_id = $t_id
        ORDER BY penerbit_nama, buku_nama")->result();

      echo json_encode($data);

    }
  }

}

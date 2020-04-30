<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Review_CRUD extends CI_Controller
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

      $data['title'] = 'Pilih Kelas';

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
      $this->load->view('review_crud/index', $data);
      $this->load->view('templates/footer');
    }else{
      //jika bukan walkel redirect
      redirect('Profile');
    }

  }

  public function view_review()
  {
    if($this->input->post('kelas_id',true)){

      $data['title'] = 'Review Jurnal';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kelas_id = $this->input->post('kelas_id',true);

      $data['review_all'] = $this->db->query(
        "SELECT *
        FROM jurnal
        LEFT JOIN mapel ON mapel_id = jurnal_mapel_id
        LEFT JOIN mapel_outline ON mapel_outline_id = jurnal_mapel_outline_id
        WHERE jurnal_kelas_id = $kelas_id AND jurnal_review = 0
        ORDER BY jurnal_bulan_id, jurnal_kelas_id, jurnal_minggu_ke, jurnal_hari_ke")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('review_crud/view_review', $data);
      $this->load->view('templates/footer');
    }
  }

  public function proses_review(){
    if($this->input->post('setujui[]',true)){
      $setujui = $this->input->post('setujui[]',true);
      $jurnal_id = $this->input->post('jurnal_id[]',true);
      //var_dump($jurnal_id);

      $index_absen = 0;
      for($i=0;$i<count($setujui);$i++){
        if($setujui[$i]==1){
          $data[$i] = [
            'jurnal_id' => $jurnal_id[$i],
            'jurnal_review' => 1
          ];
          if($this->input->post($jurnal_id[$i]."[]",true)){
            $absen_d_s = $this->input->post($jurnal_id[$i]."[]",true);
            $ket_d_s = $this->input->post("k".$jurnal_id[$i]."[]",true);
            for($j=0;$j<count($absen_d_s);$j++){
              $data2[$index_absen] = [
                'absen_j_jurnal_id' => $jurnal_id[$i],
                'absen_j_d_s_id' => $absen_d_s[$j],
                'absen_j_ket' => $ket_d_s[$j]
              ];
              $index_absen++;
            }

          }
        }
      }

      //update tabel jurnal
      $this->db->update_batch('jurnal',$data, 'jurnal_id');

      //insert tabel absen_j
      $this->db->insert_batch('absen_j', $data2);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
      redirect('Review_CRUD');
    }
  }

  public function cancel_review(){
    if(walkel_menu() >= 1){
      //cek kelas ajar

      $data['title'] = 'Pilih Kelas dan Mapel';

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
      $this->load->view('review_crud/cancel_review', $data);
      $this->load->view('templates/footer');
    }else{
      //jika bukan walkel redirect
      redirect('Profile');
    }
  }

  public function cancel_review_list(){
    if($this->input->post('kelas_id',true)){
      $data['title'] = 'Cancel Jurnal';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kelas_id = $this->input->post('kelas_id',true);
      $mapel_id = $this->input->post('mapel_id',true);

      $data['review_all'] = $this->db->query(
        "SELECT *
        FROM jurnal
        LEFT JOIN mapel ON mapel_id = jurnal_mapel_id
        LEFT JOIN mapel_outline ON mapel_outline_id = jurnal_mapel_outline_id
        WHERE jurnal_kelas_id = $kelas_id AND jurnal_review = 1 AND jurnal_mapel_id = $mapel_id
        ORDER BY jurnal_bulan_id, jurnal_kelas_id, jurnal_minggu_ke, jurnal_hari_ke")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('review_crud/cancel_review_list', $data);
      $this->load->view('templates/footer');
    }
  }

  public function proses_cancel_review(){
    if($this->input->post('jurnal_id',true)){
      $jurnal_id = $this->input->post('jurnal_id',true);

      $data = [
        'jurnal_review' => 0
      ];

      $this->db->where('jurnal_id', $jurnal_id);
      $this->db->update('jurnal', $data);

      $this->db->where('absen_j_jurnal_id', $jurnal_id);
      $this->db->delete('absen_j');

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Delete Sukses!</div>');
      redirect('Review_CRUD/cancel_review');
    }
  }

}

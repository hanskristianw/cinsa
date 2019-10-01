<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kelas');
    $this->load->model('_t');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');
    $this->load->model('_mapel');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }
  }

  public function index(){

    $data['title'] = 'CP Report';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['t_all'] = $this->_t->return_all();

    if($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }
    else if($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    else if($this->session->userdata('kr_jabatan_id')){
      if(return_menu_kepsek()){
        $kr_id = $this->session->userdata('kr_id');

        $data['sk_all'] = $this->db->query(
          "SELECT *
          FROM sk
          WHERE sk_kepsek = $kr_id")->result_array();

      }else{
        $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
      }
      
    }

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Laporan_CRUD/index',$data);
    $this->load->view('templates/footer');

  }

  public function afektif(){

    $data['title'] = 'Affective Report';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $kr_id = $this->session->userdata('kr_id');
    //data karyawan untuk konten
    $data['t_all'] = $this->_t->return_all();

    if($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->db->query(
        "SELECT sk_id, sk_nama
        FROM sk
        ORDER BY sk_nama")->result_array();
    }
    else if($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->db->query(
        "SELECT sk_id, sk_nama
        FROM kr
        LEFT JOIN sk ON kr_sk_id = sk_id
        WHERE kr_id = $kr_id")->result_array();
    }
    else if($this->session->userdata('kr_jabatan_id')){
      if(return_menu_kepsek()){
        $kr_id = $this->session->userdata('kr_id');

        $data['sk_all'] = $this->db->query(
          "SELECT *
          FROM sk
          WHERE sk_kepsek = $kr_id")->result_array();
          
      }else{
        $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
      }
    }

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Laporan_CRUD/afektif',$data);
    $this->load->view('templates/footer');

  }

  public function konseling(){

    $data['title'] = 'Counseling Report';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['t_all'] = $this->_t->return_all();

    if($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }

    if($this->session->userdata('kr_jabatan_id')){
      if(return_menu_kepsek()){
        $kr_id = $this->session->userdata('kr_id');

        $data['sk_all'] = $this->db->query(
          "SELECT *
          FROM sk
          WHERE sk_kepsek = $kr_id")->result_array();
          
      }else{
        $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
      }
      
    }

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Laporan_CRUD/konseling',$data);
    $this->load->view('templates/footer');

  }

  public function show_cp(){
    if($this->input->post('sk_id',TRUE)){

      $data['title'] = 'Cognitive & Psychomotor Report';
      $sk_id = $this->input->post('sk_id',TRUE);
      $kelas_id = $this->input->post('kelas_id',TRUE);
      $mapel_id = $this->input->post('mapel_id',TRUE);
      
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      
      $data['mapel'] = $this->_mapel->find_mapel_nama($mapel_id);

      $data['kelas_id'] = $kelas_id;
      //Dapatkan topik
      $data['topik'] = $this->db->query
                    ("SELECT DISTINCT topik_id
                    FROM tes
                    LEFT JOIN topik ON tes_topik_id = topik_id
                    LEFT JOIN mapel ON topik_mapel_id = mapel_id
                    LEFT JOIN d_s ON tes_d_s_id = d_s_id
                    WHERE topik_mapel_id = $mapel_id AND d_s_kelas_id = $kelas_id
                    ORDER BY topik_semester, topik_nama")->result_array();

      //Dapatkan ujian
      $data['ujian'] = $this->db->query
                    ("SELECT *
                    FROM uj
                    LEFT JOIN d_s ON uj_d_s_id = d_s_id
                    LEFT JOIN sis ON sis_id = d_s_sis_id
                    WHERE uj_mapel_id = $mapel_id AND d_s_kelas_id = $kelas_id
                    ORDER BY sis_no_induk, sis_nama_depan")->result_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Laporan_CRUD/show_cp',$data);
      $this->load->view('templates/footer');
    }
    else{
      redirect('Profile');
    }
  }

  public function show_afek(){
    if($this->input->post('sk_id',TRUE)){

      $data['title'] = 'Affective Report';
      $data['sk_id'] = $this->input->post('sk_id',TRUE);
      $data['t_id'] = $this->input->post('t',TRUE);
      $data['kelas_id'] = $this->input->post('kelas_id',TRUE);
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      
      $data['bulan'] = $this->db->query
                    ("SELECT *
                    FROM bulan")->result_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Laporan_CRUD/show_afek',$data);
      $this->load->view('templates/footer');
    }
    else{
      redirect('Profile');
    }
  }

  public function summary_index(){
    $data['title'] = 'Summary';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['t_all'] = $this->_t->return_all();

    if($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }
    else if($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    else if($this->session->userdata('kr_jabatan_id')){
      if(return_menu_kepsek()){
        $kr_id = $this->session->userdata('kr_id');

        $data['sk_all'] = $this->db->query(
          "SELECT *
          FROM sk
          WHERE sk_kepsek = $kr_id")->result_array();

      }else{
        $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
      }
      
    }

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Laporan_CRUD/summary_index',$data);
    $this->load->view('templates/footer');
  }

  
  public function summary_show(){
    if($this->input->post('sk_id',TRUE)){

      $sk_id = $this->input->post('sk_id',TRUE);
      $t_id = $this->input->post('t',TRUE);

      $data['title'] = 'Summary Detail';
      $data['sk_id'] = $sk_id;
      $data['t_id'] = $t_id;
      
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      //mapel di sekolah
      $data['kelas_all'] = $this->db->query
                    ("SELECT kelas_id, kelas_nama, COUNT(d_s_id) AS jumlah_murid
                    FROM kelas
                    LEFT JOIN d_s ON d_s_kelas_id = kelas_id
                    WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id
                    GROUP BY kelas_id
                    ORDER BY kelas_nama")->result_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Laporan_CRUD/summary_show',$data);
      $this->load->view('templates/footer');
    }
    else{
      redirect('Profile');
    }
  }

}

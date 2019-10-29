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
    $this->load->model('_bulan');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }
  }

  public function index(){

    // $data['title'] = 'CP Report';

    // //data karyawan yang sedang login untuk topbar
    // $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    // //data karyawan untuk konten
    // $data['t_all'] = $this->_t->return_all();

    // if($this->session->userdata('kr_jabatan_id')==5){
    //   $data['sk_all'] = $this->_sk->return_all();
    // }
    // else if($this->session->userdata('kr_jabatan_id')==4){
    //   $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    // }
    // else if($this->session->userdata('kr_jabatan_id')){
    //   if(return_menu_kepsek()){
    //     $kr_id = $this->session->userdata('kr_id');

    //     $data['sk_all'] = $this->db->query(
    //       "SELECT *
    //       FROM sk
    //       WHERE sk_kepsek = $kr_id")->result_array();

    //   }else{
    //     $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    //   }
      
    // }

    // $this->load->view('templates/header',$data);
    // $this->load->view('templates/sidebar',$data);
    // $this->load->view('templates/topbar',$data);
    // $this->load->view('Laporan_CRUD/index',$data);
    // $this->load->view('templates/footer');

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

  public function summary_index(){

    if(mapel_menu() == 0 && $this->session->userdata('kr_jabatan_id')!=5 && $this->session->userdata('kr_jabatan_id')!=4 && !return_menu_kepsek()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['title'] = 'Summary';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['t_all'] = $this->_t->return_all();
    $kr_id = $this->session->userdata('kr_id');

    if($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }
    else if($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    else if($this->session->userdata('kr_jabatan_id')){
      if(return_menu_kepsek()){

        $data['sk_all'] = $this->db->query(
          "SELECT *
          FROM sk
          WHERE sk_kepsek = $kr_id")->result_array();

      }else{
        $data['sk_all'] = $this->db->query(
          "SELECT DISTINCT sk_id, sk_nama
          FROM d_mpl
          LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
          LEFT JOIN sk ON mapel_sk_id = sk_id
          WHERE d_mpl_kr_id = $kr_id")->result_array();
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

      $kr_id = $this->session->userdata('kr_id');
      //mapel di sekolah

      if (mapel_menu() >= 1 && $this->session->userdata('kr_jabatan_id')!=5 && $this->session->userdata('kr_jabatan_id')!=4) {
        $data['kelas_all'] = $this->db->query
        ("SELECT kelas_id, kelas_nama, COUNT(DISTINCT d_s_id) AS jumlah_murid
        FROM d_mpl
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN d_s ON d_s_kelas_id = kelas_id
        WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id AND d_mpl_kr_id = $kr_id
        GROUP BY kelas_id
        ORDER BY kelas_nama")->result_array();
      }else{
        $data['kelas_all'] = $this->db->query
        ("SELECT kelas_id, kelas_nama, COUNT(d_s_id) AS jumlah_murid
        FROM kelas
        LEFT JOIN d_s ON d_s_kelas_id = kelas_id
        WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id
        GROUP BY kelas_id
        ORDER BY kelas_nama")->result_array();
      }
      

      $data['bulan_aktif'] = $this->db->query
                    ("SELECT *
                    FROM k_afek
                    WHERE k_afek_sk_id = $sk_id AND k_afek_t_id = $t_id
                    ORDER BY k_afek_bulan_id")->result_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Laporan_CRUD/summary_show',$data);
      $this->load->view('templates/footer');
    }
    else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function afektif_new(){
    $data['title'] = 'Affective Report';
    $kr_id = $this->session->userdata('kr_id');
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    if($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }
    elseif($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    elseif(konselor_menu()>0){
      $data['sk_all'] = $this->db->query("SELECT sk_id, sk_nama
                                          FROM konselor 
                                          LEFT JOIN sk ON konselor_sk_id = sk_id
                                          WHERE konselor_kr_id = $kr_id")->result_array();
    }elseif(return_menu_kepsek()){
      $data['sk_all'] = $this->db->query("SELECT *
                                          FROM sk
                                          WHERE sk_kepsek = $kr_id")->result_array();
    }

    $data['bulan_all'] = $this->_bulan->return_all();
    $data['tahun_all'] = $this->_t->return_all();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('laporan_crud/afektif_new', $data);
    $this->load->view('templates/footer');
  }
  
  public function show_report_by_subject()
  {
    if($this->input->post('t_id', true) && $this->input->post('sk_id', true) && $this->input->post('bulan_check[]', true)){
      $data['title'] = 'Affective Report';
      $t_id = $this->input->post('t_id', true);
      $sk_id = $this->input->post('sk_id', true);
      $bulan_id = $this->input->post('bulan_check[]', true);

      if(count($bulan_id)==0){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please select 1 or more month!</div>');
        redirect('Laporan_CRUD/afektif_new');
      }


      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas_all'] = $this->db->query(
        "SELECT kelas_id, kelas_nama, COUNT(d_s_id) AS jumlah_murid
        FROM kelas
        LEFT JOIN d_s ON d_s_kelas_id = kelas_id
        WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id
        GROUP BY kelas_id
        ORDER BY kelas_nama")->result_array();

      $data['bulan_id'] = $bulan_id;


      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('laporan_crud/show_report_by_subject', $data);
      $this->load->view('templates/footer');
      
    }
    else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function summary_ssp_index(){

    if(ssp_menu() == 0 && $this->session->userdata('kr_jabatan_id')!=5 && $this->session->userdata('kr_jabatan_id')!=4 && !return_menu_kepsek()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['title'] = 'SSP Summary';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['t_all'] = $this->_t->return_all();
    $kr_id = $this->session->userdata('kr_id');

    if($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }
    else if($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    else if($this->session->userdata('kr_jabatan_id')){
      if(return_menu_kepsek()){

        $data['sk_all'] = $this->db->query(
          "SELECT *
          FROM sk
          WHERE sk_kepsek = $kr_id")->result_array();

      }elseif(ssp_menu() >= 1){
        $data['sk_all'] = $this->db->query(
          "SELECT DISTINCT sk_id, sk_nama
          FROM ssp
          LEFT JOIN sk ON ssp_sk_id = sk_id
          WHERE ssp_kr_id = $kr_id")->result_array();
      }
      else{
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
        redirect('Profile');
      }
      
    }

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Laporan_CRUD/summary_ssp_index',$data);
    $this->load->view('templates/footer');
  }

  public function summary_ssp_show(){
    if($this->input->post('sk_id',TRUE)){

      $sk_id = $this->input->post('sk_id',TRUE);
      $t_id = $this->input->post('t',TRUE);

      $data['title'] = 'Summary Detail';
      $data['sk_id'] = $sk_id;
      $data['t_id'] = $t_id;
      
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');
      //mapel di sekolah

      //kalau dia pengajar ssp dan dia bukan wakakur atau kadiv 
      if (ssp_menu() >= 1 && $this->session->userdata('kr_jabatan_id')!=5 && $this->session->userdata('kr_jabatan_id')!=4) {
        $data['ssp_all'] = $this->db->query
        ("SELECT ssp_id, ssp_nama, COUNT(ssp_peserta_id) as jumlah_siswa
        FROM ssp
        LEFT JOIN ssp_peserta ON ssp_id = ssp_peserta_ssp_id
        WHERE ssp_sk_id = $sk_id AND ssp_t_id = $t_id AND ssp_kr_id = $kr_id
        GROUP BY ssp_id
        ORDER BY ssp_nama")->result_array();
      }else{
        //asumsinya disini dia kadiv dan wakakur
        $data['ssp_all'] = $this->db->query
        ("SELECT ssp_id, ssp_nama, COUNT(ssp_peserta_id) as jumlah_siswa
        FROM ssp
        LEFT JOIN ssp_peserta ON ssp_id = ssp_peserta_ssp_id
        WHERE ssp_sk_id = $sk_id AND ssp_t_id = $t_id
        GROUP BY ssp_id
        ORDER BY ssp_nama")->result_array();
      }
      

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Laporan_CRUD/summary_ssp_show',$data);
      $this->load->view('templates/footer');
    }
    else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

  }

}

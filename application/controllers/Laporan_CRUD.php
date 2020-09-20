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

    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
    redirect('Profile');

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

    $data['title'] = 'Rangkuman Nilai';

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

      $data['title'] = 'Detail Rangkuman';
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

  public function afektif_new2(){
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
    $this->load->view('laporan_crud/afektif_new2', $data);
    $this->load->view('templates/footer');
  }

  public function show_report_by_month()
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
      $data['t_id'] = $t_id;
      $data['sk_id'] = $sk_id;

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('laporan_crud/show_report_by_month', $data);
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

  public function Report_life(){

    if(konselor_menu()==0 && !return_menu_kepsek() && $this->session->userdata('kr_jabatan_id') != 5 && $this->session->userdata('kr_jabatan_id') != 4){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['title'] = 'Life Skill Report';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['t_all'] = $this->_t->return_all();

    $kr_id = $this->session->userdata('kr_id');

    if(konselor_menu()>0){
      $data['sk_all'] = $this->db->query("
        SELECT sk_id, sk_nama
        FROM konselor
        LEFT JOIN sk ON konselor_sk_id = sk_id
        WHERE konselor_kr_id = $kr_id")->result_array();
    }
    elseif(return_menu_kepsek()){
      $data['sk_all'] = $this->db->query(
        "SELECT *
        FROM sk
        WHERE sk_kepsek = $kr_id")->result_array();
    }
    elseif($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    elseif($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('laporan_crud/report_life', $data);
    $this->load->view('templates/footer');
  }

  public function Report_life_show(){
    if($this->input->post('sk_id',true)){
      $sk_id = $this->input->post('sk_id',true);
      $t_id = $this->input->post('t_id',true);


      $data['title'] = 'Life Skill Report';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['kelas_all'] = $this->db->query
                    ("SELECT kelas_id, kelas_nama, kelas_nama_singkat, COUNT(d_s_id) AS jumlah_murid
                    FROM kelas
                    LEFT JOIN d_s ON d_s_kelas_id = kelas_id
                    WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id
                    GROUP BY kelas_id
                    ORDER BY kelas_nama")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('laporan_crud/report_life_show', $data);
      $this->load->view('templates/footer');
    }
  }

  public function ptspas(){

    if(!return_menu_kepsek() && $this->session->userdata('kr_jabatan_id') != 5 && $this->session->userdata('kr_jabatan_id') != 4){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['title'] = 'Analisis PTS & PAS';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['t_all'] = $this->_t->return_all();

    $kr_id = $this->session->userdata('kr_id');

    if(return_menu_kepsek() && $this->session->userdata('kr_jabatan_id') != 5){
      $data['sk_all'] = $this->db->query(
        "SELECT *
        FROM sk
        WHERE sk_kepsek = $kr_id")->result_array();
    }
    elseif($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    elseif($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('laporan_crud/ptspas', $data);
    $this->load->view('templates/footer');
  }

  public function ptspasShow(){

    if($this->input->post('sk_ptspas',true) && $this->input->post('t_ptspas',true)){


      $data['title'] = 'Analisis PTS & PAS';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');
      $sk_id = $this->input->post('sk_ptspas',true);
      $t_id = $this->input->post('t_ptspas',true);

      $data['pJenis'] = $this->input->post('pJenis',true);
      $data['semester'] = $this->input->post('semester',true);

      $data['kelas_all'] = $this->db->query
        ("SELECT kelas_id, kelas_nama, COUNT(DISTINCT d_s_id) AS jumlah_murid
        FROM d_mpl
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN d_s ON d_s_kelas_id = kelas_id
        WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id
        GROUP BY kelas_id
        ORDER BY kelas_nama")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('laporan_crud/ptspasShow', $data);
      $this->load->view('templates/footer');

    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }


  }

  public function final_report(){

    $data['t_all'] = $this->_t->return_all();
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['title'] = 'Laporan Nilai Akhir';

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('laporan_crud/final_report', $data);
    $this->load->view('templates/footer');
  }

  public function final_report_show(){
    if($this->input->post('t',true) && $this->input->post('semester',true)){

      $t_id = $this->input->post('t',true);
      $semester = $this->input->post('semester',true);

      $data['title'] = 'Nilai Akhir';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');

      $data['kelas_all'] = $this->db->query
        ("SELECT kelas_id, kelas_nama, COUNT(DISTINCT d_s_id) AS jumlah_murid, sk_nama, kelas_jenj_id
        FROM d_mpl
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN d_s ON d_s_kelas_id = kelas_id
        LEFT JOIN sk ON kelas_sk_id = sk_id
        WHERE kelas_t_id = $t_id AND d_mpl_kr_id = $kr_id
        GROUP BY kelas_id
        ORDER BY kelas_sk_id, kelas_nama")->result_array();

      $data['semester'] = $semester;
      $data['t_id'] = $t_id;

      $data['kr_id'] = $kr_id;

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('laporan_crud/final_report_show', $data);
      $this->load->view('templates/footer');

    }

  }

  public function dkn(){
    $data['title'] = 'DKN';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['t_all'] = $this->_t->return_all();

    $kr_id = $this->session->userdata('kr_id');

    if(return_menu_kepsek()){
      $data['sk_all'] = $this->db->query(
        "SELECT *
        FROM sk
        WHERE sk_kepsek = $kr_id")->result_array();
    }
    elseif($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    elseif($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('laporan_crud/dkn', $data);
    $this->load->view('templates/footer');
  }

  public function dkn_show(){
    if($this->input->post('sk_id',true) && $this->input->post('t_id',true)){

      $data['title'] = 'Laporan DKN';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');
      $sk_id = $this->input->post('sk_id',true);
      $t_id = $this->input->post('t_id',true);
      $kelas_id = $this->input->post('kelas_id',true);

      $data['t_id'] = $t_id;
      $data['kelas_all'] = $this->db->query
        ("SELECT kelas_id, kelas_nama, COUNT(DISTINCT d_s_id) AS jumlah_murid, kelas_jenj_id
        FROM d_mpl
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN d_s ON d_s_kelas_id = kelas_id
        WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id AND kelas_id = $kelas_id
        GROUP BY kelas_id
        ORDER BY kelas_nama")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('laporan_crud/dkn_show', $data);
      $this->load->view('templates/footer');
    }
  }

  public function bi(){
    $data['title'] = 'Buku Induk';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['t_all'] = $this->_t->return_all();

    $kr_id = $this->session->userdata('kr_id');

    if(return_menu_kepsek()){
      $data['sk_all'] = $this->db->query(
        "SELECT *
        FROM sk
        WHERE sk_kepsek = $kr_id")->result_array();
    }
    elseif($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    elseif($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('laporan_crud/bi', $data);
    $this->load->view('templates/footer');
  }

  public function bi_show(){
    if($this->input->post('sk_id',true) && $this->input->post('t_id',true)){

      $data['title'] = 'Laporan Buku Induk';
      $data['sis_arr'] = $this->input->post('siswa_check[]',TRUE);
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');
      $sk_id = $this->input->post('sk_id',true);
      $t_id = $this->input->post('t_id',true);
      $kelas_id = $this->input->post('kelas_id',true);

      $data['t_id'] = $t_id;
      $data['kepsek'] = $this->db->query(
        "SELECT *
        FROM sk
        LEFT JOIN kelas ON kelas_sk_id = sk_id
        LEFT JOIN kr ON sk_kepsek = kr_id
        WHERE kelas_id = $kelas_id")->row_array();

      $data['walkel'] = $this->_kelas->find_walkel_by_kelas_id($kelas_id);

      $data['kelas_all'] = $this->db->query
        ("SELECT kelas_id, kelas_nama, COUNT(DISTINCT d_s_id) AS jumlah_murid, kelas_jenj_id, t_nama
        FROM d_mpl
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN t ON kelas_t_id = t_id
        LEFT JOIN d_s ON d_s_kelas_id = kelas_id
        WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id AND kelas_id = $kelas_id
        GROUP BY kelas_id
        ORDER BY kelas_nama")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('laporan_crud/bi_show', $data);
      $this->load->view('templates/footer');
    }
  }

  public function grade_history(){

    $data['title'] = 'History Nilai';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['t_all'] = $this->_t->return_all();

    $kr_id = $this->session->userdata('kr_id');

    if(return_menu_kepsek() && $this->session->userdata('kr_jabatan_id')!=5){
      $data['sk_all'] = $this->db->query(
        "SELECT *
        FROM sk
        WHERE sk_kepsek = $kr_id")->result_array();
    }
    elseif($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    elseif($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }
    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('laporan_crud/grade_history', $data);
    $this->load->view('templates/footer');

  }


  public function grade_history_show(){

    if($this->input->post('sk_id',true) && $this->input->post('t_id',true)){

      $data['title'] = 'History Nilai';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $kr_id = $this->session->userdata('kr_id');
      $sk_id = $this->input->post('sk_id',true);
      $t_id = $this->input->post('t_id',true);
      $kelas_id = $this->input->post('kelas_id',true);

      $data['t_id'] = $t_id;
      $data['kelas_all'] = $this->db->query
        ("SELECT kelas_id, kelas_nama, COUNT(DISTINCT d_s_id) AS jumlah_murid, kelas_jenj_id
        FROM d_mpl
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN d_s ON d_s_kelas_id = kelas_id
        WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id AND kelas_id = $kelas_id
        GROUP BY kelas_id
        ORDER BY kelas_nama")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('laporan_crud/grade_history_show', $data);
      $this->load->view('templates/footer');
    }

  }

  public function login_siswa_sekolah(){
    $data['title'] = 'Pilih Unit';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    if($this->session->userdata('kr_jabatan_id')==5){
      //Div pendidikan
      $data['sk_all'] = $this->_sk->return_all();
    }
    else if($this->session->userdata('kr_jabatan_id')==4){
      //Wakakur
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    else {
      redirect("Profile");
    }

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('laporan_crud/login_siswa_sekolah', $data);
    $this->load->view('templates/footer');
  }

  public function login_siswa(){
    if($this->input->post('sk_id',true)){

      $data['title'] = 'Daftar Siswa';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $sk_id = $this->input->post('sk_id',true);

      $data['siswa_all'] = $this->db->query
        ("SELECT sis_id, sis_no_induk, sis_nama_depan, sis_nama_bel, sis_username
        FROM sis
        WHERE sis_sk_id = $sk_id AND sis_alumni = 0
        ORDER BY sis_nama_depan, sis_nama_bel")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('laporan_crud/login_siswa', $data);
      $this->load->view('templates/footer');
    }
  }

}

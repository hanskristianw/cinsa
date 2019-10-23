<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_CRUD extends CI_Controller
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

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'Class List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['t_all'] = $this->_t->return_all();

    if($this->session->userdata('kr_jabatan_id')==5){
      $data['sk_all'] = $this->_sk->return_all();
    }
    elseif($this->session->userdata('kr_jabatan_id')==4){
      $data['sk_all'] = $this->_sk->find_by_id_arr($this->session->userdata('kr_sk_id'));
    }
    else{
      if(walkel_menu()>0){
        //jika dia wali kelas
        $kr_id = $this->session->userdata('kr_id');
        $data['sk_all'] = $this->db->query(
          "SELECT DISTINCT sk_id, sk_nama
          FROM kelas
          LEFT JOIN sk ON kelas_sk_id = sk_id
          WHERE kelas_kr_id = $kr_id
          ORDER BY sk_nama")->result_array();
      }
      elseif(return_menu_kepsek()){
        //jika dia wali kelas
        $kr_id = $this->session->userdata('kr_id');
        $data['sk_all'] = $this->db->query(
          "SELECT DISTINCT sk_id, sk_nama
          FROM sk
          WHERE sk_kepsek = $kr_id
          ORDER BY sk_nama")->result_array();
      }
      else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
        redirect('Profile');
      }
    }

    //var_dump($data['sk_all']);
    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Report_CRUD/index',$data);
    $this->load->view('templates/footer');

  }

  public function get_kelas(){
    if($this->input->post('id',TRUE)){
    
      $t_id = $this->input->post('id',TRUE);
      $sk_id = $this->input->post('sk_id',TRUE);
      
      //temukan jenjang id pada kelas itu
      if($this->session->userdata('kr_jabatan_id')==4 || $this->session->userdata('kr_jabatan_id')==5 || return_menu_kepsek()){
        $data = $this->db->query(
          "SELECT kelas_id, kelas_nama
          FROM kelas
          WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id
          ORDER BY kelas_nama")->result();
      }else{
        $kr_id = $this->session->userdata('kr_id');

        $data = $this->db->query(
          "SELECT kelas_id, kelas_nama
          FROM kelas
          WHERE kelas_kr_id = $kr_id AND kelas_t_id = $t_id AND kelas_sk_id = $sk_id
          ORDER BY kelas_nama")->result();
      }
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function get_siswa(){
    if($this->input->post('id',TRUE)){
    
      $kelas_id = $this->input->post('id',TRUE);
      
      //temukan jenjang id pada kelas itu
      $data = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE d_s_kelas_id = $kelas_id
        ORDER BY sis_nama_depan")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function show(){

    if($this->input->post('siswa_check[]',TRUE) || $this->input->post('semester',TRUE)){

      if(count($this->input->post('siswa_check[]',TRUE))==0){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Select one or more student!</div>');
        redirect('Report_CRUD');
      }

      $data['title'] = 'Report Page';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
  
      $data['sis_arr'] = $this->input->post('siswa_check[]',TRUE);
      $data['semester'] = $this->input->post('semester',TRUE);

      
      $sk_id = $this->input->post('sk',TRUE);
      $jenis = $this->input->post('pJenis',TRUE);

      
      $data['checkSsp'] = $this->input->post('checkSsp',TRUE);
      $data['checkScout'] = $this->input->post('checkScout',TRUE);

      $kelas_id = $this->input->post('kelas_id',TRUE);

      $data['karakter'] = $this->db->query(
        "SELECT *
        FROM karakter
        ORDER BY karakter_urutan")->result_array();

      $data['kepsek'] = $this->db->query(
                        "SELECT *
                        FROM sk
                        LEFT JOIN kelas ON kelas_sk_id = sk_id
                        LEFT JOIN kr ON sk_kepsek = kr_id
                        WHERE kelas_id = $kelas_id")->row_array();

      $data['walkel'] = $this->_kelas->find_walkel_by_kelas_id($this->input->post('kelas_id',TRUE));

      
      $data['guru_cb'] = $this->db->query(
        "SELECT *
        FROM konselor
        LEFT JOIN kr ON konselor_kr_id = kr_id
        WHERE konselor_sk_id = $sk_id")->row_array();


      $data['kelas_jenj_id'] = $this->db->query(
        "SELECT kelas_jenj_id
        FROM kelas
        WHERE kelas_id = $kelas_id")->row_array();

      $t_id = $this->input->post('t',TRUE);
      $data['t'] = $this->db->query(
        "SELECT t_nama
        FROM t
        WHERE t_id = $t_id")->row_array();

      //var_dump($data['checkSsp']);

      if($jenis==0){
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('Report_CRUD/sisipan',$data);
        $this->load->view('templates/footer');
      }elseif($jenis==1){
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('Report_CRUD/semester',$data);
        $this->load->view('templates/footer');
      }

      

    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly!</div>');
      redirect('Profile');
    }
  }

}

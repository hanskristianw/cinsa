<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uj_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_sk');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_kelas');
    $this->load->model('_mapel');


    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan guru dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=7 && $this->session->userdata('kr_jabatan_id')!=4 && $this->session->userdata('kr_jabatan_id')!=5 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    if($this->session->userdata('kr_jabatan_id')==5){
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Success!</div>');
      redirect('Kadiv_CRUD/ujian');
    }

    $data['title'] = 'Mid and Final';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //$data['tes'] = var_dump($this->db->last_query());

    //cari guru mengajar mapel mana saja

    $kr_id = $data['kr']['kr_id'];

    //SELECT * from d_mpl WHERE d_mpl_kr_id = $data['kr']['kr_id']

    $data['mapel_all'] = $this->db->query(
      "SELECT t_nama, sk_nama, d_mpl_mapel_id, mapel_nama, kelas_id, kelas_nama
      FROM d_mpl
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
      LEFT JOIN t ON kelas_t_id = t_id
      LEFT JOIN sk ON kelas_sk_id = sk_id
      WHERE d_mpl_kr_id = $kr_id
      ORDER BY t_id DESC, sk_nama, kelas_nama")->result_array();

    if(empty($data['mapel_all'])){
      $this->session->set_flashdata("message","<div class='alert alert-danger' role='alert'>You don't teach any class, contact curriculum for more information!</div>");
      redirect('Profile');
    }

    //var_dump($this->db->last_query());
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('uj_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function input(){

    if(!$this->input->post('arr') && !$this->input->post('sk_id')){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly!</div>');
      redirect('Uj_CRUD');
    }

    if($this->input->post('arr')){
      $arr = explode("|",$this->input->post('arr'));
      $mapel_id = $arr[0];
      $kelas_id = $arr[1];
    }

    if($this->input->post('sk_id')){
      $mapel_id = $this->input->post('mapel_id');
      $kelas_id = $this->input->post('kelas_id');
    }

    $siswacount = $this->db->join('kelas', 'd_s_kelas_id = kelas_id', 'left')->where('d_s_kelas_id',$kelas_id)->from("d_s")->count_all_results();
    if($siswacount == 0){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">No Student Detected in Class, Please Contact Curriculum!</div>');
      redirect('Tes_CRUD');
    }

    $data['title'] = 'Mid and Final';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['kelas'] = $this->_kelas->find_kelas_nama($kelas_id);
    $data['mapel'] = $this->_mapel->find_mapel_nama($mapel_id);

    $data['kelas_id'] = $kelas_id;
    $data['mapel_id'] = $mapel_id;

    if($this->input->post('cek_agama') == 1){
      $_gb = "sis_agama_id,";
    }else{
      $_gb = "";
    }

    $data['cek_agama'] = $this->input->post('cek_agama');

    $uj_count = $this->db->join('d_s', 'uj_d_s_id=d_s_id', 'left')->where('d_s_kelas_id',$kelas_id)->where('uj_mapel_id',$mapel_id)->from("uj")->count_all_results();
    if($uj_count == 0){
      $data['siswa_all'] = $this->db->query(
        "SELECT d_s_id, sis_agama_id, agama_nama, sis_nama_depan, sis_nama_bel, sis_no_induk
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN agama ON sis_agama_id = agama_id
        WHERE d_s_kelas_id = $kelas_id
        ORDER BY $_gb sis_nama_depan, sis_no_induk")->result_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('uj_crud/input',$data);
      $this->load->view('templates/footer');
    }else{
      $data['siswa_all'] = $this->db->query(
        "SELECT *
        FROM uj
        LEFT JOIN d_s ON uj_d_s_id = d_s_id
        LEFT JOIN sis ON sis_id = d_s_sis_id
        LEFT JOIN agama ON sis_agama_id = agama_id
        WHERE d_s_kelas_id = $kelas_id AND uj_mapel_id = $mapel_id
        ORDER BY $_gb sis_nama_depan, sis_no_induk")->result_array();

      //cari siswa yang ada di kelas tapi tidak mempunyai nilai
      $data['siswa_baru'] = $this->db->query(
        "SELECT sis_agama_id, agama_nama, d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN agama ON sis_agama_id = agama_id
        WHERE d_s_kelas_id = $kelas_id AND d_s_sis_id NOT IN 
          (SELECT d_s_sis_id
          FROM uj
          LEFT JOIN d_s ON uj_d_s_id = d_s_id
          LEFT JOIN sis ON sis_id = d_s_sis_id
          LEFT JOIN agama ON sis_agama_id = agama_id
          WHERE d_s_kelas_id = $kelas_id AND uj_mapel_id = $mapel_id
          )
        ORDER BY sis_nama_depan")->result_array();

      //var_dump($this->db->last_query());

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('uj_crud/update',$data);
      $this->load->view('templates/footer');
    }


  }

  public function save_input(){
    if($this->input->post('uj_mid1_kog[]')){

      $uj_count = $this->db->join('d_s', 'uj_d_s_id=d_s_id', 'left')->where('d_s_kelas_id',$this->input->post('kelas_id'))->where('uj_mapel_id',$this->input->post('mapel_id'))->from("uj")->count_all_results();
      if($uj_count == 0){
        //Save input
        $data = array();
        $d_s_id = $this->input->post('d_s_id[]');

        $uj_mid1_kog = $this->input->post('uj_mid1_kog[]');
        $uj_mid1_psi = $this->input->post('uj_mid1_psi[]');
        $uj_fin1_kog = $this->input->post('uj_fin1_kog[]');
        $uj_fin1_psi = $this->input->post('uj_fin1_psi[]');

        $uj_mid2_kog = $this->input->post('uj_mid2_kog[]');
        $uj_mid2_psi = $this->input->post('uj_mid2_psi[]');
        $uj_fin2_kog = $this->input->post('uj_fin2_kog[]');
        $uj_fin2_psi = $this->input->post('uj_fin2_psi[]');

        for($i=0;$i<count($d_s_id);$i++){
            $data[$i] = [
              'uj_d_s_id' => $d_s_id[$i],
              'uj_mid1_kog' => $uj_mid1_kog[$i],
              'uj_mid1_kog_persen' => $this->input->post('uj_mid1_kog_persen'),
              'uj_mid1_psi' => $uj_mid1_psi[$i],
              'uj_mid1_psi_persen' => $this->input->post('uj_mid1_psi_persen'),
              'uj_fin1_kog' =>  $uj_fin1_kog[$i],
              'uj_fin1_kog_persen' => $this->input->post('uj_fin1_kog_persen'),
              'uj_fin1_psi' =>  $uj_fin1_psi[$i],
              'uj_fin1_psi_persen' => $this->input->post('uj_fin1_psi_persen'),
              'uj_mid2_kog' =>  $uj_mid2_kog[$i],
              'uj_mid2_kog_persen' => $this->input->post('uj_mid2_kog_persen'),
              'uj_mid2_psi' =>  $uj_mid2_psi[$i],
              'uj_mid2_psi_persen' => $this->input->post('uj_mid2_psi_persen'),
              'uj_fin2_kog' =>  $uj_fin2_kog[$i],
              'uj_fin2_kog_persen' => $this->input->post('uj_fin2_kog_persen'),
              'uj_fin2_psi' =>  $uj_fin2_psi[$i],
              'uj_fin2_psi_persen' => $this->input->post('uj_fin2_psi_persen'),
              'uj_mapel_id' => $this->input->post('mapel_id')
            ];
        }

        $this->db->insert_batch('uj', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('Uj_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Failed, already have score!</div>');
        redirect('Uj_CRUD');
      }

    }
  }

  public function save_new_student(){


    if($this->input->post('uj_mid1_kog[]')){
      $uj_count = $this->db->join('d_s', 'uj_d_s_id=d_s_id', 'left')->where_in('d_s_id',$this->input->post('d_s_id[]'))->where('uj_mapel_id',$this->input->post('mapel_id'))->from("uj")->count_all_results();

      //var_dump($this->db->last_query());
      if($uj_count == 0){
        $data = array();
        $d_s_id = $this->input->post('d_s_id[]');

        $uj_mid1_kog = $this->input->post('uj_mid1_kog[]');
        $uj_mid1_psi = $this->input->post('uj_mid1_psi[]');
        $uj_fin1_kog = $this->input->post('uj_fin1_kog[]');
        $uj_fin1_psi = $this->input->post('uj_fin1_psi[]');

        $uj_mid2_kog = $this->input->post('uj_mid2_kog[]');
        $uj_mid2_psi = $this->input->post('uj_mid2_psi[]');
        $uj_fin2_kog = $this->input->post('uj_fin2_kog[]');
        $uj_fin2_psi = $this->input->post('uj_fin2_psi[]');

        for($i=0;$i<count($d_s_id);$i++){
          $data[$i] = [
            'uj_d_s_id' => $d_s_id[$i],
            'uj_mid1_kog' => $uj_mid1_kog[$i],
            'uj_mid1_kog_persen' => $this->input->post('uj_mid1_kog_persen'),
            'uj_mid1_psi' => $uj_mid1_psi[$i],
            'uj_mid1_psi_persen' => $this->input->post('uj_mid1_psi_persen'),
            'uj_fin1_kog' =>  $uj_fin1_kog[$i],
            'uj_fin1_kog_persen' => $this->input->post('uj_fin1_kog_persen'),
            'uj_fin1_psi' =>  $uj_fin1_psi[$i],
            'uj_fin1_psi_persen' => $this->input->post('uj_fin1_psi_persen'),
            'uj_mid2_kog' =>  $uj_mid2_kog[$i],
            'uj_mid2_kog_persen' => $this->input->post('uj_mid2_kog_persen'),
            'uj_mid2_psi' =>  $uj_mid2_psi[$i],
            'uj_mid2_psi_persen' => $this->input->post('uj_mid2_psi_persen'),
            'uj_fin2_kog' =>  $uj_fin2_kog[$i],
            'uj_fin2_kog_persen' => $this->input->post('uj_fin2_kog_persen'),
            'uj_fin2_psi' =>  $uj_fin2_psi[$i],
            'uj_fin2_psi_persen' => $this->input->post('uj_fin2_psi_persen'),
            'uj_mapel_id' => $this->input->post('mapel_id')
          ];
        }

        $this->db->insert_batch('uj', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input New Student(s) Success!</div>');
        redirect('Uj_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">New Student(s) Grade Already Exist!</div>');
        redirect('Uj_CRUD');
      }
      
    }
  }

  public function save_update(){

    if($this->input->post('uj_mid1_kog[]')){
      $data = array();
      $uj_id = $this->input->post('uj_id[]');

      $uj_mid1_kog = $this->input->post('uj_mid1_kog[]');
      $uj_mid1_psi = $this->input->post('uj_mid1_psi[]');
      $uj_fin1_kog = $this->input->post('uj_fin1_kog[]');
      $uj_fin1_psi = $this->input->post('uj_fin1_psi[]');

      $uj_mid2_kog = $this->input->post('uj_mid2_kog[]');
      $uj_mid2_psi = $this->input->post('uj_mid2_psi[]');
      $uj_fin2_kog = $this->input->post('uj_fin2_kog[]');
      $uj_fin2_psi = $this->input->post('uj_fin2_psi[]');

      for($i=0;$i<count($uj_id);$i++){
        $data[$i] = [
          'uj_mid1_kog' => $uj_mid1_kog[$i],
          'uj_mid1_kog_persen' => $this->input->post('uj_mid1_kog_persen'),
          'uj_mid1_psi' => $uj_mid1_psi[$i],
          'uj_mid1_psi_persen' => $this->input->post('uj_mid1_psi_persen'),
          'uj_fin1_kog' =>  $uj_fin1_kog[$i],
          'uj_fin1_kog_persen' => $this->input->post('uj_fin1_kog_persen'),
          'uj_fin1_psi' =>  $uj_fin1_psi[$i],
          'uj_fin1_psi_persen' => $this->input->post('uj_fin1_psi_persen'),
          'uj_mid2_kog' =>  $uj_mid2_kog[$i],
          'uj_mid2_kog_persen' => $this->input->post('uj_mid2_kog_persen'),
          'uj_mid2_psi' =>  $uj_mid2_psi[$i],
          'uj_mid2_psi_persen' => $this->input->post('uj_mid2_psi_persen'),
          'uj_fin2_kog' =>  $uj_fin2_kog[$i],
          'uj_fin2_kog_persen' => $this->input->post('uj_fin2_kog_persen'),
          'uj_fin2_psi' =>  $uj_fin2_psi[$i],
          'uj_fin2_psi_persen' => $this->input->post('uj_fin2_psi_persen'),
          'uj_id' =>  $uj_id[$i]
        ];
      }
      $this->db->update_batch('uj',$data, 'uj_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Success!</div>');
      redirect('Uj_CRUD');
    }
  }
}

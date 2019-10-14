<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Komen_CRUD extends CI_Controller
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

    $data['title'] = 'Student Comment';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['kelas_all'] = $this->_kelas->find_by_walkel($this->session->userdata('kr_id'));

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('komen_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function input()
  {

    if($this->input->post('kelas_komen',TRUE)){

      $data = [
        'd_s_sick' => $this->input->post('d_s_sick',true),
        'd_s_absenin' => $this->input->post('d_s_absenin',true),
        'd_s_absenex' => $this->input->post('d_s_absenex',true),
        'd_s_sick2' => $this->input->post('d_s_sick2',true),
        'd_s_absenin2' => $this->input->post('d_s_absenin2',true),
        'd_s_absenex2' => $this->input->post('d_s_absenex2',true),
        'd_s_komen_sis' => $this->input->post('d_s_komen_sis',true),
        'd_s_komen_sem' => $this->input->post('d_s_komen_sem',true),
        'd_s_komen_sis2' => $this->input->post('d_s_komen_sis2',true),
        'd_s_komen_sem2' => $this->input->post('d_s_komen_sem2',true)
      ];
      
      $this->db->where('d_s_id', $this->input->post('d_s_id'));
      $this->db->update('d_s', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success!</div>');
      redirect('Komen_CRUD');
    } 
    else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function get_siswa()
  {

    if($this->input->post('id',TRUE)){
      
      $kelas_id = $this->input->post('id',TRUE);
      
      $data = $this->db->query(
        "SELECT *
        FROM d_s
        LEFT JOIN sis ON sis_id = d_s_sis_id
        WHERE d_s_kelas_id = $kelas_id")->result();
  
      //var_dump($data);
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function get_komen()
  {

    if($this->input->post('id',TRUE)){
      
      $d_s_id = $this->input->post('id',TRUE);
      
      $data = $this->db->query(
        "SELECT *
        FROM d_s
        WHERE d_s_id = $d_s_id")->result();
  
      //var_dump($data);
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function habit()
  {
    $data['title'] = 'Social Skill, Physical Fitness and Healthful Habit';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['kelas_all'] = $this->_kelas->find_by_walkel($this->session->userdata('kr_id'));

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('komen_crud/habit', $data);
    $this->load->view('templates/footer');
  }

  public function habit_input(){
    if($this->input->post('kelas_habit',TRUE)){

      $kelas_id = $this->input->post('kelas_habit',TRUE);

      $data['title'] = 'Social Skill, Physical Fitness and Healthful Habit';

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['siswa_all'] = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk, kelas_nama,
                ss_relationship, ss_cooperation, ss_conflict, ss_self_a,
                ss_relationship2, ss_cooperation2, ss_conflict2, ss_self_a2,
                pfhf_absent, pfhf_uks, pfhf_tardiness,
                pfhf_absent2, pfhf_uks2, pfhf_tardiness2
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN kelas ON d_s_kelas_id = kelas_id
        WHERE d_s_kelas_id = $kelas_id ORDER BY sis_no_induk, sis_nama_depan")->result_array();

      if(!$data['siswa_all']){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">No Student, add one or more student!</div>');
        redirect('Komen_crud/habit');
      }

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('Komen_crud/habit_input',$data);
        $this->load->view('templates/footer');

    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

  }

  public function save_habit(){
    if($this->input->post('d_s_id[]')){
      $data = array();
      $ss_relationship = $this->input->post('ss_relationship[]',true);
      $ss_cooperation = $this->input->post('ss_cooperation[]',true);
      $ss_conflict = $this->input->post('ss_conflict[]',true);
      $ss_self_a = $this->input->post('ss_self_a[]',true);
      $ss_relationship2 = $this->input->post('ss_relationship2[]',true);
      $ss_cooperation2 = $this->input->post('ss_cooperation2[]',true);
      $ss_conflict2 = $this->input->post('ss_conflict2[]',true);
      $ss_self_a2 = $this->input->post('ss_self_a2[]',true);
      
      $pfhf_absent = $this->input->post('pfhf_absent[]',true);
      $pfhf_uks = $this->input->post('pfhf_uks[]',true);
      $pfhf_tardiness = $this->input->post('pfhf_tardiness[]',true);
      $pfhf_absent2 = $this->input->post('pfhf_absent2[]',true);
      $pfhf_uks2 = $this->input->post('pfhf_uks2[]',true);
      $pfhf_tardiness2 = $this->input->post('pfhf_tardiness2[]',true);
      $d_s_id = $this->input->post('d_s_id[]');

      for($i=0;$i<count($d_s_id);$i++){
        $data[$i] = [
          'ss_relationship' => $ss_relationship[$i],
          'ss_cooperation' => $ss_cooperation[$i],
          'ss_conflict' => $ss_conflict[$i],
          'ss_self_a' => $ss_self_a[$i],
          'ss_relationship2' => $ss_relationship2[$i],
          'ss_cooperation2' => $ss_cooperation2[$i],
          'ss_conflict2' => $ss_conflict2[$i],
          'ss_self_a2' => $ss_self_a2[$i],
          'pfhf_absent' => $pfhf_absent[$i],
          'pfhf_uks' => $pfhf_uks[$i],
          'pfhf_tardiness' => $pfhf_tardiness[$i],
          'pfhf_absent2' => $pfhf_absent2[$i],
          'pfhf_uks2' => $pfhf_uks2[$i],
          'pfhf_tardiness2' => $pfhf_tardiness2[$i],
          'd_s_id' =>  $d_s_id[$i]
        ];
      }
      $this->db->update_batch('d_s',$data, 'd_s_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Success!</div>');
      redirect('Komen_crud/habit');
    }
  }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SSP_grade_CRUD extends CI_Controller
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
    $this->load->model('_ssp_topik');


    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan guru dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=7 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'SSP Grade';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //$data['tes'] = var_dump($this->db->last_query());

    //cari guru mengajar mapel mana saja

    $kr_id = $data['kr']['kr_id'];

    //SELECT * from d_mpl WHERE d_mpl_kr_id = $data['kr']['kr_id']

    $data['ssp_all'] = $this->db->query(
      "SELECT ssp_id, ssp_nama, t_nama, t_id
      FROM ssp
      LEFT JOIN t ON ssp_t_id = t_id
      WHERE ssp_kr_id = $kr_id
      ORDER BY t_id DESC, ssp_nama")->result_array();

    //var_dump($this->db->last_query());
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('ssp_grade_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function get_topik(){

    if($this->input->post('id',TRUE)){
      $ssp_id = $this->input->post('id',TRUE);
      
      $data = $this->db->query(
        "SELECT *
        FROM ssp_topik
        WHERE ssp_topik_ssp_id = $ssp_id
        ORDER BY ssp_topik_semester DESC, ssp_topik_nama")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
    
  }

  public function input(){

    if(!$this->input->post('arr_ssp')){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly!</div>');
      redirect('ssp_grade_CRUD');
    }

    $ssp_id = $this->input->post('arr_ssp');
    $ssp_topik_id = $this->input->post('ssp_topik_id');
    

    $data['title'] = 'SSP grade';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //untuk header
    
    $data['ssp_all'] = $this->_ssp_topik->find_by_id($ssp_topik_id);
    
    $data['ssp_id'] = $ssp_id;
    $data['ssp_topik_id'] = $ssp_topik_id;

    $gradecount = $this->db->where('ssp_nilai_ssp_topik_id',$ssp_topik_id)->from("ssp_nilai")->count_all_results();
    if($gradecount == 0){
      //belum ada nilai
      $data['siswa_all'] = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk, kelas_nama
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN kelas ON d_s_kelas_id = kelas_id
        LEFT JOIN ssp_peserta ON d_s_id = ssp_peserta_d_s_id
        WHERE ssp_peserta_ssp_id = $ssp_id
        ORDER BY sis_nama_depan")->result_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('ssp_grade_crud/input',$data);
      $this->load->view('templates/footer');
    }else{
      $data['siswa_all'] = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk, ssp_nilai_ssp_topik_id, ssp_nilai_angka, ssp_nilai_id, kelas_nama
        FROM ssp_nilai
        LEFT JOIN d_s ON ssp_nilai_d_s_id = d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN kelas ON d_s_kelas_id = kelas_id
        LEFT JOIN ssp_peserta ON d_s_id = ssp_peserta_d_s_id
        LEFT JOIN ssp ON ssp_peserta_ssp_id = ssp_id
        WHERE ssp_peserta_ssp_id = $ssp_id AND ssp_nilai_ssp_topik_id = $ssp_topik_id
        ORDER BY sis_nama_depan")->result_array();

      // //cari siswa yang ada di kelas tapi tidak mempunyai nilai
      $data['siswa_baru'] = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk, kelas_nama
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN kelas ON d_s_kelas_id = kelas_id
        LEFT JOIN ssp_peserta ON d_s_id = ssp_peserta_d_s_id
        WHERE ssp_peserta_ssp_id = $ssp_id AND d_s_id NOT IN 
          (SELECT d_s_id
          FROM ssp_nilai
          LEFT JOIN d_s ON ssp_nilai_d_s_id = d_s_id
          LEFT JOIN sis ON d_s_sis_id = sis_id
          LEFT JOIN ssp_peserta ON d_s_id = ssp_peserta_d_s_id
          LEFT JOIN ssp ON ssp_peserta_ssp_id = ssp_id
          WHERE ssp_peserta_ssp_id = $ssp_id AND ssp_nilai_ssp_topik_id = $ssp_topik_id
          )
        ORDER BY sis_nama_depan")->result_array();

      //var_dump($this->db->last_query());

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('ssp_grade_crud/update',$data);
      $this->load->view('templates/footer');
    }


  }

  public function save_input(){
    if($this->input->post('ssp_nilai_angka[]', true)){

      $ssp_topik_id = $this->input->post('ssp_topik_id', true);
      $gradecount = $this->db->where('ssp_nilai_ssp_topik_id',$ssp_topik_id)->from("ssp_nilai")->count_all_results();
      if($gradecount == 0){
        //Save input
        $data = array();
        $d_s_id = $this->input->post('d_s_id[]');

        $ssp_nilai_angka = $this->input->post('ssp_nilai_angka[]');

        for($i=0;$i<count($d_s_id);$i++){
            $data[$i] = [
              'ssp_nilai_d_s_id' => $d_s_id[$i],
              'ssp_nilai_angka' => $ssp_nilai_angka[$i],
              'ssp_nilai_ssp_topik_id' => $this->input->post('ssp_topik_id')
            ];
        }

        $this->db->insert_batch('ssp_nilai', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('SSP_grade_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Failed, already have score!</div>');
        redirect('SSP_grade_CRUD');
      }

    }
  }

  public function save_new_student(){


    if($this->input->post('ssp_nilai_angka[]', true)){
      $gradecount = $this->db->where('ssp_nilai_ssp_topik_id',$ssp_topik_id)->from("ssp_nilai")->count_all_results();

      //var_dump($this->db->last_query());
      if($gradecount == 0){
        $data = array();
        $d_s_id = $this->input->post('d_s_id[]');

        $ssp_nilai_angka = $this->input->post('ssp_nilai_angka[]');
        
        for($i=0;$i<count($d_s_id);$i++){
          $data[$i] = [
            'ssp_nilai_d_s_id' => $d_s_id[$i],
            'ssp_nilai_angka' => $ssp_nilai_angka[$i],
            'ssp_nilai_ssp_topik_id' => $this->input->post('ssp_topik_id')
          ];
        }

        $this->db->insert_batch('ssp_nilai', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input New Student(s) Success!</div>');
        redirect('SSP_grade_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">New Student(s) Grade Already Exist!</div>');
        redirect('SSP_grade_CRUD');
      }
      
    }
  }

  public function save_update(){

    if($this->input->post('ssp_nilai_angka[]')){
      $data = array();
      $ssp_nilai_id = $this->input->post('ssp_nilai_id[]');

      $ssp_nilai_angka = $this->input->post('ssp_nilai_angka[]');

      for($i=0;$i<count($ssp_nilai_id);$i++){
        $data[$i] = [
          'ssp_nilai_angka' => $ssp_nilai_angka[$i],
          'ssp_nilai_id' =>  $ssp_nilai_id[$i]
        ];
      }
      $this->db->update_batch('ssp_nilai',$data, 'ssp_nilai_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Success!</div>');
      redirect('SSP_grade_CRUD');
    }
  }
}

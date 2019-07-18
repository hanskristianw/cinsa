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
    $this->load->model('_topik');


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
      $id = explode("|",$this->input->post('id',TRUE));
    
      $ssp_id = $id[0];
      $t_id = $id[1];
      
      //temukan d_sis pada tahun ajaran itu dari sis id
      $siswa = $this->db->query(
        "SELECT *
        FROM ssp_peserta
        LEFT JOIN d_s ON ssp_peserta_sis_id = d_s_sis_id
        LEFT JOIN sis ON ssp_peserta_sis_id = sis_id
        LEFT JOIN kelas ON d_s_kelas_id = kelas_id
        WHERE ssp_peserta_ssp_id = $ssp_id AND kelas_t_id = $t_id")->row_array();
  
      //print_r($jenjang['jenj_id']);
  
      $jenj_id = $jenjang['jenj_id'];
      $data = $this->db->query(
        "SELECT topik_id, topik_nama, topik_semester
        FROM topik
        LEFT JOIN jenj ON topik_jenj_id = jenj_id
        LEFT JOIN mapel ON topik_mapel_id = mapel_id
        WHERE jenj_id = $jenj_id AND mapel_id = $mapel_id")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
    
  }

  public function input(){

    if(!$this->input->post('arr_ssp')){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly!</div>');
      redirect('ssp_grade_CRUD');
    }

    $ssp_id = $this->input->post('arr_ssp');

    $data['title'] = 'SSP grade';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //untuk header
    $data['kelas'] = $this->_kelas->find_kelas_nama($kelas_id);
    $data['mapel'] = $this->_mapel->find_mapel_nama($mapel_id);
    $data['topik'] = $this->_topik->find_by_id($topik_id);

    //untuk tabel
    $data['kelas_id'] = $kelas_id;
    $data['mapel_id'] = $mapel_id;
    $data['topik_id'] = $topik_id;


    if($this->input->post('cek_agama') == 1){
      $_gb = "sis_agama_id,";
    }else{
      $_gb = "";
    }

    $data['cek_agama'] = $this->input->post('cek_agama');

    $tescount = $this->db->join('d_s', 'tes_d_s_id=d_s_id', 'left')->where('d_s_kelas_id',$kelas_id)->where('tes_topik_id',$topik_id)->from("tes")->count_all_results();
    if($tescount == 0){
      $data['siswa_all'] = $this->db->query(
        "SELECT d_s_id, sis_agama_id, agama_nama, sis_nama_depan, sis_nama_bel, sis_no_induk
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN agama ON sis_agama_id = agama_id
        WHERE d_s_kelas_id = $kelas_id
        ORDER BY $_gb sis_nama_depan")->result_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('tes_crud/input',$data);
      $this->load->view('templates/footer');
    }else{
      $data['siswa_all'] = $this->db->query(
        "SELECT *
        FROM tes
        LEFT JOIN d_s ON tes_d_s_id = d_s_id
        LEFT JOIN sis ON sis_id = d_s_sis_id
        LEFT JOIN agama ON sis_agama_id = agama_id
        WHERE d_s_kelas_id = $kelas_id AND tes_topik_id = $topik_id
        ORDER BY $_gb sis_nama_depan")->result_array();

      //cari siswa yang ada di kelas tapi tidak mempunyai nilai
      $data['siswa_baru'] = $this->db->query(
        "SELECT sis_agama_id, agama_nama, d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN agama ON sis_agama_id = agama_id
        WHERE d_s_kelas_id = $kelas_id AND d_s_sis_id NOT IN 
          (SELECT d_s_sis_id
          FROM tes
          LEFT JOIN d_s ON tes_d_s_id = d_s_id
          LEFT JOIN sis ON sis_id = d_s_sis_id
          LEFT JOIN agama ON sis_agama_id = agama_id
          WHERE d_s_kelas_id = $kelas_id AND tes_topik_id = $topik_id
          )
        ORDER BY sis_nama_depan")->result_array();

      //var_dump($this->db->last_query());

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('tes_crud/update',$data);
      $this->load->view('templates/footer');
    }


  }

  public function save_input(){
    if($this->input->post('kog_quiz[]')){

      $tes_count = $this->db->join('d_s', 'tes_d_s_id=d_s_id', 'left')->where('d_s_kelas_id',$this->input->post('kelas_id'))->where('tes_topik_id',$this->input->post('topik_id'))->from("tes")->count_all_results();
      if($tes_count == 0){
        //Save input
        $data = array();
        $d_s_id = $this->input->post('d_s_id[]');

        $kog_quiz = $this->input->post('kog_quiz[]');
        $kog_test = $this->input->post('kog_test[]');
        $kog_ass = $this->input->post('kog_ass[]');
        $psi_quiz = $this->input->post('psi_quiz[]');
        $psi_test = $this->input->post('psi_test[]');
        $psi_ass = $this->input->post('psi_ass[]');

        for($i=0;$i<count($d_s_id);$i++){
            $data[$i] = [
              'tes_d_s_id' => $d_s_id[$i],
              'kog_quiz' => $kog_quiz[$i],
              'kog_quiz_persen' => $this->input->post('kog_quiz_persen'),
              'kog_test' =>  $kog_test[$i],
              'kog_test_persen' => $this->input->post('kog_test_persen'),
              'kog_ass' => $kog_ass[$i],
              'kog_ass_persen' => $this->input->post('kog_ass_persen'),
              'psi_quiz' =>  $psi_quiz[$i],
              'psi_quiz_persen' => $this->input->post('psi_quiz_persen'),
              'psi_test' =>  $psi_test[$i],
              'psi_test_persen' => $this->input->post('psi_test_persen'),
              'psi_ass' =>  $psi_ass[$i],
              'psi_ass_persen' => $this->input->post('psi_ass_persen'),
              'tes_topik_id' => $this->input->post('topik_id')
            ];
        }

        $this->db->insert_batch('tes', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('Tes_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Failed, already have score!</div>');
        redirect('Tes_CRUD');
      }

    }
  }

  public function save_new_student(){


    if($this->input->post('kog_quiz[]')){
      $uj_count = $this->db->join('d_s', 'tes_d_s_id=d_s_id', 'left')->where_in('d_s_id',$this->input->post('d_s_id[]'))->where('tes_topik_id',$this->input->post('topik_id'))->from("tes")->count_all_results();

      //var_dump($this->db->last_query());
      if($uj_count == 0){
        $data = array();
        $d_s_id = $this->input->post('d_s_id[]');

        $kog_quiz = $this->input->post('kog_quiz[]');
        $kog_test = $this->input->post('kog_test[]');
        $kog_ass = $this->input->post('kog_ass[]');
        $psi_quiz = $this->input->post('psi_quiz[]');
        $psi_test = $this->input->post('psi_test[]');
        $psi_ass = $this->input->post('psi_ass[]');

        for($i=0;$i<count($d_s_id);$i++){
          $data[$i] = [
            'tes_d_s_id' => $d_s_id[$i],
            'kog_quiz' => $kog_quiz[$i],
            'kog_quiz_persen' => $this->input->post('kog_quiz_persen'),
            'kog_test' =>  $kog_test[$i],
            'kog_test_persen' => $this->input->post('kog_test_persen'),
            'kog_ass' => $kog_ass[$i],
            'kog_ass_persen' => $this->input->post('kog_ass_persen'),
            'psi_quiz' =>  $psi_quiz[$i],
            'psi_quiz_persen' => $this->input->post('psi_quiz_persen'),
            'psi_test' =>  $psi_test[$i],
            'psi_test_persen' => $this->input->post('psi_test_persen'),
            'psi_ass' =>  $psi_ass[$i],
            'psi_ass_persen' => $this->input->post('psi_ass_persen'),
            'tes_topik_id' => $this->input->post('topik_id')
          ];
        }

        $this->db->insert_batch('tes', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input New Student(s) Success!</div>');
        redirect('Tes_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">New Student(s) Grade Already Exist!</div>');
        redirect('Tes_CRUD');
      }
      
    }
  }

  public function save_update(){

    if($this->input->post('kog_quiz[]')){
      $data = array();
      $tes_id = $this->input->post('tes_id[]');

      $kog_quiz = $this->input->post('kog_quiz[]');
      $kog_test = $this->input->post('kog_test[]');
      $kog_ass = $this->input->post('kog_ass[]');
      $psi_quiz = $this->input->post('psi_quiz[]');
      $psi_test = $this->input->post('psi_test[]');
      $psi_ass = $this->input->post('psi_ass[]');

      for($i=0;$i<count($tes_id);$i++){
        $data[$i] = [
          'kog_quiz' => $kog_quiz[$i],
          'kog_quiz_persen' => $this->input->post('kog_quiz_persen'),
          'kog_test' =>  $kog_test[$i],
          'kog_test_persen' => $this->input->post('kog_test_persen'),
          'kog_ass' => $kog_ass[$i],
          'kog_ass_persen' => $this->input->post('kog_ass_persen'),
          'psi_quiz' =>  $psi_quiz[$i],
          'psi_quiz_persen' => $this->input->post('psi_quiz_persen'),
          'psi_test' =>  $psi_test[$i],
          'psi_test_persen' => $this->input->post('psi_test_persen'),
          'psi_ass' =>  $psi_ass[$i],
          'psi_ass_persen' => $this->input->post('psi_ass_persen'),
          'tes_id' =>  $tes_id[$i]
        ];
      }
      $this->db->update_batch('tes',$data, 'tes_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Success!</div>');
      redirect('Tes_CRUD');
    }
  }
}

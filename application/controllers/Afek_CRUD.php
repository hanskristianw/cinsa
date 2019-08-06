<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Afek_CRUD extends CI_Controller
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
    $this->load->model('_k_afek');


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

    $data['title'] = 'Affective';

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
    $this->load->view('afek_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function get_topik(){

    if($this->input->post('id',TRUE)){
      $id = explode("|",$this->input->post('id',TRUE));
    
      $mapel_id = $id[0];
      $kelas_id = $id[1];
      
      //temukan jenjang id pada kelas itu
      $tahun = $this->db->query(
        "SELECT t_id, kelas_sk_id
        FROM kelas
        LEFT JOIN t ON kelas_t_id = t_id
        WHERE kelas_id = $kelas_id")->row_array();
  
      //print_r($jenjang['jenj_id']);
  
      $t_id = $tahun['t_id'];
      $sk_id = $tahun['kelas_sk_id'];
      $data = $this->db->query(
        "SELECT k_afek_id, k_afek_topik_nama, bulan_nama
        FROM k_afek
        LEFT JOIN bulan ON k_afek_bulan_id = bulan_id
        WHERE k_afek_t_id = $t_id AND k_afek_sk_id = $sk_id ORDER BY k_afek_t_id DESC, bulan_id")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
    
  }

  public function input(){

    if(!$this->input->post('arr_afek')){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly!</div>');
      redirect('Afek_CRUD');
    }

    $arr = explode("|",$this->input->post('arr_afek'));
    $k_afek_id = $this->input->post('k_afek_id');
    $mapel_id = $arr[0];
    $kelas_id = $arr[1];

    $data['title'] = 'Affective';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    
    $data['sk'] = $this->_sk->find_sk_nama($this->session->userdata('kr_sk_id'));

    //untuk header
    $data['kelas'] = $this->_kelas->find_kelas_nama($kelas_id);
    $data['mapel'] = $this->_mapel->find_mapel_nama($mapel_id);
    $data['k_afek'] = $this->_k_afek->find_by_id($k_afek_id,$this->session->userdata('kr_sk_id'));

    //untuk tabel
    $data['kelas_id'] = $kelas_id;
    $data['mapel_id'] = $mapel_id;
    $data['k_afek_id'] = $k_afek_id;


    if($this->input->post('cek_agama') == 1){
      $_gb = "sis_agama_id,";
    }else{
      $_gb = "";
    }

    $data['cek_agama'] = $this->input->post('cek_agama');

    $afekcount = $this->db->join('d_s', 'afektif_d_s_id=d_s_id', 'left')->where('d_s_kelas_id',$kelas_id)->where('afektif_mapel_id',$mapel_id)->where('afektif_k_afek_id',$k_afek_id)->from("afektif")->count_all_results();
    if($afekcount == 0){
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
      $this->load->view('Afek_crud/input',$data);
      $this->load->view('templates/footer');
    }else{
      $data['siswa_all'] = $this->db->query(
        "SELECT *
        FROM afektif
        LEFT JOIN d_s ON afektif_d_s_id = d_s_id
        LEFT JOIN sis ON sis_id = d_s_sis_id
        LEFT JOIN agama ON sis_agama_id = agama_id
        WHERE d_s_kelas_id = $kelas_id AND afektif_k_afek_id = $k_afek_id AND afektif_mapel_id = $mapel_id
        ORDER BY $_gb sis_nama_depan, sis_no_induk")->result_array();

      //cari siswa yang ada di kelas tapi tidak mempunyai nilai
      $data['siswa_baru'] = $this->db->query(
        "SELECT sis_agama_id, agama_nama, d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN agama ON sis_agama_id = agama_id
        WHERE d_s_kelas_id = $kelas_id AND d_s_sis_id NOT IN 
          (SELECT d_s_sis_id
          FROM afektif
          LEFT JOIN d_s ON afektif_d_s_id = d_s_id
          LEFT JOIN sis ON sis_id = d_s_sis_id
          LEFT JOIN agama ON sis_agama_id = agama_id
          WHERE d_s_kelas_id = $kelas_id AND afektif_k_afek_id = $k_afek_id AND afektif_mapel_id = $mapel_id
          )
        ORDER BY sis_nama_depan")->result_array();

      //var_dump($this->db->last_query());

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('afek_crud/update',$data);
      $this->load->view('templates/footer');
    }


  }

  public function save_input(){
    if($this->input->post('minggu1a1[]')){

      $afekcount = $this->db->join('d_s', 'afektif_d_s_id=d_s_id', 'left')->where('afektif_mapel_id',$this->input->post('mapel_id'))->where('d_s_kelas_id',$this->input->post('kelas_id'))->where('afektif_k_afek_id',$this->input->post('k_afek_id'))->from("afektif")->count_all_results();
      if($afekcount == 0){
        //Save input
        $data = array();
        $d_s_id = $this->input->post('d_s_id[]');

        $minggu1a1 = $this->input->post('minggu1a1[]');
        $minggu1a2 = $this->input->post('minggu1a2[]');
        $minggu1a3 = $this->input->post('minggu1a3[]');

        $minggu2a1 = $this->input->post('minggu2a1[]');
        $minggu2a2 = $this->input->post('minggu2a2[]');
        $minggu2a3 = $this->input->post('minggu2a3[]');

        $minggu3a1 = $this->input->post('minggu3a1[]');
        $minggu3a2 = $this->input->post('minggu3a2[]');
        $minggu3a3 = $this->input->post('minggu3a3[]');

        $minggu4a1 = $this->input->post('minggu4a1[]');
        $minggu4a2 = $this->input->post('minggu4a2[]');
        $minggu4a3 = $this->input->post('minggu4a3[]');

        $minggu5a1 = $this->input->post('minggu5a1[]');
        $minggu5a2 = $this->input->post('minggu5a2[]');
        $minggu5a3 = $this->input->post('minggu5a3[]');

        for($i=0;$i<count($d_s_id);$i++){
          $data[$i] = [
            'afektif_d_s_id' => $d_s_id[$i],
            'afektif_minggu1a1' => $minggu1a1[$i],
            'afektif_minggu1a2' => $minggu1a2[$i],
            'afektif_minggu1a3' => $minggu1a3[$i],
            'afektif_minggu2a1' => $minggu2a1[$i],
            'afektif_minggu2a2' => $minggu2a2[$i],
            'afektif_minggu2a3' => $minggu2a3[$i],
            'afektif_minggu3a1' => $minggu3a1[$i],
            'afektif_minggu3a2' => $minggu3a2[$i],
            'afektif_minggu3a3' => $minggu3a3[$i],
            'afektif_minggu4a1' => $minggu4a1[$i],
            'afektif_minggu4a2' => $minggu4a2[$i],
            'afektif_minggu4a3' => $minggu4a3[$i],
            'afektif_minggu5a1' => $minggu5a1[$i],
            'afektif_minggu5a2' => $minggu5a2[$i],
            'afektif_minggu5a3' => $minggu5a3[$i],
            'afektif_mapel_id' => $this->input->post('mapel_id'),
            'afektif_k_afek_id' => $this->input->post('k_afek_id')
          ];
        }

        $this->db->insert_batch('afektif', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('Afek_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Failed, already have score!</div>');
        redirect('Afek_CRUD');
      }

    }
  }

  public function save_new_student(){


    if($this->input->post('minggu1a1[]')){
      $uj_count = $this->db->join('d_s', 'afektif_d_s_id=d_s_id', 'left')->where_in('d_s_id',$this->input->post('d_s_id[]'))->where('afektif_k_afek_id',$this->input->post('k_afek_id'))->from("afektif")->count_all_results();

      //var_dump($this->db->last_query());
      if($uj_count == 0){
        //Save input
        $data = array();
        $d_s_id = $this->input->post('d_s_id[]');

        $minggu1a1 = $this->input->post('minggu1a1[]');
        $minggu1a2 = $this->input->post('minggu1a2[]');
        $minggu1a3 = $this->input->post('minggu1a3[]');

        $minggu2a1 = $this->input->post('minggu2a1[]');
        $minggu2a2 = $this->input->post('minggu2a2[]');
        $minggu2a3 = $this->input->post('minggu2a3[]');

        $minggu3a1 = $this->input->post('minggu3a1[]');
        $minggu3a2 = $this->input->post('minggu3a2[]');
        $minggu3a3 = $this->input->post('minggu3a3[]');

        $minggu4a1 = $this->input->post('minggu4a1[]');
        $minggu4a2 = $this->input->post('minggu4a2[]');
        $minggu4a3 = $this->input->post('minggu4a3[]');

        $minggu5a1 = $this->input->post('minggu5a1[]');
        $minggu5a2 = $this->input->post('minggu5a2[]');
        $minggu5a3 = $this->input->post('minggu5a3[]');

        for($i=0;$i<count($d_s_id);$i++){
          $data[$i] = [
            'afektif_d_s_id' => $d_s_id[$i],
            'afektif_minggu1a1' => $minggu1a1[$i],
            'afektif_minggu1a2' => $minggu1a2[$i],
            'afektif_minggu1a3' => $minggu1a3[$i],
            'afektif_minggu2a1' => $minggu2a1[$i],
            'afektif_minggu2a2' => $minggu2a2[$i],
            'afektif_minggu2a3' => $minggu2a3[$i],
            'afektif_minggu3a1' => $minggu3a1[$i],
            'afektif_minggu3a2' => $minggu3a2[$i],
            'afektif_minggu3a3' => $minggu3a3[$i],
            'afektif_minggu4a1' => $minggu4a1[$i],
            'afektif_minggu4a2' => $minggu4a2[$i],
            'afektif_minggu4a3' => $minggu4a3[$i],
            'afektif_minggu5a1' => $minggu5a1[$i],
            'afektif_minggu5a2' => $minggu5a2[$i],
            'afektif_minggu5a3' => $minggu5a3[$i],
            'afektif_mapel_id' => $this->input->post('mapel_id'),
            'afektif_k_afek_id' => $this->input->post('k_afek_id')
          ];
        }

        $this->db->insert_batch('afektif', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input New Student(s) Success!</div>');
        redirect('Afek_CRUD');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">New Student(s) Grade Already Exist!</div>');
        redirect('Afek_CRUD');
      }
      
    }
  }

  public function save_update(){

    if($this->input->post('minggu1a1[]')){
      $data = array();
      $d_s_id = $this->input->post('d_s_id[]');
      $afektif_id = $this->input->post('afektif_id[]');

      $minggu1a1 = $this->input->post('minggu1a1[]');
      $minggu1a2 = $this->input->post('minggu1a2[]');
      $minggu1a3 = $this->input->post('minggu1a3[]');

      $minggu2a1 = $this->input->post('minggu2a1[]');
      $minggu2a2 = $this->input->post('minggu2a2[]');
      $minggu2a3 = $this->input->post('minggu2a3[]');

      $minggu3a1 = $this->input->post('minggu3a1[]');
      $minggu3a2 = $this->input->post('minggu3a2[]');
      $minggu3a3 = $this->input->post('minggu3a3[]');

      $minggu4a1 = $this->input->post('minggu4a1[]');
      $minggu4a2 = $this->input->post('minggu4a2[]');
      $minggu4a3 = $this->input->post('minggu4a3[]');

      $minggu5a1 = $this->input->post('minggu5a1[]');
      $minggu5a2 = $this->input->post('minggu5a2[]');
      $minggu5a3 = $this->input->post('minggu5a3[]');

      for($i=0;$i<count($d_s_id);$i++){
        $data[$i] = [
          'afektif_minggu1a1' => $minggu1a1[$i],
          'afektif_minggu1a2' => $minggu1a2[$i],
          'afektif_minggu1a3' => $minggu1a3[$i],
          'afektif_minggu2a1' => $minggu2a1[$i],
          'afektif_minggu2a2' => $minggu2a2[$i],
          'afektif_minggu2a3' => $minggu2a3[$i],
          'afektif_minggu3a1' => $minggu3a1[$i],
          'afektif_minggu3a2' => $minggu3a2[$i],
          'afektif_minggu3a3' => $minggu3a3[$i],
          'afektif_minggu4a1' => $minggu4a1[$i],
          'afektif_minggu4a2' => $minggu4a2[$i],
          'afektif_minggu4a3' => $minggu4a3[$i],
          'afektif_minggu5a1' => $minggu5a1[$i],
          'afektif_minggu5a2' => $minggu5a2[$i],
          'afektif_minggu5a3' => $minggu5a3[$i],
          'afektif_id' => $afektif_id[$i]
        ];
      }
      $this->db->update_batch('afektif',$data, 'afektif_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Success!</div>');
      redirect('Afek_CRUD');
    }
  }
}

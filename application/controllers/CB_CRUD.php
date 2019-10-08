<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CB_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_sk');
    $this->load->model('_jenj');
    $this->load->model('_t');
    $this->load->model('_kelas');

    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika belum login dan bukan konselor
    if (konselor_menu() <= 0) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'CB Topic';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $kr_id = $this->session->userdata('kr_id');

    $data['sk_all'] = $this->db->query("
                      SELECT sk_id, sk_nama
                      FROM konselor 
                      LEFT JOIN sk ON konselor_sk_id = sk_id
                      WHERE konselor_kr_id = $kr_id")->result_array();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('cb_crud/index', $data);
    $this->load->view('templates/footer');
    
  }

  public function add_topik()
  {

    $sk_id = $this->input->post('topik_sk_id');
    if(!$sk_id){
      redirect('Profile');
    }

    $data['title'] = 'Add Topic';

    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['jenj_all'] = $this->_jenj->return_all_by_sk($sk_id);
    $data['sk_id'] = $sk_id;

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('cb_crud/add_topik', $data);
    $this->load->view('templates/footer');
    
  }

  public function add_proses_topik()
  {
    $sk_id = $this->input->post('sk_id',true);

    if($sk_id){
      $data = [
        'topik_cb_nama' => $this->input->post('topik_cb_nama',true),
        'topik_cb_jenj_id' => $this->input->post('topik_cb_jenj_id',true),
        'topik_cb_semester' => $this->input->post('topik_cb_semester',true),
        'topik_cb_a' => $this->input->post('topik_cb_a',true),
        'topik_cb_b' => $this->input->post('topik_cb_b',true),
        'topik_cb_c' => $this->input->post('topik_cb_c',true),
        'topik_cb_sk_id' => $sk_id
      ];

      $this->db->insert('topik_cb', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Topic Created!</div>');
      redirect('cb_crud');
    }else{
      redirect('Profile');
    }
    
  }

  public function edit_topik(){

    $topik_cb_id = $this->input->post('topik_cb_id',true);

    if($topik_cb_id){
      $data['title'] = 'Edit Topic';
      
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));



      $data['topik_cb'] = $this->db->query("
                      SELECT *
                      FROM topik_cb
                      WHERE topik_cb_id = $topik_cb_id")->row_array();

      $data['jenj_all'] = $this->_jenj->return_all_by_sk($data['topik_cb']['topik_cb_sk_id']);

      
      $data['jum_cb'] = $this->input->post('jum_cb',true);
                      
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('cb_crud/edit_topik', $data);
      $this->load->view('templates/footer');
    }

  }
  
  public function edit_topik_proses()
  {

    //dari method post
    $topik_cb_id = $this->input->post('topik_cb_id', true);

    //jika bukan dari form update sendiri
    if (!$topik_cb_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data = [
      'topik_cb_nama' => $this->input->post('topik_cb_nama',true),
      'topik_cb_jenj_id' => $this->input->post('topik_cb_jenj_id',true),
      'topik_cb_semester' => $this->input->post('topik_cb_semester',true),
      'topik_cb_a' => $this->input->post('topik_cb_a',true),
      'topik_cb_b' => $this->input->post('topik_cb_b',true),
      'topik_cb_c' => $this->input->post('topik_cb_c',true),
    ];

    //simpan ke db

    $this->db->where('topik_cb_id', $topik_cb_id);
    $this->db->update('topik_cb', $data);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Topic Updated!</div>');
    redirect('CB_CRUD');

  }
  
  public function grade(){
    $data['title'] = 'CB Grade';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['t_all'] = $this->_t->return_all();

    $kr_id = $this->session->userdata('kr_id');

    $data['sk_all'] = $this->db->query("
                      SELECT sk_id, sk_nama
                      FROM konselor 
                      LEFT JOIN sk ON konselor_sk_id = sk_id
                      WHERE konselor_kr_id = $kr_id")->result_array();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('cb_crud/grade', $data);
    $this->load->view('templates/footer');
  }

  public function grade_cek(){
    
    $topik_cb_id = $this->input->post('topik_cb',true);
    $kelas_id = $this->input->post('kelas_id',true);
    //cek ada nilai atau belum

    if($topik_cb_id && $kelas_id){
      $data['title'] = 'CB Grade';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas'] = $this->_kelas->find_kelas_nama($kelas_id);

      
      $data['topik_cb_nama'] = $this->db->query("SELECT topik_cb_nama
      FROM topik_cb 
      WHERE topik_cb_id = $topik_cb_id")->row_array();

      $cb_cek = $this->db->query("SELECT COUNT(*) AS jumlah
      FROM nilai_cb 
      LEFT JOIN d_s ON nilai_cb_d_s_id = d_s_id
      WHERE nilai_cb_topik_cb_id = $topik_cb_id AND d_s_kelas_id = $kelas_id")->row_array();

      $data['topik_cb_id'] = $topik_cb_id;
      if($cb_cek['jumlah'] == 0){
        //masih kosong nilainya

        $data['siswa_all'] = $this->db->query(
          "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk
          FROM d_s
          LEFT JOIN sis ON d_s_sis_id = sis_id
          WHERE d_s_kelas_id = $kelas_id
          ORDER BY sis_nama_depan, sis_no_induk")->result_array();
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cb_crud/grade_input', $data);
        $this->load->view('templates/footer');
      }else{
        //sudah ada
        $data['siswa_all'] = $this->db->query(
          "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk, nilai_cb1, nilai_cb2, nilai_cb3, nilai_cb4, nilai_cb5, nilai_cb_jum, nilai_cb_id
          FROM nilai_cb
          LEFT JOIN d_s ON d_s_id = nilai_cb_d_s_id
          LEFT JOIN sis ON d_s_sis_id = sis_id
          WHERE d_s_kelas_id = $kelas_id AND nilai_cb_topik_cb_id = $topik_cb_id
          ORDER BY sis_nama_depan, sis_no_induk")->result_array();

        //cek apakah ada murid baru
        $data['siswa_baru'] = $this->db->query(
          "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk
          FROM d_s
          LEFT JOIN sis ON d_s_sis_id = sis_id
          WHERE d_s_kelas_id = $kelas_id AND d_s_id NOT IN 
            (SELECT d_s_id
            FROM nilai_cb
            LEFT JOIN d_s ON nilai_cb_d_s_id = d_s_id
            WHERE d_s_kelas_id = $kelas_id AND nilai_cb_topik_cb_id = $topik_cb_id
            )
          ORDER BY sis_nama_depan")->result_array();

        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('cb_crud/grade_update', $data);
        $this->load->view('templates/footer');
      }
    }

    
  }

  public function save_input(){
    if($this->input->post('nilai_cb1[]',true)){

      $topik_cb_id = $this->input->post('nilai_cb_topik_cb_id',true);
      $kelas_id = $this->input->post('kelas_id',true);

      $cb_cek = $this->db->query("SELECT COUNT(*) AS jumlah
      FROM nilai_cb 
      LEFT JOIN d_s ON nilai_cb_d_s_id = d_s_id
      WHERE nilai_cb_topik_cb_id = $topik_cb_id AND d_s_kelas_id = $kelas_id")->row_array();

      if($cb_cek['jumlah'] == 0){
        $data = array();
        $d_s_id = $this->input->post('d_s_id[]');

        $nilai_cb1 = $this->input->post('nilai_cb1[]');
        $nilai_cb2 = $this->input->post('nilai_cb2[]');
        $nilai_cb3 = $this->input->post('nilai_cb3[]');
        $nilai_cb4 = $this->input->post('nilai_cb4[]');
        $nilai_cb5 = $this->input->post('nilai_cb5[]');
        $nilai_cb_jum = $this->input->post('nilai_cb_jum');
        $nilai_cb_topik_cb_id = $topik_cb_id;

        for($i=0;$i<count($d_s_id);$i++){
            $data[$i] = [
              'nilai_cb_d_s_id' => $d_s_id[$i],
              'nilai_cb_topik_cb_id' => $nilai_cb_topik_cb_id,
              'nilai_cb_jum' => $nilai_cb_jum,
              'nilai_cb1' => $nilai_cb1[$i],
              'nilai_cb2' => $nilai_cb2[$i],
              'nilai_cb3' => $nilai_cb3[$i],
              'nilai_cb4' => $nilai_cb4[$i],
              'nilai_cb5' => $nilai_cb5[$i]
            ];
        }

        $this->db->insert_batch('nilai_cb', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('cb_crud/grade');
      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Failed, grade already exist!</div>');
        redirect('cb_crud/grade');
      }
    }
  }

  public function save_update(){
    if($this->input->post('nilai_cb1[]',true)){

      $topik_cb_id = $this->input->post('nilai_cb_topik_cb_id',true);
      $kelas_id = $this->input->post('kelas_id',true);

      $data = array();
      $d_s_id = $this->input->post('d_s_id[]');

      $nilai_cb1 = $this->input->post('nilai_cb1[]');
      $nilai_cb2 = $this->input->post('nilai_cb2[]');
      $nilai_cb3 = $this->input->post('nilai_cb3[]');
      $nilai_cb4 = $this->input->post('nilai_cb4[]');
      $nilai_cb5 = $this->input->post('nilai_cb5[]');
      $nilai_cb_id = $this->input->post('nilai_cb_id[]');
      $nilai_cb_jum = $this->input->post('nilai_cb_jum');

      for($i=0;$i<count($d_s_id);$i++){
          $data[$i] = [
            'nilai_cb_jum' => $nilai_cb_jum,
            'nilai_cb1' => $nilai_cb1[$i],
            'nilai_cb2' => $nilai_cb2[$i],
            'nilai_cb3' => $nilai_cb3[$i],
            'nilai_cb4' => $nilai_cb4[$i],
            'nilai_cb5' => $nilai_cb5[$i],
            'nilai_cb_id' => $nilai_cb_id[$i]
          ];
      }

      $this->db->update_batch('nilai_cb', $data, 'nilai_cb_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Success!</div>');
      redirect('cb_crud/grade');
    }
  }

  public function save_new_student(){
    if($this->input->post('d_s_id[]',true)){

      $d_s_id = $this->input->post('d_s_id[]',true);
      $topik_cb_id = $this->input->post('nilai_cb_topik_cb_id',true);
      $kelas_id = $this->input->post('kelas_id',true);
      $nilai_cb_jum = $this->input->post('nilai_cb_jum',true);

      $siswa_id = "";
      for($i=0;$i<count($d_s_id);$i++){
        $siswa_id .= $d_s_id[$i];
        if($i != count($d_s_id)-1){
          $siswa_id .= ",";
        }
      }

      $cb_cek = $this->db->query("SELECT COUNT(*) AS jumlah
                FROM nilai_cb 
                LEFT JOIN d_s ON nilai_cb_d_s_id = d_s_id
                WHERE nilai_cb_topik_cb_id = $topik_cb_id AND d_s_id IN ($siswa_id)")->row_array();

      
      //cek apa nilai sudah ada

      if($cb_cek['jumlah'] == 0){
        
        $nilai_cb1 = $this->input->post('nilai_cb1[]');
        $nilai_cb2 = $this->input->post('nilai_cb2[]');
        $nilai_cb3 = $this->input->post('nilai_cb3[]');
        $nilai_cb4 = $this->input->post('nilai_cb4[]');
        $nilai_cb5 = $this->input->post('nilai_cb5[]');
        for($i=0;$i<count($d_s_id);$i++){
          $data[$i] = [
            'nilai_cb_d_s_id' => $d_s_id[$i],
            'nilai_cb_topik_cb_id' => $topik_cb_id,
            'nilai_cb_jum' => $nilai_cb_jum,
            'nilai_cb1' => $nilai_cb1[$i],
            'nilai_cb2' => $nilai_cb2[$i],
            'nilai_cb3' => $nilai_cb3[$i],
            'nilai_cb4' => $nilai_cb4[$i],
            'nilai_cb5' => $nilai_cb5[$i]
          ];
        }
        
        $this->db->insert_batch('nilai_cb', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('cb_crud/grade');

      }else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Failed, grade already exist!</div>');
        redirect('cb_crud/grade');
      }

      //var_dump($cb_cek);
    }
  }

  
  public function report(){

    $data['title'] = 'CB Grade';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['t_all'] = $this->_t->return_all();

    $kr_id = $this->session->userdata('kr_id');

    $data['sk_all'] = $this->db->query("
                      SELECT sk_id, sk_nama
                      FROM konselor 
                      LEFT JOIN sk ON konselor_sk_id = sk_id
                      WHERE konselor_kr_id = $kr_id")->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('cb_crud/report', $data);
    $this->load->view('templates/footer');
  }

  
  public function report_show(){
    if($this->input->post('sk_id',true)){
      $sk_id = $this->input->post('sk_id',true);
      $t_id = $this->input->post('t_id',true);

      
      $data['title'] = 'CB Report';
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
      $this->load->view('cb_crud/report_show', $data);
      $this->load->view('templates/footer');
    }
  }

  public function delete_topik(){
    if($this->input->post('topik_cb_id',true)){
      $topik_cb_id = $this->input->post('topik_cb_id',true);

      $this->db->where('topik_cb_id', $topik_cb_id);
      $this->db->delete('topik_cb');

      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Topic Deleted!</div>');
      redirect('CB_crud');
    }
  }

}

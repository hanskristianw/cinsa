<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Topik_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_sk');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_mapel');
    $this->load->model('_jenj');
    $this->load->model('_topik');


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

    $data['title'] = 'Topic';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //$data['tes'] = var_dump($this->db->last_query());

    //cari guru mengajar mapel mana saja

    $kr_id = $data['kr']['kr_id'];

    //SELECT * from d_mpl WHERE d_mpl_kr_id = $data['kr']['kr_id']
    $data['jabatan_id'] = $this->session->userdata('kr_jabatan_id');

    if($this->session->userdata('kr_jabatan_id')!=4){
      $data['mapel_all'] = $this->db->query(
        "SELECT DISTINCT mapel_id, mapel_nama, sk_nama
        FROM d_mpl 
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN sk ON kelas_sk_id = sk_id
        WHERE d_mpl_kr_id = $kr_id")->result_array();
  
      if(empty($data['mapel_all'])){
        $this->session->set_flashdata("message","<div class='alert alert-danger' role='alert'>You don't teach any class, contact curriculum for more information!</div>");
        redirect('Profile');
      }
    }else{
      $sk_id = $this->session->userdata('kr_sk_id');
      $data['mapel_all'] = $this->db->query(
        "SELECT DISTINCT mapel_id, mapel_nama, sk_nama
        FROM d_mpl 
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN sk ON kelas_sk_id = sk_id
        WHERE sk_id = $sk_id
        ORDER BY mapel_nama")->result_array();


    }

    //var_dump($this->session->userdata('kr_jabatan_id'));
    

    //var_dump($this->db->last_query());
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('topik_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function get_topik_detail(){
    if($this->input->post('id',TRUE)){
      
      $mapel_id = $this->input->post('id',TRUE);
      
      $data = $this->db->query(
        "SELECT topik_nama, topik_id, jenj_nama, topik_mapel_id, topik_urutan, topik_semester, count(tes_id) as jum_tes
        FROM topik
        LEFT JOIN jenj ON topik_jenj_id = jenj_id
        LEFT JOIN tes ON tes_topik_id = topik_id
        WHERE topik_mapel_id = $mapel_id
        GROUP BY topik_id
        ORDER BY jenj_id, topik_semester, topik_urutan, topik_nama")->result();
  
      //var_dump($data);
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function proses_add(){

    $mapel_id = $this->input->post('mapel_id', true);

    if (!$mapel_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }else{
      $data = [
        'topik_nama' => $this->input->post('topik_nama'),
        'topik_semester' => $this->input->post('topik_semester'),
        'topik_urutan' => $this->input->post('topik_urutan'),
        'topik_jenj_id' => $this->input->post('jenj_id'),
        'topik_mapel_id' => $this->input->post('mapel_id')
      ];
  
      $this->db->insert('topik', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Topic Created!</div>');
      redirect('Topik_CRUD');
    }

  }
  
  public function add(){


    $mapel_id = $this->input->post('topik_mapel', true);

    if (!$mapel_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['sk'] = $this->db->query(
      "SELECT mapel_sk_id
      FROM mapel
      WHERE mapel_id = $mapel_id")->row_array();

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['jenj_all'] = $this->_jenj->return_all_by_sk($data['sk']['mapel_sk_id']);
    
    $data['mapel_id'] = $mapel_id;
    $data['title'] = 'Create Topic';

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Topik_CRUD/add',$data);
    $this->load->view('templates/footer');

  }

  public function edit(){
    
    $topik_id = $this->input->post('topik_id', true);
    $mapel_id = $this->input->post('mapel_id', true);

    if(!$topik_id || !$mapel_id){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['title'] = 'Edit Topic';

    $data['sk'] = $this->db->query(
      "SELECT mapel_sk_id
      FROM mapel
      WHERE mapel_id = $mapel_id")->row_array();

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['jenj_all'] = $this->_jenj->return_all_by_sk($data['sk']['mapel_sk_id']);
    $data['topik_update'] = $this->_topik->find_by_id($topik_id);
    $data['jum_tes'] = $this->input->post('jum_tes', true);

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Topik_CRUD/edit',$data);
    $this->load->view('templates/footer');

  }
  
  public function delete(){
    if($this->input->post('topik_id', true) || $this->session->userdata('kr_jabatan_id')!=4){
      $topik_id = $this->input->post('topik_id', true);

      $this->db->where('topik_id', $topik_id);
      $this->db->delete('topik');

      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Topic Deleted!</div>');
      redirect('topik_crud');
    }
  }

  public function edit_proses(){
    if($this->input->post('_id', true)){
      $data = [
        'topik_nama' => $this->input->post('topik_nama'),
        'topik_semester' => $this->input->post('topik_semester'),
        'topik_jenj_id' => $this->input->post('jenj_id'),
        'topik_urutan' => $this->input->post('topik_urutan')
      ];

      //simpan ke db

      $this->db->where('topik_id', $this->input->post('_id', true));
      $this->db->update('topik', $data); 
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Topic Updated!</div>');
      redirect('Topik_CRUD');
    }
  }

  public function outline(){
    $data['title'] = 'Outline';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    
    $kr_id = $data['kr']['kr_id'];
    
    $data['jabatan_id'] = $this->session->userdata('kr_jabatan_id');

    if($this->session->userdata('kr_jabatan_id')!=4){
      $data['mapel_all'] = $this->db->query(
        "SELECT DISTINCT mapel_id, mapel_nama, sk_nama
        FROM d_mpl 
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN sk ON kelas_sk_id = sk_id
        WHERE d_mpl_kr_id = $kr_id")->result_array();
  
      if(empty($data['mapel_all'])){
        $this->session->set_flashdata("message","<div class='alert alert-danger' role='alert'>You don't teach any class, contact curriculum for more information!</div>");
        redirect('Profile');
      }
    }else{
      $sk_id = $this->session->userdata('kr_sk_id');
      $data['mapel_all'] = $this->db->query(
        "SELECT DISTINCT mapel_id, mapel_nama, sk_nama
        FROM d_mpl 
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        LEFT JOIN sk ON kelas_sk_id = sk_id
        WHERE sk_id = $sk_id
        ORDER BY mapel_nama")->result_array();
        
    }
    
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('topik_crud/outline',$data);
    $this->load->view('templates/footer');
  }

  public function add_outline(){
    $mapel_id = $this->input->post('mapel_id', true);

    if (!$mapel_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['sk'] = $this->db->query(
      "SELECT mapel_nama, mapel_sk_id
      FROM mapel
      WHERE mapel_id = $mapel_id")->row_array();

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['jenj_all'] = $this->_jenj->return_all_by_sk($data['sk']['mapel_sk_id']);
    
    $data['mapel_id'] = $mapel_id;
    $data['mapel_nama'] = $data['sk']['mapel_nama'];
    $data['title'] = 'Tambah Outline';

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Topik_CRUD/add_outline',$data);
    $this->load->view('templates/footer');
  }

  public function proses_add_outline(){
    if($this->input->post('mapel_outline_nama', true)){

      $mapel_outline_mapel_id = $this->input->post('mapel_outline_mapel_id', true);
      $mapel_outline_nama = $this->input->post('mapel_outline_nama', true);
      $mapel_outline_jenj_id = $this->input->post('mapel_outline_jenj_id', true);

      $data = [
        'mapel_outline_mapel_id' => $mapel_outline_mapel_id,
        'mapel_outline_nama' => $mapel_outline_nama,
        'mapel_outline_jenj_id' => $mapel_outline_jenj_id
      ];
  
      $this->db->insert('mapel_outline', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Outline Berhasil Dibuat!</div>');
      redirect('Topik_CRUD/outline');

    }
  }

  public function edit_outline(){
    
    $mapel_outline_id = $this->input->post('mapel_outline_id', true);

    if(!$mapel_outline_id){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['title'] = 'Edit Outline';

    $data['mo'] = $this->db->query(
      "SELECT *
      FROM mapel_outline
      WHERE mapel_outline_id = $mapel_outline_id")->row_array();

    $mapel_id = $data['mo']['mapel_outline_mapel_id'];

    $data['sk'] = $this->db->query(
      "SELECT mapel_nama, mapel_sk_id
      FROM mapel
      WHERE mapel_id = $mapel_id")->row_array();

    $data['mapel_nama'] = $data['sk']['mapel_nama'];

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['jenj_all'] = $this->_jenj->return_all_by_sk($data['sk']['mapel_sk_id']);

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Topik_CRUD/edit_outline',$data);
    $this->load->view('templates/footer');

  }

  public function edit_outline_proses(){
    if($this->input->post('mapel_outline_nama', true)){
      
      $mapel_outline_nama = $this->input->post('mapel_outline_nama', true);
      $mapel_outline_jenj_id = $this->input->post('mapel_outline_jenj_id', true);
      
      $data = [
        'mapel_outline_nama' => $mapel_outline_nama,
        'mapel_outline_jenj_id' => $mapel_outline_jenj_id
      ];

      $this->db->where('mapel_outline_id', $this->input->post('mapel_outline_id', true));
      $this->db->update('mapel_outline', $data); 
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Outline berhasil dirubah!</div>');
      redirect('Topik_CRUD/outline');
    }
  }

}

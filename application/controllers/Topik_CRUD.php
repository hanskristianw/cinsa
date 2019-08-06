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
        "SELECT *
        FROM topik
        LEFT JOIN jenj ON topik_jenj_id = jenj_id
        WHERE topik_mapel_id = $mapel_id
        ORDER BY jenj_id, topik_urutan, topik_semester, topik_nama")->result();
  
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

    $data['sk'] = $this->db->query(
      "SELECT mapel_sk_id
      FROM mapel
      WHERE mapel_id = $mapel_id")->row_array();

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['jenj_all'] = $this->_jenj->return_all_by_sk($data['sk']['mapel_sk_id']);
    $data['topik_update'] = $this->_topik->find_by_id($topik_id);

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Topik_CRUD/edit',$data);
    $this->load->view('templates/footer');

    // //jika bukan dari form update sendiri
    // if (!$topik_post) {
    //   //ambil id dari method get
    //   $topik_get = $this->_topik->find_by_id($this->input->get('_id', true));

    //   //jika langsung akses halaman
    //   if (!$topik_get['topik_id']) {
    //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
    //     redirect('Topik_CRUD');
    //   }

    //   //////////////////////////////////////
    //   //jika akses mapel yang tidak diajar//
    //   //////////////////////////////////////
    //   $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    //   $kr_id = $data['kr']['kr_id'];

    //   $data['mapel_all'] = $this->db->query(
    //     "SELECT GROUP_CONCAT(DISTINCT mapel_id) as mapel_id
    //     FROM d_mpl 
    //     LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
    //     WHERE d_mpl_kr_id = $kr_id")->row_array();

    //   $mapelget = $this->input->get('_mapelid', true);

    //   $arr_mapel_id = explode(",",$data['mapel_all']['mapel_id']);

    //   $found = 0;
    //   for($i=0;$i<count($arr_mapel_id);$i++){
    //     if($mapelget == $arr_mapel_id[$i]){
    //       $found = 1;
    //     }
    //   }
    //   if($found == 0){
    //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You dont teach this subject!</div>');
    //     redirect('Topik_CRUD');
    //   }

    // }
    
    // $this->form_validation->set_rules('topik_nama', 'Topic Name', 'required|trim');
    // $this->form_validation->set_rules('topik_urutan', 'Topic Order', 'required|trim');

		// if($this->form_validation->run() == false){
		// 	$data['title'] = 'Edit Topic';
    //   $data['_id'] = $this->input->get('_id', true);

    //   $data['topik_update'] = $this->_topik->find_by_id($this->input->get('_id', true));

    //   //data karyawan yang sedang login untuk topbar
    //   $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    //   $data['jenj_all'] = $this->_jenj->return_all_by_sk($this->session->userdata('kr_sk_id'));
      

    //   $this->load->view('templates/header',$data);
    //   $this->load->view('templates/sidebar',$data);
    //   $this->load->view('templates/topbar',$data);
    //   $this->load->view('Topik_CRUD/edit',$data);
    //   $this->load->view('templates/footer');
		// }
    // else{
    //   //fetch data hasil inputan
    //   $data = [
    //     'topik_nama' => $this->input->post('topik_nama'),
		// 		'topik_semester' => $this->input->post('topik_semester'),
		// 		'topik_urutan' => $this->input->post('topik_urutan'),
		// 		'topik_jenj_id' => $this->input->post('jenj_id')
    //   ];

    //   //simpan ke db

    //   $this->db->where('topik_id', $this->input->post('_id'));
    //   $this->db->update('topik', $data); 
      
    //   $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Topic Updated!</div>');
    //   redirect('Topik_CRUD');
    // }

  }

  public function edit_proses(){
    if($this->input->post('_id', true)){
      $data = [
        'topik_nama' => $this->input->post('topik_nama'),
        'topik_semester' => $this->input->post('topik_semester'),
        'topik_urutan' => $this->input->post('topik_urutan'),
        'topik_jenj_id' => $this->input->post('jenj_id')
      ];

      //simpan ke db

      $this->db->where('topik_id', $this->input->post('_id', true));
      $this->db->update('topik', $data); 
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Topic Updated!</div>');
      redirect('Topik_CRUD');
    }
  }
}

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
    if($this->session->userdata('kr_jabatan_id')!=7 && $this->session->userdata('kr_jabatan_id')){
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
      "SELECT DISTINCT mapel_id, mapel_nama, sk_nama, 
      GROUP_CONCAT(DISTINCT topik_id ORDER BY topik_nama) as topik_id, 
      GROUP_CONCAT(DISTINCT topik_nama ORDER BY topik_nama) as topik_nama
      FROM d_mpl 
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
      LEFT JOIN t ON kelas_t_id = t_id
      LEFT JOIN sk ON kelas_sk_id = sk_id
      LEFT JOIN topik ON mapel_id = topik_mapel_id
      WHERE d_mpl_kr_id = $kr_id
      GROUP BY mapel_id
      ORDER BY t_id DESC, sk_nama, kelas_nama")->result_array();

    //var_dump($this->db->last_query());
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('topik_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function add(){


    $mapel_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if (!$mapel_post) {
      //ambil id dari method get
      $mapel_get = $this->_mapel->find_by_id($this->input->get('_id', true));
      
      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if (!$mapel_get['mapel_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use +TOPIC button instead!</div>');
        redirect('Topik_CRUD');
      }
      //////////////////////////////////////
      //jika akses mapel yang tidak diajar//
      //////////////////////////////////////
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $kr_id = $data['kr']['kr_id'];

      $data['mapel_all'] = $this->db->query(
        "SELECT GROUP_CONCAT(DISTINCT mapel_id) as mapel_id
        FROM d_mpl 
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        WHERE d_mpl_kr_id = $kr_id")->row_array();

      $arr_mapel_id = explode(",",$data['mapel_all']['mapel_id']);
      $j = $this->input->get('_id', true);
      $found = 0;
      for($i=0;$i<count($arr_mapel_id);$i++){
        if($j == $arr_mapel_id[$i]){
          $found = 1;
        }
      }
      if($found == 0){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You dont teach this subject!</div>');
        redirect('Topik_CRUD');
      }

    }

		$this->form_validation->set_rules('topik_nama', 'Topic Name', 'required|trim');

		if($this->form_validation->run() == false){
			$data['title'] = 'Create Topic';
      $data['_id'] = $this->input->get('_id', true);

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jenj_all'] = $this->_jenj->return_all_by_sk($this->session->userdata('kr_sk_id'));

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Topik_CRUD/add',$data);
      $this->load->view('templates/footer');
		}
		else{
			$data = [
				'topik_nama' => $this->input->post('topik_nama'),
				'topik_semester' => $this->input->post('topik_semester'),
				'topik_jenj_id' => $this->input->post('jenj_id'),
				'topik_mapel_id' => $this->input->post('_id')
			];

			$this->db->insert('topik', $data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Topic Created!</div>');
			redirect('Topik_CRUD');
		}

  }

  public function edit(){
    
    $topik_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if (!$topik_post) {
      //ambil id dari method get
      $topik_get = $this->_topik->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman
      if (!$topik_get['topik_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Topik_CRUD');
      }

      //////////////////////////////////////
      //jika akses mapel yang tidak diajar//
      //////////////////////////////////////
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $kr_id = $data['kr']['kr_id'];

      $data['mapel_all'] = $this->db->query(
        "SELECT GROUP_CONCAT(DISTINCT mapel_id) as mapel_id
        FROM d_mpl 
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        WHERE d_mpl_kr_id = $kr_id")->row_array();

      $mapelget = $this->input->get('_mapelid', true);

      $arr_mapel_id = explode(",",$data['mapel_all']['mapel_id']);

      $found = 0;
      for($i=0;$i<count($arr_mapel_id);$i++){
        if($mapelget == $arr_mapel_id[$i]){
          $found = 1;
        }
      }
      if($found == 0){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">You dont teach this subject!</div>');
        redirect('Topik_CRUD');
      }

    }
    
    $this->form_validation->set_rules('topik_nama', 'Topic Name', 'required|trim');

		if($this->form_validation->run() == false){
			$data['title'] = 'Edit Topic';
      $data['_id'] = $this->input->get('_id', true);

      $data['topik_update'] = $this->_topik->find_by_id($this->input->get('_id', true));

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jenj_all'] = $this->_jenj->return_all_by_sk($this->session->userdata('kr_sk_id'));
      

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Topik_CRUD/edit',$data);
      $this->load->view('templates/footer');
		}
    else{
      //fetch data hasil inputan
      $data = [
        'topik_nama' => $this->input->post('topik_nama'),
				'topik_semester' => $this->input->post('topik_semester'),
				'topik_jenj_id' => $this->input->post('jenj_id')
      ];

      //simpan ke db

      $this->db->where('topik_id', $this->input->post('_id'));
      $this->db->update('topik', $data); 
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Topic Updated!</div>');
      redirect('Topik_CRUD');
    }

  }
}

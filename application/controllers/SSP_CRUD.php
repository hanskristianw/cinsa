<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SSP_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_ssp');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');
    $this->load->model('_t');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=4 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'SSP List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['ssp_all'] = $this->_ssp->return_all_by_sk_id($this->session->userdata('kr_sk_id'));

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('ssp_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function add(){

		$this->form_validation->set_rules('ssp_nama', 'SSP Name', 'required|trim');
    // $this->form_validation->set_rules('ssp_kkm', 'Passing Grade', 'required|trim|greater_than[0]|less_than[101])');
    // $this->form_validation->set_rules('ssp_sing', 'Abbreviation', 'required|trim');
    // $this->form_validation->set_rules('ssp_urutan', 'Order', 'required|trim');
    //$this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim|is_unique[mapel.mapel_urutan]', ['is_unique' => 'This order number already exist!']);


		if($this->form_validation->run() == false){
			$data['title'] = 'Create SSP';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['ssp_all'] = $this->_ssp->return_all();
      $data['sk_all'] = $this->_sk->return_all();
      $data['guru_all'] = $this->_kr->return_all_teacher();
      $data['t_all'] = $this->_t->return_all();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('ssp_crud/add',$data);
      $this->load->view('templates/footer');
		}
		else{
			$data = [
				'ssp_nama' => $this->input->post('ssp_nama'),
				'ssp_t_id' => $this->input->post('ssp_t_id'),
				'ssp_kr_id' => $this->input->post('ssp_kr_id'),
        'ssp_sk_id' => $this->session->userdata('kr_sk_id')
			];

			$this->db->insert('ssp', $data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">SSP Created!</div>');
			redirect('ssp_crud/add');
		}

  }
  
  public function update(){

    //dari method post
    $ssp_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if(!$ssp_post){
      //ambil id dari method get
      $ssp_get = $this->_ssp->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if(!$ssp_get){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('SSP_CRUD');
      }
    }

    $this->form_validation->set_rules('ssp_nama', 'SSP Name', 'required|trim');
		// $this->form_validation->set_rules('mapel_sing', 'Abbreviation', 'required|trim');
  //   $this->form_validation->set_rules('mapel_kkm', 'Passing Grade', 'required|trim|greater_than[0]|less_than[101])');
  //   $this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim');
    // if($this->input->post('_mapel_urutan') == $this->input->post('mapel_urutan')){
    //   $this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim');
    // }else{
    //   $this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim|is_unique[mapel.mapel_urutan]', ['is_unique' => 'This order number already exist!']);
    // }

    if($this->form_validation->run() == false){
      //jika menekan tombol edit
      $data['title'] = 'Update SSP Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();

      //simpan data primary key
      $ssp_id = $this->input->get('_id', true);

      $data['ssp_update'] = $this->_ssp->find_by_id($ssp_id);
      $data['guru_all'] = $this->_kr->return_all_teacher();
      $data['t_all'] = $this->_t->return_all();

      //load view dengan data query
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('ssp_crud/update',$data);
      $this->load->view('templates/footer');
    }
    else{
      //fetch data hasil inputan
      $data = [
        'ssp_nama' => $this->input->post('ssp_nama'),
				'ssp_t_id' => $this->input->post('ssp_t_id'),
				'ssp_kr_id' => $this->input->post('ssp_kr_id')
      ];

      //simpan ke db
      $this->db->where('ssp_id', $this->input->post('_id'));
      $this->db->update('ssp', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">SSP Updated!</div>');
      redirect('SSP_CRUD');
    }

  }

}

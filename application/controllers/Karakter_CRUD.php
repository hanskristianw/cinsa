<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karakter_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_mapel');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');
    $this->load->model('_karakter');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=5 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'Character List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['karakter_all'] = $this->_karakter->return_all();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('karakter_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function edit_subject(){
    $data['title'] = 'Edit Subject';

    $karakter_id = $this->input->post('karakter_id',true);
    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['sk_all'] = $this->_sk->return_all();
    
    $data['karakter'] = $this->_karakter->find_by_id($karakter_id);

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('karakter_crud/edit_subject',$data);
    $this->load->view('templates/footer');
  }

  public function delete(){
    $karakter_id = $this->input->post('karakter_id',true);
    if($karakter_id){
      $this->db->where('karakter_id', $karakter_id);
      $this->db->delete('karakter');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Successfully Delete Character</div>');
      redirect('Karakter_CRUD');
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied</div>');
      redirect('Profile');
    }
  }

  public function save_character(){
    $mapel = $this->input->post('mapel_check[]',true);
    $karakter_id = $this->input->post('karakter_id',true);

    if($mapel){
      //delete semua mapel dengan karakter ini
      $this->db->where('karakter_detail_karakter_id', $karakter_id);
      $this->db->delete('karakter_detail');

      //set semua mapel yang dipilih dengan karakter id
      $data = array();
      for($i=0;$i<count($mapel);$i++){
        $data[$i] = [
          'karakter_detail_mapel_id' => $mapel[$i],
          'karakter_detail_karakter_id' => $karakter_id
        ];
      }

      $this->db->insert_batch('karakter_detail', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Success!</div>');
			redirect('karakter_crud');
    }

  }

  public function add(){

		$this->form_validation->set_rules('karakter_nama', 'Character Name', 'required|trim');
    $this->form_validation->set_rules('karakter_urutan', 'Order ', 'required|trim');
    $this->form_validation->set_rules('karakter_a', 'Character A', 'required|trim');
    $this->form_validation->set_rules('karakter_b', 'Character B', 'required|trim');
    $this->form_validation->set_rules('karakter_c', 'Character C', 'required|trim');
    //$this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim|is_unique[mapel.mapel_urutan]', ['is_unique' => 'This order number already exist!']);


		if($this->form_validation->run() == false){
			$data['title'] = 'Create Character';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['karakter_all'] = $this->_karakter->return_all();
      // $data['sk_all'] = $this->_sk->return_all();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('karakter_crud/add',$data);
      $this->load->view('templates/footer');
		}
		else{
			$data = [
				'karakter_nama' => $this->input->post('karakter_nama'),
        'karakter_a' => $this->input->post('karakter_a'),
				'karakter_b' => $this->input->post('karakter_b'),
        'karakter_c' => $this->input->post('karakter_c'),
        'karakter_urutan' => $this->input->post('karakter_urutan')
			];

			$this->db->insert('karakter', $data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Character Created!</div>');
			redirect('karakter_crud/add');
		}

  }
  
  public function update(){

    //dari method post
    $karakter_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if(!$karakter_post){
      //ambil id dari method get
      $karakter_get = $this->_karakter->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if(!$karakter_get){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Karakter_CRUD');
      }
    }

    $this->form_validation->set_rules('karakter_nama', 'Character Name', 'required|trim');
    $this->form_validation->set_rules('karakter_urutan', 'Number Character', 'required|trim');
		$this->form_validation->set_rules('karakter_a', 'Character A', 'required|trim');
    $this->form_validation->set_rules('karakter_b', 'Character B', 'required|trim');
    $this->form_validation->set_rules('karakter_c', 'Character C', 'required|trim');
    // if($this->input->post('_mapel_urutan') == $this->input->post('mapel_urutan')){
    //   $this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim');
    // }else{
    //   $this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim|is_unique[mapel.mapel_urutan]', ['is_unique' => 'This order number already exist!']);
    // }

    if($this->form_validation->run() == false){
      //jika menekan tombol edit
      $data['title'] = 'Update Character Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['karakter_all'] = $this->_karakter->return_all();

      //simpan data primary key
      $karakter_id = $this->input->get('_id', true);

      $data['karakter_update'] = $this->_karakter->find_by_id($karakter_id);

      //load view dengan data query
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('karakter_crud/update',$data);
      $this->load->view('templates/footer');
    }
    else{
      //fetch data hasil inputan
      $data = [
        'karakter_nama' => $this->input->post('karakter_nama'),
				'karakter_a' => $this->input->post('karakter_a'),
        'karakter_b' => $this->input->post('karakter_b'),
        'karakter_c' => $this->input->post('karakter_c'),
        'karakter_urutan' => $this->input->post('karakter_urutan')
      ];

      //simpan ke db
      $this->db->where('karakter_id', $this->input->post('_id'));
      $this->db->update('karakter', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Character Updated!</div>');
      redirect('Karakter_CRUD');
    }

  }

}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mid_Report_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kelas');
    $this->load->model('_t');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');

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

    $data['title'] = 'Class List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['t_all'] = $this->_t->return_all();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Mid_Report_CRUD/index',$data);
    $this->load->view('templates/footer');

  }

  public function get_kelas(){
    if($this->input->post('id',TRUE)){
    
      $t_id = $this->input->post('id',TRUE);
      $sk_id = $this->session->userdata('kr_sk_id');
      
      //temukan jenjang id pada kelas itu
      $data = $this->db->query(
        "SELECT kelas_id, kelas_nama
        FROM kelas
        WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id
        ORDER BY kelas_nama")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function get_siswa(){
    if($this->input->post('id',TRUE)){
    
      $kelas_id = $this->input->post('id',TRUE);
      
      //temukan jenjang id pada kelas itu
      $data = $this->db->query(
        "SELECT sis_id, sis_nama_depan, sis_nama_bel
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE d_s_kelas_id = $kelas_id
        ORDER BY sis_nama_depan")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function add(){

		$this->form_validation->set_rules('mapel_nama', 'Subject Name', 'required|trim');
    $this->form_validation->set_rules('mapel_kkm', 'Passing Grade', 'required|trim|greater_than[0]|less_than[101])');
    $this->form_validation->set_rules('mapel_sing', 'Abbreviation', 'required|trim');
    $this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim');
    //$this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim|is_unique[mapel.mapel_urutan]', ['is_unique' => 'This order number already exist!']);


		if($this->form_validation->run() == false){
			$data['title'] = 'Create Subject';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['mapel_all'] = $this->_mapel->return_all();
      $data['sk_all'] = $this->_sk->return_all();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('mapel_crud/add',$data);
      $this->load->view('templates/footer');
		}
		else{
			$data = [
				'mapel_nama' => $this->input->post('mapel_nama'),
        'mapel_kkm' => $this->input->post('mapel_kkm'),
				'mapel_sing' => $this->input->post('mapel_sing'),
        'mapel_urutan' => $this->input->post('mapel_urutan'),
        'mapel_sk_id' => $this->session->userdata('kr_sk_id')
			];

			$this->db->insert('mapel', $data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Subject Created!</div>');
			redirect('mapel_crud/add');
		}

  }
  
  public function update(){

    //dari method post
    $mapel_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if(!$mapel_post){
      //ambil id dari method get
      $mapel_get = $this->_mapel->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if(!$mapel_get){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Mapel_CRUD');
      }
    }

    $this->form_validation->set_rules('mapel_nama', 'Subject Name', 'required|trim');
		$this->form_validation->set_rules('mapel_sing', 'Abbreviation', 'required|trim');
    $this->form_validation->set_rules('mapel_kkm', 'Passing Grade', 'required|trim|greater_than[0]|less_than[101])');
    $this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim');
    // if($this->input->post('_mapel_urutan') == $this->input->post('mapel_urutan')){
    //   $this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim');
    // }else{
    //   $this->form_validation->set_rules('mapel_urutan', 'Order', 'required|trim|is_unique[mapel.mapel_urutan]', ['is_unique' => 'This order number already exist!']);
    // }

    if($this->form_validation->run() == false){
      //jika menekan tombol edit
      $data['title'] = 'Update Subject Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();

      //simpan data primary key
      $mapel_id = $this->input->get('_id', true);

      $data['mapel_update'] = $this->_mapel->find_by_id($mapel_id);

      //load view dengan data query
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('mapel_crud/update',$data);
      $this->load->view('templates/footer');
    }
    else{
      //fetch data hasil inputan
      $data = [
        'mapel_nama' => $this->input->post('mapel_nama'),
				'mapel_sing' => $this->input->post('mapel_sing'),
        'mapel_urutan' => $this->input->post('mapel_urutan'),
        'mapel_kkm' => $this->input->post('mapel_kkm')
      ];

      //simpan ke db
      $this->db->where('mapel_id', $this->input->post('_id'));
      $this->db->update('mapel', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Subject Updated!</div>');
      redirect('Mapel_CRUD');
    }

  }

}

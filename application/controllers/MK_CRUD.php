<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MK_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_mk');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');
    $this->load->model('_t');
    $this->load->model('_siswa');
    $this->load->model('_mapel');

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

    $data['title'] = 'Special Subject List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['mk_all'] = $this->_mk->return_all_by_sk_id($this->session->userdata('kr_sk_id'));
    

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('mk_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function add(){

		$this->form_validation->set_rules('mk_nama', 'Subject Name', 'required|trim');


		if($this->form_validation->run() == false){
			$data['title'] = 'Create Special Subject';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['t_all'] = $this->_t->return_all();
      $data['mapel_all'] = $this->_mapel->return_all_by_sk_id($this->session->userdata('kr_sk_id'));

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('mk_crud/add',$data);
      $this->load->view('templates/footer');
		}
		else{
			$data = [
				'mk_nama' => $this->input->post('mk_nama'),
				'mk_t_id' => $this->input->post('mk_t_id'),
        'mk_sk_id' => $this->session->userdata('kr_sk_id'),
        'mk_mapel_id' => $this->input->post('mk_mapel_id')
			];

			$this->db->insert('mk', $data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Special Subject Created!</div>');
			redirect('mk_crud/add');
		}

  }
  
  public function update(){

    //dari method post
    $mk_post = $this->input->post('mk_id', true);

    //jika bukan dari form update sendiri
    if(!$mk_post){
      //ambil id dari method get
      $mk_get = $this->_mk->find_by_id($this->input->get('mk_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if(!$mk_get){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('MK_CRUD');
      }
    }

    $this->form_validation->set_rules('mk_nama', 'Subject Name', 'required|trim');
    

    if($this->form_validation->run() == false){
      //jika menekan tombol edit
      $data['title'] = 'Update Subject Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['t_all'] = $this->_t->return_all();
      $data['mapel_all'] = $this->_mapel->return_all_by_sk_id($this->session->userdata('kr_sk_id'));

      //simpan data primary key
      $mk_id = $this->input->get('mk_id', true);

      $data['mk_update'] = $this->_mk->find_by_id($mk_id);

      //var_dump($data['mk_update']);
      //load view dengan data query
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('mk_crud/update',$data);
      $this->load->view('templates/footer');
    }
    else{
      //fetch data hasil inputan
      $data = [
        'mk_nama' => $this->input->post('mk_nama'),
        'mk_t_id' => $this->input->post('mk_t_id'),
        'mk_mapel_id' => $this->input->post('mk_mapel_id')
      ];

      //simpan ke db
      $this->db->where('mk_id', $this->input->post('mk_id'));
      $this->db->update('mk', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Subject Updated!</div>');
      redirect('MK_CRUD');
    }

  }

  public function addStudent(){

    if($this->input->post('siswa_check[]',TRUE)){
      $d_s_id = $this->input->post('siswa_check[]',TRUE);
      $mk_id = $this->input->post('mkId',TRUE);
    
      
      for($i=0;$i<count($d_s_id);$i++){
        $data[] = array(
          'mk_detail_d_s_id' => $d_s_id[$i],
				  'mk_detail_mk_id' => $mk_id
        );
      }
      
			$this->db->insert_batch('mk_detail', $data);
  
      //$this->db->last_query();

      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo '<div class="alert alert-success" role="alert">Successfully Added '. count($d_s_id) .' student(s)</div>';
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function deleteStudent(){

    if($this->input->post('mk_detail_id',TRUE)){
      $mk_detail_id = $this->input->post('mk_detail_id',TRUE);
    
      $this->db->where('mk_detail_id', $mk_detail_id);
      $this->db->delete('mk_detail');
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Successfully delete Student</div>');
      redirect('MK_CRUD');

    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function get_siswaKelas(){
    if($this->input->post('kelas_id',TRUE)){
      $kelas_id = $this->input->post('kelas_id',TRUE);
      $mk_mapel_id = $this->input->post('mk_mapel_id',TRUE);
      //dapatkan t pada kelas
      $t = $this->db->query(
        "SELECT DISTINCT kelas_t_id
        FROM kelas
        LEFT JOIN d_s ON d_s_kelas_id = kelas_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE kelas_id = $kelas_id")->row_array();

      $t_id = $t['kelas_t_id'];
      //var_dump($t['kelas_t_id']);

      $data = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE d_s_kelas_id = $kelas_id AND d_s_id NOT IN (
          SELECT mk_detail_d_s_id FROM mk_detail 
          LEFT JOIN mk ON mk_detail_mk_id = mk_id
          WHERE mk_t_id = $t_id AND mk_mapel_id = $mk_mapel_id
        )")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function edit_student()
  {

    $mk_id = $this->input->post('mk_id', true);
    if (!$mk_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('MK_CRUD');
    }

    $data['title'] = 'Student List';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');
    $mk_id = $this->input->post('mk_id', true);
    //cari tahun ssp
    $mk = $this->db->query(
      "SELECT mk_nama, mk_t_id, mk_mapel_id
      FROM mk
      WHERE mk_id = $mk_id")->row_array();

    $mk_t_id = $mk['mk_t_id'];
    $data['mk_nama'] = $mk['mk_nama'];
    $data['mk_id'] = $mk_id;
    $data['mk_mapel_id'] = $mk['mk_mapel_id'];

    //cari kelas pada tahun ajaran itu
    $data['kelas_all'] = $this->db->query(
      "SELECT kelas_id, kelas_nama
      FROM kelas
      WHERE kelas_t_id = $mk_t_id AND kelas_sk_id = $sk_id ORDER BY kelas_nama")->result_array();
      
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('mk_crud/edit_student',$data);
    $this->load->view('templates/footer');
    
  }

}

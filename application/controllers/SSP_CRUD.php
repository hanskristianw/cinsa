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
    $this->load->model('_siswa');

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

  public function addStudent(){

    if($this->input->post('siswa_check[]',TRUE)){
      $d_s_id = $this->input->post('siswa_check[]',TRUE);
      $ssp_id = $this->input->post('sspId',TRUE);
    
      
      for($i=0;$i<count($d_s_id);$i++){
        $data[] = array(
          'ssp_peserta_d_s_id' => $d_s_id[$i],
				  'ssp_peserta_ssp_id' => $ssp_id
        );
      }
      
			$this->db->insert_batch('ssp_peserta', $data);
  
      //$this->db->last_query();

      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo '<div class="alert alert-success" role="alert">Successfully Added '. count($d_s_id) .' student(s)</div>';
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function deleteSiswaSSP(){
    if($this->input->post('ssp_peserta_id',TRUE)){
      $ssp_peserta_id = $this->input->post('ssp_peserta_id',TRUE);
      $ssp_id = $this->input->post('ssp_id',TRUE);
      $d_s_id = $this->input->post('d_s_id',TRUE);

      //cek apakah siswa sudah punya nilai pada ssp ini
      $data = $this->db->query(
        "SELECT *
        FROM ssp_nilai 
        LEFT JOIN ssp_topik ON ssp_nilai_ssp_topik_id = ssp_topik_id
        LEFT JOIN ssp ON ssp_topik_ssp_id = ssp_id
        WHERE ssp_id = $ssp_id AND ssp_nilai_d_s_id = $d_s_id")->result_array();

      if(!$data){
        $this->db->where('ssp_peserta_id', $ssp_peserta_id);
        $this->db->delete('ssp_peserta');

        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berhasil dihapus!</div>');
        redirect('SSP_CRUD');
      }
      else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Gagal, siswa sudah mempunyai nilai di SSP!</div>');
        redirect('SSP_CRUD');
      }

      //$this->db->last_query();

      // echo $ssp_id."<br>";
      // echo $d_s_id;
      
    }
    else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function get_siswaKelas(){
    if($this->input->post('id',TRUE)){
      $kelas_id = $this->input->post('id',TRUE);
      
      $data = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        WHERE d_s_kelas_id = $kelas_id AND d_s_id NOT IN (
          SELECT ssp_peserta_d_s_id FROM ssp_peserta
        )")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function get_siswaSSP(){
    if($this->input->post('sspId',TRUE)){
      $sspId = $this->input->post('sspId',TRUE);
      
      $data = $this->db->query(
        "SELECT ssp_peserta_id, d_s_id, sis_nama_depan, sis_nama_bel, kelas_nama, ssp_peserta_ssp_id
        FROM ssp_peserta
        LEFT JOIN d_s ON ssp_peserta_d_s_id = d_s_id
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN kelas ON d_s_kelas_id = kelas_id
        WHERE ssp_peserta_ssp_id = $sspId")->result();
  
      //$data = $this->product_model->get_sub_category($category_id)->result();
      echo json_encode($data);
    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Whoopsie doopsie, what are you doing there!</div>');
      redirect('Profile');
    }
  }

  public function edit_student()
  {

    $ssp_id_post = $this->input->post('ssp_id', true);
    if (!$ssp_id_post) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('SSP_CRUD');
    }

    $data['title'] = 'Student List';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');
    $ssp_id = $this->input->post('ssp_id', true);
    //cari tahun ssp
    $ssp = $this->db->query(
      "SELECT ssp_nama, ssp_t_id
      FROM ssp
      WHERE ssp_id = $ssp_id")->row_array();

    $ssp_t_id = $ssp['ssp_t_id'];
    $data['ssp_nama'] = $ssp['ssp_nama'];
    $data['ssp_id'] = $ssp_id;

    //cari kelas pada tahun ajaran itu
    $data['kelas_all'] = $this->db->query(
      "SELECT kelas_id, kelas_nama
      FROM kelas
      WHERE kelas_t_id = $ssp_t_id AND kelas_sk_id = $sk_id")->result_array();
      
    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('ssp_crud/edit_student',$data);
    $this->load->view('templates/footer');
    
  }

}

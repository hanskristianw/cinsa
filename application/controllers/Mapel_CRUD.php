<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mapel_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_mapel');
    $this->load->model('_kr');
    $this->load->model('_t');
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

    $data['title'] = 'Subject List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['mapel_all'] = $this->_mapel->return_all_by_sk_id($this->session->userdata('kr_sk_id'));

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('mapel_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function add(){

		$this->form_validation->set_rules('mapel_nama', 'Subject Name', 'required|trim');
    $this->form_validation->set_rules('mapel_kkm', 'Passing Grade', 'required|trim|greater_than[0]|less_than[101])');

		if($this->form_validation->run() == false){
			$data['title'] = 'Create Subject';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['mapel_all'] = $this->_mapel->return_all();
      $data['tahun_all'] = $this->_t->return_all();
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
        'mapel_t_id' => $this->input->post('mapel_t_id'),
        'mapel_sk_id' => $this->session->userdata('kr_sk_id')
			];

			$this->db->insert('mapel', $data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Lesson Created!</div>');
			redirect('mapel_crud/add');
		}

  }

  public function edit_teacher()
  {

    $mapel_id_post = $this->input->post('mapel_id', true);
    if(!$mapel_id_post){
      $mapel_get = $this->_mapel->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update
      if (!$mapel_get['mapel_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Mapel_CRUD');
      }
    }

    $this->form_validation->set_rules('mapel_id', 'Kelas Nama', 'required|trim');
    $this->form_validation->set_rules('kr_id', 'Kelas Nama', 'required|trim');

    if ($this->form_validation->run() == false) {
      
      $sk_id = $this->session->userdata('kr_sk_id');

      //jika belum ada murid sama sekali
      
      $sis_count = $this->db->where('kr_jabatan_id',7)->from("kr")->count_all_results();

      if ($sis_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please inform HR to add teacher first!</div>');
        redirect('Mapel_CRUD');
      }

      $data['title'] = 'All Teachers';
      $data['mapel_id'] = $mapel_get;

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      //dapatkan nama  karyawan
      $data['kr_all'] = $this->_kr->find_teacher_by_sk($sk_id);

      //var_dump($data['kelas_all']);

      //return siswa yang belum mempunyai kelas pada kelas dengan tahun ajaran

      // $data['sis_all'] = $this->db->query(
      //   "SELECT * FROM sis 
      //   LEFT JOIN agama ON sis_agama_id = agama_id 
      //   LEFT JOIN t ON sis_t_id = t_id 
      //   LEFT JOIN sk ON sis_sk_id = sk_id 
      //   WHERE sis_sk_id = $sk_id
      //   AND sis_id NOT IN (SELECT d_s_sis_id FROM d_s 
      //                       LEFT JOIN sis ON d_s_sis_id = sis_id
      //                       LEFT JOIN kelas ON d_s_kelas_id = kelas_id
      //                       WHERE sis_sk_id = $sk_id AND kelas_t_id = ".$data['kelas_all']['kelas_t_id'].")
      //   ORDER BY sis_t_id DESC, sis_nama_depan ASC")->result_array(); 


      //var_dump($this->db->last_query());

      //$data['d_mpl_all'] = $this->_d_mpl->return_teacher_by_mapel_id($this->input->get('_id', true));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('mapel_crud/edit_teacher', $data);
      $this->load->view('templates/footer');
    } 
    else {
      
      $sis = $this->_siswa->find_by_id($this->input->post('sis_id'));

      //var_dump($sis);
      $data = [
        'd_s_sis_id' => $this->input->post('sis_id'),
        'd_s_kelas_id' => $this->input->post('kelas_id')
      ];

      $this->db->insert('d_s', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully add '.$sis['sis_nama_depan'].'!</div>');
      redirect('kelas_crud/edit_student?_id='.$this->input->post('kelas_id'));
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
    $this->form_validation->set_rules('mapel_kkm', 'Passing Grade', 'required|trim|greater_than[0]|less_than[101])');

    if($this->form_validation->run() == false){
      //jika menekan tombol edit
      $data['title'] = 'Update Subject Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();
      
      $data['tahun_all'] = $this->_t->return_all();

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
        'mapel_t_id' => $this->input->post('mapel_t_id'),
        'mapel_kkm' => $this->input->post('mapel_kkm')
      ];

      //simpan ke db
      $this->db->where('mapel_id', $this->input->post('_id'));
      $this->db->update('mapel', $data); 
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Lesson Data Updated!</div>');
      redirect('Mapel_CRUD');
    }

  } 

}

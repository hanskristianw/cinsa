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

  public function edit_student()
  {

    $ssp_id_post = $this->input->post('ssp_id', true);
    if (!$ssp_id_post) {
      $ssp_get = $this->_ssp->find_by_id($this->input->get('ssp_id', true));
      if (!$ssp_get['ssp_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
        redirect('SSP_CRUD');
      }
    }

    $sk_id = $this->session->userdata('kr_sk_id');
    $ssp_id = $this->input->post('ssp_id', true);
    //jika belum ada murid sama sekali
    $sis_count = $this->db->where('sis_sk_id', $sk_id)->from("sis")->count_all_results();

    if ($sis_count == 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please inform school administrative to add student first!</div>');
      redirect('Profile');
    }

    $this->form_validation->set_rules('ssp_id', 'ssp id', 'required|trim');
    $this->form_validation->set_rules('sis_id', 'sis_id', 'required|trim');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'All Students';
    
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['ssp_nama'] = $this->_ssp->find_by_id($this->input->get('ssp_id', true));
      
      // $data['sis_all'] = $this->db->query(
      //   "SELECT * FROM sis
      //   LEFT JOIN agama ON sis_agama_id = agama_id
      //   LEFT JOIN t ON sis_t_id = t_id
      //   LEFT JOIN sk ON sis_sk_id = sk_id
      //   WHERE sis_sk_id = $sk_id
      //   AND sis_alumni = 0
      //   AND sis_id NOT IN (SELECT d_s_sis_id FROM d_s
      //                       LEFT JOIN sis ON d_s_sis_id = sis_id
      //                       LEFT JOIN kelas ON d_s_kelas_id = kelas_id
      //                       WHERE sis_sk_id = $sk_id AND kelas_t_id = " . $data['kelas_all']['kelas_t_id'] . ")
      //   ORDER BY sis_t_id DESC, sis_nama_depan ASC"
      // )->result_array();

      $data['sis_all'] = $this->db->query(
        "SELECT * FROM sis
        LEFT JOIN agama ON sis_agama_id = agama_id
        LEFT JOIN t ON sis_t_id = t_id
        LEFT JOIN sk ON sis_sk_id = sk_id
        WHERE sis_sk_id = $sk_id
        AND sis_alumni = 0
        AND sis_id NOT IN (SELECT ssp_peserta_sis_id FROM ssp_peserta
                            LEFT JOIN sis ON ssp_peserta_sis_id = sis_id
                            LEFT JOIN ssp ON ssp_peserta_ssp_id = ssp_id
                            WHERE sis_sk_id = $sk_id AND sis_t_id = " . $data['ssp_nama']['ssp_t_id'] . ")
        ORDER BY sis_t_id DESC, sis_nama_depan ASC"
      )->result_array();

      $data['ssp_peserta'] = $this->db->query(
        "SELECT * FROM ssp_peserta
        LEFT JOIN sis ON ssp_peserta_sis_id = sis_id
        LEFT JOIN t ON sis_t_id = t_id
        WHERE ssp_peserta_ssp_id = " . $data['ssp_nama']['ssp_id'] . "
        AND sis_alumni = 0
        ORDER BY sis_t_id DESC, sis_nama_depan ASC"
      )->result_array();


      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('ssp_crud/edit_student', $data);
      $this->load->view('templates/footer');
    }else{
      $sis = $this->_siswa->find_by_id($this->input->post('sis_id'));

      //var_dump($sis);
      $data = [
        'ssp_peserta_sis_id' => $this->input->post('sis_id'),
        'ssp_peserta_ssp_id' => $this->input->post('ssp_id')
      ];

      $this->db->insert('ssp_peserta', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully add ' . $sis['sis_nama_depan'] . '!</div>');
      redirect('ssp_crud/edit_student?ssp_id=' . $this->input->post('ssp_id'));
    }
    
    
  }

}

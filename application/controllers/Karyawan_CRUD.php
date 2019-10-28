<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_sk');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=3 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'Employee List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['kr_all'] = $this->_kr->return_all_except_admin();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('karyawan_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function add(){

    $this->form_validation->set_rules('kr_nama_depan', 'First Name', 'required|trim');
		$this->form_validation->set_rules('kr_nama_belakang', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('kr_username', 'Username', 'required|trim|is_unique[kr.kr_username]',['is_unique' => 'This username already exist!']);
		$this->form_validation->set_rules('kr_password1', 'Password', 'required|trim|min_length[3]|matches[kr_password2]',['matches' => 'Password not match', 'min_length' => 'Password too short']);
		$this->form_validation->set_rules('kr_password2', 'Password', 'required|trim|matches[kr_password1]');

		if($this->form_validation->run() == false){
      
      $sk_count = $this->db->count_all('sk');

      if($sk_count == 0){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Please inform ADMIN to add school first!</div>');
        redirect('Karyawan_CRUD');
      }

      $data['title'] = 'Create Employee';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();
      $data['st_all'] = $this->_st->return_all();
      $data['sk_all'] = $this->_sk->return_all();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('karyawan_crud/add',$data);
      $this->load->view('templates/footer');
		}
		else{
			$data = [
				'kr_nama_depan' => htmlspecialchars($this->input->post('kr_nama_depan', true)),
				'kr_nama_belakang' => htmlspecialchars($this->input->post('kr_nama_belakang', true)),
				'kr_username' => $this->input->post('kr_username'),
				'kr_password' => password_hash($this->input->post('kr_password1'), PASSWORD_DEFAULT),
				'kr_jabatan_id' => $this->input->post('kr_jabatan'),
				'kr_st_id' => $this->input->post('st'),
				'kr_sk_id' => $this->input->post('sk'),
        'kr_gelar_depan' => htmlspecialchars($this->input->post('kr_gelar_depan', true)),
        'kr_gelar_belakang' => htmlspecialchars($this->input->post('kr_gelar_belakang', true)),
        'kr_alamat_ktp' => htmlspecialchars($this->input->post('kr_alamat_ktp', true)),
        'kr_alamat_tinggal' => htmlspecialchars($this->input->post('kr_alamat_tinggal', true)),
        'kr_ktp' => htmlspecialchars($this->input->post('kr_ktp', true)),
        'kr_npwp' => htmlspecialchars($this->input->post('kr_npwp', true)),
        'kr_bca' => htmlspecialchars($this->input->post('kr_bca', true)),
        'kr_date_created' => time(),
        'kr_nikah_tanggal' => htmlspecialchars($this->input->post('kr_nikah_tanggal', true)),
        'kr_nama_pasangan' => htmlspecialchars($this->input->post('kr_nama_pasangan', true)),
        'kr_anak1' => htmlspecialchars($this->input->post('kr_anak1', true)),
        'kr_anak2' => htmlspecialchars($this->input->post('kr_anak2', true)),
        'kr_anak3' => htmlspecialchars($this->input->post('kr_anak3', true)),
        'kr_anak4' => htmlspecialchars($this->input->post('kr_anak4', true)),
        'kr_marital' => htmlspecialchars($this->input->post('kr_marital', true)),
        'kr_mulai_tgl' => htmlspecialchars($this->input->post('kr_mulai_tgl', true)),
        'kr_pendidikan_skrng' => htmlspecialchars($this->input->post('kr_pendidikan_skrng', true))
			];

			$this->db->insert('kr', $data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Employee Created!</div>');
			redirect('karyawan_crud/add');
		}

  }

  public function update(){
    
    //dari method post
    $kr_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if(!$kr_post){
      //ambil id dari method get
      $kr_get = $this->_kr->find_jabatan_by_kr_id($this->input->get('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if($kr_get['kr_jabatan_id'] == 1 || !$kr_get['kr_jabatan_id']){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Karyawan_CRUD');
      }

      if($kr_get['kr_id'] == $this->session->userdata('kr_id')){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Cannot edit yourself, please use edit profile instead!</div>');
        redirect('Karyawan_CRUD');
      }
    }
    
    $this->form_validation->set_rules('kr_nama_depan', 'First Name', 'required|trim');
    $this->form_validation->set_rules('kr_nama_belakang', 'Last Name', 'required|trim');
    $this->form_validation->set_rules('kr_password1', 'Password', 'required|trim|min_length[3]|matches[kr_password2]',['matches' => 'Password not match', 'min_length' => 'Password too short']);
    $this->form_validation->set_rules('kr_password2', 'Password', 'required|trim|matches[kr_password1]');

    if($this->form_validation->run() == false){
      //jika menekan tombol edit
      $data['title'] = 'Update Employee';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();
      $data['st_all'] = $this->_st->return_all();
      $data['sk_all'] = $this->_sk->return_all();

      //simpan data primary key
      $kr_id = $this->input->get('_id', true);
      
      $data['kr_update'] = $this->_kr->find_by_id($kr_id);
      
      //load view dengan data query
      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('karyawan_crud/update',$data);
      $this->load->view('templates/footer');
    }
    else{
      //fetch data hasil inputan
      $data = [
        'kr_nama_depan' => htmlspecialchars($this->input->post('kr_nama_depan', true)),
        'kr_nama_belakang' => htmlspecialchars($this->input->post('kr_nama_belakang', true)),
        'kr_password' => password_hash($this->input->post('kr_password1'), PASSWORD_DEFAULT),
        'kr_jabatan_id' => $this->input->post('kr_jabatan_id'),
        'kr_sk_id' => $this->input->post('kr_sk_id'),
        'kr_gelar_depan' => htmlspecialchars($this->input->post('kr_gelar_depan', true)),
        'kr_gelar_belakang' => htmlspecialchars($this->input->post('kr_gelar_belakang', true)),
        'kr_alamat_ktp' => htmlspecialchars($this->input->post('kr_alamat_ktp', true)),
        'kr_alamat_tinggal' => htmlspecialchars($this->input->post('kr_alamat_tinggal', true)),
        'kr_ktp' => htmlspecialchars($this->input->post('kr_ktp', true)),
        'kr_npwp' => htmlspecialchars($this->input->post('kr_npwp', true)),
        'kr_bca' => htmlspecialchars($this->input->post('kr_bca', true)),
        'kr_st_id' => $this->input->post('st'),
        'kr_nikah_tanggal' => htmlspecialchars($this->input->post('kr_nikah_tanggal', true)),
        'kr_nama_pasangan' => htmlspecialchars($this->input->post('kr_nama_pasangan', true)),
        'kr_anak1' => htmlspecialchars($this->input->post('kr_anak1', true)),
        'kr_anak2' => htmlspecialchars($this->input->post('kr_anak2', true)),
        'kr_anak3' => htmlspecialchars($this->input->post('kr_anak3', true)),
        'kr_anak4' => htmlspecialchars($this->input->post('kr_anak4', true)),
        'kr_marital' => htmlspecialchars($this->input->post('kr_marital', true)),
        'kr_mulai_tgl' => htmlspecialchars($this->input->post('kr_mulai_tgl', true)),
        'kr_pendidikan_skrng' => htmlspecialchars($this->input->post('kr_pendidikan_skrng', true))
      ];

      $this->db->where('kr_id', $this->input->post('_id'));
      $this->db->update('kr', $data); 
      
      //simpan ke db
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Employee Updated!</div>');
      redirect('karyawan_crud');
    }

  }

  public function delete(){
    $kr_id = $this->input->post('kr_id', true);

    //jika bukan dari form update sendiri
    if($kr_id){
      $this->db->where('kr_id', $kr_id);
      $this->db->delete('kr');
      $err = $this->db->error();

      $msg_type = "success";
      $msg = "Employee Deleted";
      
      if($err['code']=="1451"){
        $msg_type = "danger";
        $msg = "Cannot Delete Employee if employee have score, is counselor, is homeroom teacher, is ssp teacher or principal";
      }
      //var_dump($err);
      $this->session->set_flashdata('message','<div class="alert alert-'.$msg_type.'" role="alert">'.$msg.'</div>');
      redirect('karyawan_crud');

    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('karyawan_crud');
    }
  }

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');

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
    $data['kr_all'] = $this->_kr->return_all();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('karyawan_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function check_default($post_string)
  {
    return $post_string == '0' ? FALSE : TRUE;
  }

  public function add(){

    $this->form_validation->set_rules('kr_nama_depan', 'First Name', 'required|trim');
		$this->form_validation->set_rules('kr_nama_belakang', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('kr_username', 'Username', 'required|trim|is_unique[kr.kr_username]',['is_unique' => 'This username already exist!']);
		$this->form_validation->set_rules('kr_password1', 'Password', 'required|trim|min_length[3]|matches[kr_password2]',['matches' => 'Password not match', 'min_length' => 'Password too short']);
		$this->form_validation->set_rules('kr_password2', 'Password', 'required|trim|matches[kr_password1]');
    $this->form_validation->set_rules('kr_jabatan','Employee Role','required|callback_check_default');
    $this->form_validation->set_message('check_default', 'You need to select something other than the default');
    $this->form_validation->set_rules('kr_status','Employee Status','required|callback_check_default');
    $this->form_validation->set_message('check_default', 'You need to select something other than the default');

		if($this->form_validation->run() == false){
			$data['ftype'] = '1';
      $data['title'] = 'Create Employee';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();

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
				'kr_status' => $this->input->post('kr_status'),
				'kr_date_created' => time()
			];

			$this->db->insert('kr', $data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Employee Created!</div>');
			redirect('karyawan_crud/add');
		}

  }

  public function update(){
    
      if($this->input->post('_id', TRUE)){
        
        if($this->input->post('is_update')){

            $this->form_validation->set_rules('kr_nama_depan', 'First Name', 'required|trim');
            $this->form_validation->set_rules('kr_nama_belakang', 'Last Name', 'required|trim');
            $this->form_validation->set_rules('kr_username', 'Username', 'required|trim|is_unique[kr.kr_username]',['is_unique' => 'This username already exist!']);
            $this->form_validation->set_rules('kr_password1', 'Password', 'required|trim|min_length[3]|matches[kr_password2]',['matches' => 'Password not match', 'min_length' => 'Password too short']);
            $this->form_validation->set_rules('kr_password2', 'Password', 'required|trim|matches[kr_password1]');
            $this->form_validation->set_rules('kr_jabatan','Employee Role','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select something other than the default');
            $this->form_validation->set_rules('kr_status','Employee Status','required|callback_check_default');
            $this->form_validation->set_message('check_default', 'You need to select something other than the default');
        }
        if($this->form_validation->run() == null || $this->form_validation->run() == false){
          //jika menekan tombol edit
          $data['ftype'] = '2';
          $data['title'] = 'Update Employee';
    
          //data karyawan yang sedang login untuk topbar
          $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
          $data['jabatan_all'] = $this->_jabatan->return_all();
    
          //simpan data primary key
          $kr_id = $this->input->post('_id');

          //query
          $data['kr_update'] = $this->_kr->find_by_id($kr_id);

          //load view dengan data query
          $this->load->view('templates/header',$data);
          $this->load->view('templates/sidebar',$data);
          $this->load->view('templates/topbar',$data);
          $this->load->view('karyawan_crud/add',$data);
          $this->load->view('templates/footer');
        }
        else{
          //fetch data hasil inputan
          $data = [
            'kr_nama_depan' => htmlspecialchars($this->input->post('kr_nama_depan', true)),
            'kr_nama_belakang' => htmlspecialchars($this->input->post('kr_nama_belakang', true)),
            'kr_username' => $this->input->post('kr_username'),
            'kr_password' => password_hash($this->input->post('kr_password1'), PASSWORD_DEFAULT),
            'kr_jabatan_id' => $this->input->post('kr_jabatan'),
            'kr_status' => $this->input->post('kr_status'),
            'kr_date_created' => time()
          ];
    
          //simpan ke db
          // $this->db->insert('kr', $data);
          // $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Employee Created!</div>');
          // redirect('karyawan_crud/add');
        }
      }
      else{
        //jika mengakses url langsung tanpa menekan tombol
        redirect('karyawan_crud');
      }

    
		

  }

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
	}

	public function index()
	{
		$this->form_validation->set_rules('kr_username', 'Username', 'required|trim');
		$this->form_validation->set_rules('kr_password', 'Password', 'required|trim');
		if($this->form_validation->run() == false){
			$data['title'] = 'LOGIN PAGE';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/login');
			$this->load->view('templates/auth_footer');
		}
		else{
			$this->_login();
		}
	}

	private function _login(){
		$kr_username = $this->input->post('kr_username');
		$kr_password = $this->input->post('kr_password');

		$user = $this->db->get_where('kr', ['kr_username' => $kr_username])-> row_array();

		if($user){
			if(password_verify($kr_password, $user['kr_password'])){
				$data = [
					'kr_username' => $user['kr_username'],
					'kr_jabatan_id' => $user['kr_jabatan_id']
				];
				$this->session->set_userdata($data);
				if($user['kr_jabatan_id'] == 1){
					redirect('Admin');
				}else{
					redirect('Karyawan');
				}
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Wrong password</div>');
				redirect('auth');
			}
		}else{
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">User not exist</div>');
			redirect('auth');
		}
	}

	public function registration()
	{
		$this->form_validation->set_rules('kr_nama_depan', 'First Name', 'required|trim');
		$this->form_validation->set_rules('kr_nama_belakang', 'Last Name', 'required|trim');
		$this->form_validation->set_rules('kr_username', 'Username', 'required|trim|is_unique[kr.kr_username]',['is_unique' => 'This username already exist!']);
		$this->form_validation->set_rules('kr_password1', 'Password', 'required|trim|min_length[3]|matches[kr_password2]',['matches' => 'Password not match', 'min_length' => 'Password too short']);
		$this->form_validation->set_rules('kr_password2', 'Password', 'required|trim|matches[kr_password1]');

		if($this->form_validation->run() == false){
			$data['title'] = 'EMPLOYEE REGISTRATION';
			$this->load->view('templates/auth_header', $data);
			$this->load->view('auth/registration');
			$this->load->view('templates/auth_footer');
		}
		else{
			$data = [
				'kr_nama_depan' => htmlspecialchars($this->input->post('kr_nama_depan', true)),
				'kr_nama_belakang' => htmlspecialchars($this->input->post('kr_nama_belakang', true)),
				'kr_username' => $this->input->post('kr_username'),
				'kr_password' => password_hash($this->input->post('kr_password1'), PASSWORD_DEFAULT),
				'kr_jabatan_id' => 2,
				'kr_date_created' => time()
			];

			$this->db->insert('kr', $data);
			$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">User Created!</div>');
			redirect('Auth');
		}
	}

	public function logout(){
		$this->session->unset_userdata('kr_username');
		$this->session->unset_userdata('kr_jabatan_id');
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Logout Success!</div>');
		redirect('Auth');
	}
}

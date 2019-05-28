<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		if($this->session->userdata('kr_jabatan_id')){
			redirect('Profile');
    }

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
					'kr_id' => $user['kr_id'],
					'kr_jabatan_id' => $user['kr_jabatan_id'],
					'kr_sk_id' => $user['kr_sk_id']
				];
				$this->session->set_userdata($data);
				redirect('Profile');
			}else{
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Wrong password</div>');
				redirect('auth');
			}
		}else{
			$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">User not exist</div>');
			redirect('auth');
		}
	}

	public function logout(){
		$this->session->unset_userdata('kr_username');
		$this->session->unset_userdata('kr_jabatan_id');
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Logout Success!</div>');
		redirect('Auth');
	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{

		//echo $this->get_theme();

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

		$kr_username = htmlspecialchars($this->input->post('kr_username',true));
		$kr_password = htmlspecialchars($this->input->post('kr_password',true));

		$user = $this->db->get_where('kr', ['kr_username' => $kr_username])-> row_array();

		if($user){
			if(password_verify($kr_password, $user['kr_password'])){

				$kr_id_cek = $user['kr_id'];

				$cek = $this->db->query(
	        "SELECT kr_resign
	        FROM kr
	        WHERE kr_id = $kr_id_cek"
	      )->row_array();

				if($cek['kr_resign'] == 1){
					$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Gagal, Login anda tidak aktif, hubungi HRD / Div Pendidikan</div>');
					redirect('auth');
				}

				$ip = return_ip_login();
				$data2 = [
					'kr_last_login' => date('Y/m/d H:i:s'),
					'kr_last_login_ip' => $ip
				];

				$this->db->where('kr_id', $user['kr_id']);
      	$this->db->update('kr', $data2);


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

		if(!$this->session->userdata('kr_id')){
			redirect('Auth');
		}

		$this->session->unset_userdata('token');

		$this->session->unset_userdata('kr_username');
		$this->session->unset_userdata('kr_jabatan_id');
		$this->session->unset_userdata('kr_sk_id');
		$this->session->unset_userdata('kr_id');
		$this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Logout Success!</div>');
		redirect('Auth');
	}

	public function auth_google(){

		if($this->session->userdata('kr_id')){
			redirect('Profile');
		}

		//ambil google client dari class global
		$gc = $this->get_client();

		//ambil code dari method get
		$code = $this->input->get('code',true);

		//jika dapat code
		if($code){
			//set access token
			$token = $gc->fetchAccessTokenWithAuthCode($this->input->get('code',true));
			$oAuth = new Google_Service_Oauth2($gc);
			$userData = $oAuth->userinfo_v2_me->get();

			//ambil google account dari user data
			$email_google = $userData["email"];

			//cek apakah ada email terdaftar dan karyawan belum resign
			$cek = $this->db->query(
	      "SELECT *
	      FROM kr
	      WHERE kr_email = '$email_google' AND kr_resign = 0"
	    )->row_array();

			if($cek){
				//jika ada dan belum resign, mulai proses login
				$ip = return_ip_login();
				$data2 = [
					'kr_last_login' => date('Y/m/d H:i:s'),
					'kr_last_login_ip' => $ip
				];
				$this->db->where('kr_id', $cek['kr_id']);
      	$this->db->update('kr', $data2);

				$data = [
					'kr_username' => $cek['kr_username'],
					'kr_id' => $cek['kr_id'],
					'kr_jabatan_id' => $cek['kr_jabatan_id'],
					'kr_sk_id' => $cek['kr_sk_id'],
					'token' => $token
				];

				$this->session->set_userdata($data);
				redirect('Profile');

			}else{
				//jika tidak ada email terdaftar atau sudah resign, hapus token dan kembalikan user ke auth
				$gc->revokeToken($token);
				$this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Email google anda belum terdaftar atau user anda tidak aktif, masuk ke account anda, lalu lengkapi profile google account!</div>');
				redirect('Auth');
			}

		}else{
			//jika belum ada code minta permission dulu ke user
		  $gc->addScope("https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/classroom.courses.readonly https://www.googleapis.com/auth/classroom.coursework.students.readonly https://www.googleapis.com/auth/classroom.rosters.readonly");
			$loginurl = $gc->createAuthUrl();

			redirect($loginurl);
		}

	}

}

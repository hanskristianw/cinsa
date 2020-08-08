<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');

    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('auth');
    }
  }

  public function index()
  {

    // $accessToken = $this->session->userdata('token');
    //
    // $client = $this->get_client();
    // $client->setAccessToken($accessToken);
    // //$oAuth = new Google_Service_Oauth2($client);
    // $service = new Google_Service_Classroom($client);
    //
    // $optParams = array(
    //   'pageSize' => 10
    // );
    // $results = $service->courses->listCourses($optParams);
    //
    // if (count($results->getCourses()) == 0) {
    //   echo "No courses found.";
    // } else {
    //   echo "Courses:<br>";
    //   foreach ($results->getCourses() as $course) {
    //     echo("<br>".$course->getName().$course->getId());
    //   }
    // }

    //var_dump($service);

    $data['title'] = 'Profil Karyawan';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['jabatan'] = $this->_kr->find_jabatan_by_kr_id($this->session->userdata('kr_id'));

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('profile/index', $data);
    $this->load->view('templates/footer');
  }

  public function update()
  {

    if ($this->input->post('_kr_username') == $this->input->post('kr_username')) {
      $this->form_validation->set_rules('kr_username', 'Username', 'required|trim');
    } else {
      $this->form_validation->set_rules('kr_username', 'Username', 'required|trim|is_unique[kr.kr_username]', ['is_unique' => 'This Username already exist!']);
    }
    $this->form_validation->set_rules('kr_nama_depan', 'First Name', 'required|trim');
    $this->form_validation->set_rules('kr_nama_belakang', 'Last Name', 'trim');
    $this->form_validation->set_rules('kr_password1', 'Password', 'required|trim|min_length[3]|matches[kr_password2]', ['matches' => 'Password not match', 'min_length' => 'Password too short']);
    $this->form_validation->set_rules('kr_password2', 'Password', 'required|trim|matches[kr_password1]');

    if ($this->form_validation->run() == false) {
      //set judul
      $data['title'] = 'Update Profile';

      //ambil data karyawan yang sedang login
      $data['kr'] = $this->_kr->find_by_id($this->session->userdata('kr_id'));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('profile/update', $data);
      $this->load->view('templates/footer');
    } else {
      $data = [
        'kr_nama_depan' => htmlspecialchars($this->input->post('kr_nama_depan', true)),
        'kr_username' => htmlspecialchars($this->input->post('kr_username', true)),
        'kr_nama_belakang' => htmlspecialchars($this->input->post('kr_nama_belakang', true)),
        'kr_password' => password_hash($this->input->post('kr_password1'), PASSWORD_DEFAULT),
        'kr_gelar_depan' => htmlspecialchars($this->input->post('kr_gelar_depan', true)),
        'kr_gelar_belakang' => htmlspecialchars($this->input->post('kr_gelar_belakang', true)),
        'kr_alamat_ktp' => htmlspecialchars($this->input->post('kr_alamat_ktp', true)),
        'kr_alamat_tinggal' => htmlspecialchars($this->input->post('kr_alamat_tinggal', true)),
        'kr_ktp' => htmlspecialchars($this->input->post('kr_ktp', true)),
        'kr_npwp' => htmlspecialchars($this->input->post('kr_npwp', true))

      ];

      //cek image
      $upload_image = $_FILES['image']['name'];

      if ($upload_image) {
        $config['allowed_types'] = 'gif|png|jpg';
        $config['max_size']     = '2048';
        $config['upload_path'] = './assets/img/profile/';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image')) {
          $old_image = $this->input->post('kr_pp');

          if ($old_image != 'default.jpg') {
            unlink(FCPATH . 'assets/img/profile/' . $old_image);
          }
          $new_image = $this->upload->data('file_name');
          $this->db->set('kr_pp', $new_image);
        } else {
          echo  $this->upload->display_errors();
        }
      }

      $this->db->where('kr_id', $this->session->userdata('kr_id'));
      $this->db->update('kr', $data);

      $this->session->unset_userdata('kr_username');
      $this->session->unset_userdata('kr_id');
      $this->session->unset_userdata('kr_jabatan_id');
      $this->session->unset_userdata('kr_sk_id');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Profile Updated, please re-login</div>');
      redirect('Auth');
    }
  }

  public function ttd()
  {
    $data['title'] = 'Upload Tanda Tangan Digital';

    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['kr_id'] = $this->session->userdata('kr_id');

    $kr_id = $this->session->userdata('kr_id');

    $data['kr_ttd'] = $this->db->query(
      "SELECT kr_ttd
      FROM kr
      WHERE kr_id = $kr_id"
    )->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('profile/ttd', $data);
    $this->load->view('templates/footer');
  }

  public function save_ttd()
  {
    $config['upload_path'] = './assets/img/ttd/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size'] = 10000;
    $config['max_width'] = 3000;
    $config['max_height'] = 3000;
    $config['file_name'] = date('ymd') . '-' . substr(md5(rand()), 0, 10);
    $old_image = $this->input->post('kr_ttd');
    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('image')) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
      redirect('Profile/ttd');
    } else {

      if ($old_image != 'default_ttd.png') {
        unlink(FCPATH . '/assets/img/ttd/' . $old_image);
      }

      $data = [
        'kr_ttd' => $this->upload->data('file_name')
      ];

      $kr_id = $this->session->userdata('kr_id');

      $this->db->where('kr_id', $kr_id);
      $this->db->update('kr', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Success!</div>');
      redirect('Profile/ttd');
    }
  }

  public function email_google(){

    $data['title'] = 'Google account';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['kr_id'] = $this->session->userdata('kr_id');

    $kr_id = $this->session->userdata('kr_id');

    $data['kr_email'] = $this->db->query(
      "SELECT kr_email
      FROM kr
      WHERE kr_id = $kr_id"
    )->row_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('profile/email_google', $data);
    $this->load->view('templates/footer');
  }

  public function save_email_google(){
    if ($this->input->post('kr_email')) {
      $kr_email = $this->input->post('kr_email');
      $kr_id = $this->session->userdata('kr_id');

      $cek_lama = $this->db->query(
        "SELECT kr_email
        FROM kr
        WHERE kr_email = '$kr_email' AND kr_id = $kr_id"
      )->row_array();

      if($cek_lama['kr_email'] == $kr_email){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Google account baru dan lama tidak boleh sama!</div>');
        redirect('Profile/email_google');
      }

      $cek = $this->db->query(
        "SELECT kr_email
        FROM kr
        WHERE kr_email = '$kr_email'"
      )->row_array();

      if($cek){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Google account sudah terdaftar pada account lain!</div>');
        redirect('Profile/email_google');
      }else{
        $data = [
          'kr_email' => $kr_email
        ];

        $this->db->where('kr_id', $kr_id);
        $this->db->update('kr', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil merubah google account!</div>');
        redirect('Profile/email_google');
      }
    }
  }
}

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
    $this->load->model('_agama');

    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 3 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Daftar Karyawan';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['kr_all'] = $this->db->query(
      "SELECT kr_id,kr_nama_depan,kr_nama_belakang,kr_username,jabatan_nama,sk_nama,kr_resign,
      GROUP_CONCAT(st_nama ORDER BY kr_h_status_tanggal DESC) as st_nama
      FROM kr
      LEFT JOIN jabatan ON kr_jabatan_id = jabatan_id
      LEFT JOIN sk ON kr_sk_id = sk_id
      LEFT JOIN kr_h_status ON kr_h_status_kr_id = kr_id
      LEFT JOIN st ON kr_h_status_status_id = st_id
      GROUP BY kr_id
      ORDER BY kr_nama_depan")->result_array();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('karyawan_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function add()
  {

    $this->form_validation->set_rules('kr_nama_depan', 'First Name', 'required|trim');
    $this->form_validation->set_rules('kr_nama_belakang', 'Last Name', 'trim');
    $this->form_validation->set_rules('kr_username', 'Username', 'required|trim|is_unique[kr.kr_username]', ['is_unique' => 'This username already exist!']);
    $this->form_validation->set_rules('kr_password1', 'Password', 'required|trim|min_length[3]|matches[kr_password2]', ['matches' => 'Password not match', 'min_length' => 'Password too short']);
    $this->form_validation->set_rules('kr_password2', 'Password', 'required|trim|matches[kr_password1]');

    if ($this->form_validation->run() == false) {

      $sk_count = $this->db->count_all('sk');

      if ($sk_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please inform ADMIN to add school first!</div>');
        redirect('Karyawan_CRUD');
      }

      $data['title'] = 'Create Employee';

      $data['agama_all'] = $this->_agama->return_all();
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();
      $data['st_all'] = $this->_st->return_all();
      $data['sk_all'] = $this->_sk->return_all_list();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('karyawan_crud/add', $data);
      $this->load->view('templates/footer');
    } else {
      $data = [
        'kr_nama_depan' => htmlspecialchars($this->input->post('kr_nama_depan', true)),
        'kr_nama_belakang' => htmlspecialchars($this->input->post('kr_nama_belakang', true)),
        'kr_username' => $this->input->post('kr_username'),
        'kr_password' => password_hash($this->input->post('kr_password1'), PASSWORD_DEFAULT),
        'kr_jabatan_id' => $this->input->post('kr_jabatan'),
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
        'kr_anak1_tanggal' => htmlspecialchars($this->input->post('kr_anak1_tanggal', true)),
        'kr_anak2_tanggal' => htmlspecialchars($this->input->post('kr_anak2_tanggal', true)),
        'kr_anak3_tanggal' => htmlspecialchars($this->input->post('kr_anak3_tanggal', true)),
        'kr_anak4_tanggal' => htmlspecialchars($this->input->post('kr_anak4_tanggal', true)),
        'kr_marital' => htmlspecialchars($this->input->post('kr_marital', true)),
        'kr_mulai_tgl' => htmlspecialchars($this->input->post('kr_mulai_tgl', true)),
        'kr_pendidikan_skrng' => htmlspecialchars($this->input->post('kr_pendidikan_skrng', true)),
        'kr_agama_id' => htmlspecialchars($this->input->post('kr_agama_id', true)),
        'kr_hp' => htmlspecialchars($this->input->post('kr_hp', true)),
        'kr_rumah' => htmlspecialchars($this->input->post('kr_rumah', true)),
        'kr_pendidikan_univ' => htmlspecialchars($this->input->post('kr_pendidikan_univ', true))
      ];

      $this->db->insert('kr', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Employee Created!</div>');
      redirect('karyawan_crud/add');
    }
  }

  public function update()
  {

    //dari method post
    $kr_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if (!$kr_post) {
      //ambil id dari method get
      $kr_get = $this->_kr->find_jabatan_by_kr_id($this->input->get('_id', true));

      //jika langsung akses halaman update atau jabatan yang akan diedit admin
      if ($kr_get['kr_jabatan_id'] == 1 || !$kr_get['kr_jabatan_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Karyawan_CRUD');
      }

      if ($kr_get['kr_id'] == $this->session->userdata('kr_id')) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Cannot edit yourself, please use edit profile instead!</div>');
        redirect('Karyawan_CRUD');
      }
    }

    $this->form_validation->set_rules('kr_nama_depan', 'First Name', 'required|trim');
    $this->form_validation->set_rules('kr_nama_belakang', 'Last Name', 'trim');

    if ($this->form_validation->run() == false) {
      //jika menekan tombol edit
      $data['title'] = 'Update Data Karyawan';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jabatan_all'] = $this->_jabatan->return_all();
      $data['st_all'] = $this->_st->return_all();
      $data['sk_all'] = $this->_sk->return_all_list();
      $data['agama_all'] = $this->_agama->return_all();

      //simpan data primary key
      $kr_id = $this->input->get('_id', true);

      $data['kr_update'] = $this->_kr->find_by_id($kr_id);

      //load view dengan data query
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('karyawan_crud/update', $data);
      $this->load->view('templates/footer');
    } else {
      //fetch data hasil inputan
      $data = [
        'kr_nama_depan' => htmlspecialchars($this->input->post('kr_nama_depan', true)),
        'kr_nama_belakang' => htmlspecialchars($this->input->post('kr_nama_belakang', true)),
        'kr_jabatan_id' => $this->input->post('kr_jabatan_id'),
        'kr_sk_id' => $this->input->post('kr_sk_id'),
        'kr_gelar_depan' => htmlspecialchars($this->input->post('kr_gelar_depan', true)),
        'kr_gelar_belakang' => htmlspecialchars($this->input->post('kr_gelar_belakang', true)),
        'kr_alamat_ktp' => htmlspecialchars($this->input->post('kr_alamat_ktp', true)),
        'kr_alamat_tinggal' => htmlspecialchars($this->input->post('kr_alamat_tinggal', true)),
        'kr_ktp' => htmlspecialchars($this->input->post('kr_ktp', true)),
        'kr_npwp' => htmlspecialchars($this->input->post('kr_npwp', true)),
        'kr_bca' => htmlspecialchars($this->input->post('kr_bca', true)),
        'kr_nikah_tanggal' => htmlspecialchars($this->input->post('kr_nikah_tanggal', true)),
        'kr_nama_pasangan' => htmlspecialchars($this->input->post('kr_nama_pasangan', true)),
        'kr_anak1' => htmlspecialchars($this->input->post('kr_anak1', true)),
        'kr_anak2' => htmlspecialchars($this->input->post('kr_anak2', true)),
        'kr_anak3' => htmlspecialchars($this->input->post('kr_anak3', true)),
        'kr_anak4' => htmlspecialchars($this->input->post('kr_anak4', true)),
        'kr_anak1_tanggal' => htmlspecialchars($this->input->post('kr_anak1_tanggal', true)),
        'kr_anak2_tanggal' => htmlspecialchars($this->input->post('kr_anak2_tanggal', true)),
        'kr_anak3_tanggal' => htmlspecialchars($this->input->post('kr_anak3_tanggal', true)),
        'kr_anak4_tanggal' => htmlspecialchars($this->input->post('kr_anak4_tanggal', true)),
        'kr_marital' => htmlspecialchars($this->input->post('kr_marital', true)),
        'kr_mulai_tgl' => htmlspecialchars($this->input->post('kr_mulai_tgl', true)),
        'kr_pendidikan_skrng' => htmlspecialchars($this->input->post('kr_pendidikan_skrng', true)),
        'kr_agama_id' => htmlspecialchars($this->input->post('kr_agama_id', true)),
        'kr_hp' => htmlspecialchars($this->input->post('kr_hp', true)),
        'kr_rumah' => htmlspecialchars($this->input->post('kr_rumah', true)),
        'kr_pendidikan_univ' => htmlspecialchars($this->input->post('kr_pendidikan_univ', true))
      ];

      $this->db->where('kr_id', $this->input->post('_id'));
      $this->db->update('kr', $data);

      //simpan ke db

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Employee Updated!</div>');
      redirect('karyawan_crud');
    }
  }

  public function delete()
  {
    $kr_id = $this->input->post('kr_id', true);

    //jika bukan dari form update sendiri
    if ($kr_id) {
      $this->db->where('kr_id', $kr_id);
      $this->db->delete('kr');
      $err = $this->db->error();

      $msg_type = "success";
      $msg = "Employee Deleted";

      if ($err['code'] == "1451") {
        $msg_type = "danger";
        $msg = "Gagal menghapus karyawan, tidak bisa menghapus karyawan jika karyawan masih tercatat sebagai kepsek, punya nilai kpi, konselor, dan atau wali kelas, silahkan non aktifkan karyawan";
      }

      $this->session->set_flashdata('message', '<div class="alert alert-' . $msg_type . '" role="alert">' . $msg . '</div>');
      redirect('karyawan_crud');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('karyawan_crud');
    }
  }

  public function update_status()
  {
    $kr_id = $this->input->post('kr_id', true);
    if ($kr_id) {

      $data = [
        'kr_h_status_kr_id' => htmlspecialchars($this->input->post('kr_id', true)),
        'kr_h_status_status_id' => htmlspecialchars($this->input->post('kr_h_status_status_id', true)),
        'kr_h_status_tanggal' => $this->input->post('kr_h_status_tanggal')
      ];

      $this->db->insert('kr_h_status', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">History Updated!</div>');
      redirect('karyawan_crud');
    }
  }

  public function delete_history()
  {
    if ($this->input->post('kr_h_status_id', true)) {
      $kr_h_status_id = $this->input->post('kr_h_status_id', true);

      $this->db->where('kr_h_status_id', $kr_h_status_id);
      $this->db->delete('kr_h_status');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">History Deleted!</div>');
      redirect('karyawan_crud');
    }
  }

  public function reset()
  {
    $kr_id = $this->input->post('kr_id', true);
    if ($kr_id) {

      $data['title'] = 'Reset Password';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kr_update'] = $this->_kr->find_by_id($kr_id);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('karyawan_crud/reset', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('Profile');
    }
  }

  public function reset_proses()
  {
    $kr_id = $this->input->post('kr_id', true);
    if ($kr_id) {

      $data = [
        'kr_password' => password_hash($this->input->post('kr_password1'), PASSWORD_DEFAULT)
      ];

      $this->db->where('kr_id', $this->input->post('kr_id'));
      $this->db->update('kr', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Updated!</div>');
      redirect('karyawan_crud');
    } else {
      redirect('Profile');
    }
  }

  public function print_laporan()
  {
    $kr_id = $this->input->post('kr_id', true);
    if ($kr_id) {

      $data['title'] = 'Print Detail';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['kr_update'] = $this->db->query(
        "SELECT *
        FROM kr
        LEFT JOIN sk ON kr_sk_id = sk_id
        LEFT JOIN agama ON kr_agama_id = agama_id
        WHERE kr_id = $kr_id"
      )->row_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('karyawan_crud/print', $data);
      $this->load->view('templates/footer');
    } else {
      redirect('Profile');
    }
  }

  public function ubah_status(){

    $kr_id = $this->input->post('kr_id', true);
    if ($kr_id) {

      $cek = $this->db->query(
        "SELECT kr_resign
        FROM kr
        WHERE kr_id = $kr_id"
      )->row_array();

      if($cek['kr_resign'] == 0){
        $val = 1;
      }
      else{
        $val = 0;
      }

      $data = [
        'kr_resign' => $val
      ];

      $this->db->where('kr_id', $kr_id);
      $this->db->update('kr', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Status berhasil dirubah!</div>');
      redirect('Karyawan_CRUD');

    } else {
      redirect('Profile');
    }
  }

  public function unit_tambahan(){
    $kr_id = $this->input->post('kr_id', true);
    if($kr_id){

      $nama= $this->db->query(
        "SELECT kr_nama_depan, kr_nama_belakang, kr_sk_id
        FROM kr
        WHERE kr_id = $kr_id"
      )->row_array();

      $data['title'] = 'Unit Tambahan '.$nama['kr_nama_depan'].' '.$nama['kr_nama_belakang'];

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['kr_id'] = $kr_id;

      $kr_sk_id = $nama['kr_sk_id'];

      $data['utama']= $this->db->query(
        "SELECT sk_nama
        FROM sk
        WHERE sk_id = $kr_sk_id"
      )->row_array();

      $data['tambah']= $this->db->query(
        "SELECT sk_id, sk_nama
        FROM sk
        WHERE sk_id NOT IN
          (SELECT kr_sk_id
          FROM kr
          WHERE kr_id = $kr_id)
        AND sk_id NOT IN
          (SELECT kr_sk_tam_sk_id
          FROM kr_sk_tam
          WHERE kr_sk_tam_kr_id = $kr_id)"
      )->result_array();

      $data['terdaftar']= $this->db->query(
        "SELECT kr_sk_tam_id, sk_nama
        FROM kr_sk_tam
        LEFT JOIN sk ON sk_id = kr_sk_tam_sk_id
        WHERE kr_sk_tam_kr_id = $kr_id"
      )->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('karyawan_crud/unit_tambahan', $data);
      $this->load->view('templates/footer');

    }else {
      redirect('Profile');
    }
  }

  public function unit_tambahan_proses(){
    $sk_id = $this->input->post('sk_id[]', true);
    if($sk_id){

      $kr_id = $this->input->post('kr_id', true);

      $data = array();

      for($i=0;$i<count($sk_id);$i++){
        $data[$i] = [
          'kr_sk_tam_sk_id' => $sk_id[$i],
          'kr_sk_tam_kr_id' => $kr_id
        ];
      }

      $this->db->insert_batch('kr_sk_tam', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berhasil menambahkan unit!</div>');
			redirect('karyawan_crud');

    }else {
      redirect('Profile');
    }
  }

  public function delete_tambahan(){
    $kr_sk_tam_id = $this->input->post('kr_sk_tam_id', true);
    if($kr_sk_tam_id){
      $this->db->where('kr_sk_tam_id', $kr_sk_tam_id);
      $this->db->delete('kr_sk_tam');

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berhasil menghapus unit tambahan!</div>');
			redirect('karyawan_crud');
    }
  }

}

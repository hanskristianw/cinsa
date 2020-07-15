<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sekolah_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_sk');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_t');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan KADIV dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 5 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Daftar Unit';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['sk_all'] = $this->db->query(
      "SELECT * FROM
      (
          Select sk_id, sk_nama, sk_mid, sk_fin, kr1.kr_nama_depan as kepsek, kr2.kr_nama_depan as guru_scout, sk_nickname, sk_type, sk_jenis_rapor
            from sk, kr kr1, kr kr2
            where kr1.kr_id = sk.sk_kepsek
            and kr2.kr_id = sk.sk_scout_kr_id
      )AS a
      LEFT JOIN
      (
        SELECT sk_id, kr_nama_depan as wakasis
          FROM sk
          LEFT JOIN kr ON sk_wakasis = kr_id
      )AS b ON a.sk_id = b.sk_id"
    )->result_array();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('sekolah_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function check_default($post_string)
  {
    return $post_string == '0' ? FALSE : TRUE;
  }

  public function add()
  {

    $this->form_validation->set_rules('sk_nama', 'School Name', 'required|trim');
    $this->form_validation->set_rules('sk_nickname', 'School Nickname', 'required|trim');

    if ($this->form_validation->run() == false) {
      $data['title'] = 'Create School';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['sk_all'] = $this->_sk->return_all();
      $data['guru_all'] = $this->_kr->return_all_teacher();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('sekolah_crud/add', $data);
      $this->load->view('templates/footer');
    } else {
      $rawdate = htmlentities($this->input->post('sk_mid'));
      $sk_mid = date('Y-m-d', strtotime($rawdate));

      $rawdate = htmlentities($this->input->post('sk_fin'));
      $sk_fin = date('Y-m-d', strtotime($rawdate));

      $data = [
        'sk_nama' => $this->input->post('sk_nama'),
        'sk_nickname' => $this->input->post('sk_nickname'),
        'sk_type' => $this->input->post('sk_type')
      ];

      $this->db->insert('sk', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Unit Created!</div>');
      redirect('sekolah_crud/add');
    }
  }

  public function update()
  {

    //dari method post
    $sk_id = $this->input->post('_id', true);
    $sk_type = $this->input->post('sk_type', true);

    //jika bukan dari form update sendiri
    if ($sk_id) {

      if ($sk_type == 0) {
        $data['title'] = 'Update School';

        //data karyawan yang sedang login untuk topbar
        $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
        $data['jabatan_all'] = $this->_jabatan->return_all();
        $data['st_all'] = $this->_st->return_all();
        $data['guru_all'] = $this->_kr->return_all_teacher();


        $data['sk_update'] = $this->_sk->find_by_id($sk_id);

        //load view dengan data query
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sekolah_crud/update', $data);
        $this->load->view('templates/footer');
      } elseif ($sk_type == 1) {
        $data['title'] = 'Update Unit';

        //data karyawan yang sedang login untuk topbar
        $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));


        $data['sk_update'] = $this->_sk->find_by_id($sk_id);

        //load view dengan data query
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('sekolah_crud/update_unit', $data);
        $this->load->view('templates/footer');
      }
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function update_proses()
  {
    if ($this->input->post('sk_nama')) {
      $rawdate = htmlentities($this->input->post('sk_mid'));
      $sk_mid = date('Y-m-d', strtotime($rawdate));

      $rawdate = htmlentities($this->input->post('sk_fin'));
      $sk_fin = date('Y-m-d', strtotime($rawdate));
      $data = [
        'sk_nama' => $this->input->post('sk_nama'),
        'sk_nickname' => $this->input->post('sk_nickname'),
        'sk_mid' => $sk_mid,
        'sk_kepsek' => $this->input->post('kr_id'),
        'sk_scout_kr_id' => $this->input->post('scout_id'),
        'sk_wakasis' => $this->input->post('sk_wakasis'),
        'sk_ex_nama' => $this->input->post('sk_ex_nama'),
        'sk_ex_abr' => $this->input->post('sk_ex_abr'),
        'sk_fin' => $sk_fin
      ];

      $this->db->where('sk_id', $this->input->post('_id'));
      $this->db->update('sk', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">School Updated!</div>');
      redirect('Sekolah_CRUD');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function update_unit_proses()
  {
    if ($this->input->post('sk_nama')) {
      $data = [
        'sk_nama' => $this->input->post('sk_nama'),
        'sk_nickname' => $this->input->post('sk_nickname')
      ];

      $this->db->where('sk_id', $this->input->post('_id'));
      $this->db->update('sk', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Unit Updated!</div>');
      redirect('Sekolah_CRUD');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function ttd_kepsek()
  {

    if ($this->input->post('sk_id')) {

      $data['title'] = 'Upload Tanda Tangan Digital Kepsek';

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['sk_id'] = $this->input->post('sk_id');

      $sk_id = $this->input->post('sk_id');

      $data['ttd_kepsek'] = $this->db->query(
        "SELECT ttd_kepsek, sk_nama
        FROM sk
        WHERE sk_id = $sk_id"
      )->row_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('sekolah_crud/ttd_kepsek', $data);
      $this->load->view('templates/footer');
    }
  }

  public function save_ttd_kepsek()
  {
    if ($this->input->post('sk_id')) {

      $config['upload_path'] = './assets/img/ttd_kepsek/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['max_size'] = 10000;
      $config['max_width'] = 3000;
      $config['max_height'] = 3000;
      $config['file_name'] = date('ymd') . '-' . substr(md5(rand()), 0, 10);
      $old_image = $this->input->post('ttd_kepsek');
      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('image')) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
        redirect('Profile/ttd');
      } else {

        if ($old_image != 'ttd_kepsek.png') {
          unlink(FCPATH . '/assets/img/ttd_kepsek/' . $old_image);
        }

        $data = [
          'ttd_kepsek' => $this->upload->data('file_name')
        ];


        $sk_id = $this->input->post('sk_id');

        $this->db->where('sk_id', $sk_id);
        $this->db->update('sk', $data);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Success!</div>');
        redirect('Sekolah_CRUD');
      }
    }
  }

  public function ubah_rapor(){

    $sk_id = $this->input->post('sk_id', true);
    if ($sk_id) {

      $cek = $this->db->query(
        "SELECT sk_jenis_rapor
        FROM sk
        WHERE sk_id = $sk_id"
      )->row_array();

      if($cek['sk_jenis_rapor'] == 0){
        $val = 1;
      }
      else{
        $val = 0;
      }

      $data = [
        'sk_jenis_rapor' => $val
      ];

      $this->db->where('sk_id', $sk_id);
      $this->db->update('sk', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jenis rapor berhasil dirubah!</div>');
      redirect('Sekolah_CRUD');

    } else {
      redirect('Profile');
    }
  }
}

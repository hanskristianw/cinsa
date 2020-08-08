<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelulusan_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_kelas');
    $this->load->model('_t');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan wakakur dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 4 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Daftar Siswa pada jenjang akhir';

    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    //cari jenjang terakhir dari sekolah tersebut
    $jenj = $this->db->query(
      "SELECT jenj_id
      FROM jenj
      WHERE jenj_sk_id = $sk_id
      ORDER BY jenj_urutan DESC"
    )->row_array();

    $jenj_akhir = $jenj['jenj_id'];

    $data['sis_all'] = $this->db->query(
      "SELECT sis_nama_depan, sis_nama_bel, kelas_nama, sis_alumni, sis_id
      FROM d_s
      LEFT JOIN sis ON d_s_sis_id = sis_id
      LEFT JOIN kelas ON kelas_id = d_s_kelas_id
      LEFT JOIN jenj ON jenj_id = kelas_jenj_id
      WHERE kelas_sk_id = $sk_id AND jenj_id = $jenj_akhir
      ORDER BY kelas_nama, sis_nama_depan"
    )->result_array();

    //var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Kelulusan_CRUD/index', $data);
    $this->load->view('templates/footer');
  }

  public function proses_lulus()
  {
    $sis_id = $this->input->post('sis_id[]', true);
    $sis_alumni = $this->input->post('sis_alumni[]', true);

    if ($sis_id) {

      $data = array();

      for ($i = 0; $i < count($sis_id); $i++) {
        $data[$i] = [
          'sis_alumni' => $sis_alumni[$i],
          'sis_id' =>  $sis_id[$i]
        ];
      }

      $this->db->update_batch('sis', $data, 'sis_id');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Status kelulusan siswa berhasil diupdate!</div>');
      redirect('Kelulusan_CRUD');
    } else {
      redirect('Profile');
    }
  }

}

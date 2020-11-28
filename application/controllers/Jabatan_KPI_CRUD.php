<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jabatan_KPI_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    if($this->session->userdata('kr_jabatan_id')!=1 && $this->session->userdata('kr_jabatan_id')){
      redirect('Profile');
    }

  }

  public function index()
  {

    $data['title'] = 'Jabatan KPI';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['jabatan_all'] = $this->db->query(
      "SELECT jabatan_kpi_id, a.jabatan_kpi_nama AS responden, GROUP_CONCAT(b.jabatan_kpi_nama) AS penilai
      FROM
      (SELECT *
      FROM jabatan_kpi) AS a
      LEFT JOIN (
      SELECT jabatan_kpi_nama, dkpi_responden_jabatan_kpi_id
      FROM dkpi
      LEFT JOIN jabatan_kpi ON dkpi_penilai_jabatan_kpi_id = jabatan_kpi_id
      )AS b ON a.jabatan_kpi_id = b.dkpi_responden_jabatan_kpi_id
      GROUP BY jabatan_kpi_id
      ORDER BY a.jabatan_kpi_nama"
    )->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Jabatan_KPI_CRUD/index', $data);
    $this->load->view('templates/footer');
  }

  public function add(){
    $data['title'] = 'Tambah Jabatan KPI';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Jabatan_KPI_CRUD/add', $data);
    $this->load->view('templates/footer');
  }

  public function add_proses(){
    if($this->input->post('jabatan_kpi_nama')){
      $data = [
        'jabatan_kpi_nama' => $this->input->post('jabatan_kpi_nama'),
      ];

      $this->db->insert('jabatan_kpi', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jabatan KPI berhasil dibuat!</div>');
      redirect('Jabatan_KPI_CRUD/add');
    }
  }

  public function edit(){
    if($this->input->post('jabatan_kpi_id')){
      $data['title'] = 'Edit Jabatan KPI';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id');

      $data['jabatan_all'] = $this->db->query(
        "SELECT * FROM
        jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id"
      )->row_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Jabatan_KPI_CRUD/edit', $data);
      $this->load->view('templates/footer');
    }else{
      redirect('Jabatan_KPI_CRUD');
    }
  }

  public function edit_proses()
  {
    if ($this->input->post('jabatan_kpi_id')) {

      $data = [
        'jabatan_kpi_nama' => $this->input->post('jabatan_kpi_nama')
      ];

      $this->db->where('jabatan_kpi_id', $this->input->post('jabatan_kpi_id'));
      $this->db->update('jabatan_kpi', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jabatan berhasil diupdate!</div>');
      redirect('Jabatan_KPI_CRUD');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function edit_penilai(){
    if($this->input->post('jabatan_kpi_id')){
      $data['title'] = 'Edit Penilai Jabatan';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id');

      $data['responden'] = $jabatan_kpi_id;
      $data['jabatan_all'] = $this->db->query(
        "SELECT * FROM
        jabatan_kpi
        WHERE jabatan_kpi_id != $jabatan_kpi_id"
      )->result_array();

      $data['penilai_all'] = $this->db->query(
        "SELECT dkpi_id, jabatan_kpi_nama
        FROM dkpi
        LEFT JOIN jabatan_kpi ON jabatan_kpi_id = dkpi_penilai_jabatan_kpi_id
        WHERE dkpi_responden_jabatan_kpi_id = $jabatan_kpi_id"
      )->result_array();

      if(count($data['jabatan_all'])>0){
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('Jabatan_KPI_CRUD/edit_penilai', $data);
        $this->load->view('templates/footer');
      }else{
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Jabatan harus lebih dari 1!</div>');
        redirect('Jabatan_KPI_CRUD');
      }

    }else{
      redirect('Jabatan_KPI_CRUD');
    }
  }

  public function edit_penilai_proses(){
    $dkpi_responden_jabatan_kpi_id = $this->input->post('dkpi_responden_jabatan_kpi_id');
    $dkpi_penilai_jabatan_kpi_id = $this->input->post('dkpi_penilai_jabatan_kpi_id');

    if($dkpi_responden_jabatan_kpi_id){

      $cek1 = $this->db->query(
        "SELECT * FROM
        dkpi
        WHERE dkpi_responden_jabatan_kpi_id = $dkpi_responden_jabatan_kpi_id AND dkpi_penilai_jabatan_kpi_id = $dkpi_penilai_jabatan_kpi_id"
      )->row_array();

      if($cek1){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Penilai sudah terdaftar!</div>');
        redirect('Jabatan_KPI_CRUD');
      }

      $data = [
        'dkpi_responden_jabatan_kpi_id' => $dkpi_responden_jabatan_kpi_id,
        'dkpi_penilai_jabatan_kpi_id' => $dkpi_penilai_jabatan_kpi_id,
      ];

      $this->db->insert('dkpi', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Penilai berhasil ditambah!</div>');
      redirect('Jabatan_KPI_CRUD');

    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function edit_peserta(){
    $jabatan_kpi_id = $this->input->post('jabatan_kpi_id');

    if($jabatan_kpi_id){

      $cek = $this->db->query(
        "SELECT jabatan_kpi_nama
        FROM jabatan_kpi
        WHERE jabatan_kpi_id = $jabatan_kpi_id"
      )->row_array();

      $data['title'] = 'Edit Peserta '.$cek['jabatan_kpi_nama'];

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['jabatan_kpi_id'] = $jabatan_kpi_id;

      $data['kr_all'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, sk_nama
        FROM kr
        LEFT JOIN sk ON sk_id = kr_sk_id
        WHERE kr_resign = 0 AND kr_id NOT IN (SELECT d_jabatan_kpi_kr_id FROM d_jabatan_kpi WHERE d_jabatan_kpi_id = $jabatan_kpi_id)
        ORDER BY kr_nama_depan"
      )->result_array();

      $data['kr_all2'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, d_jabatan_kpi_id, sk_nama
        FROM kr
        LEFT JOIN d_jabatan_kpi ON d_jabatan_kpi_kr_id = kr_id
        LEFT JOIN sk ON sk_id = kr_sk_id
        WHERE d_jabatan_kpi_jabatan_kpi_id = $jabatan_kpi_id
        ORDER BY kr_nama_depan"
      )->result_array();


      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Jabatan_KPI_CRUD/edit_peserta', $data);
      $this->load->view('templates/footer');
    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

  }
  public function edit_peserta_proses(){
    if($this->input->post('kr_id[]')){

      $kr_id = $this->input->post('kr_id[]');
      $jabatan_kpi_id = $this->input->post('jabatan_kpi_id');

      for($i=0;$i<count($kr_id);$i++){
        $data[$i] = [
          'd_jabatan_kpi_kr_id' => $kr_id[$i],
          'd_jabatan_kpi_jabatan_kpi_id' => $jabatan_kpi_id
        ];
      }
      $this->db->insert_batch('d_jabatan_kpi', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">'.count($kr_id).' Peserta berhasil diinput!</div>');
      redirect('Jabatan_KPI_CRUD');

    }
  }

  public function delete_peserta(){
    if($this->input->post('d_jabatan_kpi_id')){
      $d_jabatan_kpi_id = $this->input->post('d_jabatan_kpi_id');

      $this->db->where('d_jabatan_kpi_id', $d_jabatan_kpi_id);
      $this->db->delete('d_jabatan_kpi');

      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Delete Sukses!</div>');
      redirect('Jabatan_KPI_CRUD');
    }
  }

}

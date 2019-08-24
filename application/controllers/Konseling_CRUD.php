<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Konseling_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_sk');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_kelas');
    $this->load->model('_mapel');
    $this->load->model('_topik');
    $this->load->model('_k_afek');
    $this->load->model('_t');
    $this->load->model('_d_s');

    //jika bukan guru dan sudah login redirect ke home
    if (konselor_menu() <= 0 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index(){
    $data['title'] = 'Select School';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['t_all'] = $this->_t->return_all();
    $kr_id = $this->session->userdata('kr_id');
    //data karyawan untuk konten
    $data['sk_all'] = $this->db->query("
                      SELECT sk_id, sk_nama
                      FROM konselor 
                      LEFT JOIN sk ON konselor_sk_id = sk_id
                      WHERE konselor_kr_id = $kr_id")->result_array();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('konseling_crud/index', $data);
    $this->load->view('templates/footer');
  }
  public function add(){

    $sk_id = $this->input->post('sk_id', true);
    if ($sk_id) {
      $d_s_id = $this->input->post('d_s_id', true);

      $data['title'] = 'Add Counseling';

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['sis'] = $this->_d_s->return_nama_by_d_s_id($d_s_id);

      //var_dump($d_s_id);


      $data['sk_id'] = $sk_id;
      $data['d_s_id'] = $d_s_id;
      $data['kategori'] = $this->db->query("SELECT * FROM konseling_kategori")->result_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('konseling_crud/add',$data);
      $this->load->view('templates/footer');
    }else{
      redirect('Profile');
    }
  }

  public function delete(){
    $konseling_id = $this->input->post('konseling_id', true);
    if ($konseling_id) {
      $this->db->where('konseling_id', $konseling_id);
      $this->db->delete('konseling');
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Session Deleted!</div>');
      redirect('Konseling_CRUD');
    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }
 
  public function proses_add(){

    if ($this->input->post('d_s_id',TRUE)) {

      $data = [
        'konseling_d_s_id' => $this->input->post('d_s_id'),
        'konseling_alasan' => $this->input->post('konseling_alasan'),
        'konseling_hasil' => $this->input->post('konseling_hasil'),
        'konseling_saran' => $this->input->post('konseling_saran'),
        'konseling_tanggal' => $this->input->post('konseling_tanggal'),
        'konseling_konseling_kategori_id' => $this->input->post('konseling_kategori_id')
      ];
      
      $this->db->insert('konseling', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Input Success!</div>');
      redirect('Konseling_CRUD');
      
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

  }

  public function edit(){
    
    $konseling_id = $this->input->post('konseling_id', true);
    $data['title'] = 'Edit Counseling';

    if(!$konseling_id){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $d_s_id = $this->input->post('d_s_id', true);
    $data['d_s_id'] = $d_s_id;
    $data['konseling'] = $this->db->query(
      "SELECT *
      FROM konseling
      WHERE konseling_id = $konseling_id")->row_array();

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sis'] = $this->_d_s->return_nama_by_d_s_id($d_s_id);
    $data['kr_all'] = $this->_kr->return_all_teacher();
    $data['kategori'] = $this->db->query("SELECT * FROM konseling_kategori")->result_array();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Konseling_CRUD/edit',$data);
    $this->load->view('templates/footer');

  }

  public function proses_edit(){
    if($this->input->post('konseling_id', true)){
      $data = [
        'konseling_alasan' => $this->input->post('konseling_alasan'),
        'konseling_hasil' => $this->input->post('konseling_hasil'),
        'konseling_saran' => $this->input->post('konseling_saran'),
        'konseling_tanggal' => $this->input->post('konseling_tanggal'),
        'konseling_konseling_kategori_id' => $this->input->post('konseling_kategori_id')
      ];

      //simpan ke db

      $this->db->where('konseling_id', $this->input->post('konseling_id', true));
      $this->db->update('konseling', $data); 
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Session Updated!</div>');
      redirect('Konseling_CRUD');
    }
  }

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wakasis_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kelas');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');
    $this->load->model('_t');
    $this->load->model('_siswa');

    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan guru dan sudah login redirect ke home
    if(wakasis_menu() == 0){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'Class List';
    $kr_id = $this->session->userdata('kr_id');
    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    $data['sk_all'] = $this->db->query(
      "SELECT *
      FROM sk
      WHERE sk_wakasis = $kr_id")->result_array();

    $data['t_all'] = $this->_t->return_all();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('wakasis_crud/index',$data);
    $this->load->view('templates/footer');

  }

  public function moral_input(){

    if($this->input->post('kelas_moral',TRUE)){

      $kelas_id = $this->input->post('kelas_moral',TRUE);

      $data['title'] = 'Moral Behaviour';

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['siswa_all'] = $this->db->query(
        "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk, kelas_nama,
                moralb_lo,moralb_so,moralb_lo2,moralb_so2
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN kelas ON d_s_kelas_id = kelas_id
        WHERE d_s_kelas_id = $kelas_id ORDER BY sis_no_induk, sis_nama_depan")->result_array();

      if(!$data['siswa_all']){
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">No Student, add one or more student!</div>');
        redirect('wakasis_crud');
      }

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('wakasis_crud/moral_input',$data);
        $this->load->view('templates/footer');

    }else{
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

  }

  public function save_moral(){
    if($this->input->post('d_s_id[]')){
      $data = array();
      $moralb_lo = $this->input->post('moralb_lo[]',true);
      $moralb_so = $this->input->post('moralb_so[]',true);
      $moralb_lo2 = $this->input->post('moralb_lo2[]',true);
      $moralb_so2 = $this->input->post('moralb_so2[]',true);

      $d_s_id = $this->input->post('d_s_id[]');

      for($i=0;$i<count($d_s_id);$i++){
        $data[$i] = [
          'moralb_lo' => $moralb_lo[$i],
          'moralb_so' => $moralb_so[$i],
          'moralb_lo2' => $moralb_lo2[$i],
          'moralb_so2' => $moralb_so2[$i],
          'd_s_id' =>  $d_s_id[$i]
        ];
      }
      $this->db->update_batch('d_s',$data, 'd_s_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Success!</div>');
      redirect('wakasis_crud');
    }
  }

}

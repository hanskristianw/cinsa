<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Disjam_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_jenj');
    $this->load->model('_t');
    $this->load->model('_siswa');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_d_s');


    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika bukan wakakur dan sudah login redirect ke home
    if ($this->session->userdata('kr_jabatan_id') != 5 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'List of School';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data jenjang untuk konten
    $data['sekolah_all'] = $this->_sk->return_all();
    $data['t_all'] = $this->_t->return_all();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('disjam_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function proses()
  {

    if($this->input->post('t_id', true)){
      $t_id = $this->input->post('t_id', true);
      $sk_id = $this->input->post('sk_id', true);

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['title'] = 'Distribusi Jam';

      $data['sk_detail'] = $this->db->query(
        "SELECT *
        FROM sk
        WHERE sk_id = $sk_id")->row_array();

      $data['t_detail'] = $this->db->query(
        "SELECT *
        FROM t
        WHERE t_id = $t_id")->row_array();

      $data['kr_all'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, GROUP_CONCAT(st_nama ORDER BY kr_h_status_tanggal DESC) as st_nama
        FROM kr
        LEFT JOIN jabatan ON kr_jabatan_id = jabatan_id
        LEFT JOIN sk ON kr_sk_id = sk_id
        LEFT JOIN kr_h_status ON kr_h_status_kr_id = kr_id
        LEFT JOIN st ON kr_h_status_status_id = st_id
        WHERE kr_sk_id = $sk_id
        GROUP BY kr_id
        ORDER BY kr_nama_depan")->result_array();

      
      $data['kr_all_not_in'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, beban_tam_jum, GROUP_CONCAT(st_nama ORDER BY kr_h_status_tanggal DESC) as st_nama
        FROM beban_tam
        LEFT JOIN kr ON beban_tam_kr_id = kr_id
        LEFT JOIN kr_h_status ON kr_h_status_kr_id = kr_id
        LEFT JOIN st ON kr_h_status_status_id = st_id
        WHERE beban_tam_t_id = $t_id AND kr_sk_id = $sk_id AND kr_id NOT IN 
        (SELECT d_mpl_kr_id
        FROM d_mpl
        LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
        WHERE kelas_sk_id = $sk_id AND kelas_t_id = $t_id)
        GROUP BY kr_id
        ORDER BY kr_nama_depan")->result_array();

      //echo $this->db->last_query();


      $data['kelas_all'] = $this->db->query(
        "SELECT kelas_id, kelas_nama, kelas_nama_singkat FROM kelas WHERE kelas_t_id = $t_id AND kelas_sk_id = $sk_id ORDER BY kelas_nama")->result_array();


      //$data['kr_all'] = $this->_kr->return_all_by_sk_id($sk_id);

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('disjam_crud/disjam', $data);
      $this->load->view('templates/footer');

    }else{
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }
  }

  public function set_beban(){
    
    $data['title'] = 'Beban Jam';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data jenjang untuk konten
    $data['sekolah_all'] = $this->_sk->return_all();
    $data['t_all'] = $this->_t->return_all();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('disjam_crud/set_beban', $data);
    $this->load->view('templates/footer');
  }

  public function set_beban_show(){
    
    if($this->input->post('t_id', true)){
      $t_id = $this->input->post('t_id', true);
      $sk_id = $this->input->post('sk_id', true);

      $data['title'] = 'Beban Jam';
      $data['t_id'] = $t_id;
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['kr_terbeban'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang, beban_tam_jum, beban_tam_id
        FROM kr
        LEFT JOIN beban_tam ON beban_tam_kr_id = kr_id
        WHERE kr_sk_id = $sk_id AND beban_tam_t_id = $t_id
        ORDER BY kr_nama_depan")->result_array();

      
      $data['kr_tanpa_beban'] = $this->db->query(
        "SELECT kr_id, kr_nama_depan, kr_nama_belakang
        FROM kr
        WHERE kr_sk_id = $sk_id AND kr_id NOT IN (
          SELECT kr_id
          FROM kr
          LEFT JOIN beban_tam ON beban_tam_kr_id = kr_id
          WHERE kr_sk_id = $sk_id AND beban_tam_t_id = $t_id
        )
        ORDER BY kr_nama_depan")->result_array();


      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('disjam_crud/set_beban_show', $data);
      $this->load->view('templates/footer');
    }
  }

  public function set_beban_proses_save(){
    
    $beban_tam_kr_id = $this->input->post('beban_tam_kr_id[]',true);
    $beban_tam_t_id = $this->input->post('beban_tam_t_id',true);
    $beban_tam_jum = $this->input->post('beban_tam_jum[]',true);

    if($beban_tam_kr_id){

      for($i=0;$i<count($beban_tam_kr_id);$i++){

        if($beban_tam_jum[$i]){
          $data[$i] = [
            'beban_tam_kr_id' => $beban_tam_kr_id[$i],
            'beban_tam_t_id' => $beban_tam_t_id,
            'beban_tam_jum' => $beban_tam_jum[$i]
          ];
        }
      }
      if($data){
        $this->db->insert_batch('beban_tam', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
        redirect('Disjam_CRUD/set_beban');
      }
      else{
        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Gagal, Isi setidaknya 1 guru!</div>');
        redirect('Disjam_CRUD/set_beban');
      }
    }
  }

  public function set_beban_proses_up(){
    $beban_tam_id = $this->input->post('beban_tam_id[]',true);
    $beban_tam_jum = $this->input->post('beban_tam_jum[]',true);
    if($beban_tam_id){

      for($i=0;$i<count($beban_tam_id);$i++){
        $data[$i] = [
          'beban_tam_id' => $beban_tam_id[$i],
          'beban_tam_jum' => $beban_tam_jum[$i]
        ];
      }
      $this->db->update_batch('beban_tam',$data, 'beban_tam_id');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Update Success!</div>');
      redirect('Disjam_CRUD/set_beban');
    }
  }

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Event_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_mapel');
    $this->load->model('_kr');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_jabatan');
    $this->load->model('_jenj');
    $this->load->model('_t');


    //jika belum login
    if(!$this->session->userdata('kr_jabatan_id')){
      redirect('Auth');
    }

    //jika bukan HRD dan sudah login redirect ke home
    if($this->session->userdata('kr_jabatan_id')!=5){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'Event List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');
    
    $data['event_all'] = $this->db->query(
      "SELECT *
      FROM event
      ORDER BY event_tgl DESC")->result_array();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Event_CRUD/index',$data);
    $this->load->view('templates/footer');

  }

  public function add(){
    $data['title'] = 'Add Event';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Event_CRUD/add',$data);
    $this->load->view('templates/footer');
  }

  public function add_proses(){
    $event_nama = $this->input->post('event_nama',true);
    $event_tgl = $this->input->post('event_tgl',true);
    
    if($event_nama && $event_tgl){
      $data = [
        'event_nama' => $event_nama,
        'event_tgl' => $event_tgl
      ];

      $this->db->insert('event', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success announce" role="alert">Event Saved!</div>');
      redirect('Event_CRUD');
    }else{
      redirect('Event_CRUD');
    }

  }

  public function update(){

    $event_id = $this->input->post('event_id',true);
    if($event_id){
      
      $data['title'] = 'Edit Event';
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['event'] = $this->db->query(
        "SELECT *
        FROM event
        WHERE event_id = $event_id")->row_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Event_CRUD/update',$data);
      $this->load->view('templates/footer');
    }else{
      redirect('Event_CRUD');
    }
  }

  public function update_proses(){

    $event_id = $this->input->post('event_id',true);
    if($event_id){
      
      $data['title'] = 'Edit Event';
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data = [
        'event_nama' => $this->input->post('event_nama',true),
        'event_tgl' => $this->input->post('event_tgl',true)
      ];
      $this->db->where('event_id', $event_id);
      $this->db->update('event', $data);

      $this->session->set_flashdata('message','<div class="alert alert-success announce" role="alert">Event Updated!</div>');
      redirect('Event_CRUD');
    }else{
      redirect('Event_CRUD');
    }
  }

  public function absent(){
    $event_id = $this->input->post('event_id',true);
    if($event_id){
      
      $data['title'] = 'Event Absent';
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $data['sk_all'] = $this->db->query(
        "SELECT sk_id, sk_nama
        FROM sk")->result_array();

      
      $data['event_all'] = $this->db->query(
        "SELECT *
        FROM event
        WHERE event_id = $event_id")->row_array();

      $data['event_id'] = $event_id;

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Event_CRUD/absent',$data);
      $this->load->view('templates/footer');
    }else{
      redirect('Event_CRUD');
    }
  }

  public function add_absent(){
    $kr_id = $this->input->post('kr_id[]',true);

    if($kr_id){

      $event_id = $this->input->post('event_id',true);

      for($i=0;$i<count($kr_id);$i++){

        if($this->input->post($kr_id[$i],true)!=0){
          $data[$i] = [
            'd_event_kr_id' => $kr_id[$i],
            'd_event_event_id' => $event_id,
            'd_event_hadir' => $this->input->post($kr_id[$i],true)
          ];
        }
      }
      $this->db->insert_batch('d_event', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Input Success!</div>');
      redirect('Event_CRUD');
    }

    //var_dump($data);
  }

  public function del_absent(){
    $event_id = $this->input->post('event_id',true);
    if($event_id){
      
      $data['title'] = 'Event Absent';
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      
      $data['event_all'] = $this->db->query(
        "SELECT event_id, event_nama, kr_nama_depan, kr_nama_belakang, sk_nama, kr_id, d_event_hadir
        FROM d_event
        LEFT JOIN event ON d_event_event_id = event_id
        LEFT JOIN kr ON d_event_kr_id = kr_id
        LEFT JOIN sk ON kr_sk_id = sk_id
        WHERE event_id = $event_id
        ORDER BY sk_id, kr_nama_depan")->result_array();

      $data['event_d'] = $this->db->query(
        "SELECT *
        FROM event
        WHERE event_id = $event_id")->row_array();

      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Event_CRUD/del_absent',$data);
      $this->load->view('templates/footer');
    }else{
      redirect('Event_CRUD');
    }

  }

  public function del_absent_proses(){
    $event_id = $this->input->post('event_id',true);
    $kr_id = $this->input->post('kr_id',true);

    if($event_id && $kr_id){
      
      $this->db->where('d_event_kr_id', $kr_id);
      $this->db->where('d_event_event_id', $event_id);
      $this->db->delete('d_event');
      
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Delete Success!</div>');
      redirect('Event_CRUD');
    }
  }

  public function laporan(){

    $data['title'] = 'Event Report';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');
    
    $data['sk_all'] = $this->db->query(
      "SELECT sk_id, sk_nama
      FROM sk
      ORDER BY sk_nama")->result_array();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Event_CRUD/laporan',$data);
    $this->load->view('templates/footer');
  }

  public function laporan_show(){

    $data['title'] = 'Event Report';

    $startdate = $this->input->post('tgl_awal',true);
    $endDate = $this->input->post('tgl_akhir',true);
    $sk_id = $this->input->post('sk',true);
    $data['sk_nama'] = $this->db->query(
      "SELECT sk_nama
      FROM sk
      WHERE sk_id = $sk_id")->row_array();
    // var_dump($startdate);
    // var_dump($endDate);

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    
    $data['event_all'] = $this->db->query(
      "SELECT event_id, event_nama, event_tgl
      FROM event
      WHERE event_tgl BETWEEN '$startdate' AND '$endDate'
      ORDER BY event_tgl")->result_array();

    $data['kr_all'] = $this->db->query(
      "SELECT kr_id, kr_nama_depan, kr_nama_belakang
      FROM kr
      WHERE kr_sk_id = $sk_id
      ORDER BY kr_nama_depan")->result_array();

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Event_CRUD/laporan_show',$data);
    $this->load->view('templates/footer');
  }

  public function add_pic(){
    if($this->input->post('event_id',true)){

      $data['title'] = 'Upload Foto Kegiatan';
      $data['event_id'] = $this->input->post('event_id',true);
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));


      $this->load->view('templates/header',$data);
      $this->load->view('templates/sidebar',$data);
      $this->load->view('templates/topbar',$data);
      $this->load->view('Event_CRUD/add_pic',$data);
      $this->load->view('templates/footer');

    }
  }

  public function save_pic() {
    $config['upload_path'] = './assets/img/event/';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size'] = 10000;
    $config['max_width'] = 3000;
    $config['max_height'] = 3000;
    $config['file_name'] = 'event'.date('ymd').'-'.substr(md5(rand()),0,10);

    $this->load->library('upload', $config);

    if (!$this->upload->do_upload('image')) {
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">'.$this->upload->display_errors().'</div>');
      redirect('Event_CRUD');
    } else {

      $data = [
        'event_gambar_event_id' => $this->input->post('event_id',true),
        'event_gambar_path' => $this->upload->data('file_name')
      ];

      $this->db->insert('event_gambar', $data);
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Upload Success!</div>');
      redirect('Event_CRUD');
    }
  }

  public function deleteimg(){
    if($this->input->post('event_gambar_id',true)){

      $event_gambar_id = $this->input->post('event_gambar_id',true);
      $old_image = $this->input->post('event_gambar_path',true);
      unlink(FCPATH.'assets/img/event/'.$old_image);
      $this->db->where('event_gambar_id', $event_gambar_id);
      $this->db->delete('event_gambar');
      $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Delete Success!</div>');
      redirect('Event_CRUD');
    }

  }

}
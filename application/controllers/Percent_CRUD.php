<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Percent_CRUD extends CI_Controller
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
    if($this->session->userdata('kr_jabatan_id')!=4){
      redirect('Profile');
    }
  }

  public function index(){

    $data['title'] = 'Subject List';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $sk_id = $this->session->userdata('kr_sk_id');

    // $kr_id = $this->session->userdata('kr_id');
    
    $data['t_all'] = $this->_t->return_all();
    
    $data['mapel_all'] = $this->db->query(
      "SELECT *
      FROM mapel
      WHERE mapel_sk_id = $sk_id")->result_array();

    $data['jenj_all'] = $this->_jenj->return_all_by_sk($this->session->userdata('kr_sk_id'));

    $this->load->view('templates/header',$data);
    $this->load->view('templates/sidebar',$data);
    $this->load->view('templates/topbar',$data);
    $this->load->view('Percent_CRUD/index',$data);
    $this->load->view('templates/footer');

  }

  public function save_persen(){
    $persen_forma_peng = $this->input->post('persen_forma_peng',true);
    $mapel_id = $this->input->post('mapel_id',true);
    $jenj_id = $this->input->post('jenj_id',true);
    $t_id = $this->input->post('t_id',true);

    if($persen_forma_peng){
      
      $cek_ada = $this->db->query(
        "SELECT *
        FROM persen
        WHERE persen_mapel_id = $mapel_id AND persen_jenj_id = $jenj_id AND persen_t_id = $t_id")->result_array();

      
      if(!$cek_ada){ 
        //belum ada insert
        $data = [
          'persen_mapel_id' => $mapel_id,
          'persen_jenj_id' => $jenj_id,
          'persen_forma_peng' => $this->input->post('persen_forma_peng',true),
          'persen_summa_peng' => $this->input->post('persen_summa_peng',true),
          'persen_forma_ket' => $this->input->post('persen_forma_ket',true),
          'persen_summa_ket' => $this->input->post('persen_summa_ket',true),
          'persen_peng_akhir' => $this->input->post('persen_peng_akhir',true),
          'persen_ket_akhir' => $this->input->post('persen_ket_akhir',true),
          'persen_t_id' => $t_id
        ];
  
        $this->db->insert('persen', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success announce m-3" role="alert">Percentage Saved!</div>');
        redirect('percent_crud');

      }else{
        //sudah ada update
        $data = [
          'persen_forma_peng' => $this->input->post('persen_forma_peng',true),
          'persen_summa_peng' => $this->input->post('persen_summa_peng',true),
          'persen_forma_ket' => $this->input->post('persen_forma_ket',true),
          'persen_summa_ket' => $this->input->post('persen_summa_ket',true),
          'persen_peng_akhir' => $this->input->post('persen_peng_akhir',true),
          'persen_ket_akhir' => $this->input->post('persen_ket_akhir',true)
        ];
        $this->db->where('persen_mapel_id', $mapel_id);
        $this->db->where('persen_jenj_id', $jenj_id);
        $this->db->where('persen_t_id', $t_id);
        $this->db->update('persen', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success announce m-3" role="alert">Percentage Updated!</div>');
        redirect('percent_crud');
      }

    }

  }

}
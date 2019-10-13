<?php
defined('BASEPATH') or exit('No direct script access allowed');

class K_afek_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_k_afek');
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_st');
    $this->load->model('_sk');
    $this->load->model('_bulan');
    $this->load->model('_t');

    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('Auth');
    }

    //jika belum login dan bukan konselor
    if (konselor_menu() <= 0 && $this->session->userdata('kr_jabatan_id')) {
      redirect('Profile');
    }
  }

  public function index()
  {

    if($this->input->post('sk_id', true)){
      $data['title'] = 'Affective Indicator';

      $sk_id = $this->input->post('sk_id', true);
      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
  
      //data karyawan untuk konten
      $data['k_afek_all'] = $this->_k_afek->return_all_by_sk($sk_id);
      $data['sk_id'] = $sk_id;
  
      //$data['tes'] = var_dump($this->db->last_query());
  
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('k_afek_crud/index', $data);
      $this->load->view('templates/footer');
    }
    elseif(!$this->input->post('sk_id', true)){
      $data['title'] = 'Select School';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
  
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
      $this->load->view('k_afek_crud/index_sekolah', $data);
      $this->load->view('templates/footer');
    }
    
  }

  public function add()
  {

    $sk_id = $this->input->post('sk_id');
    if(!$sk_id){
      redirect('Profile');
    }

    $data['title'] = 'Affective Indicator';

    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk_all'] = $this->_sk->return_all();
    $data['bulan_all'] = $this->_bulan->return_all();
    $data['tahun_all'] = $this->_t->return_all();
    $data['sk_id'] = $sk_id;

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('k_afek_crud/add', $data);
    $this->load->view('templates/footer');
    
  }

  public function add_proses()
  {
    $sk_id = $this->input->post('sk_id');

    if($sk_id){
      $data = [
        'k_afek_topik_nama' => $this->input->post('k_afek_nama'),
        'k_afek_1' => $this->input->post('k_afek_1'),
        'k_afek_2' => $this->input->post('k_afek_2'),
        'k_afek_3' => $this->input->post('k_afek_3'),
        'k_afek_instruksi_1' => $this->input->post('k_afek_instruksi_1'),
        'k_afek_instruksi_2' => $this->input->post('k_afek_instruksi_2'),
        'k_afek_instruksi_3' => $this->input->post('k_afek_instruksi_3'),
        'k_afek_t_id' => $this->input->post('k_afek_t_id'),
        'k_afek_sk_id' => $sk_id,
        'k_afek_bulan_id' => $this->input->post('k_afek_bulan_id')
      ];

      $this->db->insert('k_afek', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Indicator Created!</div>');
      redirect('k_afek_crud');
    }else{
      redirect('Profile');
    }

    
  }

  public function report(){
    $data['title'] = 'Affective Report';
    $kr_id = $this->session->userdata('kr_id');
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk_all'] = $this->db->query("
                        SELECT sk_id, sk_nama
                        FROM konselor 
                        LEFT JOIN sk ON konselor_sk_id = sk_id
                        WHERE konselor_kr_id = $kr_id")->result_array();
    $data['bulan_all'] = $this->_bulan->return_all();
    $data['tahun_all'] = $this->_t->return_all();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('k_afek_crud/report', $data);
    $this->load->view('templates/footer');
  }

  public function show_report(){
    if($this->input->post('t_id', true)){
      $data['title'] = 'Affective Report';
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

      $sk_id = $this->input->post('sk_id', true);
      $t_id = $this->input->post('t_id', true);
      $bulan_id = $this->input->post('bulan_id', true);
      $kelas_id = $this->input->post('kelas_id', true);
      
      $data['bulan_id'] = $bulan_id;

      $data['k_afek'] = $this->db->query("
        SELECT *
        FROM k_afek 
        WHERE k_afek_bulan_id = $bulan_id AND k_afek_t_id = $t_id AND k_afek_sk_id = $sk_id")->row_array();


      $mapel_header = $this->db->query("
        SELECT DISTINCT mapel_id, mapel_sing
        FROM d_mpl 
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        WHERE d_mpl_kelas_id = $kelas_id ORDER BY mapel_urutan,mapel_nama")->result_array();

      $query_concat ="";
      foreach ($mapel_header as $m){
        $query_concat .= "GROUP_CONCAT(IF(afektif_mapel_id = {$m['mapel_id']}, afektif_nilai, '') SEPARATOR '') AS '{$m['mapel_sing']}'";
        $query_concat .= ",";
      }
      $query_concat = substr($query_concat, 0, -1);
      //echo $query_concat;
      //var_dump($mapel_header);

      $data['mapel_header'] = $mapel_header;

      $data['afektif_all'] = $this->db->query(
      "SELECT afektif_d_s_id, sis_nama_depan, sis_nama_bel, d_s_kelas_id, sis_no_induk, kelas_nama, $query_concat
      FROM 
      (SELECT afektif_d_s_id, sis_nama_depan, sis_nama_bel, d_s_kelas_id, sis_no_induk, kelas_nama,
      (afektif_minggu1a1+afektif_minggu1a2+afektif_minggu1a3+afektif_minggu2a1+afektif_minggu2a2+afektif_minggu2a3+afektif_minggu3a1+afektif_minggu3a2+afektif_minggu3a3+afektif_minggu4a1+afektif_minggu4a2+afektif_minggu4a3+afektif_minggu5a1+afektif_minggu5a2+afektif_minggu5a3)/afektif_minggu_aktif AS afektif_nilai, afektif_mapel_id 
      FROM afektif
      LEFT JOIN d_s on afektif_d_s_id = d_s_id 
      LEFT JOIN sis on d_s_sis_id = sis_id 
      LEFT JOIN k_afek on k_afek_id = afektif_k_afek_id 
      LEFT JOIN kelas on d_s_kelas_id = kelas_id 
      WHERE k_afek_bulan_id = {$bulan_id} AND d_s_kelas_id = {$kelas_id}) as afektif_kelas
      GROUP BY afektif_d_s_id")->result_array();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('k_afek_crud/show_report', $data);
      $this->load->view('templates/footer');

    }
  }
  

  public function update()
  {

    //dari method post
    $k_afek_id = $this->input->post('k_afek_id', true);

    //jika bukan dari form update sendiri
    if (!$k_afek_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data['title'] = 'Update Criteria';

    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk_all'] = $this->_sk->return_all();
    $data['bulan_all'] = $this->_bulan->return_all();
    $data['tahun_all'] = $this->_t->return_all();

    
    $data['k_afek_update'] = $this->_k_afek->find_by_id($k_afek_id);

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('k_afek_crud/update', $data);
    $this->load->view('templates/footer');

  }
  public function update_proses()
  {
    $k_afek_id = $this->input->post('k_afek_id', true);

    //jika bukan dari form update sendiri
    if (!$k_afek_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Denied!</div>');
      redirect('Profile');
    }

    $data = [
      'k_afek_topik_nama' => $this->input->post('k_afek_nama'),
      'k_afek_1' => $this->input->post('k_afek_1'),
      'k_afek_2' => $this->input->post('k_afek_2'),
      'k_afek_3' => $this->input->post('k_afek_3'),
      'k_afek_instruksi_1' => $this->input->post('k_afek_instruksi_1'),
      'k_afek_instruksi_2' => $this->input->post('k_afek_instruksi_2'),
      'k_afek_instruksi_3' => $this->input->post('k_afek_instruksi_3'),
      'k_afek_t_id' => $this->input->post('k_afek_t_id'),
      'k_afek_sk_id' => $this->input->post('sk_id'),
      'k_afek_bulan_id' => $this->input->post('k_afek_bulan_id')
    ];

    //simpan ke db

    $this->db->where('k_afek_id', $this->input->post('k_afek_id'));
    $this->db->update('k_afek', $data);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Criteria Updated!</div>');
    redirect('K_afek_CRUD');
  }

}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kelas_CRUD extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_jabatan');
    $this->load->model('_kelas');
    $this->load->model('_t');
    $this->load->model('_siswa');
    $this->load->model('_jenj');
    $this->load->model('_sk');
    $this->load->model('_st');
    $this->load->model('_d_s');
    $this->load->model('_mapel');
    $this->load->model('_d_mpl');


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

    $guru_count = $this->db->where('kr_jabatan_id','7')->from("kr")->count_all_results();

    if ($guru_count == 0) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please inform HR to add teacher first!</div>');
      redirect('Profile');
    }


    $data['title'] = 'List of Class';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    //data karyawan untuk konten
    //$data['kelas_all'] = $this->_kelas->return_all_by_sk($this->session->userdata('kr_sk_id'));

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['kelas_all'] = $this->db->query(
      "SELECT kelas_nama, t_nama, jenj_nama, kelas_id, kelas_kr_id, count(d_s_kelas_id) as jum_siswa
      FROM kelas
      LEFT JOIN t ON kelas_t_id = t_id
      LEFT JOIN jenj ON kelas_jenj_id = jenj_id
      LEFT JOIN sk ON kelas_sk_id = sk_id
      LEFT JOIN d_s ON kelas_id = d_s_kelas_id
      WHERE kelas_sk_id = $sk_id
      GROUP BY kelas_id
      ORDER BY t_id DESC, jenj_nama, kelas_nama")->result_array();

    $data['guru_all'] = $this->_kr->return_all_teacher();

    //$data['tes'] = var_dump($this->db->last_query());

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('kelas_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function add()
  {

    $this->form_validation->set_rules('kelas_nama', 'Kelas Nama', 'required|trim');

    if ($this->form_validation->run() == false) {
      //jika belum ada tahun ajaran sama sekali
      $t_count = $this->db->count_all('t');

      if ($t_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please inform ADMIN to year first!</div>');
        redirect('Kelas_CRUD');
      }

      $jenjang_count = $this->db->where('jenj_sk_id',$this->session->userdata('kr_sk_id'))->from("jenj")->count_all_results();

      if ($jenjang_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please add level first!</div>');
        redirect('Kelas_CRUD');
      }

      $data['title'] = 'Create Class';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas_all'] = $this->_kelas->return_all();
      $data['tahun_all'] = $this->_t->return_all();
      $data['jenj_all'] = $this->_jenj->return_all_by_sk($this->session->userdata('kr_sk_id'));
      $data['sk_all'] = $this->_sk->return_all();

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('kelas_crud/add', $data);
      $this->load->view('templates/footer');
    } else {

      $data = [
        'kelas_nama' => $this->input->post('kelas_nama'),
        'kelas_sk_id' => $this->input->post('kelas_sk_id'),
        'kelas_jenj_id' => $this->input->post('jenj_id'),
        'kelas_t_id' => $this->input->post('kelas_t_id')
      ];

      $this->db->insert('kelas', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Class Created!</div>');
      redirect('kelas_crud/add');
    }
  }
  public function save_homeroom(){
    $kelas_post = $this->_kelas->find_by_id($this->input->post('kelas_id', true));

    if (!$kelas_post['kelas_id']) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
      redirect('Kelas_CRUD');
    }

    $data = [
      'kelas_id' => $this->input->post('kelas_id'),
      'kelas_kr_id' => $this->input->post('kelas_kr_id')
    ];

    $this->db->where('kelas_id', $this->input->post('kelas_id', true));
    $this->db->update('kelas', $data);

    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Class Homeroom Teacher Updated!</div>');
    redirect('Kelas_CRUD');

  }
  public function save_teacher(){

    $kr_id = $this->input->post('kr_id', true);
    $mapel_id = $this->input->post('mapel_id', true);
    $kelas_id = $this->input->post('kelas_id', true);
    $d_mpl_id = explode(",",$this->input->post('d_mpl_id', true));
    $beban = $this->input->post('beban', true);

    if(!$kr_id || !$mapel_id || !$kelas_id){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly!</div>');
      redirect('kelas_crud');
    }

    //var_dump($d_mpl_id);

    $data = array();

    for($i=0;$i<count($kr_id);$i++){
      $data[$i] = [
        'd_mpl_id' => $d_mpl_id[$i],
        'd_mpl_kr_id' => $kr_id[$i],
        'd_mpl_beban' => $beban[$i]
      ];
    }

    $this->db->update_batch('d_mpl',$data, 'd_mpl_id'); 
    var_dump($this->db->last_query());
    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Teacher(s) Updated!</div>');
    redirect('kelas_crud/edit_subject?_id='.$kelas_id);
    // var_dump($kr_id[0]);
    // var_dump($kr_id[1]);
    // var_dump($kr_id[2]);
    // var_dump($mapel_id);
    // var_dump($kelas_id);
  }

  public function delete_subject(){
    $d_mpl_id = explode(",",$this->input->post('d_mpl_id_delete', true));
    $kelas_id = $this->input->post('kelas_id', true);

    if(!$d_mpl_id || !$kelas_id){
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly!</div>');
      redirect('kelas_crud');
    }

    $this->db->where_in('d_mpl_id', $d_mpl_id)->delete('d_mpl');
    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Subject Deleted</div>');
    redirect('kelas_crud/edit_subject?_id='.$kelas_id);
  }

  public function edit_subject(){
    $kelas_id_post = $this->input->post('kelas_id', true);
    if(!$kelas_id_post){
      $kelas_get = $this->_kelas->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update
      if (!$kelas_get['kelas_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Kelas_CRUD');
      }
    }

    $this->form_validation->set_rules('mapel_id', 'Siswa Nama', 'required|trim');
    $this->form_validation->set_rules('kelas_id', 'Kelas Nama', 'required|trim');

    if ($this->form_validation->run() == false) {

      $sk_id = $this->session->userdata('kr_sk_id');

      //jika belum ada murid sama sekali

      $mapel_count = $this->db->where('mapel_sk_id',$sk_id)->from("mapel")->count_all_results();

      if ($mapel_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please add subject first!</div>');
        redirect('Kelas_CRUD');
      }

      //jika belum ada guru sama sekali
      $guru_count = $this->db->where('kr_jabatan_id','7')->from("kr")->count_all_results();

      if ($guru_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please inform HR to add teacher first!</div>');
        redirect('Kelas_CRUD');
      }

      $data['title'] = 'Subjects';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas_all'] = $this->_kelas->find_by_id($this->input->get('_id', true));

      $data['mapel_all'] = $this->db->query(
        "SELECT *
        FROM mapel
        WHERE mapel_sk_id = $sk_id AND
        mapel_id NOT IN (SELECT d_mpl_mapel_id FROM d_mpl WHERE d_mpl_kelas_id = ".$kelas_get['kelas_id'].")
        ORDER BY mapel_urutan")->result_array();
      
      $data['guru_all'] = $this->_kr->return_all_teacher();

      //var_dump($data['kelas_all']);

      //return siswa yang belum mempunyai kelas pada kelas dengan tahun ajaran
      $data['mapel_in_class'] = $this->_d_mpl->return_all_by_kelas_id($this->input->get('_id', true));

      //var_dump($data['kelas_all']['kelas_t_id']);

      $data['d_mpl_all'] = $this->db->query(
        "SELECT mapel_id, mapel_sing, mapel_nama, mapel_urutan, GROUP_CONCAT(d_mpl_id ORDER BY d_mpl_id) as d_mpl_id, GROUP_CONCAT(d_mpl_beban ORDER BY d_mpl_id) as d_mpl_beban, COUNT(d_mpl_kr_id) as jum_guru, GROUP_CONCAT(d_mpl_kr_id ORDER BY d_mpl_id) as d_mpl_kr_id
        FROM d_mpl
        LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
        WHERE d_mpl_kelas_id = ".$kelas_get['kelas_id']."
        GROUP BY mapel_id
        ORDER BY mapel_urutan")->result_array();


      //var_dump($this->db->last_query());

      //$data['d_mpl_all'] = $this->_d_mpl->return_all_by_kelas_id($this->input->get('_id', true));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('kelas_crud/edit_subject', $data);
      $this->load->view('templates/footer');
    }
    else {

      $sis = $this->_siswa->find_by_id($this->input->post('sis_id'));

      
      $jum_guru = $this->input->post('jum_guru');

      //var_dump($sis);

      $data = array();

      for($i=0;$i<$jum_guru;$i++){
          $data[$i] = [
            'd_mpl_mapel_id' => $this->input->post('mapel_id'),
            'd_mpl_kelas_id' => $this->input->post('kelas_id')
          ];
      }

      $this->db->insert_batch('d_mpl', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success!</div>');
      redirect('kelas_crud/edit_subject?_id='.$this->input->post('kelas_id'));
    }

  }

  public function edit_student()
  {

    $kelas_id_post = $this->input->post('kelas_id', true);
    if(!$kelas_id_post){
      $kelas_get = $this->_kelas->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update
      if (!$kelas_get['kelas_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Kelas_CRUD');
      }
    }

    $this->form_validation->set_rules('sis_id', 'Siswa Nama', 'required|trim');
    $this->form_validation->set_rules('kelas_id', 'Kelas Nama', 'required|trim');

    if ($this->form_validation->run() == false) {

      $sk_id = $this->session->userdata('kr_sk_id');

      //jika belum ada murid sama sekali

      $sis_count = $this->db->where('sis_sk_id',$sk_id)->from("sis")->count_all_results();

      if ($sis_count == 0) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please inform school administrative to add student first!</div>');
        redirect('Kelas_CRUD');
      }

      $data['title'] = 'All Students';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['kelas_all'] = $this->_kelas->find_by_id($this->input->get('_id', true));

      //var_dump($data['kelas_all']);

      //return siswa yang belum mempunyai kelas pada kelas dengan tahun ajaran
      //$data['sis_all'] = $this->_siswa->return_all_by_sk($this->session->userdata('kr_sk_id'));

      //var_dump($data['kelas_all']['kelas_t_id']);

      $data['sis_all'] = $this->db->query(
        "SELECT * FROM sis
        LEFT JOIN agama ON sis_agama_id = agama_id
        LEFT JOIN t ON sis_t_id = t_id
        LEFT JOIN sk ON sis_sk_id = sk_id
        WHERE sis_sk_id = $sk_id
        AND sis_alumni = 0
        AND sis_id NOT IN (SELECT d_s_sis_id FROM d_s
                            LEFT JOIN sis ON d_s_sis_id = sis_id
                            LEFT JOIN kelas ON d_s_kelas_id = kelas_id
                            WHERE sis_sk_id = $sk_id AND kelas_t_id = ".$data['kelas_all']['kelas_t_id'].")
        ORDER BY sis_t_id DESC, sis_nama_depan ASC")->result_array();


      //var_dump($this->db->last_query());

      $data['d_s_all'] = $this->_d_s->return_siswa_by_kelas_id($this->input->get('_id', true));

      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('kelas_crud/edit_student', $data);
      $this->load->view('templates/footer');
    }
    else {

      $sis = $this->_siswa->find_by_id($this->input->post('sis_id'));

      //var_dump($sis);
      $data = [
        'd_s_sis_id' => $this->input->post('sis_id'),
        'd_s_kelas_id' => $this->input->post('kelas_id')
      ];

      $this->db->insert('d_s', $data);
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully add '.$sis['sis_nama_depan'].'!</div>');
      redirect('kelas_crud/edit_student?_id='.$this->input->post('kelas_id'));
    }
  }

  public function update()
  {

    //dari method post
    $kelas_post = $this->input->post('_id', true);

    //jika bukan dari form update sendiri
    if (!$kelas_post) {
      //ambil id dari method get
      $kelas_get = $this->_kelas->find_by_id($this->input->get('_id', true));

      //jika langsung akses halaman update
      if (!$kelas_get['kelas_id']) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Do not access page directly, please use edit button instead!</div>');
        redirect('Kelas_CRUD');
      }
    }

    $this->form_validation->set_rules('kelas_nama', 'Kelas Nama', 'required|trim');
    $this->form_validation->set_rules('kelas_t_id', 'Kelas Tahun', 'required');

    if ($this->form_validation->run() == false) {
      //jika menekan tombol edit
      $data['title'] = 'Update Class Name';

      //data karyawan yang sedang login untuk topbar
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $data['jenj_all'] = $this->_jenj->return_all_by_sk($this->session->userdata('kr_sk_id'));

      $data['tahun_all'] = $this->_t->return_all();

      //simpan data primary key
      $kelas_id = $this->input->get('_id', true);

      $data['kelas_update'] = $this->_kelas->find_by_id($kelas_id);

      //load view dengan data query
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('kelas_crud/update', $data);
      $this->load->view('templates/footer');
    } else {
      //fetch data hasil inputan
      $data = [
        'kelas_nama' => $this->input->post('kelas_nama'),
        'kelas_jenj_id' => $this->input->post('jenj_id'),
        'kelas_t_id' => $this->input->post('kelas_t_id')
      ];

      //simpan ke db

      $this->db->where('kelas_id', $this->input->post('_id'));
      $this->db->update('kelas', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Class Data Updated!</div>');
      redirect('Kelas_CRUD');
    }
  }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jadwal_CRUD extends CI_Controller
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

    //jika bukan wakakur, kadiv
    if (
      $this->session->userdata('kr_jabatan_id') != 4 &&
      $this->session->userdata('kr_jabatan_id') != 5
    ) {
      redirect('Profile');
    }
  }

  public function index()
  {

    $data['title'] = 'Pilih Unit';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $sk_id = $this->session->userdata('kr_sk_id');
    if ($this->session->userdata('kr_jabatan_id') == 5) {
      $data['sk_all'] = $this->db->query(
        "SELECT sk_id, sk_nama
        FROM sk
        WHERE sk_type = 0
        ORDER BY sk_nama"
      )->result_array();
    } else if ($this->session->userdata('kr_jabatan_id') == 4) {
      $data['sk_all'] = $this->db->query(
        "SELECT sk_id, sk_nama
        FROM sk
        WHERE sk_id = $sk_id AND sk_type = 0"
      )->result_array();
    }

    $data['t_all'] = $this->db->query(
      "SELECT *
      FROM t
      ORDER BY t_nama DESC"
    )->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('jadwal_crud/index', $data);
    $this->load->view('templates/footer');
  }

  public function jadwal_input()
  {
    if ($this->input->post('sk_id', true)) {

      $sk_id = $this->input->post('sk_id', true);
      $t_id = $this->input->post('t_id', true);
      $kelas_id = $this->input->post('kelas_id', true);


      //cek input / update
      $cek = $this->db->query(
        "SELECT *
        FROM jampel
        WHERE jampel_kelas_id = $kelas_id
        ORDER BY jampel_hari_ke, jampel_ke"
      )->result_array();

      $data['kelas'] = $this->db->query(
        "SELECT kelas_id, kelas_nama
        FROM kelas
        WHERE kelas_id = $kelas_id"
      )->row_array();

      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      if ($cek) {
        //////////////////////////update////////////////////////
        $data['jadwal'] = $cek;

        $data['title'] = 'Update Jadwal Pelajaran';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('jadwal_crud/jadwal_update', $data);
        $this->load->view('templates/footer');
      } else {

        //////////////////////////input////////////////////////

        $data['title'] = 'Input Jadwal Pelajaran';

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('jadwal_crud/jadwal_input', $data);
        $this->load->view('templates/footer');
      }
    }
  }

  public function jadwal_input_proses()
  {
    if ($this->input->post('kelas_id', true)) {

      //cek apa jadwal kelas sudah ada sebelumnya
      $k_cek = $this->input->post('kelas_id', true);
      $cek = $this->db->query(
        "SELECT *
        FROM jampel
        WHERE jampel_kelas_id = $k_cek
        ORDER BY jampel_hari_ke, jampel_ke"
      )->result_array();

      if ($cek) {
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Jadwal di kelas ini sudah ada!</div>');
        redirect('Jadwal_CRUD');
      } else {

        //5 hari
        $indeks = 0;
        for ($i = 1; $i <= 5; $i++) {
          // echo "Hari: ".$i;
          //tiap jam
          for ($j = 1; $j <= 9; $j++) {

            // echo "<br>";
            $mapel_id = $this->input->post('m' . $i . '_' . $j, true);
            $k_id = $this->input->post('k' . $i . '_' . $j, true);
            $t = $this->input->post('t' . $i . '_' . $j, true);

            // echo "Jam ".$j.': '.$mapel_id;
            // echo "<br>";
            // echo "Kr ".$j.': '.$k_id;
            // echo "<br>";
            // echo "T ".': '.$t;

            // var_dump($k_id);

            $data[$indeks] = [
              'jampel_kelas_id' => $this->input->post('kelas_id', true),
              'jampel_mapel_id' => $mapel_id,
              'jampel_hari_ke' => $i,
              'jampel_ke' => $j,
              'jampel_jam_mulai' => $t,
              'jampel_kr_id' => $k_id
            ];

            // var_dump($data);
            $indeks++;
          }
        }

        $this->db->insert_batch('jampel', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jadwal Berhasil diinput!</div>');
        redirect('Jadwal_CRUD');
      }
    }
  }

  public function jadwal_update_proses()
  {
    if ($this->input->post('kelas_id', true)) {
      $jampel_id = $this->input->post('jampel_id[]', true);
      $jampel_mapel_id = $this->input->post('jampel_mapel_id[]', true);
      $jampel_jam_mulai = $this->input->post('jampel_jam_mulai[]', true);
      $jampel_kr_id = $this->input->post('jampel_kr_id[]', true);
      $jampel_id_aktif = $this->input->post('jampel_id_aktif[]', true);

      //var_dump($jampel_id_aktif);

      for ($j = 0; $j < count($jampel_id_aktif); $j++) {
        $data[$j] = [
          'jampel_id' => $jampel_id[$j],
          'jampel_mapel_id' => $jampel_mapel_id[$j],
          'jampel_jam_mulai' => $jampel_jam_mulai[$j],
          'jampel_kr_id' => $jampel_kr_id[$j]
        ];
      }

      $this->db->update_batch('jampel', $data, 'jampel_id');
      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Jadwal Berhasil diupdate!</div>');
      redirect('Jadwal_CRUD');
    }
  }

  public function pengumuman(){

    $data['title'] = 'Daftar Pengumuman';

    //data karyawan yang sedang login untuk topbar
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk_id'] = $this->session->userdata('kr_sk_id');

    $sk_id = $this->session->userdata('kr_sk_id');

    $data['pengumuman_all'] = $this->db->query(
      "SELECT *
      FROM pengumuman
      WHERE pengumuman_sk_id = $sk_id
      ORDER BY pengumuman_tgl DESC"
    )->result_array();


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('jadwal_crud/pengumuman', $data);
    $this->load->view('templates/footer');
  }
  public function pengumuman_input(){

    $data['title'] = 'Input Pengumuman';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['sk_id'] = $this->session->userdata('kr_sk_id');


    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('jadwal_crud/pengumuman_input', $data);
    $this->load->view('templates/footer');

  }

  public function pengumuman_input_proses(){

    if ($this->input->post('pengumuman_sk_id', true)) {

      $data = [
        'pengumuman_judul' => $this->input->post('pengumuman_judul'),
        'pengumuman_isi' => $this->input->post('pengumuman_isi'),
        'pengumuman_tgl' => $this->input->post('pengumuman_tgl'),
        'pengumuman_sk_id' => $this->input->post('pengumuman_sk_id')
      ];

      $this->db->insert('pengumuman', $data);

      //cari daftar token
      $sk_id = $this->input->post('pengumuman_sk_id');
      $judul = $this->input->post('pengumuman_judul');
      $pesan = $this->input->post('pengumuman_isi');

      $device = $this->db->query(
        "SELECT token_text
        FROM token
        LEFT JOIN sis ON sis_id = token_sis_id
        WHERE sis_sk_id = $sk_id AND sis_alumni = 0"
      )->result_array();

      $id = "";

      //echo count($device);

      $count = 1;
      foreach ($device as $d) {
        if(count($device) != $count)
          $id .= $d['token_text'].",";
        else
          $id .= $d['token_text'];
      }

      $curl = curl_init();

      $ids = '["'.$id.'"]';
      //echo $ids;

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>'{
                                "registration_ids":'.$ids.',
                                "notification": {
                                    "title":"'.$judul.'",
                                    "body":"'.$pesan.'"
                                }
                              }',
        CURLOPT_HTTPHEADER => array(
          "Content-type: application/json",
          "Authorization: key=AAAAbKcavbI:APA91bGD5dGjHcYjVVyOaI_JFK8cAsI5S9BYz5YtiK-46zRJMEp-4PXnuVVJm2OQqoQLqxzt5mosPYNvzk4AaeqLLlDjIYTnndtDirlEDRhM3Y41YkruZJfygaraD3dxsjsszvkb3Kft"
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      //echo $id;

      //var_dump($response);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pengumuman berhasil dibuat!</div>');
      redirect('jadwal_crud/pengumuman');
    }
  }

  public function pengumuman_edit(){

    if ($this->input->post('pengumuman_id', true)) {

        $data['title'] = 'Update Pengumuman';
        $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

        $pengumuman_id = $this->input->post('pengumuman_id', true);

        $data['pengumuman_all'] = $this->db->query(
          "SELECT *
          FROM pengumuman
          WHERE pengumuman_id = $pengumuman_id"
        )->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('jadwal_crud/pengumuman_update', $data);
        $this->load->view('templates/footer');
    }
  }

  public function pengumuman_update_proses(){

    if ($this->input->post('pengumuman_id', true)) {
      $data = [
        'pengumuman_judul' => $this->input->post('pengumuman_judul'),
        'pengumuman_isi' => $this->input->post('pengumuman_isi'),
        'pengumuman_tgl' => $this->input->post('pengumuman_tgl'),
      ];

      $this->db->where('pengumuman_id', $this->input->post('pengumuman_id', true));
      $this->db->update('pengumuman', $data);

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pengumuman berhasil dirubah!</div>');
      redirect('jadwal_crud/pengumuman');
    }
  }

  public function pengumuman_delete(){
    if($this->input->post('pengumuman_id', true)){
      $pengumuman_id = $this->input->post('pengumuman_id', true);

      $this->db->where('pengumuman_id', $pengumuman_id);
      $this->db->delete('pengumuman');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pengumuman berhasil dihapus!</div>');
      redirect('jadwal_crud/pengumuman');
    }
  }

  public function daftar_siswa(){
    $sk_id = $this->session->userdata('kr_sk_id');

    $data['title'] = 'Daftar perangkat yang akan mendapat pengumuman';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
    $data['device_all'] = $this->db->query(
      "SELECT sis_nama_depan, sis_nama_bel, token_device, token_last_seen, token_id
      FROM token
      LEFT JOIN sis ON sis_id = token_sis_id
      WHERE sis_sk_id = $sk_id AND sis_alumni = 0
      ORDER BY sis_nama_depan"
    )->result_array();

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('jadwal_crud/daftar_siswa', $data);
    $this->load->view('templates/footer');
  }

  public function token_delete(){
    if($this->input->post('token_id', true)){
      $token_id = $this->input->post('token_id', true);

      $this->db->where('token_id', $token_id);
      $this->db->delete('token');

      $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Device berhasil dihapus!</div>');
      redirect('jadwal_crud/pengumuman');
    }
  }

}

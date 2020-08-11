<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Classroom_CRUD extends MY_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model('_kr');
    $this->load->model('_t');

    //jika belum login
    if (!$this->session->userdata('kr_jabatan_id')) {
      redirect('auth');
    }
  }

  public function index()
  {

    $kr_id = $this->session->userdata('kr_id');

    $mapel_all = $this->db->query(
      "SELECT t_nama, sk_nama, d_mpl_mapel_id, mapel_nama, kelas_id, kelas_nama
      FROM d_mpl
      LEFT JOIN mapel ON d_mpl_mapel_id = mapel_id
      LEFT JOIN kelas ON d_mpl_kelas_id = kelas_id
      LEFT JOIN t ON kelas_t_id = t_id
      LEFT JOIN sk ON kelas_sk_id = sk_id
      WHERE d_mpl_kr_id = $kr_id
      ORDER BY t_id DESC, sk_nama, kelas_nama")->result_array();

    if(!$mapel_all){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Gagal, anda tidak mengajar kelas manapun di YPPI, silahkan hubungi wakakur</div>');
			redirect('Profile');
    }

    $accessToken = $this->session->userdata('token');

    if(!$accessToken){
      $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Silahkan logout dan login menggunakan google account</div>');
			redirect('Profile');
    }

    $client = $this->get_client();
    $client->setAccessToken($accessToken);
    if ($client->isAccessTokenExpired()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Google Account Session timeout, silahkan logout dan login kembali menggunakan google account</div>');
      redirect('Profile');
    }


    $service = new Google_Service_Classroom($client);

    //var_dump($service);

    $optParams = array(
      'pageSize' => 30
    );

    try {
      $results = $service->courses->listCourses($optParams);
    } catch (Exception $e) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Akses gagal</div>');
      redirect('Profile');
    }

    $data['title'] = 'Daftar Kelas';
    $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

    $data['results'] = $results;

    $this->load->view('templates/header', $data);
    $this->load->view('templates/sidebar', $data);
    $this->load->view('templates/topbar', $data);
    $this->load->view('Classroom_CRUD/index', $data);
    $this->load->view('templates/footer');
  }

  public function grade(){
    if ($this->input->post('classroom_id', true)) {
      $classroom_id = $this->input->post('classroom_id', true);
      $classroom_nama = $this->input->post('classroom_nama', true);

      $accessToken = $this->session->userdata('token');
      $client = $this->get_client();
      $client->setAccessToken($accessToken);

      $get_token = $accessToken['access_token'];

      //var_dump($accessToken['access_token']);

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://classroom.googleapis.com/v1/courses/$classroom_id/courseWork",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer ".$get_token
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $res = json_decode($response);

      if(isset($res->error)){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access ditolak, silahkan logout lalu login kembali dan pastikan anda mengijinkan SAS untuk mengakses classroom</div>');
        redirect('Profile');
      }else{

        //var_dump($res->courseWork);

        $data['title'] = 'Daftar Assignment '.$classroom_nama;
        $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

        if(!isset($res->courseWork)){
          $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Kelas tidak mempunyai assignment</div>');
          redirect('Classroom_CRUD');
        }

        $data['cwork'] = $res->courseWork;
        $data['t_all'] = $this->_t->return_all();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('Classroom_CRUD/assignment', $data);
        $this->load->view('templates/footer');
      }

    }
  }

  public function get_grade(){
    if ($this->input->post('ass_opt', true)) {
      $arr = explode("~",$this->input->post('ass_opt', true));

      $courseWorkId = $arr[0];
      $courseId= $arr[1];

      // echo $courseWorkId;
      // echo "<br>".$courseId;

      $accessToken = $this->session->userdata('token');
      $client = $this->get_client();
      $client->setAccessToken($accessToken);
      $get_token = $accessToken['access_token'];

      //dapatkan daftar siswa
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://classroom.googleapis.com/v1/courses/$courseId/students",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer ".$get_token
        ),
      ));
      $response = json_decode(curl_exec($curl));
      if(isset($response->error)){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access ditolak, silahkan logout lalu login kembali dan pastikan anda mengijinkan SAS untuk mengakses classroom</div>');
        redirect('Profile');
      }

      //membuat array keyNya profile id, value nya email address
      $siswa_classroom = array();
      for ($i=0; $i < count($response->students); $i++) {
        $siswa_classroom[$response->students[$i]->profile->id] = $response->students[$i]->profile->emailAddress;
      }
      curl_close($curl);

      //dapatkan nilai
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://classroom.googleapis.com/v1/courses/$courseId/courseWork/$courseWorkId/studentSubmissions",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer ".$get_token
        ),
      ));
      $response = json_decode(curl_exec($curl));

      $siswa_fix = array();
      for ($i=0; $i < count($response->studentSubmissions); $i++) {

        if(isset($response->studentSubmissions[$i]->assignedGrade))
          $siswa_fix[$siswa_classroom[$response->studentSubmissions[$i]->userId]] = $response->studentSubmissions[$i]->assignedGrade;
        else
          $siswa_fix[$siswa_classroom[$response->studentSubmissions[$i]->userId]] = 0;
      }

      ksort($siswa_fix);
      //var_dump($siswa_fix);

      curl_close($curl);

      if(isset($response->error)){
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access ditolak, silahkan logout lalu login kembali dan pastikan anda mengijinkan SAS untuk mengakses classroom</div>');
        redirect('Profile');
      }

      $data['n_class'] = $siswa_fix;

      //kelas dan mapel tujuan
      $kelas_id = $this->input->post('kelas_id', true);
      $mapel_id = $this->input->post('mapel_id', true);

      $temp = explode("~",$this->input->post('jenis_ex', true));

      //var_dump($temp);

      $jenis = $temp[0];

      $uj_count = $this->db->join('d_s', 'uj_d_s_id=d_s_id', 'left')->where('d_s_kelas_id',$kelas_id)->where('uj_mapel_id',$mapel_id)->from("uj")->count_all_results();

      //var_dump($uj_count);

      if($uj_count>0){
        $data['siswa_all'] = $this->db->query(
          "SELECT uj_id, d_s_id, sis_nama_depan, sis_email, sis_nama_bel, $jenis
          FROM uj
          LEFT JOIN d_s ON uj_d_s_id = d_s_id
          LEFT JOIN sis ON sis_id = d_s_sis_id
          LEFT JOIN agama ON sis_agama_id = agama_id
          WHERE d_s_kelas_id = $kelas_id AND uj_mapel_id = $mapel_id
          ORDER BY sis_nama_depan")->result_array();
      }else{
        $data['siswa_all'] = $this->db->query(
          "SELECT d_s_id, sis_nama_depan, sis_email, sis_nama_bel
          FROM d_s
          LEFT JOIN sis ON d_s_sis_id = sis_id
          WHERE d_s_kelas_id = $kelas_id
          ORDER BY sis_nama_depan")->result_array();
      }

      //echo $this->db->last_query();

      $data['title'] = 'Transfer Nilai';
      $data['jenis'] = $jenis;
      $data['judul'] = $temp[1];
      $data['kelas_id'] = $kelas_id;
      $data['mapel_id'] = $mapel_id;
      $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
      $this->load->view('templates/header', $data);
      $this->load->view('templates/sidebar', $data);
      $this->load->view('templates/topbar', $data);
      $this->load->view('Classroom_CRUD/transfer', $data);
      $this->load->view('templates/footer');

    }
  }

  public function set_uj(){
    if($this->input->post('nil[]', true)){
      $uj_id = $this->input->post('uj_id[]', true);
      $d_s_id = $this->input->post('d_s_id[]', true);
      $nil = $this->input->post('nil[]', true);
      $kelas_id = $this->input->post('kelas_id', true);
      $mapel_id = $this->input->post('mapel_id', true);
      $jenis = $this->input->post('jenis', true);
      //cek apakah sudah ada Nilai
      $uj_count = $this->db->join('d_s', 'uj_d_s_id=d_s_id', 'left')->where('d_s_kelas_id',$kelas_id)->where('uj_mapel_id',$mapel_id)->from("uj")->count_all_results();

      if($uj_count>0){
        //jika sudah maka update

        for($i=0;$i<count($uj_id);$i++){

          $data[$i] = [
            $jenis => $nil[$i],
            'uj_id' =>  $uj_id[$i]
          ];
        }

        //var_dump($data);
        $this->db->update_batch('uj',$data, 'uj_id');
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berhasil melakukan import!</div>');
        redirect('Profile');
      }else{
        //jika belum insert
        for($i=0;$i<count($d_s_id);$i++){
          $data[$i] = [
            'uj_d_s_id' => $d_s_id[$i],
            $jenis => $nil[$i],
            'uj_mid1_kog_persen' => 50,
            'uj_mid1_psi_persen' => 50,
            'uj_fin1_kog_persen' => 50,
            'uj_fin1_psi_persen' => 50,
            'uj_mid2_kog_persen' => 50,
            'uj_mid2_psi_persen' => 50,
            'uj_fin2_kog_persen' => 50,
            'uj_fin2_psi_persen' => 50,
            'uj_mapel_id' => $this->input->post('mapel_id')
          ];
        }
        $this->db->insert_batch('uj', $data);
        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">Berhasil melakukan import!</div>');
        redirect('Profile');
      }
    }

  }

}

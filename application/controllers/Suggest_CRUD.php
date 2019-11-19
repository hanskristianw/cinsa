<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suggest_CRUD extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('_kr');

        //jika belum login
        if (!$this->session->userdata('kr_jabatan_id')) {
            redirect('Auth');
        }
    }

    public function index()
    {

        $data['title'] = 'Suggestion';
        $kr_id = $this->session->userdata('kr_id');
        //data karyawan yang sedang login untuk topbar
        $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('suggest_crud/index', $data);
        $this->load->view('templates/footer');
    }

    public function input()
    {

        $kelas_scout_id = $this->input->post('kelas_id', true);

        if ($kelas_scout_id) {

            $data['title'] = 'Nilai Pramuka';

            $data['kr'] = $this->_kr->find_by_username($this->session->userdata('kr_username'));
            $data['siswa_all'] = $this->db->query(
                "SELECT d_s_id, sis_nama_depan, sis_nama_bel, sis_no_induk, d_s_scout_nilai, d_s_scout_nilai2, kelas_nama
        FROM d_s
        LEFT JOIN sis ON d_s_sis_id = sis_id
        LEFT JOIN kelas ON d_s_kelas_id = kelas_id
        WHERE d_s_kelas_id = $kelas_scout_id ORDER BY sis_no_induk, sis_nama_depan"
            )->result_array();

            if (!$data['siswa_all']) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">No Student, add one or more student!</div>');
                redirect('Scout_crud');
            }

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('scout_crud/input', $data);
            $this->load->view('templates/footer');
        } else {
            redirect('Profile');
        }
    }

    public function save_input()
    {
        if ($this->input->post('d_s_id[]')) {
            $data = array();
            $d_s_scout_nilai = $this->input->post('d_s_scout_nilai[]');
            $d_s_scout_nilai2 = $this->input->post('d_s_scout_nilai2[]');
            $d_s_scout_komen1 = $this->input->post('d_s_scout_komen1[]');
            $d_s_scout_komen2 = $this->input->post('d_s_scout_komen2[]');
            $d_s_id = $this->input->post('d_s_id[]');

            for ($i = 0; $i < count($d_s_id); $i++) {
                $data[$i] = [
                    'd_s_scout_nilai' => $d_s_scout_nilai[$i],
                    'd_s_scout_nilai2' => $d_s_scout_nilai2[$i],
                    'd_s_id' =>  $d_s_id[$i]
                ];
            }
            $this->db->update_batch('d_s', $data, 'd_s_id');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success!</div>');
            redirect('Scout_crud');
        }
    }
}

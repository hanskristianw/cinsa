<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Suggest_CRUD extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('_kr');

        //jika belum login
        if ($this->session->userdata('kr_jabatan_id') == 5 || $this->session->userdata('kr_jabatan_id') == 8) {
            redirect('Auth');
        }

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

    public function add()
    {

        if ($this->input->post('suggest_jabatan_id', true)) {

            $suggest_kr_id;
            if($this->input->post('suggest_kr_id', true) == ""){
                $suggest_kr_id = NULL;
            }else{
                $suggest_kr_id = $this->input->post('suggest_kr_id', true);
            }

            $data = [
                'suggest_jabatan_id' => $this->input->post('suggest_jabatan_id',true),
                'suggest_kr_id' => $suggest_kr_id,
                'suggest_pesan' => $this->input->post('suggest_pesan',true)
            ];
            
            $this->db->insert('suggest', $data);
    
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pesan berhasil dikirimkan!</div>');
            redirect('suggest_CRUD');
        } else {
            redirect('Profile');
        }
    }
}

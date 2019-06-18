<?php

class _bulan extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function return_all()
    {
        return $this->db->order_by("bulan_id", "ASC")->get('bulan')->result_array();
    }
}

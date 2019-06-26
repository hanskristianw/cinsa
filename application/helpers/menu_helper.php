<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function cetak(){
  $ci =& get_instance();
  $ci->load->model('_kr');

  $kr = $ci->_kr->find_by_username($ci->session->userdata('kr_username'));
  return $kr;
}
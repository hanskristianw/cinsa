<?php

  class MY_Controller Extends CI_Controller
  {

   private $default_theme = 'theme';

   private $obj_gclient = NULL;

   public function __construct()
   {
      parent::__construct();
      
  		$gClient = new Google_Client();

  		$gClient->setClientID("747929668230-cl82u0sfcpejrr5nrnqhlhos7h001rpc.apps.googleusercontent.com");
  		$gClient->setClientSecret("LcjOpST0SGB7FMPKMOSQKtFR");

  		$gClient->setApplicationName("Sistem Administrasi Sekolah");
  		$gClient->setRedirectUri(base_url('auth/auth_google'));
			$gClient->setAccessType('offline');

      $this->obj_gclient = $gClient;
   }

   public function set_client($pass){
     $this->obj_gclient = $pass;
   }

   public function get_client(){
     return $this->obj_gclient;
   }


  }

?>

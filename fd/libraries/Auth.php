<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth {

    protected $CI;

    public function __construct() {
        $this->CI =&get_instance();
    }

    public function logged_in()
    {
      return (bool) $this->CI->session->userdata('hospitaladmin');
    }

    public function login($user_id) {
        $this->CI->session->set_userdata('user_id', $user_id);
    }

    public function logout()
    {
      $this->CI->session->unset_userdata('hospitaladmin');
      $this->CI->session->sess_destroy();
    }
}

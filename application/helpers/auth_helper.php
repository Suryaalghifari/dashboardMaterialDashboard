<?php defined('BASEPATH') OR exit('No direct script access allowed');

function check_login()
{
    $CI =& get_instance();
    $user = $CI->session->userdata('user');
    if (!$user) {
        redirect('login');
        exit;
    }
}

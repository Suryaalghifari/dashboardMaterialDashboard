<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends MX_Controller {
  public function __construct()
    {
        parent::__construct();
        check_login(); // <<-- cek login di setiap akses dashboard
    }
  public function profile() {
    $data['title'] = 'Profile';
    $data['content_view'] = 'account/profile';
    $this->load->view('layout/master', $data);
  }
  public function settings() {
    $data['title'] = 'Settings';
    $data['content_view'] = 'account/settings';
    $this->load->view('layout/master', $data);
  }
}

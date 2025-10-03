<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
     public function __construct()
    {
        parent::__construct();
        check_login(); // <<-- cek login di setiap akses dashboard
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['content_view'] = 'dashboard/index';
        $this->load->view('layout/master', $data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Analytics extends MX_Controller {
    public function __construct()
    {
        parent::__construct();
        check_login(); // <<-- cek login di setiap akses dashboard
    }
    public function index() {
        $data['title'] = 'Analyticsss';
        $data['content_view'] = 'pages/analytics';
        $this->load->view('layout/master', $data);
    }
}

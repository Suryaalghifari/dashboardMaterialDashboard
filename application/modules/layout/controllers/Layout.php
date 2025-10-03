<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Layout extends MX_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->library('session');
        check_login(); // <<-- cek login di setiap akses dashboard
    }

    // $content_view contoh: 'dashboard/index'
    public function render($content_view, $data = []){
        $data['content_view'] = $content_view;
        $this->load->view('layout/master', $data);
    }
}

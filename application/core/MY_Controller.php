<?php defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'third_party/MX/Controller.php';

class MY_Controller extends MX_Controller {
     public function __construct()
    {
        parent::__construct();
        // cegah cache
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
        $this->output->set_header("Pragma: no-cache");
    }

}


class Auth_Controller extends MY_Controller {
    protected $current_user = null;
    public function __construct(){
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form']);
        $this->current_user = $this->session->userdata('user') ?: null;
    }
    protected function require_login(){
        if(!$this->current_user){
            $this->session->set_flashdata('error','Silakan login dulu.');
            redirect('login');
        }
    }
}

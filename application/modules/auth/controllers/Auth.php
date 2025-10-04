<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MX_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->library(['session','form_validation']);
        $this->load->model('auth/Login_model', 'login_m');
        $this->load->model('auth/Register_model', 'register_m');
    }
     public function index()
    {
       
        redirect('login');
    }


    /* ========== LOGIN ========== */
    public function login(){
        if ($this->input->method() === 'post') return $this->_handle_login();
        $this->_render_auth('signin', ['title' => 'Sign In']);
    }

    private function _handle_login(){
        $this->form_validation->set_rules('email','Email','required|valid_email');
        $this->form_validation->set_rules('password','Password','required|min_length[6]');
        if (!$this->form_validation->run()){
            return $this->_render_auth('signin', ['title' => 'Sign In']);
        }

        $email = (string)$this->input->post('email');
        $pass  = (string)$this->input->post('password');

        $user = $this->login_m->authenticate($email, $pass);
        if (!$user){
            $this->session->set_flashdata('error','Email atau password salah.');
            return redirect('login');
        }

        $this->session->set_userdata('user', [
            'id' => (int)$user->id,
            'name' => $user->name,
            'email' => $user->email
        ]);
        $this->session->set_flashdata('welcome', 'Selamat datang, '.$user->name.'!'); 
        return redirect('dashboard');
        
    }

    /* ========== REGISTER ========== */
    public function register(){
        if ($this->input->method() === 'post') return $this->_handle_register();
        $this->_render_auth('register', ['title' => 'Sign Up']);
    }

    private function _handle_register(){
    $this->form_validation->set_rules('name','Nama','required|min_length[3]');
    $this->form_validation->set_rules('email','Email','required|valid_email');
    $this->form_validation->set_rules('password','Password','required|min_length[6]');
    $this->form_validation->set_rules('password_confirm','Konfirmasi Password','required|matches[password]');

        if (!$this->form_validation->run()){
            if ($this->input->is_ajax_request()) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'success' => false,
                        'message' => validation_errors()
                    ]));
            }
            return $this->_render_auth('register');
        }

        try {
            $this->register_m->register(
                (string)$this->input->post('name'),
                (string)$this->input->post('email'),
                (string)$this->input->post('password')
            );
        } catch (Exception $e){
            if ($this->input->is_ajax_request()) {
                return $this->output
                    ->set_content_type('application/json')
                    ->set_output(json_encode([
                        'success' => false,
                        'message' => $e->getMessage()
                    ]));
            }
            $this->session->set_flashdata('error',$e->getMessage());
            return redirect('register');
        }

        if ($this->input->is_ajax_request()) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'success' => true,
                    'message' => 'Registrasi berhasil, silakan login.'
                ]));
        }

        // fallback non-AJAX
        $this->session->set_flashdata('success','Registrasi berhasil, silakan login.');
        redirect('login');
    }


    /* ========== LOGOUT ========== */
    public function logout(){
        $this->session->unset_userdata('user');
        $this->session->sess_destroy();
        redirect('login');
    }

    /* ========== GLOBAL MODAL (AJAX contoh) ========== */
    public function modal_terms(){
        if(!$this->input->is_ajax_request()){ show_404(); return; }
        $json = [
            'title'  => 'Terms & Conditions',
            'body'   => '<p>Dengan membuat akun, Anda menyetujui S&K dan Kebijakan Privasi.</p>',
            'footer' => '<button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>',
            'size'   => 'modal-lg'
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    /* ========== UTIL ========== */
    private function _render_auth($view, $data = []){
        $data['content_view'] = 'auth/'.$view;
        $this->load->view('auth/layouts/auth_layout', $data);
    }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth/User_model');
    }

    /**
     * Autentikasi user
     * @return object|false  objek user jika sukses, false jika gagal
     */
    public function authenticate(string $email, string $password) {
        $email = strtolower(trim($email));
        $user  = $this->User_model->find_by_email($email);

        if (!$user) return false;
        if (!$user->is_active) return false;
        if (!password_verify($password, $user->password_hash)) return false;

        // update last_login
        $this->User_model->touch_last_login((int)$user->id);
        return $user;
    }
}

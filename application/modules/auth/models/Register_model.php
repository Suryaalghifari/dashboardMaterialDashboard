<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Register_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('auth/User_model');
    }

    /**
     * Registrasi user baru
     * @throws Exception jika email sudah terdaftar
     * @return int insert_id
     */
    public function register(string $name, string $email, string $password) {
        $email = strtolower(trim($email));

        // cek apakah email sudah ada
        if ($this->User_model->find_by_email($email)) {
            throw new Exception('Email sudah terdaftar.');
        }

        $data = [
            'name'          => trim($name),
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'is_active'     => 1,
        ];
        return $this->User_model->create($data);
    }
}

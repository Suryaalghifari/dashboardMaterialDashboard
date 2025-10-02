<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    protected $table = 'users';

    public function find_by_email(string $email) {
        return $this->db->get_where($this->table, ['email' => $email])->row();
    }

    public function create(array $data) {
        $now = date('Y-m-d H:i:s');
        $data['created_at'] = $data['created_at'] ?? $now;
        $data['updated_at'] = $data['updated_at'] ?? $now;
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function touch_last_login(int $user_id) {
        return $this->db->update($this->table, [
            'last_login' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ], ['id' => $user_id]);
    }
}

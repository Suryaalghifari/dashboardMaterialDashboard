<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Repository untuk chat_sessions & chat_messages
 * - Simpan/ambil sesi
 * - Simpan pesan
 * - Ambil history (rewritten_question) untuk payload API
 * - Ambil profil user (dari tabel users)
 */
class Chat_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Buat sesi chat baru untuk user
     * @param int $user_id
     * @return int insert_id
     */
    public function create_session($user_id)
    {
        $this->db->insert('chat_sessions', [
            'user_id'     => (int) $user_id,
            'started_at'  => date('Y-m-d H:i:s'),
            'last_active' => date('Y-m-d H:i:s'),
        ]);
        return (int) $this->db->insert_id();
    }

    /**
     * Update last_active pada sesi
     * @param int $session_id
     * @return bool
     */
    public function touch_session($session_id)
    {
        $this->db->where('id', (int) $session_id)
                 ->update('chat_sessions', ['last_active' => date('Y-m-d H:i:s')]);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Tambah pesan baru
     * @param int         $session_id
     * @param 'user'|'assistant' $role
     * @param string      $content
     * @param ?string     $rewritten_question
     * @return int insert_id
     */
    public function add_message($session_id, $role, $content, $rewritten_question = null)
    {
        $this->db->insert('chat_messages', [
            'session_id'         => (int) $session_id,
            'role'               => $role === 'assistant' ? 'assistant' : 'user',
            'content'            => (string) $content,
            'rewritten_question' => $rewritten_question !== null ? (string) $rewritten_question : null,
            'created_at'         => date('Y-m-d H:i:s'),
        ]);
        return (int) $this->db->insert_id();
    }

    /**
     * Update pesan user terakhir pada sesi ini dengan rewritten_question dari API
     * @param int $session_id
     * @param ?string $rewritten
     * @return bool
     */
    public function update_last_user_rewritten($session_id, $rewritten)
    {
        if ($rewritten === null || trim($rewritten) === '') return false;

        $row = $this->db->select('id')
                        ->from('chat_messages')
                        ->where('session_id', (int) $session_id)
                        ->where('role', 'user')
                        ->order_by('id', 'DESC')
                        ->limit(1)
                        ->get()
                        ->row_array();

        if (!$row) return false;

        $this->db->where('id', (int) $row['id'])
                 ->update('chat_messages', ['rewritten_question' => (string) $rewritten]);

        return $this->db->affected_rows() > 0;
    }

    /**
     * Ambil N rewritten_question terakhir (lama → baru) untuk payload API
     * @param int $session_id
     * @param int $limit
     * @return array messages: [ ['role'=>'user','content'=>'...'], ... ]
     */
    public function get_rewritten_history($session_id, $limit = 5)
    {
        $limit = max(1, (int) $limit);

        $rows = $this->db->select('rewritten_question')
                         ->from('chat_messages')
                         ->where('session_id', (int) $session_id)
                         ->where('rewritten_question IS NOT NULL', null, false)
                         ->order_by('id', 'DESC')
                         ->limit($limit)
                         ->get()
                         ->result_array();

        // urutkan lama -> baru
        $rows = array_reverse($rows);

        $messages = [];
        foreach ($rows as $r) {
            $rq = trim((string) $r['rewritten_question']);
            if ($rq !== '') {
                $messages[] = ['role' => 'user', 'content' => $rq];
            }
        }
        return $messages;
    }

    /**
     * (Opsional) Ambil beberapa pesan terakhir untuk ditampilkan/diagnostik
     * @param int $session_id
     * @param int $limit
     * @return array
     */
    public function get_last_messages($session_id, $limit = 50)
    {
        return $this->db->from('chat_messages')
                        ->where('session_id', (int) $session_id)
                        ->order_by('id', 'DESC')
                        ->limit(max(1, (int) $limit))
                        ->get()
                        ->result_array();
    }


    /**
     * Ambil profil user dari tabel users
     * @param int $user_id
     * @return array|null
     */
    public function get_user_profile($user_id)
    {
        $row = $this->db->select('id,name,email,created_at,last_login,is_active,updated_at')
                        ->from('users')
                        ->where('id', (int) $user_id)
                        ->limit(1)
                        ->get()
                        ->row_array();
        return $row ?: null;
    }

    public function build_user_context($user_id, array $keys)
    {
        $u = $this->get_user_profile($user_id);
        if (!$u) return '';

        $ctx = [];
        foreach ($keys as $k) {
            if (array_key_exists($k, $u) && $u[$k] !== null) {
                $ctx[$k] = $u[$k];
            }
        }
        // standardkan tanggal ke ISO biar LLM mudah cerna
        foreach (['created_at','last_login','updated_at'] as $ts) {
            if (!empty($ctx[$ts])) $ctx[$ts] = date('c', strtotime($ctx[$ts]));
        }

        // format JSON agar engine mudah konsumsi
        return json_encode(['user'=>$ctx], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
}

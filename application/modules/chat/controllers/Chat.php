<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat extends MX_Controller
{
    /** @var Chat_service */
    protected $service;
    /** @var Chat_model */
    protected $chat_repo; // ← konsisten: pakai chat_repo

    public function __construct(){
        parent::__construct();
        $this->load->helper(['url']);
        $this->load->library(['session']);
        $this->load->database();

        if (!isset($this->chat_repo) || !is_object($this->chat_repo))
        $this->load->model('chat/Chat_model', 'chat_repo');

        // Service sekali saja (jangan re-new di method)
        require_once APPPATH.'modules/chat/services/Chat_service.php';
        $this->service = new Chat_service();
    }

    public function widget(){
        $user = $this->session->userdata('user');
        $data = [
            'badgeCount' => 1,
            'user_name'  => $user['name'] ?? 'Teman'
        ];
        $this->load->view('chat/widget', $data);
    }

    public function open(){
        $user = $this->session->userdata('user');
        if (!$user) return $this->_json(['ok'=>false,'error'=>'Not logged in'], 401);

        $out = $this->service->open_or_resume_session($user);

        $limit = (int)$this->input->get('limit') ?: 50;

        // AMBIL HISTORY VIA SERVICE (bukan via $this->chat_repo lagi)
        $rows = $this->service->get_history($out['session_id'], $limit); // DESC
        $rows = array_reverse($rows); // → ASC

        $messages = array_map(function($r){
            return [
                'role'       => $r['role'],
                'content'    => $r['content'],
                'created_at' => $r['created_at'],
            ];
        }, $rows);

        return $this->_json(['ok'=>true] + $out + ['messages'=>$messages]);
    }


    public function send(){
        $user  = $this->session->userdata('user');
        if (!$user) return $this->_json(['ok'=>false,'error'=>'Not logged in'], 401);

        $text  = trim($this->input->post('message', true) ?? '');
        $debug = ($this->input->get('debug') === '1');

        $out = $this->service->handle_message($user, $text, ['debug'=>$debug]);

        return $this->_json(['ok'=>true] + $out);
    }

    private function _json($arr,$status=200){
        return $this->output->set_status_header($status)
            ->set_content_type('application/json')
            ->set_output(json_encode($arr));
    }
}

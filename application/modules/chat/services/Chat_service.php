<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_service
{
    /** @var CI_Controller */
    protected $CI;
    /** @var Chat_model */
    protected $repo;
    /** @var Chat_api_client */
    protected $api;
    /** @var CI_Session */
    protected $session;
    /** @var CI_Config */
    protected $config;

    public function __construct(){
        $this->CI = &get_instance();
        $this->CI->load->model('chat/Chat_model','repo');
        $this->CI->load->model('chat/Chat_api_client','api');
        $this->CI->load->library('session');
        $this->CI->config->load('chatbot', true);
        $this->CI->load->helper('chat/chat_intent');

       
        $this->repo    = $this->CI->repo;   
        $this->api     = $this->CI->api;
        $this->session = $this->CI->session;
        $this->config  = $this->CI->config;
    }

   
    private function cfg($k,$d=null){
        $v=$this->config->item($k,'chatbot');
        if($v===NULL) $v=$this->config->item($k);
        return $v===NULL?$d:$v;
    }

    
    private function fmt_wib($ts){
        $bulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $t = is_numeric($ts) ? (int)$ts : strtotime($ts ?: 'now');
        return sprintf('%02d %s %s %s WIB',
            (int)date('d',$t), $bulan[(int)date('n',$t)-1], date('Y',$t), date('H.i',$t)
        );
    }
    private function cache_get($q){
        $m = $this->session->userdata('chat_cache') ?: [];
        return $m[mb_strtolower(trim((string)$q))] ?? null;
    }
    private function cache_put($q,$reply){
        $key = mb_strtolower(trim((string)$q));
        $m = $this->session->userdata('chat_cache') ?: [];
        $m[$key] = $reply;
        if (count($m) > 30) array_shift($m); // LRU sederhana
        $this->session->set_userdata('chat_cache', $m);
    }

    public function open_or_resume_session($user){
        $sid = $this->session->userdata('chat_session_id');
        if (!$sid) {
            $sid = $this->repo->create_session($user['id']);
            $this->session->set_userdata('chat_session_id', $sid);
        } else {
            $this->repo->touch_session($sid);
        }
        return ['session_id'=>$sid, 'user_name'=>$user['name'] ?? 'Teman'];
    }

    public function get_history($session_id, $limit = 50)
    {
        $session_id = (int)$session_id;
        $limit      = max(1, (int)$limit);
        return $this->repo->get_last_messages($session_id, $limit);
    }

    public function handle_message($user, $text, array $opts = [])
    {
        $debug       = !empty($opts['debug']);
        $forceRemote = !empty($opts['force_remote']);   // override manual dari controller (opsional)

        $text = trim((string)$text);
        if ($text === '') {
            return ['reply' => 'Pesan kosong.'];
        }

        // ===== CACHE HIT? hemat token & waktu =====
        if ($hit = $this->cache_get($text)) {
            return ['reply'=>$hit, 'source'=>'cache'];
        }

        // --- pastikan ada session id ---
        $sid = (int)$this->session->userdata('chat_session_id');
        if (!$sid) {
            $sid = $this->repo->create_session($user['id']);
            $this->session->set_userdata('chat_session_id', $sid);
        }

        // simpan pesan user (rewritten belum ada)
        $this->repo->add_message($sid, 'user', $text, null);

        // --- prefix untuk paksa remote, mis. "! pertanyaan" ---
        $prefix = (string)$this->cfg('chatbot_force_remote_prefix','!');
        if (!$forceRemote && $prefix && isset($text[0]) && $text[0] === $prefix) {
            $forceRemote = true;
            $text = ltrim(substr($text, 1));
        }

        // --- intent lokal (boleh dimatikan via config/prefix) ---
        $enableLocal = (bool)$this->cfg('chatbot_enable_local_intents', true);
        if ($enableLocal && !$forceRemote) {
            if ($reply = $this->maybe_answer_locally($user['id'], $text)) {
                $this->repo->add_message($sid,'assistant',$reply,null);
                $this->cache_put($text, $reply); // simpan cache
                $out = ['reply'=>$reply,'source'=>'local'];
                if ($debug) $out['debug'] = ['outbound_payload'=>null,'provider'=>'local'];
                return $out;
            }
        }

        // --- payload REAL untuk provider ---
        $payload  = $this->build_payload($sid, $user['id'], $text);
        $provider = strtolower($this->cfg('chatbot_provider','gemini'));

        // offline mode?
        if (!(bool)$this->cfg('chatbot_use_remote', true)) {
            $summary = 'Mode offline: '.$text;
            $this->repo->add_message($sid,'assistant',$summary,null);
            $this->cache_put($text, $summary);
            $out = ['reply'=>$summary,'source'=>'offline'];
            if ($debug) $out['debug'] = ['outbound_payload'=>$payload,'provider'=>'offline'];
            return $out;
        }

        // --- panggil API provider ---
        $apiRes = [];
        try {
            $apiRes = $this->api->call($payload);   
        } catch (\Throwable $e) {
            log_message('error','[CHAT] API error: '.$e->getMessage());
            $apiRes = ['ok'=>false,'error'=>$e->getMessage()];
        }

        if (empty($apiRes['ok'])) {
            $fail = 'Maaf, sistem sedang sibuk. Coba lagi sebentar lagi.';
            $this->repo->add_message($sid,'assistant',$fail,null);
            $this->cache_put($text, $fail);
            $out = ['reply'=>$fail,'source'=>'remote-error'];
            if ($debug) $out['debug'] = [
                'outbound_payload'=>$payload,
                'provider'=>$provider,
                'remote_debug'=>$apiRes['debug']??null,
                'error'=>$apiRes['error']??null
            ];
            return $out;
        }

        // --- normalisasi response agar selalu lengkap ---
        $d = $apiRes['data'] + [
            'original_question'  => $text,
            'rewritten_question' => $text,
            'sql_query'          => '',
            'results'            => ['success'=>false,'data'=>[],'query'=>'','row_count'=>0],
            'summary'            => 'Oke.'
        ];

        // simpan rewritten utk memori turn berikutnya
        if (!empty($d['rewritten_question'])) {
            $this->repo->update_last_user_rewritten($sid, $d['rewritten_question']);
        }

        // ===== Normalisasi jawaban + jaga tetap Bahasa Indonesia =====
        $reply = trim((string)$d['summary']);
        if ($reply === '') {
            $reply = 'Maaf, saya belum mendapat jawabannya. Coba ulangi pertanyaannya.';
        }
        // guard ringan; jika tercium Inggris banget, tetap beri pembuka Indonesia
        if (preg_match('/\b(Your|The|is|are|was|were|I am|I\'m)\b/i',$reply)) {
            $reply = 'Berikut jawabannya: '.$reply;
        }

        // simpan balasan assistant (content = reply final) + cache
        $this->repo->add_message($sid,'assistant',$reply,$d['rewritten_question']);
        $this->cache_put($text, $reply);

        $out = ['reply'=>$reply,'api'=>$d,'source'=>'remote','provider'=>$provider];
        if ($debug) $out['debug'] = [
            'outbound_payload'=>$payload,
            'provider'=>$provider,
            'remote_debug'=>$apiRes['debug']??null,
            'normalized_api'=>$d
        ];
        return $out;
    }

    private function maybe_answer_locally($user_id, $text){
         $intent = detect_user_intent($text);
        if (!$intent['type']) return null;

        // 1) Sapaan (tidak butuh remote)
        if ($intent['type'] === 'greeting') {
            $u  = $this->repo->get_user_profile($user_id);
            $nm = $u ? $u['name'] : 'Teman';
            return "Halo $nm! Ada yang bisa saya bantu?";
        }

        // 2) Small talk ringkas (hemat token)
        if ($intent['type'] === 'chat.thanks') return 'Sama-sama, senang bisa membantu 😊';
        if ($intent['type'] === 'chat.ack')    return 'Oke 👍';

        // 3) Nama bot (dibedakan dari nama pengguna)
        if ($intent['type'] === 'bot.name') {
            $bot = (string)$this->cfg('chatbot_bot_name', 'Asisten');
            return 'Nama saya: '.$bot;
        }

        // 4) Intent yang perlu data pengguna dari DB
        $u = $this->repo->get_user_profile($user_id);
        if (!$u) return 'Maaf, data akun tidak ditemukan.';

        switch ($intent['type']) {
            case 'user.created_at':
                // fmt_wib() adalah helper di class ini untuk format Indonesia
                return 'Akun Anda dibuat pada: '.$this->fmt_wib($u['created_at']);

            case 'user.last_login':
                return $u['last_login']
                    ? 'Login terakhir: '.$this->fmt_wib($u['last_login'])
                    : 'Belum ada data login.';

            case 'user.name':
                return 'Nama Anda: '.$u['name'];

            case 'user.email':
                return 'Email Anda: '.$u['email'];

            case 'user.who_is_logged_in':
                return 'Pengguna yang sedang login: '.$u['name'].' ('.$u['email'].')';
        }

        // tidak ada yang cocok → biarkan remote yang jawab
        return null;
    }
    private function build_payload($session_id, $user_id, $user_question)
    {
        
        $limit = (int)$this->cfg('chatbot_history_limit', 3);
        $msgs  = [];

        
        $msgs[] = [
            'role'=>'system',
            'content'=>'Balas SELALU dalam Bahasa Indonesia yang ringkas (maksimal 1–3 kalimat). Jika tidak yakin, minta klarifikasi singkat.'
        ];

        
        if ((bool)$this->cfg('chatbot_include_profile_context', true)) {
            $keys = (array)$this->cfg('chatbot_profile_context_keys', []);
            $ctx  = $this->repo->build_user_context($user_id, $keys); 
            if ($ctx) {
                $msgs[] = ['role'=>'system', 'content'=>'[KONTEKS] '.$ctx];
            }
        }

   
        $history = $this->repo->get_rewritten_history($session_id, $limit);
        foreach ($history as $m) {
            $msgs[] = ['role'=>$m['role'], 'content'=>$m['content']];
        }

        return [
            'history'       => [ ['messages'=>$msgs] ],
            'user_question' => (string)$user_question
        ];
    }
}

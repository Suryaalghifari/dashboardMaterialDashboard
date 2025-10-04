<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_api_client extends CI_Model
{
  public function __construct(){
    parent::__construct();
    $this->config->load('chatbot', true);
  }

  
  private function cfg($key, $default=null){
    $v = $this->config->item($key, 'chatbot'); 
    if ($v === NULL) $v = $this->config->item($key); 
    return ($v === NULL) ? $default : $v;
  }

  
  public function call(array $payload){
    $provider = strtolower($this->cfg('chatbot_provider', 'gemini'));
    if ($provider === 'gemini') return $this->call_gemini($payload);
    
    return ['ok'=>false, 'error'=>'Unknown provider'];
  }

  private function call_gemini(array $payload){
    $model = $this->cfg('gemini_model', 'gemini-2.5-flash');
    $apiKey = $this->cfg('gemini_api_key', '');
    if (!$apiKey) return ['ok'=>false, 'error'=>'Missing GEMINI_API_KEY'];

    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";


    $contents = [];

    
    $system_instruction = [
      'role'  => 'user',
      'parts' => [[ 'text' =>
        "Kamu adalah asisten analitik. Jawab SELALU dalam JSON dengan struktur:\n".
        "{\n".
        '  "original_question": string,'."\n".
        '  "rewritten_question": string,'."\n".
        '  "sql_query": string,'."\n".
        '  "results": {"success": boolean, "data": [], "query": string, "row_count": number},'."\n".
        '  "summary": string'."\n".
        "}\n".
        "Jika tidak yakin, set success=false, data=[] dan jelaskan singkat di summary. Dilarang mengirim teks selain JSON."
      ]]
    ];
    $contents[] = $system_instruction;

    
    $hist = $payload['history'][0]['messages'] ?? [];
    foreach ($hist as $m){
      $txt = (string)($m['content'] ?? '');
      if ($txt !== '') $contents[] = [ 'role'=>'user', 'parts'=>[[ 'text'=>$txt ]] ];
    }

    
    $uq = (string)($payload['user_question'] ?? '');
    if ($uq !== '') {
      
      $contents[] = [ 'role'=>'user', 'parts'=>[[ 'text'=>"ORIGINAL_QUESTION: ".$uq ]] ];
    }

    $body = [
      'contents' => $contents,
      'generationConfig' => [
        'temperature' => 0.3,
        'response_mime_type' => 'application/json'
      ]
    ];

    
    $ch = curl_init($url);
    curl_setopt_array($ch, [
      CURLOPT_RETURNTRANSFER=>true,
      CURLOPT_POST=>true,
      CURLOPT_HTTPHEADER=>['Content-Type: application/json'],
      CURLOPT_POSTFIELDS=>json_encode($body, JSON_UNESCAPED_UNICODE),
      CURLOPT_TIMEOUT=>25,
    ]);
    $resp = curl_exec($ch);
    $err  = curl_error($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($err) return ['ok'=>false, 'error'=>$err];

    $json = json_decode($resp, true);
    if (!is_array($json) || empty($json['candidates'][0]['content']['parts'][0]['text'])) {
      return ['ok'=>false, 'error'=>"Bad response", 'raw'=>$resp];
    }

    $text = $json['candidates'][0]['content']['parts'][0]['text'];
    $parsed = json_decode($text, true);

    if (is_array($parsed)) {
      return ['ok'=>true, 'data'=>$parsed];
    }

    
    return [
      'ok'=>true,
      'data'=>[
        'original_question'  => $uq,
        'rewritten_question' => $uq,
        'sql_query'          => '',
        'results'            => ['success'=>false,'data'=>[],'query'=>'','row_count'=>0],
        'summary'            => trim($text)
      ],
      'raw'=>$json
    ];
  }
}

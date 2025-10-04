<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['chatbot_use_remote']              = TRUE;  
$config['chatbot_provider']                = 'gemini';

$config['gemini_model']                    = 'gemini-2.5-flash';
$config['gemini_api_key']                  = getenv('GEMINI_API_KEY') ?: 'AIzaSyCaDYhUPHbnPJzEe1YN_i6t4QYcLHgoHnE';

$config['chatbot_bot_name']                = 'Telkom Assistant';

$config['chatbot_history_limit']           = 3;


$config['chatbot_enable_local_intents']    = TRUE;


$config['chatbot_include_profile_context'] = TRUE;
$config['chatbot_profile_context_keys']    = ['id','name','email','created_at','last_login'];


$config['chatbot_force_remote_prefix']     = '!';






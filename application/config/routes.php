<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth/auth/login';

$route['login']    = 'auth/auth/login';
$route['register'] = 'auth/auth/register';
$route['logout']   = 'auth/auth/logout';

// ajax modal contoh
$route['auth/modal/terms'] = 'auth/auth/modal_terms';
;


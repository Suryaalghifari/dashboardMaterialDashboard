<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| Default controller
| Saran: jangan tulis method di default_controller. Arahkan ke controller saja,
| lalu di controller Auth, method index() panggil login().
*/
$route['default_controller']    = 'auth/auth';
$route['404_override']          = '';
$route['translate_uri_dashes']  = FALSE;

/* AUTH (modules/auth/controllers/Auth.php) */
$route['login']                 = 'auth/auth/login';
$route['login/submit']          = 'auth/auth/do_login';
$route['logout']                = 'auth/auth/logout';
$route['register']              = 'auth/auth/register';
$route['register/submit']       = 'auth/auth/do_register';

/* DASHBOARD (modules/dashboard/controllers/Dashboard.php) */
$route['dashboard']             = 'dashboard/dashboard/index';

/* PAGES: Analytics (modules/pages/controllers/Analytics.php) */
$route['analytics']             = 'pages/analytics/index';

/* ACCOUNT (modules/account/controllers/Account.php) */
$route['account/profile']       = 'account/account/profile';
$route['account/settings']      = 'account/account/settings';

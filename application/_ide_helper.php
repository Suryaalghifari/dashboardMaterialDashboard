<?php
// application/_ide_helper.php
// HANYA UNTUK IDE (VS Code/Intelephense). TIDAK DIEKSEKUSI RUNTIME.

class CI_Loader {}
class CI_Config {}
class CI_Session {}

/**
 * @property CI_Loader       $load
 * @property CI_Config       $config
 * @property CI_Session      $session
 * @property Chat_model      $repo            // alias model: 'repo'
 * @property Chat_api_client $api             // alias model: 'api'
 */
class CI_Controller {}

/** HMVC */
class MX_Controller extends CI_Controller {}

<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Timezone {

  public function php(){
    date_default_timezone_set('Asia/Jakarta');
    if (function_exists('ini_set')) @ini_set('date.timezone','Asia/Jakarta');
  }


  public function db(){
    $CI = &get_instance();
    if (isset($CI->db)) {
      // WIB = UTC+07:00
      $CI->db->simple_query("SET time_zone = '+07:00'");
    }
  }
}

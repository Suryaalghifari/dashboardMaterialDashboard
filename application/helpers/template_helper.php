<?php defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('asset_url')) {
  function asset_url($path = '') {
    return base_url('assets/' . ltrim($path, '/'));
  }
}

if (!function_exists('active_menu')) {
  function active_menu($current, $needle) {
    return strtolower($current) === strtolower($needle) ? 'active' : '';
  }
}

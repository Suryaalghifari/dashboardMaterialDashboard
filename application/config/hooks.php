<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_system'][] = [
  'class'    => 'Timezone',
  'function' => 'php',
  'filename' => 'Timezone.php',
  'filepath' => 'hooks',
];

$hook['post_controller_constructor'][] = [
  'class'    => 'Timezone',
  'function' => 'db',
  'filename' => 'Timezone.php',
  'filepath' => 'hooks',
];


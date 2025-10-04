<?php defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('detect_user_intent')) {
  function detect_user_intent($text) {
    $q = mb_strtolower(trim((string)$text));
    if ($q === '') return ['type'=>null];

    // greet
    if (preg_match('/\b(halo|hai|hey|hi|selamat\s+(pagi|siang|sore|malam))\b/u', $q)) {
      return ['type' => 'greeting'];
    }

    // thanks / appreciation
    if (preg_match('/\b(terima\s*kasih|makasih|thanks?|thank\s*you)\b/u', $q)) {
      return ['type' => 'chat.thanks'];
    }

    // acknowledgement / kecil
    if (preg_match('/\b(ok+|sip+|mantap+|baiklah|siap)\b/u', $q)) {
      return ['type' => 'chat.ack'];
    }

    // created_at
    if (preg_match('/\b(akun|account).*(dibuat|di\s*buat|pembuatan|created)\b/u', $q)
     || preg_match('/\bkapan\b.*\b(akun|account).*(dibuat|di\s*buat)\b/u', $q)
     || preg_match('/\btanggal\b.*\bpembuatan\b.*\b(akun|account)\b/u', $q)) {
      return ['type' => 'user.created_at'];
    }

    // last_login
    if (preg_match('/\b(terakhir\s*login|last\s*login|login\s*terakhir|terakhir\s*masuk)\b/u', $q)) {
      return ['type' => 'user.last_login'];
    }

    // bot name
    if (preg_match('/\b(siapa\s*nama\s*(kamu|mu|bot|asisten)|apa\s*nama\s*bot|nama\s*bot|nama\s*asisten)\b/u', $q)) {
      return ['type' => 'bot.name'];
    }
    // name
    if (preg_match('/\b(nama\s*saya|siapa\s*nama\s*saya|nama\s*akun|siapa\s*nama(ku)?)\b/u', $q)
    || preg_match('/\bsiapa\b.*\bnama\b.*\b(akun|ini)\b/u', $q)) {
      return ['type' => 'user.name'];
    }

    // email
    if (preg_match('/\b(email\s*saya|alamat\s*email|sure[l|l]?el|email\s*akun)\b/u', $q)) {
      return ['type' => 'user.email'];
    }

    // who is logged in
    if (preg_match('/\b(siapa|yang)\s+(sedang\s*)?login\b/u', $q)) {
      return ['type' => 'user.who_is_logged_in'];
    }

    return ['type'=>null];
  }
}

<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<link rel="stylesheet" href="<?= base_url('assets/chatbot/chatbot.css') ?>">

<div id="chatbot-root"
     data-open-url="<?= site_url('chat/open') ?>"
     data-send-url="<?= site_url('chat/send') ?>"
     data-user-name="<?= html_escape($user_name ?? 'Teman') ?>">

  <!-- FAB -->
  <div class="mdp-fab-wrap">
    <button id="chatbot-fab" class="mdp-fab mdp-shadow" aria-label="Buka chatbot">
      <span class="material-symbols-rounded">chat</span>
      <span class="mdp-fab-badge" data-count="<?= (int)($badgeCount ?? 0) ?>"></span>
    </button>
    <div id="chat-fab-label" class="mdp-fab-label">Chat Here</div>
  </div>

  <!-- Panel -->
  <div id="chatbot-sheet" class="mdp-sheet mdp-shadow" aria-hidden="true">
    <div class="mdp-sheet-header">
      <div class="mdp-title">
        <span class="material-symbols-rounded mdp-title-icon">chat</span>
        <div>
          <div class="h6 mb-0">Telkom Assistant</div>
          <small><span class="mdp-dot online"></span> Online</small>
        </div>
      </div>
      <div class="mdp-actions">
        <button class="btn" id="chatbot-close" aria-label="Tutup">
          <span class="material-symbols-rounded">close</span>
        </button>
      </div>
    </div>

    <div id="chatbot-messages" class="mdp-sheet-body"></div>

    <div class="mdp-sheet-input">
      <form id="chatbot-form" autocomplete="off">
        <input id="chatbot-text" type="text" class="form-control" placeholder="Ketik pesan Anda..." />
        <button type="submit" class="btn btn-primary" id="chatbot-send" aria-label="Kirim">
          <span class="material-symbols-rounded">send</span>
        </button>
      </form>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/chatbot/chatbot.js') ?>"></script>

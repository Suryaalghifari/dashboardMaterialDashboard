<?php $this->load->view('auth/layouts/auth_head'); ?>

<div class="container position-sticky z-index-sticky top-0">
  <div class="row">
    
  </div>
</div>

<main class="main-content mt-0">
  <?php $this->load->view($content_view); ?>
</main>
<?php $this->load->view('auth/layouts/_global_modal'); ?> <!-- modal global -->
<?php $this->load->view('auth/layouts/auth_footer'); ?>

<?php $dash = base_url('assets/dashboard/'); ?>
<!DOCTYPE html>
<html lang="en">
<?php
  $title = isset($title) ? $title : 'Dashboard';
  $this->load->view('layout/_head', compact('dash','title'));
?>
<body class="g-sidenav-show bg-gray-100">

  <?php $this->load->view('layout/_sidebar'); ?>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <?php $this->load->view('layout/_navbar'); ?>

    <div class="container-fluid py-2">
      <?php $this->load->view($content_view); ?>
      <?php $this->load->view('layout/_global_modal'); ?>
    </div>
  </main>

  <?php $this->load->view('layout/_footer_scripts', compact('dash')); ?>

  <?= Modules::run('chat/widget'); ?> 
</body>
</html>

<?php /** @var string $dash */ ?>
<?php
  // Jika $dash tidak dipass dari master, amankan tetap terisi
  if (!isset($dash)) $dash = base_url('assets/dashboard/');
?>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title><?= isset($title) ? $title : 'Dashboard'; ?></title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/apple-icon.png') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet">
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">

  <!-- Icons -->
  <link rel="stylesheet" href="<?= $dash ?>css/nucleo-icons.css">
  <link rel="stylesheet" href="<?= $dash ?>css/nucleo-svg.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Material Dashboard CSS (gunakan min.css bila ada, jika tidak pakai yang hash) -->
  <?php
    $cssMin   = $dash . 'css/material-dashboard.min.css';
    $cssHash  = $dash . 'css/material-dashboard.mine63c.css'; // sesuaikan jika nama hash berbeda
    // Cek keberadaan file lokal via path server
    $cssMinExists  = @file_exists(FCPATH.'assets/dashboard/css/material-dashboard.min.css');
    $cssHashExists = @file_exists(FCPATH.'assets/dashboard/css/material-dashboard.mine63c.css');
    $cssUse = $cssMinExists ? $cssMin : ($cssHashExists ? $cssHash : $cssMin);
  ?>
  <link rel="stylesheet" href="<?= $cssUse ?>">
  
</head>

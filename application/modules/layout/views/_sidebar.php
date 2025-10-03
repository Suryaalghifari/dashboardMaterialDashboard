<?php
  if (!isset($dash)) $dash = base_url('assets/dashboard/');

  // helper: cek aktif untuk 1 atau banyak slug
  $isActive = function(...$slugs){
    $u = uri_string();
    foreach ($slugs as $s) if ($u === $s) return true;
    return false;
  };

  // util: class aktif
  $activeCls = function($cond){
    return $cond ? 'active bg-dark text-white' : 'text-dark';
  };

  // state buka-tutup
  $profileOpen = $isActive('account/profile','account/settings');           // <<— TAMBAH
  $isDashOpen  = $isActive('dashboard','analytics','sales','discover');
?>

<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
  <div class="sidenav-header">
    <a class="navbar-brand px-4 py-3 m-0 d-flex align-items-center gap-2">
      <img src="<?= $dash ?>img/logo-ct-dark.png" width="26" height="26" alt="logo">
      <span class="ms-1 text-sm text-dark">Team</span>
    </a>
  </div>

  <hr class="horizontal dark mt-0 mb-2">

  <div class="collapse navbar-collapse w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">

      <!-- Profile block -->
      <li class="nav-item mb-2 mt-0">
        <a data-bs-toggle="collapse" href="#ProfileNav"
           class="nav-link text-dark <?= $profileOpen ? '' : 'collapsed' ?>"
           aria-controls="ProfileNav" role="button"
           aria-expanded="<?= $profileOpen ? 'true' : 'false' ?>">
          <img src="<?= $dash ?>img/team-3.jpg" class="avatar" alt="user">
          <span class="nav-link-text ms-2 ps-1">User</span>
          <!-- panah muncul dari ::after -->
        </a>
        <div class="collapse <?= $profileOpen ? 'show' : '' ?>" id="ProfileNav">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link <?= $activeCls($isActive('account/profile')); ?>"
                 href="<?= site_url('account/profile'); ?>">
                <span class="sidenav-mini-icon">MP</span>
                <span class="sidenav-normal ms-3 ps-1">My Profile</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $activeCls($isActive('account/settings')); ?>"
                 href="<?= site_url('account/settings'); ?>">
                <span class="sidenav-mini-icon">S</span>
                <span class="sidenav-normal ms-3 ps-1">Settings</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="<?= site_url('logout'); ?>">
                <span class="sidenav-mini-icon">L</span>
                <span class="sidenav-normal ms-3 ps-1">Logout</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <hr class="horizontal dark mt-0 mb-2">

      <!-- Dashboards (parent toggle) -->
      <li class="nav-item">
        <a data-bs-toggle="collapse" href="#dashboardsExamples"
           class="nav-link text-dark <?= $isDashOpen ? '' : 'collapsed' ?>"
           aria-controls="dashboardsExamples" role="button"
           aria-expanded="<?= $isDashOpen ? 'true' : 'false' ?>">
          <span class="material-symbols-rounded opacity-5 me-2">space_dashboard</span>
          <span class="nav-link-text ms-1 ps-1">Dashboards</span>
          <!-- panah muncul dari ::after; JANGAN taruh ikon manual di sini -->
        </a>

        <div class="collapse <?= $isDashOpen ? 'show' : '' ?>" id="dashboardsExamples">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link <?= $activeCls($isActive('dashboard')); ?>"
                 href="<?= site_url('dashboard'); ?>">
                <span class="sidenav-mini-icon">D</span>
                <span class="sidenav-normal ms-1 ps-1">Discover</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $activeCls($isActive('analytics')); ?>"
                 href="<?= site_url('analytics'); ?>">
                <span class="sidenav-mini-icon">A</span>
                <span class="sidenav-normal ms-1 ps-1">Analytics</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $activeCls($isActive('sales')); ?>"
                 href="<?= site_url('sales'); ?>">
                <span class="sidenav-mini-icon">S</span>
                <span class="sidenav-normal ms-1 ps-1">Sales</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

    </ul>
  </div>
</aside>

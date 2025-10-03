<nav class="navbar navbar-main navbar-expand-lg position-sticky mt-2 top-1 px-0 py-1 mx-3 shadow-none border-radius-lg z-index-sticky" id="navbarBlur" data-scroll="true">
  <div class="container-fluid py-1 px-2">
    <div class="sidenav-toggler sidenav-toggler-inner d-xl-block d-none">
      <a href="javascript:;" class="nav-link text-body p-0">
        <div class="sidenav-toggler-inner">
          <i class="sidenav-toggler-line"></i>
          <i class="sidenav-toggler-line"></i>
          <i class="sidenav-toggler-line"></i>
        </div>
      </a>
    </div>

    <?php
      // ambil title dari controller
      $pageTitle = isset($title) && $title !== ''
        ? htmlspecialchars($title, ENT_QUOTES, 'UTF-8')
        : ucfirst(uri_string()); // fallback dari url segment

      // kalau mau buat breadcrumbs dinamis (optional)
      // contoh di controller:
      // $data['breadcrumbs'] = [
      //   ['label' => 'Pages',   'url' => base_url()],
      //   ['label' => 'Account', 'url' => site_url('account')],
      //   ['label' => 'Profile'] // current
      // ];
    ?>

    <nav aria-label="breadcrumb" class="ps-2">
      <ol class="breadcrumb bg-transparent mb-0 p-0">
        <?php if (!empty($breadcrumbs) && is_array($breadcrumbs)): ?>
          <?php foreach ($breadcrumbs as $i => $bc): ?>
            <?php
              $label = htmlspecialchars($bc['label'], ENT_QUOTES, 'UTF-8');
              $url   = $bc['url'] ?? null;
              $isLast = ($i === array_key_last($breadcrumbs));
            ?>
            <?php if (!$isLast && $url): ?>
              <li class="breadcrumb-item text-sm">
                <a class="opacity-5 text-dark" href="<?= $url; ?>"><?= $label; ?></a>
              </li>
            <?php else: ?>
              <li class="breadcrumb-item text-sm text-dark active font-weight-bold" aria-current="page">
                <?= $label; ?>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- default tanpa array breadcrumbs -->
          <li class="breadcrumb-item text-sm">
            <a class="opacity-5 text-dark" ">Pages</a>
          </li>
          <li class="breadcrumb-item text-sm text-dark active font-weight-bold" aria-current="page">
            <?= $pageTitle; ?>
          </li>
        <?php endif; ?>
      </ol>
    </nav>

    <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
      <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        <div class="input-group input-group-outline">
          <label class="form-label">Search here</label>
          <input type="text" class="form-control">
        </div>
      </div>
      <ul class="navbar-nav justify-content-end">
        <li class="nav-item">
          <a href="javascript:;" class="px-1 py-0 nav-link line-height-0">
            <i class="material-symbols-rounded">account_circle</i>
          </a>
        </li>
        <li class="nav-item">
          <a href="javascript:;" class="nav-link py-0 px-1 line-height-0">
            <i class="material-symbols-rounded fixed-plugin-button-nav">settings</i>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

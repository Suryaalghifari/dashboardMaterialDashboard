<?php
  if (!isset($dash)) $dash = base_url('assets/dashboard/');

  // Helper kecil untuk pilih file yang ada (min vs hash)
  function prefer_js($relativeMin, $relativeHash) {
    $minPath  = FCPATH . $relativeMin;
    $hashPath = FCPATH . $relativeHash;
    if (@file_exists($minPath))  return base_url($relativeMin);
    if (@file_exists($hashPath)) return base_url($relativeHash);
    // fallback ke min (URL) walau file belum ada, agar mudah dideteksi 404 via Network
    return base_url($relativeMin);
  }

  $mdJs = prefer_js(
    'assets/dashboard/js/material-dashboard.min.js',
    'assets/dashboard/js/material-dashboard.mine63c.js' // ganti jika hash berbeda
  );
?>
<!-- Core -->
<script src="<?= $dash ?>js/core/popper.min.js"></script>
<script src="<?= $dash ?>js/core/bootstrap.min.js"></script>
<script src="<?= $dash ?>js/plugins/perfect-scrollbar.min.js"></script>
<script src="<?= $dash ?>js/plugins/smooth-scrollbar.min.js"></script>

<!-- Plugins yang dibutuhkan halaman Analytics -->
<script src="<?= $dash ?>js/plugins/chartjs.min.js"></script>
<script src="<?= $dash ?>js/plugins/world.js"></script> <!-- jsVectorMap map data -->

<!-- Material Dashboard main JS (otomatis pilih min atau hash) -->
<script src="<?= $mdJs ?>"></script>

<script>
  // Aktifkan scrollbar halus di Windows
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = { damping: '0.5' }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }

// Util global untuk membuka modal umum
window.showGlobalModal = function (opts) {
  const el = document.getElementById('globalModal');
  if (!el) return;

  const o = Object.assign({
    title: 'Info',
    body: '',
    size: '',            // '', 'modal-sm', 'modal-lg', 'modal-xl'
    primaryText: '',     // kalau kosong, tombol OK disembunyikan
    onPrimary: null
  }, opts || {});

  // set content
  el.querySelector('#globalModalLabel').textContent = o.title;
  el.querySelector('.modal-body').innerHTML = o.body;

  // size
  const dlg = el.querySelector('.modal-dialog');
  dlg.className = 'modal-dialog modal-dialog-centered';
  if (o.size) dlg.classList.add(o.size);

  // tombol primary
  const btnPrimary = el.querySelector('#globalModalPrimary');
  if (o.primaryText) {
    btnPrimary.classList.remove('d-none');
    btnPrimary.textContent = o.primaryText;
    btnPrimary.onclick = function() {
      if (typeof o.onPrimary === 'function') o.onPrimary();
      const m = bootstrap.Modal.getInstance(el);
      if (m) m.hide();
    };
  } else {
    btnPrimary.classList.add('d-none');
    btnPrimary.onclick = null;
  }

  const modal = bootstrap.Modal.getOrCreateInstance(el);
  modal.show();
};


</script>

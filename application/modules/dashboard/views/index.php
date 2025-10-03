<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="row">
  <div class="col-12">
    <div class="ms-3">
      <h3 class="mb-0 h4 font-weight-bolder">Analytics</h3>
      <p class="mb-4">Check the sales, value and bounce rate by country.</p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4 col-md-6 mb-4">
    <div class="card">
      <div class="card-body">
        <h6 class="mb-0">Website Views</h6>
        <p class="text-sm">Last Campaign Performance</p>
        <div class="pe-2">
          <div class="chart">
            <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
          </div>
        </div>
        <hr class="dark horizontal">
        <div class="d-flex">
          <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
          <p class="mb-0 text-sm">campaign sent 2 days ago</p>
        </div>
      </div>
    </div>
  </div>
  <!-- tambahkan kolom lain sesuai kebutuhan -->
</div>

<script src="<?= asset_url('dashboard/js/plugins/chartjs.min.js') ?>"></script>
<script>
  // contoh chart
  const ctx = document.getElementById('chart-bars').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: { labels:['M','T','W','T','F','S','S'],
      datasets:[{ label:'Sales', backgroundColor:'#43A047', data:[50,45,22,28,50,60,76]}]
    },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}} }
  });

  // contoh panggil modal global via flashdata (opsional)
  <?php if ($this->session->flashdata('welcome')): ?>
  document.addEventListener('DOMContentLoaded', function(){
    showGlobalModal({
      title: "Welcome",
      body: "<p><?= $this->session->flashdata('welcome'); ?></p>"
    });
  });
  <?php endif; ?>
</script>

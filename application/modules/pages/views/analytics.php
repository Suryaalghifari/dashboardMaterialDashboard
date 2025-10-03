<div class="container-fluid py-2">
  <div class="row">
    <div class="col-lg-12 position-relative z-index-2">
      <div class="ms-3">
        <h3 class="mb-0 h4 font-weight-bolder">Analytics</h3>
        <p class="mb-4">Check the sales, value and bounce rate by country.</p>
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

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0">Daily Sales</h6>
              <p class="text-sm">(<span class="font-weight-bolder">+15%</span>) increase in today sales.</p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-line" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="d-flex">
                <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                <p class="mb-0 text-sm">updated 4 min ago</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0">Completed Tasks</h6>
              <p class="text-sm">Last Campaign Performance</p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-line-tasks" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="d-flex">
                <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                <p class="mb-0 text-sm">just updated</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabel & Map -->
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6 class="mb-0">Sales by Country</h6>
          <p class="mb-2 text-sm">Check the sales, value and bounce rate by country.</p>
        </div>
        <div class="card-body p-3">
          <div class="row">
            <div class="col-lg-6 col-md-7">
              <div class="table-responsive">
                <table class="table align-items-center">
                  <thead>
                    <tr>
                      <th class="text-secondary text-sm font-weight-normal text-left p-2">Country</th>
                      <th class="text-secondary text-sm font-weight-normal text-left p-2">Sales</th>
                      <th class="text-secondary text-sm font-weight-normal text-left p-2">Value</th>
                      <th class="text-secondary text-sm font-weight-normal text-left p-2">Bounce</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="w-30">
                        <div class="d-flex px-2 py-1 align-items-center">
                          <div><img src="<?= base_url('assets/dashboard/img/icons/flags/US.png') ?>" alt="US flag"></div>
                          <div class="ms-4"><h6 class="text-sm font-weight-normal mb-0">United States</h6></div>
                        </div>
                      </td>
                      <td><h6 class="text-sm font-weight-normal mb-0">2500</h6></td>
                      <td><h6 class="text-sm font-weight-normal mb-0">$230,900</h6></td>
                      <td class="align-middle text-sm"><h6 class="text-sm font-weight-normal mb-0">29.9%</h6></td>
                    </tr>
                    <tr>
                      <td class="w-30">
                        <div class="d-flex px-2 py-1 align-items-center">
                          <div><img src="<?= base_url('assets/dashboard/img/icons/flags/DE.png') ?>" alt="DE flag"></div>
                          <div class="ms-4"><h6 class="text-sm font-weight-normal mb-0">Germany</h6></div>
                        </div>
                      </td>
                      <td><h6 class="text-sm font-weight-normal mb-0">3.900</h6></td>
                      <td><h6 class="text-sm font-weight-normal mb-0">$440,000</h6></td>
                      <td class="align-middle text-sm"><h6 class="text-sm font-weight-normal mb-0">40.22%</h6></td>
                    </tr>
                    <!-- Tambah baris lain jika perlu -->
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-lg-6 col-md-5">
              <div id="map" class="mt-0 mt-lg-n4" style="height: 350px;"></div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Inline chart & map init (boleh pindah ke file JS Anda sendiri) -->
<script>
  (function() {
    if (typeof Chart === 'undefined') return;

    // Bar
    var ctx = document.getElementById("chart-bars").getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["M","T","W","T","F","S","S"],
        datasets: [{ label: "Sales", tension: .4, borderWidth: 0, borderRadius: 4, borderSkipped: false,
          backgroundColor: "#43A047", data: [50,45,22,28,50,60,76], barThickness: 'flex' }]
      },
      options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ display:false } },
        interaction:{ intersect:false, mode:'index' },
        scales:{
          y:{ grid:{ drawBorder:false, display:true, drawOnChartArea:true, drawTicks:false, borderDash:[5,5], color:'#e5e5e5' },
              ticks:{ suggestedMin:0, suggestedMax:500, beginAtZero:true, padding:10, font:{size:14,lineHeight:2}, color:"#737373" } },
          x:{ grid:{ drawBorder:false, display:false, drawOnChartArea:false, drawTicks:false, borderDash:[5,5] },
              ticks:{ display:true, color:'#737373', padding:10, font:{size:14,lineHeight:2} } }
        }
      }
    });

    // Line
    var ctx2 = document.getElementById("chart-line").getContext("2d");
    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["J","F","M","A","M","J","J","A","S","O","N","D"],
        datasets: [{ label:"Mobile apps", tension:0, borderWidth:2, pointRadius:3,
          pointBackgroundColor:"#43A047", pointBorderColor:"transparent", borderColor:"#43A047",
          backgroundColor:"transparent", fill:true, data:[120,230,130,440,250,360,270,180,90,300,310,220], maxBarThickness:6 }]
      },
      options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ display:false } },
        interaction:{ intersect:false, mode:'index' },
        scales:{
          y:{ grid:{ drawBorder:false, display:true, drawOnChartArea:true, drawTicks:false, borderDash:[4,4], color:'#e5e5e5' },
              ticks:{ display:true, color:'#737373', padding:10, font:{size:12,lineHeight:2} } },
          x:{ grid:{ drawBorder:false, display:false, drawOnChartArea:false, drawTicks:false, borderDash:[5,5] },
              ticks:{ display:true, color:'#737373', padding:10, font:{size:12,lineHeight:2} } }
        }
      }
    });

    // Line 2
    var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");
    new Chart(ctx3, {
      type: "line",
      data: {
        labels: ["Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
        datasets: [{ label:"Mobile apps", tension:0, borderWidth:2, pointRadius:3,
          pointBackgroundColor:"#43A047", pointBorderColor:"transparent", borderColor:"#43A047",
          backgroundColor:"transparent", fill:true, data:[50,40,300,220,500,250,400,230,500], maxBarThickness:6 }]
      },
      options: {
        responsive:true, maintainAspectRatio:false,
        plugins:{ legend:{ display:false } },
        interaction:{ intersect:false, mode:'index' },
        scales:{
          y:{ grid:{ drawBorder:false, display:true, drawOnChartArea:true, drawTicks:false, borderDash:[4,4], color:'#e5e5e5' },
              ticks:{ display:true, padding:10, color:'#737373', font:{size:14,lineHeight:2} } },
          x:{ grid:{ drawBorder:false, display:false, drawOnChartArea:false, drawTicks:false, borderDash:[4,4] },
              ticks:{ display:true, color:'#737373', padding:10, font:{size:14,lineHeight:2} } }
        }
      }
    });

    // Vector map (pakai file world.js yang sudah di-include)
    if (typeof jsVectorMap !== 'undefined') {
      new jsVectorMap({
        selector: "#map",
        map: "world_merc",
        zoomOnScroll: false,
        zoomButtons: false,
        selectedMarkers: [1, 3],
        markersSelectable: true,
        markers: [
          { name:"USA",     coords:[40.71296415909766, -74.00437720027804] },
          { name:"Germany", coords:[51.17661451970939, 10.97947735117339] },
          { name:"Brazil",  coords:[-7.596735421549542, -54.781694323779185] },
          { name:"Russia",  coords:[62.318222797104276, 89.81564777631716] },
          { name:"China",   coords:[22.320178999475512, 114.17161225541399], style:{ fill:'#4CAF50' } }
        ],
        markerStyle: {
          initial:  { fill: "#333333" },
          hover:    { fill: "#333333" },
          selected: { fill: "#333333" }
        }
      });
    }
  })();
</script>

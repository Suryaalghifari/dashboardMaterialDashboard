<section>
  <div class="page-header min-vh-100">
    <div class="container">
      <div class="row">
        <!-- ilustrasi kiri -->
        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
          <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
               style="background-image: url('<?= base_url('assets/img/illustrations/illustration-signup.jpg') ?>'); background-size: cover;"></div>
        </div>

        <!-- form kanan -->
        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
          <div class="card card-plain">
            <div class="card-header text-center">
              <h4 class="font-weight-bolder">Sign Up</h4>
              <p class="mb-0">Masukkan data untuk membuat akun baru</p>
            </div>

            <div class="card-body mt-2">
              <!-- form register -->
              <form id="form-register" method="post" action="<?= site_url('register') ?>" autocomplete="off">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>"
                       value="<?=$this->security->get_csrf_hash();?>">

                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Nama</label>
                  <input type="text" class="form-control" name="name" value="<?= set_value('name') ?>" required>
                </div>

                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" value="<?= set_value('email') ?>" required>
                </div>

                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control" name="password" required>
                </div>

                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Konfirmasi Password</label>
                  <input type="password" class="form-control" name="password_confirm" required>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-lg bg-gradient-dark w-100 mt-4 mb-0">Sign up</button>
                </div>
              </form>
            </div>

            <div class="card-footer text-center pt-0 px-lg-2 px-1">
              <p class="mb-4 text-sm mx-auto">
                Sudah punya akun?
                <a href="<?= site_url('login') ?>" class="text-primary text-gradient font-weight-bold">Sign in</a>
              </p>
            </div>
          </div>
        </div>
        <!-- /form -->
      </div>
    </div>
  </div>
</section>

<!-- Script AJAX untuk trigger modal global -->
<script>
document.addEventListener("DOMContentLoaded", function(){
  var form = document.getElementById("form-register");
  if (!form) return;

  form.addEventListener("submit", function(e){
    // kalau modal/fetch belum ada → biarkan submit normal supaya tidak blank
    if (typeof window.fetch === "undefined" || typeof window.showGlobalModal === "undefined") return;

    e.preventDefault();

    var btn = form.querySelector('button[type="submit"]');
    var old = btn ? btn.innerHTML : "";
    if (btn) { btn.disabled = true; btn.innerHTML = "Processing..."; }

    fetch(form.action, {
      method: "POST",
      body: new FormData(form),
      headers: {"X-Requested-With":"XMLHttpRequest"}
    })
    .then(function(r){
      var ct = r.headers.get("content-type") || "";
      if (ct.indexOf("application/json") === -1) return r.text().then(function(){ throw new Error("Not JSON"); });
      return r.json();
    })
    .then(function(res){
      if (res.success) {
        showGlobalModal({
          title: "Registrasi Berhasil",
          body: "<p>"+(res.message || "Akun berhasil dibuat.")+"</p>",
          footer: '<a href="<?= site_url('login') ?>" class="btn bg-gradient-primary">Login Sekarang</a>'
        });
        form.reset();
        // Auto-redirect setelah 2.5 detik (opsional):
        // setTimeout(function(){ window.location.href = "<?= site_url('login') ?>"; }, 2500);
      } else {
        showGlobalModal({
          title: "Error Registrasi",
          body: "<div class='text-danger'>"+(res.message || "Gagal mendaftar")+"</div>"
        });
      }
    })
    .catch(function(err){
      showGlobalModal({ title:"Error", body:"<p>Terjadi kesalahan. Coba lagi.</p><small>"+(err.message||"")+"</small>" });
    })
    .finally(function(){
      if (btn) { btn.disabled = false; btn.innerHTML = old; }
    });
  });
});
</script>

<section>
  <div class="page-header min-vh-100">
    <div class="container">
      <div class="row">
        <!-- left illustration -->
        <div class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 start-0 text-center justify-content-center flex-column">
          <div class="position-relative h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center"
               style="background-image: url('<?= base_url('assets/img/illustrations/illustration-signin.jpg') ?>'); background-size: cover;"></div>
        </div>

        <!-- form -->
        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column ms-auto me-auto ms-lg-auto me-lg-5">
          <div class="card card-plain">
            <div class="card-header text-center">
              <h4 class="font-weight-bolder">Sign In</h4>
              <p class="mb-0">Enter your email and password to sign in</p>
            </div>

            <div class="card-body mt-2">
              <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
              <?php endif; ?>

              <?= form_open('login', ['role'=>'form', 'autocomplete'=>'off']) ?>
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>"
                       value="<?=$this->security->get_csrf_hash();?>">

                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control" name="email"
                         value="<?= set_value('email') ?>">
                </div>
                <div class="text-danger small mb-3"><?= form_error('email') ?></div>

                <div class="input-group input-group-outline mb-3">
                  <label class="form-label">Password</label>
                  <input type="password" class="form-control" name="password">
                </div>
                <div class="text-danger small mb-3"><?= form_error('password') ?></div>

                <div class="form-check form-switch d-flex align-items-center mb-3">
                  <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" value="1">
                  <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-lg bg-gradient-dark btn-lg w-100 mt-4 mb-0">Sign in</button>
                </div>
              <?= form_close() ?>
            </div>

            <div class="card-footer text-center pt-0 px-lg-2 px-1">
              <p class="mb-4 text-sm mx-auto">
                Don't have an account?
                <a href="<?= site_url('register') ?>" class="text-primary text-gradient font-weight-bold">Sign up</a>
              </p>
            </div>
          </div>
        </div>
        <!-- /form -->
      </div>
    </div>
  </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function(){
  const err = <?= json_encode($this->session->flashdata('error') ?: '') ?>;
  if (err) {
    showGlobalModal({
      title: "Login Gagal",
      body: "<p>" + err + "</p>"
    });
  }
});
</script>



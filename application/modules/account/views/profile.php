<?php
$pageTitle = isset($title) ? $title : 'Profile';
$user = $user ?? [
  'name'       => 'Richard Davis',
  'role'       => 'CEO / Co-Founder',
  'avatar'     => 'assets/profile/img/bruce-mars.jpg',
  'first_name' => 'Alec',
  'last_name'  => 'Thompson',
  'gender'     => 'Male',
  'dob_day'    => 1,
  'dob_month'  => 2,
  'dob_year'   => 2020,
  'email'      => 'example@email.com',
  'location'   => 'Sydney, A',
  'phone'      => '+40 735 631 620',
];
?>
<div class="container-fluid py-4">
  <div class="row">
    <!-- SIDEBAR LOKAL -->
    <div class="col-lg-3 mb-3">
      <div class="card position-sticky top-1">
        <ul id="sectionNav" class="list-group list-group-flush p-2">
          <li class="list-group-item border-0">
            <a class="d-flex align-items-center text-dark section-link" href="#profile">
              <i class="material-symbols-rounded me-2">person</i> Profile
            </a>
          </li>
          <li class="list-group-item border-0">
            <a class="d-flex align-items-center text-dark section-link" href="#basic-info">
              <i class="material-symbols-rounded me-2">receipt_long</i> Update Profile
            </a>
          </li>
          <li class="list-group-item border-0">
            <a class="d-flex align-items-center text-dark section-link" href="#password">
              <i class="material-symbols-rounded me-2">lock</i> Change Password
            </a>
          </li>
        </ul>
      </div>
    </div>

    <!-- KONTEN -->
    <div class="col-lg-9">

      <!-- Header Profile + Upload Foto -->
      <div class="card mb-3" id="profile">
        <div class="card-body d-flex align-items-center flex-wrap">
          <form id="form-avatar" class="d-flex align-items-center me-3"
                action="<?= site_url('profile/update-avatar'); ?>"
                method="post" enctype="multipart/form-data">
            <?php if ($this->security->get_csrf_token_name() ?? null): ?>
              <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                     value="<?= $this->security->get_csrf_hash(); ?>">
            <?php endif; ?>

            <div class="position-relative me-3">
              <img id="avatarPreview"
                   src="<?= base_url($user['avatar']); ?>"
                   class="rounded-circle shadow"
                   style="width:76px;height:76px;object-fit:cover;">
              <button type="button"
                      class="btn btn-sm btn-dark position-absolute"
                      style="right:-6px;bottom:-6px;border-radius:9999px;padding:6px 8px;"
                      onclick="document.getElementById('avatarInput').click()">
                <i class="material-symbols-rounded" style="font-size:18px;">photo_camera</i>
              </button>
            </div>

            <input id="avatarInput" name="avatar" type="file" accept="image/*" class="d-none">

            <div>
              <button id="btnSaveAvatar" type="submit" class="btn btn-sm btn-outline-dark d-none">Simpan Foto</button>
              <button id="btnCancelAvatar" type="button" class="btn btn-sm btn-outline-secondary ms-2 d-none">Batal</button>
            </div>
          </form>

          <div class="flex-grow-1 min-w-0">
            <h5 class="mb-1 fw-bold"><?= htmlspecialchars($user['name']); ?></h5>
            <div class="text-muted"><?= htmlspecialchars($user['role']); ?></div>
          </div>
        </div>
      </div>

      <!-- Update Profile -->
      <div class="card mb-3" id="basic-info">
        <div class="card-header"><h5 class="mb-0">Update Profile</h5></div>
        <div class="card-body">
          <form method="post" action="<?= site_url('profile/update-basic'); ?>">
            <div class="row g-3">
              <div class="col-md-6"><label class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" value="<?= $user['first_name']; ?>">
              </div>
              <div class="col-md-6"><label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" value="<?= $user['last_name']; ?>">
              </div>
              <div class="col-md-6"><label class="form-label">Role</label>
                <input type="text" class="form-control" name="role" value="<?= $user['role']; ?>">
              </div>
              <div class="col-md-6"><label class="form-label">Gender</label>
                <select class="form-select" name="gender">
                  <option <?= $user['gender']=='Male'?'selected':''; ?>>Male</option>
                  <option <?= $user['gender']=='Female'?'selected':''; ?>>Female</option>
                </select>
              </div>
              <div class="col-md-6"><label class="form-label">Birth Date</label>
                <div class="row g-2">
                  <div class="col-4"><select class="form-select" name="dob_day">
                    <?php for($d=1;$d<=31;$d++): ?>
                      <option value="<?= $d; ?>" <?= $user['dob_day']==$d?'selected':''; ?>><?= $d; ?></option>
                    <?php endfor; ?>
                  </select></div>
                  <div class="col-4"><select class="form-select" name="dob_month">
                    <?php $months=['January','February','March','April','May','June','July','August','September','October','November','December'];
                    foreach($months as $i=>$m): ?>
                      <option value="<?= $i+1; ?>" <?= $user['dob_month']==($i+1)?'selected':''; ?>><?= $m; ?></option>
                    <?php endforeach; ?>
                  </select></div>
                  <div class="col-4"><select class="form-select" name="dob_year">
                    <?php for($y=date('Y');$y>=1900;$y--): ?>
                      <option value="<?= $y; ?>" <?= $user['dob_year']==$y?'selected':''; ?>><?= $y; ?></option>
                    <?php endfor; ?>
                  </select></div>
                </div>
              </div>
              <div class="col-md-6"><label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $user['email']; ?>">
              </div>
              <div class="col-md-6"><label class="form-label">Confirm Email</label>
                <input type="email" class="form-control" name="email_confirm" value="<?= $user['email']; ?>">
              </div>
              <div class="col-md-6"><label class="form-label">Location</label>
                <input type="text" class="form-control" name="location" value="<?= $user['location']; ?>">
              </div>
              <div class="col-md-6"><label class="form-label">Phone</label>
                <input type="text" class="form-control" name="phone" value="<?= $user['phone']; ?>">
              </div>
            </div>
            <div class="mt-4 text-end">
              <button type="reset" class="btn btn-outline-secondary">Cancel</button>
              <button type="submit" class="btn btn-dark ms-2">Save Changes</button>
            </div>
          </form>
        </div>
      </div>

      <!-- Change Password -->
      <div class="card mb-3" id="password">
        <div class="card-header"><h5 class="mb-0">Change Password</h5></div>
        <div class="card-body">
          <form method="post" action="<?= site_url('profile/change-password'); ?>">
            <div class="mb-3"><label class="form-label">Current password</label>
              <input type="password" class="form-control" name="current_password">
            </div>
            <div class="mb-3"><label class="form-label">New password</label>
              <input type="password" class="form-control" name="new_password">
            </div>
            <div class="mb-4"><label class="form-label">Confirm new password</label>
              <input type="password" class="form-control" name="confirm_password">
            </div>
            <div class="text-end">
              <button type="reset" class="btn btn-outline-secondary">Cancel</button>
              <button type="submit" class="btn btn-dark ms-2">Update password</button>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
(function(){
  const input = document.getElementById('avatarInput');
  const preview = document.getElementById('avatarPreview');
  const btnSave = document.getElementById('btnSaveAvatar');
  const btnCancel= document.getElementById('btnCancelAvatar');
  let original = preview.src;

  input?.addEventListener('change', function(){
    const f = this.files[0];
    if(!f) return;
    if(!/^image\//.test(f.type)){ alert('File harus gambar'); this.value=''; return; }
    if(f.size > 2*1024*1024){ alert('Maks 2MB'); this.value=''; return; }
    const url = URL.createObjectURL(f);
    preview.src = url;
    btnSave.classList.remove('d-none');
    btnCancel.classList.remove('d-none');
  });

  btnCancel?.addEventListener('click', function(){
    input.value = '';
    preview.src = original;
    btnSave.classList.add('d-none');
    btnCancel.classList.add('d-none');
  });
})();
</script>

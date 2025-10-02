  <!-- Core JS -->
  <script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/perfect-scrollbar.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/smooth-scrollbar.min.js') ?>"></script>
  <!-- Plugins (opsional, hanya jika dipakai di halaman) -->
  <script src="<?= base_url('assets/js/plugins/dragula/dragula.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/jkanban/jkanban.min.js') ?>"></script>
  <!-- Material Dashboard control center -->
  <script src="<?= base_url('assets/js/material-dashboard.min.js') ?>"></script>

  <script>
    // helper: tambahkan class is-filled ke input yg berisi value (server-side refill)
    document.querySelectorAll('.input-group.input-group-outline input').forEach(function(inp){
      if (inp.value && inp.value.trim() !== '') {
        inp.closest('.input-group').classList.add('is-filled');
      }
      inp.addEventListener('focus', function(){ inp.closest('.input-group').classList.add('is-focused'); });
      inp.addEventListener('blur',  function(){
        inp.closest('.input-group').classList.remove('is-focused');
        if (inp.value && inp.value.trim() !== '') inp.closest('.input-group').classList.add('is-filled');
        else inp.closest('.input-group').classList.remove('is-filled');
      });
    });

    function showGlobalModal(opts) {
      const modal = document.getElementById("globalModal");
      if (!modal) return;

      if (opts.title) modal.querySelector("#globalModalLabel").innerHTML = opts.title;
      if (opts.body)  modal.querySelector("#globalModalBody").innerHTML  = opts.body;
      if (opts.footer) modal.querySelector("#globalModalFooter").innerHTML = opts.footer;

      var bsModal = new bootstrap.Modal(modal);
      bsModal.show();
    }

    // opsional: load konten via AJAX ke modal
    function showModalFrom(url) {
      fetch(url, {headers: {"X-Requested-With":"XMLHttpRequest"}})
        .then(r => r.text())
        .then(html => {
          showGlobalModal({title:"Info", body:html});
        });
    }
  </script>
</body>
</html>

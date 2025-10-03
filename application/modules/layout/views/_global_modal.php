<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="globalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"> <!-- size diubah via JS -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-normal" id="globalModalLabel">Title</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">...</div>
      <div class="modal-footer">
        <button type="button" id="globalModalClose" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="globalModalPrimary" class="btn bg-gradient-primary d-none">OK</button>
      </div>
    </div>
  </div>
</div>

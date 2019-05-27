<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
            </div>

            <form class="user" method="post" action="<?= base_url('Jenjang_CRUD/update'); ?>">
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <input type="hidden" name="_id" value="<?= set_value('_id', $jenj_update['jenj_id']); ?>">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0 cek">
                  <input type="text" class="form-control" id="jenj_nama" name="jenj_nama" placeholder="Level Name (EX: X, XI, XII)" value="<?= set_value('jenj_nama', $jenj_update['jenj_nama']) ?>">
                  <?= form_error('jenj_nama', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
              </div>
              <?= $this->session->flashdata('warning'); ?>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Update
              </button>
            </form>
            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
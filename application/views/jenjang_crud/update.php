<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u><?= $title ?></u></h1>
            </div>

            <form class="user" method="post" action="<?= base_url('Jenjang_CRUD/update'); ?>">
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0">
                  <input type="hidden" name="_id" value="<?= set_value('_id', $jenj_update['jenj_id']); ?>">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm mb-3 mb-sm-0 cek">
                  <label for="jenj_nama"><u><b>Nama Jenjang</b></u>:</label>
                  <input type="text" class="form-control form-control-sm" name="jenj_nama" value="<?= $jenj_update['jenj_nama'] ?>" required>
                </div>

                <div class="col-sm mb-3 mb-sm-0 cek">
                  <label for="jenj_nama"><u><b>Urutan Jenjang</b></u>:</label>
                  <input type="number" class="form-control form-control-sm" name="jenj_urutan" value="<?= $jenj_update['jenj_urutan'] ?>" required>
                </div>
              </div>
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
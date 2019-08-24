<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900"><u><b>SCHOOL LIST</b></u></h1>
            </div>

            <input type="hidden" id="tes_flag" value = 1>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('K_afek_CRUD') ?>" method="POST">
              <div class="form-group row">
                <div class="col-sm mb-sm-0 mt-2">
                  <select name="sk_id" class="form-control mb-1">
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                  Show Value
              </button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

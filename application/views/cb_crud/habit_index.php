<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><?= $title ?></h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('CB_CRUD/habit_input') ?>" method="POST">

              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="kelas_habit" id="kelas_komen" class="form-control">
                    <option value="0">Select Class</option>
                    <?php foreach ($kelas_all as $m) : ?>
                      <option value='<?= $m['kelas_id'] ?>'>
                        <?= $m['kelas_nama'] . " (" . $m['sk_nama'] . " " . $m['t_nama'] . ")" ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-user mt-2 btn-block">
                Input
              </button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>
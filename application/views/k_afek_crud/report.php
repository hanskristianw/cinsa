<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4">Select Year And Month</h1>
            </div>

            <?= $this->session->flashdata('message'); ?>

            <form class="user" action="<?= base_url('K_afek_CRUD/show_report') ?>" method="POST">

              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="t_id" id="t_id" class="form-control">
                    <option value="0">Select Year</option>
                    <?php foreach ($tahun_all as $m) : ?>
                      <option value='<?=$m['t_id']?>'>
                        <?= $m['t_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="bulan_id" id="bulan_id" class="form-control">
                    <?php foreach ($bulan_all as $m) : ?>
                      <option value='<?=$m['bulan_id']?>'>
                        <?= $m['bulan_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>

              <div id="report_afek_kelas"></div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

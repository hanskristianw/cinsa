<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900"><u><b>SSP Report</b></u></h1>
              <h5 class="text-gray-900 mb-4">Select School and Year</h5>
            </div>

            <?= $this->session->flashdata('message'); ?>
            
            <input type="hidden" id="laporan_flag" value="0">

            <form class="user" action="<?= base_url('Laporan_CRUD/summary_ssp_show') ?>" method="POST">
              
              <div class="form-group row">
                <div class="col-sm mb-sm-0">
                  <select name="sk_id" id="laporan_sk" class="form-control">
                    <?php foreach ($sk_all as $m) : ?>
                      <option value='<?= $m['sk_id'] ?>'>
                        <?= $m['sk_nama'] ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="col-sm mb-sm-0">
                  <select name="t" id="laporan_t" class="form-control">
                    <?php foreach ($t_all as $m) : ?>
                      <option value='<?= $m['t_id'] ?>'>
                        <?= $m['t_nama']; ?>
                      </option>
                    <?php endforeach ?>
                  </select>
                </div>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">
                Show SSP Report
              </button>
            </form>
            

          </div>
        </div>
      </div>
    </div>
  </div>

</div>

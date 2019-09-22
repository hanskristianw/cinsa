<div class="container">

  <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
      <!-- Nested Row within Card Body -->
      <div class="row">
        <div class="col-lg">
          <div class="p-5 overflow-auto">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-4"><u>Affective Report</u></h1>
            </div>


            <?= $this->session->flashdata('message'); ?>

            <input type="hidden" name="kelas_id" id="kelas_laporan_id" value="<?= $kelas_id ?>">
            <input type="hidden" name="t_id" id="t_laporan_id" value="<?= $t_id ?>">
            <input type="hidden" name="sk_id" id="sk_laporan_id" value="<?= $sk_id ?>">

            <div class="col-sm mb-sm-0">
              <select name="sk_id" id="bulan_laporan_id" class="form-control">
                <option value="0">Select Month</option>
                <?php foreach ($bulan as $m) : ?>
                  <option value='<?= $m['bulan_id'] ?>'>
                    <?= $m['bulan_nama'] ?>
                  </option>
                <?php endforeach ?>
              </select>
            </div>
            <div id="laporan_desc_afek_show">
            
            </div>
            <div id="laporan_afek_show">
            
            </div>

            <hr>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

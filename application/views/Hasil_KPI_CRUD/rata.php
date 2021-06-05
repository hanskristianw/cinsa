<style>
.grid-container {
  display: grid;
  grid-template-columns: 15% 15% 15% 25% 15% 15%;
  grid-column-gap:4px;
  padding-right:3px;
}
.grid-container > div{
  text-align:left;
}

.grid-main {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 20px;
  padding-top: 20px;
}

.box1{
  /*align-self:start;*/
  grid-column:2/3;
  overflow: auto;
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}

</style>

<div class="grid-main">

  <div class="box1 text-center mt-4"><h4><u><?= $title ?></u></h4></div>
  <div class="box1 text-center"><h5><u>Pilih Tahun dan Jabatan yang akan dilihat</u></h5></div>


  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">

    <?php if ($jab_all): ?>
      <form class="" action="<?= base_url('Hasil_KPI_CRUD/rata_show'); ?>" method="post">

        <label class="mt-3"><b>Tahun Ajaran:</b></label>
        <select name="t_id" class="form-control form-control-sm">
          <?php
            foreach ($t_all as $t) :
              echo "<option value=" . $t['t_id'] . ">" . $t['t_nama'] . "</option>";
            endforeach
          ?>
        </select>

        <label class="mt-3"><b>Jabatan Anda Sebagai:</b></label>
        <select id="jabatan_kpi_id" class="form-control form-control-sm" name="jabatan_kpi_id">
          <?php
            foreach ($jab_all as $t) :
              echo "<option value=" . $t['jabatan_kpi_id'] . ">" . $t['jabatan_kpi_nama'] . "</option>";
            endforeach
          ?>
        </select>

        <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
          Tampilkan
        </button>

      </form>
    <?php else: ?>
      <h5 class="text-center text-danger">Anda belum mempunyai jabatan</h5>
    <?php endif; ?>

  </div>
</div>

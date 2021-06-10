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

  <div class="box1 text-center mt-4"><h4><u>Hapus Nilai Topik</u></h4></div>
  <div class="box1 text-center"><h5><u><?= $title ?></u></h5></div>


  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">

    <?php if($topik_all): ?>
      <form class="" action="<?= base_url('Hapus_Nilai_Mapel/hasil_topik'); ?>" method="post">

        <input type="hidden" name="kelas_id" value="<?= $kelas_id ?>">
        <input type="hidden" name="mapel_id" value="<?= $mapel_id ?>">

        <label class="mt-3"><b>Mapel:</b></label>
        <select name="topik_id" class="form-control form-control-sm">
          <?php
            foreach ($topik_all as $t) :
              echo "<option value=" . $t['topik_id'] . ">" . $t['topik_nama'] . "</option>";
            endforeach
          ?>
        </select>

        <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
          Next
        </button>

      </form>
    <?php else: ?>
      <h5 class="text-danger text-center mt-4">-Belum ada topik-</h5>
    <?php endif; ?>
  </div>
</div>

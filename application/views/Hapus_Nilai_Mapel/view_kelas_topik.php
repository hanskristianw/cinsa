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

  <div class="box1 text-center mt-4"><h4><u>Hapus Topik</u></h4></div>
  <div class="box1 text-center"><h5><u>Pilih Kelas</u></h5></div>


  <div class="box1">
    <?= $this->session->flashdata('message'); ?>
  </div>

  <div class="box1 mb-4">

    <?php if($kelas_all): ?>
      <form class="" action="<?= base_url('Hapus_Nilai_Mapel/view_mapel_topik'); ?>" method="post">

        <label class="mt-3"><b>Kelas:</b></label>
        <select name="kelas_id" class="form-control form-control-sm">
          <?php
            foreach ($kelas_all as $t) :
              echo "<option value=" . $t['kelas_id'] . ">" . $t['kelas_nama'] . "</option>";
            endforeach
          ?>
        </select>

        <button type="submit" class="btn btn-secondary btn-user btn-block mt-3">
          Next
        </button>

      </form>
    <?php else: ?>
      <h5 class="text-danger text-center mt-4">-Belum ada kelas di tahun ajaran ini-</h5>
    <?php endif; ?>
  </div>
</div>

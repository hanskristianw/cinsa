<style>
.grid-container {
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
}

.box2{
  /*align-self:start;*/
  display: grid;
  grid-template-columns: 50% 50%;
  margin-right: 20px;
}
</style>


<div class="grid-container">
  <div class="box1">
    <h5 class="text-center mt-4 mb-3"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>
  <div class="box1">

    <?php
      $changelog = get_changelog_full();
    ?>


      <div class="alert alert-secondary" role="alert">
        <h6 class="text-secondary"><u><b>APA ITU CHANGELOG?</b></u></h6>
        <div style="font-size:13px;">Daftar perubahan program secara kronologis untuk menandai setiap perubahan yang dilakukan pada program</div>

        <h6 class="text-secondary mt-4"><u><b>SIAPA YANG MEMBUTUHKAN CHANGELOG?</b></u></h6>
        <div style="font-size:13px;">Semua orang, baik pengguna ataupun developer, developer ingin mencatat perubahan, pengguna ingin tau apa yang berubah dan mengapa suatu program dirubah</div>
      </div>

      <table class="table table-sm table-bordered mt-3" style="font-size:12px;">
        <thead class="bg-secondary text-white">
          <tr>
            <th class="pt-2 pb-2" style="width:100px;">Tanggal</th>
            <th class="pt-2 pb-2">Deskripsi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($changelog as $c):
            $date = date_create($c['changelog_tgl']);

          ?>
          <tr>
            <td><?= date_format($date,"d-m-Y"); ?></td>
            <td><span class="badge badge-<?= $c['changelog_alert'] ?>"><?= $c['changelog_jenis'] ?></span>  <?= $c['changelog_text'] ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

  </div>

</div>

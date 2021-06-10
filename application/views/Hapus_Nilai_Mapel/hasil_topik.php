<style>
.grid-container {
  display: grid;
  grid-template-columns: 5% 90% 5%;
  grid-column-gap:3px;
  padding: 10px;
  margin: 20px;
  box-shadow: 5px 5px 5px 5px;
  overflow: auto;
  padding-bottom: 120px;
  padding-top: 50px;
}


.box1{
  /*align-self:start;*/
  grid-column:2/3;
}

.box2{
  /*align-self:start;*/
  grid-template-columns: 50% 50%;
}
</style>

<div class="grid-container">

  <div class="box1 mb-4">
    <h5 class="text-center"><b><u><?= $title ?></u></b></h5>
    <div><?= $this->session->flashdata('message'); ?></div>
  </div>

  <div class="box1">

    <?php if($tes_all): ?>
      <form class="user" method="post" action="<?= base_url('Hapus_Nilai_Mapel/hapus_tes_proses'); ?>">

        <h5 class="text-center"><u><?= count($tes_all) ?> nilai ditemukan</u></h5>

        <label style="font-size:14px;"><b><u><?= $mapel['mapel_nama'] ?></u></b></label> -
        <label style="font-size:14px;"><b><u><?= $kelas['kelas_nama'] ?></u></b></label> <br>
        <label style="font-size:14px;"><b><u><?= $topik['topik_nama'] ?></u></b></label>
        <table class="table table-sm table-bordered" style="font-size:13px;">
          <thead>
            <tr>
              <th rowspan="2">Nama</th>
              <th colspan="3">Kognitif</th>
              <th colspan="3">Psikomotor</th>
            </tr>
            <tr>
              <th>Quiz</th>
              <th>Test</th>
              <th>Assign</th>
              <th>Quiz</th>
              <th>Test</th>
              <th>Assign</th>
            </tr>

          </thead>
          <tbody>
            <?php foreach($tes_all as $n): ?>
              <tr>
                <td><input type="hidden" name="tes_id[]" value="<?= $n['tes_id'] ?>"><?= $n['sis_nama_depan'].' '.$n['sis_nama_bel'] ?></td>
                <td><?= $n['kog_quiz'] ?></td>
                <td><?= $n['kog_test'] ?></td>
                <td><?= $n['kog_ass'] ?></td>
                <td><?= $n['psi_quiz'] ?></td>
                <td><?= $n['psi_test'] ?></td>
                <td><?= $n['psi_ass'] ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Nilai yang sudah dihapus tidak dapat dikembalikan, lanjutkan?')">
          HAPUS
        </button>

      </form>
    <?php else: ?>
      <h5 class="text-danger text-center mt-4">- Belum ada nilai ujian -</h5>
    <?php endif; ?>

  </div>
</div>

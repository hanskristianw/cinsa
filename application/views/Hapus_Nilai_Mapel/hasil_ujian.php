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

    <?php if($uj_all): ?>
      <form class="user" method="post" action="<?= base_url('Hapus_Nilai_Mapel/hapus_ujian_proses'); ?>">

        <h5 class="text-center"><u><?= count($uj_all) ?> nilai ditemukan</u></h5>

        <label style="font-size:14px;"><b><u><?= $mapel['mapel_nama'] ?></u></b></label> -
        <label style="font-size:14px;"><b><u><?= $kelas['kelas_nama'] ?></u></b></label>
        <table class="table table-sm table-bordered" style="font-size:13px;">
          <thead>
            <tr>
              <th rowspan="3">Nilai</th>
              <th colspan="4">Kognitif</th>
              <th colspan="4">Psikomotor</th>
            </tr>
            <tr>
              <th colspan="2">Mid</th>
              <th colspan="2">Final</th>
              <th colspan="2">Mid</th>
              <th colspan="2">Final</th>
            </tr>
            <tr>
              <th>Sem 1</th>
              <th>Sem 2</th>
              <th>Sem 1</th>
              <th>Sem 2</th>
              <th>Sem 1</th>
              <th>Sem 2</th>
              <th>Sem 1</th>
              <th>Sem 2</th>
            </tr>

          </thead>
          <tbody>
            <?php foreach($uj_all as $n): ?>
              <tr>
                <td><input type="hidden" name="uj_id[]" value="<?= $n['uj_id'] ?>"><?= $n['sis_nama_depan'].' '.$n['sis_nama_bel'] ?></td>
                <td><?= $n['uj_mid1_kog'] ?></td>
                <td><?= $n['uj_mid2_kog'] ?></td>
                <td><?= $n['uj_fin1_kog'] ?></td>
                <td><?= $n['uj_fin2_kog'] ?></td>
                <td><?= $n['uj_mid1_psi'] ?></td>
                <td><?= $n['uj_mid2_psi'] ?></td>
                <td><?= $n['uj_fin1_psi'] ?></td>
                <td><?= $n['uj_fin2_psi'] ?></td>
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
